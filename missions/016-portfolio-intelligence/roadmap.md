# Company Roadmap — Mission 016

**Horizon:** Evidence-based recommendations only. No calendar dates implied — sequencing by dependency and strategic priority.

**Strategic anchor:** Recommendation **B — Unify Get Paid Toolkit suite** before fourth product or M003 SaaS platform.

---

## Next month (immediate)

### Products

| Priority | Work | Owner | Evidence |
|----------|------|-------|----------|
| P0 | **Suite landing page** at `/products/get-paid-toolkit/` | Agent mission | Backlog; M015 gap |
| P0 | **Cross-links in P001/P002 `index.html`** | Agent mission | M015 report §7 |
| P1 | **Shared suite branding** — align P001 dark theme with P002/P003 palette | Agent mission | Three visual identities noted |
| P1 | **Privacy-first analytics** — page views only; no fabricated metrics | Agent + operator tool choice | Principles §5; M015 weakness |
| P2 | Document suite navigation spec in `decisions/D010` (at merge) | Agent mission | D008/D009 pattern |

### Architecture

| Priority | Work | Evidence |
|----------|------|----------|
| P1 | Lightweight `products/_suite/` shared JS (tone, copy, storage) | Duplicated P002/P003 patterns |
| P2 | Bump compiler version meta to M016 | Stale 1.6.0-mission-014 |
| — | **No** AI-DOS architecture redesign | Mission 016 constraint |

### Marketing

| Priority | Work | Evidence |
|----------|------|----------|
| P0 | Market as **Get Paid Toolkit**, not three orphan URLs | Strategy §4 |
| P1 | Suite README with lifecycle diagram (rate → terms → chase) | M015 narrative |
| P2 | Public launch post (operator-authored) — **after** suite shell | Backlog option |
| — | No paid ads, no fabricated testimonials | Principles §5 |

### Deployment

| Priority | Work | Evidence |
|----------|------|----------|
| P0 | Hostinger deploy after M017 merge | Standards §7 |
| P1 | Verify all 4 URLs (site + 3 products + suite landing) | Deployment table M015 |

### Portfolio

| Priority | Work | Evidence |
|----------|------|----------|
| P0 | Suite unification (recommendation B) | Mission 016 final recommendation |
| — | **No Product 004** until suite shell ships | This roadmap |

### Technical debt

| Priority | Work | Evidence |
|----------|------|----------|
| P1 | M006 Phase B decision: run interviews OR formally sunset SaaS thesis | D006 paused |
| P2 | Fix `compile.php` current_mission hardcode | architecture-audit C1 |
| P3 | Sync `system/assets.md` | Stale since M009 |
| P3 | Resolve Standards §9/§10 duplication | Doc drift |

### AI-DOS evolution

| Priority | Work | Evidence |
|----------|------|----------|
| P1 | Mission 017: Execute Strategic Product Roadmap (suite first) | This mission approval |
| P2 | Use execution plan for multi-step suite mission | M015 underuse |
| — | No new OS subsystems | M012 stop line holds |

---

## Next quarter

### Products

| Sequence | Deliverable | Rationale |
|----------|-------------|-----------|
| 1 | **P004 Scope Guard** | M015 #2 (33/40); margin protection; copy-tool pattern |
| 2 | **P005 Quick Proposal** | P001 extension; revenue reasoning 4/5 (M015) |
| 3 | P002 Pro tier spec (document only) | Client profiles, template packs — README |
| 4 | Data handoff: P003 net days → P002 due date | Portfolio analysis synergy gap |

### Architecture

- Evaluate product graduation (M007 §4.11): spin suite to separate repo **only if** public launch traction warrants — premature now (Backlog warns ops overhead)
- Execution Engine: create `mission-017-suite-unification.yaml` plan

### Marketing

- Public launch with real analytics baseline
- SEO: target "freelancer payment terms", "invoice reminder template" — M003 keyword research [S]
- Suite case study: AI-DOS built three products from organizational memory (portfolio story)

### Portfolio

- 5-product Get Paid Toolkit: rate, terms, chase, scope, proposal
- Consider **Scope Guard** as suite expansion beyond pure "payment" into **freelancer margin protection**

### Technical debt

- Complete M006 Phase B OR publish `decisions/D011` sunsetting M003 SaaS path
- Compiler modularity: extract Command Center HTML from `compile.php` (audit debt — only if blocking)

### AI-DOS evolution

- Mission 018 candidate: Repository Intelligence Score (M007 planned) — **only if** operator approves; not blocking
- Product Recommendation Report template in `workflow/Templates/` — codify M015 pattern

---

## Next year

### Products

| Path | Condition | Outcome |
|------|-----------|---------|
| **Path A: Suite + wedges** | M006 sunsets SaaS thesis | 5–7 static tools; optional Pro template packs; Landolio-competitive as free bundle |
| **Path B: Platform wedge** | M006 Phase B passes I3 WTP threshold | P002 evolves to M003 Invoice Follow-Up SaaS (auth, email API, Stripe) |
| **Path C: Graduation** | Public launch shows traction | Get Paid Toolkit → separate repo; AI-DOS remains OS |

**Evidence today favors Path A start; Path B gated on M006; Path C premature.**

### Architecture

- If Path B: separate product repo per M007; AI-DOS repo tracks via `portfolio.yaml` only
- If Path A: shared suite module matures; no backend until revenue justifies

### Marketing

- Establish Get Paid Toolkit as known freelancer brand (not AI-DOS sub-brand)
- AI-DOS itself marketed to **operators** who want AI company OS (distinct audience)

### Portfolio

- Two-track company: **AI-DOS OS** (B2B meta) + **Get Paid Toolkit** (B2C freelancer)
- Potential second portfolio cluster only after first suite proves repeatable (M007 multi-portfolio vision)

### Technical debt

- Automate compile-on-deploy or compile-on-merge commit (M007 deferred; audit C2)
- Formal `system/queue.yaml` replacing prose Backlog (M007 deferred)

### AI-DOS evolution

- Execution Engine: autonomous paste-to-worker loop with operator approval gates
- Organizational learning as default product strategy phase (M015 → standard)
- Cold-start test includes portfolio strategy artifacts

---

## Prioritized roadmap (master rank)

| Rank | Initiative | Horizon | Blocker |
|------|------------|---------|---------|
| 1 | Suite unification | Month | None |
| 2 | Real analytics | Month | Operator tool pick |
| 3 | M006 Phase B decision | Month | Operator interviews |
| 4 | P004 Scope Guard | Quarter | Suite shell |
| 5 | P005 Quick Proposal | Quarter | Suite shell |
| 6 | P002 Pro tier (paid) | Quarter | WTP evidence |
| 7 | M003 Invoice SaaS | Year | M006 pass |
| 8 | Product repo graduation | Year | Launch traction |
| 9 | Second portfolio cluster | Year | First suite proof |
| 10 | RIS / advanced intelligence | Year+ | Operator approval |

---

## What Mission 017 should execute

**Primary:** Strategic Product Roadmap items #1–3 (suite unification, analytics, M006 decision framework).

**Secondary:** Begin P004 Scope Guard only if suite shell completes in same mission or immediately after.

**Explicitly not in M017:** M003 SaaS build, architecture redesign, market pivot, fabricated launch metrics.
