# Invoice Chase (P002)

**Portfolio Project 002** — built independently by AI-DOS Mission 014.

## Problem

Freelancers lose time and relationships rewriting the same late-invoice emails.
Invoice Chase generates a full escalating reminder sequence — copy, paste, send.

Part of the **Get Paid Toolkit** — set terms first with [Payment Terms Studio](../003-payment-terms-studio/); know your rate with [Billable Rate Calculator](../001-billable-rate-calculator/).

## Features

- Five-stage email sequence (pre-due → 30 days overdue)
- Warm / neutral / direct tone setting
- Optional payment link block
- Multi-currency amount formatting
- Draft auto-save in browser (localStorage)
- One-click copy per email (subject + body)
- Mobile-first responsive layout
- No server, accounts, or data upload

## Run locally

```bash
php -S localhost:8080 -t products/002-invoice-chase
```

Or open `index.html` directly.

## Deploy

Upload folder to Hostinger:

`https://cubixmeow.com/ai-dos/products/002-invoice-chase/`

## v1 limitations

- Does not send email (by design — you control delivery)
- No invoice PDF attachment
- No client CRM / history sync
- English templates only

## Revenue path (future)

- Saved client profiles
- Custom template packs
- Stripe payment link integration helper

## Origin

Selected by AI-DOS Mission 014 after repository analysis — aligns with Mission
003 invoice follow-up recommendation without requiring backend automation.
