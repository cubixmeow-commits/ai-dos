(function () {
  'use strict';

  const STORAGE_KEY = 'invoice-chase-draft-v1';
  const form = document.getElementById('chase-form');
  const outputPanel = document.getElementById('output-panel');
  const emailList = document.getElementById('email-list');
  const outputMeta = document.getElementById('outputMeta');
  const draftHint = document.getElementById('draftHint');
  const clearDraftBtn = document.getElementById('clearDraft');
  const template = document.getElementById('email-card-template');

  const STAGES = [
    { id: 'due-soon', label: '3 days before due', dayOffset: -3, toneScale: 0 },
    { id: 'due-today', label: 'Due today', dayOffset: 0, toneScale: 1 },
    { id: 'overdue-7', label: '7 days overdue', dayOffset: 7, toneScale: 2 },
    { id: 'overdue-14', label: '14 days overdue', dayOffset: 14, toneScale: 3 },
    { id: 'overdue-30', label: '30 days overdue', dayOffset: 30, toneScale: 4 },
  ];

  function formatMoney(amount, currency) {
    return new Intl.NumberFormat(undefined, {
      style: 'currency',
      currency,
      minimumFractionDigits: 0,
      maximumFractionDigits: 2,
    }).format(amount);
  }

  function formatDate(dateStr) {
    const d = new Date(dateStr + 'T12:00:00');
    return d.toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
  }

  function addDays(dateStr, days) {
    const d = new Date(dateStr + 'T12:00:00');
    d.setDate(d.getDate() + days);
    return d.toISOString().slice(0, 10);
  }

  function signature(data) {
    const name = data.businessName || data.senderName;
    return data.businessName
      ? `${data.senderName}\n${data.businessName}`
      : data.senderName;
  }

  function paymentBlock(data) {
    if (!data.paymentLink) {
      return 'Please let me know once payment has been sent, or reply if you need anything from me to process it.';
    }
    return `You can pay securely here:\n${data.paymentLink}\n\nIf you’ve already sent payment, thank you — just reply and I’ll confirm receipt.`;
  }

  function toneIndex(baseTone, scale) {
    const map = { warm: 0, neutral: 1, direct: 2 };
    return Math.min(2, (map[baseTone] || 0) + Math.floor(scale / 2));
  }

  function buildEmail(stage, data) {
    const amount = formatMoney(Number(data.amount), data.currency);
    const due = formatDate(data.dueDate);
    const sendDate = formatDate(addDays(data.dueDate, stage.dayOffset));
    const client = data.clientName;
    const inv = data.invoiceNumber;
    const tone = toneIndex(data.tone, stage.toneScale);
    const sig = signature(data);
    const pay = paymentBlock(data);

    const openers = [
      `Hi ${client},`,
      `Hello ${client},`,
      `${client},`,
    ];

    const opener = openers[tone];

    let subject;
    let body;

    switch (stage.id) {
      case 'due-soon':
        subject = `Friendly reminder: invoice ${inv} due ${due}`;
        body = `${opener}

Just a quick note that invoice ${inv} for ${amount} is due on ${due}.

${pay}

Thanks,
${sig}`;
        break;

      case 'due-today':
        subject = `Invoice ${inv} due today — ${amount}`;
        body = `${opener}

Invoice ${inv} for ${amount} is due today (${due}). When you have a moment, could you confirm payment or let me know if you need anything from me?

${pay}

Best,
${sig}`;
        break;

      case 'overdue-7':
        subject = `Following up: invoice ${inv} (${amount})`;
        body = `${opener}

I wanted to follow up on invoice ${inv} for ${amount}, which was due on ${due}. I may have missed your confirmation — could you let me know the status?

${pay}

Thank you,
${sig}`;
        break;

      case 'overdue-14':
        subject = `Second reminder: invoice ${inv} now overdue`;
        body = `${opener}

Invoice ${inv} for ${amount} is now two weeks past the due date (${due}). I need to reconcile my accounts this week — please send payment or share when I can expect it.

${pay}

Regards,
${sig}`;
        break;

      case 'overdue-30':
        subject = `Urgent: invoice ${inv} — payment required`;
        body = `${opener}

This is a final reminder regarding invoice ${inv} for ${amount}, originally due ${due}. If payment cannot be arranged within the next few business days, I’ll need to pause work and review next steps per our agreement.

${pay}

Please reply today so we can close this out.

${sig}`;
        break;

      default:
        subject = `Invoice ${inv}`;
        body = '';
    }

    return { stage: stage.label, sendDate, subject, body };
  }

  function readForm() {
    const fd = new FormData(form);
    return {
      senderName: String(fd.get('senderName') || '').trim(),
      businessName: String(fd.get('businessName') || '').trim(),
      clientName: String(fd.get('clientName') || '').trim(),
      invoiceNumber: String(fd.get('invoiceNumber') || '').trim(),
      amount: fd.get('amount'),
      currency: fd.get('currency') || 'USD',
      dueDate: fd.get('dueDate'),
      paymentLink: String(fd.get('paymentLink') || '').trim(),
      tone: fd.get('tone') || 'warm',
    };
  }

  function validate(data) {
    const errors = [];
    if (!data.senderName) errors.push('Your name is required.');
    if (!data.clientName) errors.push('Client name is required.');
    if (!data.invoiceNumber) errors.push('Invoice number is required.');
    if (!data.amount || Number(data.amount) <= 0) errors.push('Enter a valid amount.');
    if (!data.dueDate) errors.push('Due date is required.');
    if (data.paymentLink && !/^https?:\/\//i.test(data.paymentLink)) {
      errors.push('Payment link must start with http:// or https://');
    }
    return errors;
  }

  function saveDraft(data) {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
    } catch (_) {
      /* storage full or private mode */
    }
  }

  function loadDraft() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      if (!raw) return null;
      return JSON.parse(raw);
    } catch (_) {
      return null;
    }
  }

  function applyDraft(data) {
    if (!data) return;
    for (const [key, value] of Object.entries(data)) {
      const el = form.elements.namedItem(key);
      if (!el) continue;
      if (el.type === 'radio') {
        const radio = form.querySelector(`input[name="${key}"][value="${value}"]`);
        if (radio) radio.checked = true;
      } else {
        el.value = value;
      }
    }
    draftHint.hidden = false;
  }

  function renderEmails(data) {
    emailList.innerHTML = '';
    const emails = STAGES.map((stage) => buildEmail(stage, data));

    emails.forEach((email) => {
      const node = template.content.cloneNode(true);
      node.querySelector('.stage-label').textContent = `${email.stage} · send ~${email.sendDate}`;
      node.querySelector('.subject-line').textContent = email.subject;
      node.querySelector('.email-body').textContent = email.body;

      const copyBtn = node.querySelector('.btn-copy');
      const feedback = node.querySelector('.copy-feedback');
      const fullText = `Subject: ${email.subject}\n\n${email.body}`;

      copyBtn.addEventListener('click', async () => {
        try {
          await navigator.clipboard.writeText(fullText);
          feedback.hidden = false;
          setTimeout(() => { feedback.hidden = true; }, 2000);
        } catch (_) {
          window.prompt('Copy this email:', fullText);
        }
      });

      emailList.appendChild(node);
    });

    const amount = formatMoney(Number(data.amount), data.currency);
    outputMeta.textContent = `${emails.length} reminders for ${data.clientName} · ${amount} · invoice ${data.invoiceNumber}`;
    outputPanel.hidden = false;
    outputPanel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const data = readForm();
    const errors = validate(data);
    if (errors.length) {
      alert(errors.join('\n'));
      return;
    }
    saveDraft(data);
    renderEmails(data);
  });

  clearDraftBtn.addEventListener('click', () => {
    localStorage.removeItem(STORAGE_KEY);
    form.reset();
    draftHint.hidden = true;
    outputPanel.hidden = true;
  });

  const draft = loadDraft();
  if (draft) applyDraft(draft);

  if (!form.dueDate.value) {
    const d = new Date();
    d.setDate(d.getDate() + 14);
    form.dueDate.value = d.toISOString().slice(0, 10);
  }
})();
