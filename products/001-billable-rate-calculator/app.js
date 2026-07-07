(function () {
  const form = document.getElementById('calculator');
  const results = document.getElementById('results');

  const fmtMoney = (n) =>
    new Intl.NumberFormat(undefined, {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0,
    }).format(n);

  const fmtMoneyPrecise = (n) =>
    new Intl.NumberFormat(undefined, {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    }).format(n);

  function calculate(values) {
    const takeHome = values.takeHome;
    const taxRate = values.taxRate / 100;
    const expenses = values.expenses;
    const hoursWeek = values.hoursWeek;
    const weeksOff = values.weeksOff;
    const utilization = values.utilization / 100;

    if (taxRate >= 1) {
      throw new Error('Tax rate must be below 100%.');
    }

    const grossNeeded = (takeHome + expenses) / (1 - taxRate);
    const workingWeeks = 52 - weeksOff;
    const billableHours = workingWeeks * hoursWeek * utilization;

    if (billableHours <= 0) {
      throw new Error('Billable hours must be greater than zero.');
    }

    const hourlyRate = grossNeeded / billableHours;
    const dayRate = hourlyRate * 8;

    const steps = [
      `Take-home goal ${fmtMoney(takeHome)} + expenses ${fmtMoney(expenses)} = ${fmtMoney(takeHome + expenses)} must be covered after tax.`,
      `At ${values.taxRate}% tax, gross revenue needed ≈ ${fmtMoney(grossNeeded)}.`,
      `${workingWeeks} working weeks × ${hoursWeek} h/week × ${values.utilization}% utilization = ${Math.round(billableHours)} billable hours/year.`,
      `${fmtMoney(grossNeeded)} ÷ ${Math.round(billableHours)} h ≈ ${fmtMoneyPrecise(hourlyRate)}/hour minimum.`,
    ];

    return { hourlyRate, dayRate, grossNeeded, billableHours, steps };
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault();

    const values = {
      takeHome: Number(document.getElementById('takeHome').value),
      taxRate: Number(document.getElementById('taxRate').value),
      expenses: Number(document.getElementById('expenses').value),
      hoursWeek: Number(document.getElementById('hoursWeek').value),
      weeksOff: Number(document.getElementById('weeksOff').value),
      utilization: Number(document.getElementById('utilization').value),
    };

    try {
      const out = calculate(values);
      document.getElementById('hourlyRate').textContent = fmtMoneyPrecise(out.hourlyRate);
      document.getElementById('dayRate').textContent = fmtMoneyPrecise(out.dayRate);
      document.getElementById('grossRevenue').textContent = fmtMoney(out.grossNeeded);
      document.getElementById('billableHours').textContent = Math.round(out.billableHours).toLocaleString();
      document.getElementById('summaryText').textContent =
        `To keep ${fmtMoney(values.takeHome)} after tax and cover ${fmtMoney(values.expenses)} in expenses, charge at least ${fmtMoneyPrecise(out.hourlyRate)}/hour on ${Math.round(out.billableHours)} billable hours per year.`;
      document.getElementById('breakdownList').innerHTML = out.steps.map((s) => `<li>${s}</li>`).join('');
      results.hidden = false;
      results.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } catch (err) {
      alert(err.message || 'Check your inputs and try again.');
    }
  });
})();
