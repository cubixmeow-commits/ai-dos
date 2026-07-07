# Mission 013 Report — First External Product

**Mission:** Build the First External Product Using AI-DOS  
**Status:** Complete — pending operator merge approval  
**Product:** Billable Rate Calculator (Portfolio Project 001)

---

## Executive summary

AI-DOS proposed five simple product ideas, scored them against operator
constraints, and built **Billable Rate Calculator** — a mobile-first static
tool that tells freelancers the hourly rate they need to hit a take-home goal.

No AI-DOS compiler changes. No fake metrics. Product lives at
`products/001-billable-rate-calculator/`.

---

## Phase 1 — Five candidate ideas

| # | Name | Target user | Problem | MVP scope |
|---|------|-------------|---------|-----------|
| 1 | **Billable Rate Calculator** | Solo freelancers / contractors | Don't know what to charge to hit income goals after tax & expenses | One-page calculator: inputs → hourly + day rate |
| 2 | Payment Terms Generator | Freelancers sending invoices | Awkward to write polite late-payment emails | Pick tone → copy email template |
| 3 | Project Deposit Calculator | Small agencies / freelancers | Unsure what upfront deposit protects margin | Project value + risk → suggested deposit % |
| 4 | Scope Creep Cost Estimator | Freelancers mid-project | Extra requests erode profit | Hours × rate → cost of add-ons |
| 5 | Invoice Due-Date Planner | Freelancers with multiple clients | Cash-flow gaps from staggered due dates | Enter invoices → calendar of expected cash |

---

## Phase 2 — Scoring and selection

| Criterion (1–5) | #1 Rate calc | #2 Terms | #3 Deposit | #4 Scope | #5 Due dates |
|-------------------|:---:|:---:|:---:|:---:|:---:|
| Usefulness | 5 | 4 | 4 | 4 | 4 |
| Simplicity | 5 | 5 | 5 | 4 | 3 |
| Speed to MVP | 5 | 5 | 5 | 4 | 3 |
| PHP/Hostinger fit | 5 | 5 | 5 | 5 | 4 |
| iPhone manageability | 5 | 5 | 5 | 4 | 3 |
| Portfolio value | 5 | 3 | 4 | 4 | 3 |
| Future revenue | 4 | 3 | 3 | 3 | 4 |
| **Total** | **34** | **30** | **31** | **28** | **24** |

### Selected: #1 Billable Rate Calculator

**Why:** Highest total score. Pure client-side logic — deploys as static files on
Hostinger with zero backend. Immediately useful on a phone. Clear portfolio demo
("I ship tools that solve freelancer math"). Natural upsell later (saved scenarios,
PDF proposals) without v1 complexity.

### Rejected alternatives

| Idea | Why rejected |
|------|----------------|
| Payment Terms Generator | Lower portfolio story; crowded template space; less differentiated |
| Project Deposit Calculator | Narrower use case; often one-off per project |
| Scope Creep Estimator | Needs project context input UX; harder to make instantly useful |
| Invoice Due-Date Planner | Multi-invoice state + calendar UX; slower to polish for v1 |

**Note on Mission 003 invoice follow-up:** Still a valid Portfolio candidate, but
Mission 013 constraints favor a **finished small tool now** over a validation-heavy
SaaS. Invoice product remains available for Mission 014+ or separate repo.

---

## Phase 3 — What was built

| File | Purpose |
|------|---------|
| `products/001-billable-rate-calculator/index.html` | Mobile-first UI |
| `products/001-billable-rate-calculator/styles.css` | Dark, phone-optimized layout |
| `products/001-billable-rate-calculator/app.js` | Rate math + breakdown |
| `products/001-billable-rate-calculator/README.md` | Usage and deploy notes |

### Core feature

User enters:

- Desired take-home per year
- Estimated tax rate (%)
- Annual business expenses
- Billable hours per week
- Weeks off per year
- Billable utilization (%)

Output:

- Minimum hourly rate
- Day rate (8 h)
- Gross revenue required
- Billable hours per year
- Step-by-step breakdown (expandable)

All calculation runs in the browser. No server, accounts, or storage.

---

## How to use it

1. Open `products/001-billable-rate-calculator/index.html` locally, or deploy the folder.
2. Enter your numbers (defaults are example values).
3. Tap **Calculate my rate**.
4. Read hourly/day rate and breakdown.

Local server (optional):

```bash
php -S localhost:8080 -t products/001-billable-rate-calculator
```

---

## Deployment URL / path

| Environment | Path |
|-------------|------|
| **Repository** | `products/001-billable-rate-calculator/` |
| **Production (expected)** | `https://cubixmeow.com/ai-dos/products/001-billable-rate-calculator/` |

Upload the four product files to Hostinger under `public_html/ai-dos/products/001-billable-rate-calculator/`.

**V2 architecture note:** Approved design prefers product code in a **separate repo**
when a project graduates (`missions/007-design-v2/architecture.md`). This MVP
lives in AI-DOS temporarily as Mission 013 proof; spin out before treating it as
a standalone company product.

---

## Limitations (v1)

- USD display only
- Flat tax rate (not progressive brackets)
- No save/share/export
- No accounts, analytics, or payments
- Not legal/tax advice

---

## AI-DOS infrastructure touched

| Changed | Skipped (on purpose) |
|---------|---------------------|
| `system/assets.yaml` — product assets | Compiler / Command Center |
| `tasks/Backlog.md` — M013 record | `system/portfolio.yaml` |
| `system/gpt-brief.txt` | Execution Engine changes |
| Mission 013 folder | More registries |

---

## What AI-DOS learned

- **Finished beats ambitious** — a static calculator ships faster than invoice SaaS and still proves the OS.
- **products/ works for MVP** — separate repo can wait until launch; document the graduation path.
- **Execution Engine context helped** — Mission 013 plan framed roles; actual build was single-agent Cursor work.
- **Infrastructure stop line held** — zero compiler edits; AI-DOS coordinated without building more AI-DOS.
- **Portfolio Project 001 exists** — AI-DOS is now a company OS with something outside itself.

---

## Cold-start proof

1. Product: [products/001-billable-rate-calculator/README.md](../../products/001-billable-rate-calculator/README.md)
2. Open [index.html](../../products/001-billable-rate-calculator/index.html) in browser
3. This report for selection rationale

---

Approve Mission 014: Improve or Launch First External Product? Y/N
