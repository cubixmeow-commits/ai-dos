(function () {
  'use strict';

  const form = document.getElementById('terms-form');
  const outputs = document.getElementById('outputs');
  const netDays = document.getElementById('netDays');
  const customWrap = document.getElementById('customDaysWrap');

  netDays.addEventListener('change', () => {
    customWrap.hidden = netDays.value !== 'custom';
  });

  function readForm() {
    const fd = new FormData(form);
    let days = fd.get('netDays');
    if (days === 'custom') {
      days = String(document.getElementById('customDays').value);
    }
    if (days === '0') {
      days = '0';
    }

    return {
      businessName: String(fd.get('businessName') || '').trim(),
      clientName: String(fd.get('clientName') || '').trim(),
      netDays: days,
      depositPct: Number(fd.get('depositPct') || 0),
      lateFeePct: Number(fd.get('lateFeePct') || 0),
      paymentMethods: String(fd.get('paymentMethods') || '').trim(),
      tone: fd.get('tone') || 'friendly',
    };
  }

  function duePhrase(days) {
    if (days === '0') return 'due upon receipt';
    return `due within ${days} calendar days of invoice date`;
  }

  function generate(data) {
    const due = duePhrase(data.netDays);
    const deposit = data.depositPct > 0
      ? `${data.depositPct}% of the total fee is payable upon acceptance of this agreement; the balance is ${due}.`
      : `Payment is ${due}.`;
    const late = data.lateFeePct > 0
      ? `Overdue balances accrue a late fee of ${data.lateFeePct}% per month (or the maximum permitted by law, whichever is lower).`
      : 'Please pay by the due date to avoid project delays.';
    const methods = data.paymentMethods
      ? `Accepted methods: ${data.paymentMethods}.`
      : '';

    const clause = `Payment Terms. ${deposit} ${late} ${methods} Work may pause if invoices remain unpaid more than 14 days past the due date. Client is responsible for any bank or processor fees unless otherwise agreed in writing. — ${data.businessName}`;

    const footer = `Payment ${due}.${data.lateFeePct > 0 ? ` Late fee: ${data.lateFeePct}%/month after due date.` : ''} ${methods}`.trim();

    const openers = {
      friendly: `Hi ${data.clientName},`,
      standard: `Hello ${data.clientName},`,
      firm: `${data.clientName},`,
    };

    const bodies = {
      friendly: `Sharing the payment terms we'll use for this project so we're aligned before work begins.`,
      standard: `Please find our agreed payment terms below for your records.`,
      firm: `For clarity, these are the payment terms that apply to our engagement.`,
    };

    const email = `${openers[data.tone]}

${bodies[data.tone]}

• ${deposit.replace('Payment is ', 'Balance ').replace(' of the total fee is payable upon acceptance of this agreement; the balance is ', 'Deposit & balance: ')}
• ${late}
${methods ? `• ${methods}` : ''}

Let me know if you have any questions before we proceed.

Best,
${data.businessName}`;

    return { clause, footer, email };
  }

  function validate(data) {
    const errors = [];
    if (!data.businessName) errors.push('Business name is required.');
    if (!data.clientName) errors.push('Client name is required.');
    if (data.netDays === 'custom' && (!data.netDays || Number(data.netDays) < 1)) {
      errors.push('Enter valid custom days.');
    }
    return errors;
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const data = readForm();
    const errors = validate(data);
    if (errors.length) {
      alert(errors.join('\n'));
      return;
    }

    const out = generate(data);
    document.getElementById('clause').textContent = out.clause;
    document.getElementById('footer').textContent = out.footer;
    document.getElementById('email').textContent = out.email;
    outputs.hidden = false;
    outputs.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  });

  document.querySelectorAll('.btn-copy').forEach((btn) => {
    btn.addEventListener('click', async () => {
      const id = btn.getAttribute('data-target');
      const text = document.getElementById(id).textContent;
      const card = btn.closest('.output-card');
      const feedback = card.querySelector('.copied');
      try {
        await navigator.clipboard.writeText(text);
        feedback.hidden = false;
        setTimeout(() => { feedback.hidden = true; }, 2000);
      } catch (_) {
        window.prompt('Copy:', text);
      }
    });
  });
})();
