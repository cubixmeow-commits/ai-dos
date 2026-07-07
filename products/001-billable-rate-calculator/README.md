# Billable Rate Calculator (P001)

**Portfolio Project 001** — first external product built under AI-DOS Mission 013.

## What it does

Calculates the minimum freelance hourly rate needed to reach a take-home income
goal, after estimated taxes, business expenses, vacation weeks, and realistic
billable utilization.

## Run locally

Open `index.html` in a browser, or serve the folder:

```bash
php -S localhost:8080 -t products/001-billable-rate-calculator
```

## Deploy (Hostinger / static)

Upload this folder to your host. No database, PHP, or API required for v1.

**Expected path on cubixmeow.com:**

`https://cubixmeow.com/ai-dos/products/001-billable-rate-calculator/`

## v1 limitations

- USD formatting only (locale-aware display, not multi-currency logic)
- Single tax rate estimate (not progressive brackets)
- No save/share — refresh clears results
- No accounts or payments

## Future revenue (not in v1)

- Pro: saved scenarios, PDF export, multi-currency
- Template packs for client proposals

## AI-DOS note

V2 architecture prefers product code in a **separate repository** when the
project graduates. This directory is the Mission 013 MVP proof inside the
AI-DOS repo; move to `github.com/org/billable-rate-calculator` when launching
publicly.
