# Decision D008: Portfolio Project 002 — Invoice Chase

**Status:** accepted  
**Related missions:** Mission 014

## Context

Mission 014 tested whether AI-DOS can **independently** choose and build a
useful product without operator design input. Mission 013 shipped a calculator;
Mission 014 must not repeat that pattern. Repository history (Mission 003, 006)
documents freelancer invoice payment pain.

## Decision

Ship **Invoice Chase** (`products/002-invoice-chase/`) — a client-side tool
that generates escalating late-invoice reminder emails. No email sending, no
accounts, static deploy on Hostinger.

## Alternatives considered

- **JSON explorer** — useful but commoditized; weak portfolio differentiation
- **Markdown formatter** — dev-tool niche; lower bookmark value for operator audience
- **Changelog generator** — needs git integration; exceeds static MVP scope
- **Resume optimizer** — crowded market; unclear autonomous evidence in repo
- **Full invoice SaaS (M003)** — correct long-term; too large for single-mission proof

## Why chosen

Repository intelligence pointed to invoice follow-up as validated pain.
Invoice Chase delivers **immediate utility** (copy-paste emails) without
backend complexity — proving autonomous product judgment while aligning with
organizational memory.

## Evidence

- [missions/003-prove-the-loop/report.md](../missions/003-prove-the-loop/report.md)
- [missions/014-ai-dos-independent-product-test/report.md](../missions/014-ai-dos-independent-product-test/report.md)
- Mission 014 independent brainstorm record
