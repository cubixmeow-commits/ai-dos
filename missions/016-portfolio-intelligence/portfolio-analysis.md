# Portfolio Analysis — Mission 016

**Method:** Investment-review lens. Evidence from product code, mission reports (M013–M015), `system/portfolio.yaml`, and decision records D008–D009. No fabricated customer data.

---

## Portfolio context

| ID | Name | Mission | Status | Suite |
|----|------|---------|--------|-------|
| P001 | Billable Rate Calculator | 013 | active | get-paid-toolkit (README) |
| P002 | Invoice Chase | 014 | active | get-paid-toolkit (README) |
| P003 | Payment Terms Studio | 015 | active | `get-paid-toolkit` (portfolio.yaml) |

**Intended lifecycle** (M015): P001 (price) → P003 (prevent) → P002 (collect).

---

## P001 — Billable Rate Calculator

### Problem & customer

Freelancers unsure what hourly rate achieves income goals after tax, expenses, and non-billable time. Evidence: M013 report, `portfolio.yaml`, README.

### Strengths

- Clearest one-liner in portfolio ("freelancer math")
- Lowest complexity (~81 lines `app.js`); fastest to maintain
- Utilization factor differentiates from generic calculators (M013)
- M013 portfolio value score: 5/5
- Proves AI-DOS can ship external products (first portfolio proof)

### Weaknesses

- Episodic use (rate changes infrequently)
- USD-only; flat tax; `alert()` validation
- No copy buttons, persistence, or proposal output
- UI baseline — dark minimal theme; no external fonts
- High commoditization risk (many free rate calculators)

### Implementation & UI quality

| Dimension | Assessment | Evidence |
|-----------|------------|----------|
| Code quality | Good for MVP | Clean `calculate()`, `Intl.NumberFormat`, `aria-live` |
| UI quality | Functional, not flagship | Mobile-first; M015 notes M013→M014 UI progression bypassed P001 |
| Technical complexity | Low | Single form → results panel |
| Maintenance cost | Lowest | No templates, no legal copy, no storage |

### Portfolio & revenue potential

- **Portfolio value:** High as proof artifact; medium as standalone brand
- **Revenue potential (documented future only):** M013 future revenue 4/5 — saved scenarios, PDF, multi-currency, proposal packs (README). **v1 monetizes nothing.**

### Expansion & integration

- Natural extension: **Quick Proposal** (M015 #3 candidate) — connects rate to client-facing output
- No current data handoff to P002 or P003

### Classification: **Supporting Product**

Justification: Essential portfolio anchor and cold-start demo, but episodic use and commoditized category prevent flagship status. Supports suite narrative (pricing step) without driving recurring engagement alone.

---

## P002 — Invoice Chase

### Problem & customer

Freelancers dread writing escalating late-invoice reminder emails. Evidence: M014 report, D008, M003 Candidate C lineage.

### Strengths

- Richest feature set: 5-stage escalation, tone scaling, multi-currency, `localStorage` drafts
- Best UI in portfolio: DM Sans + Fraunces, two-column grid, email cards (M014, M015)
- M014 scoring: Real problem fit 5/5, Bookmark utility 5/5
- Proves **autonomous product judgment** (M014 test — not another calculator)
- Explicit wedge toward deferred M003 invoice SaaS (M014 report)
- Highest recurring-use signal in portfolio

### Weaknesses

- English-only; manual copy-send (by design)
- Does not send email — "feature not product" risk from M003/M006
- No integration with P003 terms (due dates, net terms not prefilled)
- Template surface area: 5 emails × 3 tones = content maintenance
- M006 P1: standalone chaser WTP doubtful (Landolio free)

### Implementation & UI quality

| Dimension | Assessment | Evidence |
|-----------|------------|----------|
| Code quality | Strongest | ~273 lines; template engine, validation arrays, storage versioning |
| UI quality | Flagship | Warm paper aesthetic; responsive grid; copy feedback |
| Technical complexity | Highest in portfolio | Date math, tone engine, persistence |
| Maintenance cost | Highest | Template copy drift; most features to extend |

### Portfolio & revenue potential

- **Portfolio value:** High — demonstrates judgment + craft
- **Revenue potential (documented future only):** Client profiles, template packs, Stripe helper (README); M003 SaaS path. **v1 monetizes nothing.** Best documented path to paid tier.

### Expansion & integration

- Platform evolution: M003 full invoice follow-up SaaS (auth, email API, Stripe) — deferred since M003
- Suite: should receive P003 net terms as default due-date offset
- Competitors: Landolio (free), autoremind.ai ($9/mo generic) — M006 phase-a

### Classification: **Flagship**

Justification: Deepest product, best UI, highest recurring pain, clearest monetization path in documentation. M014 explicitly framed as the portfolio's leading wedge. Weak WTP assumption (M006) is a business risk, not a product-quality failure.

---

## P003 — Payment Terms Studio

### Problem & customer

Unclear payment terms cause late invoices; chasing (P002) happens because prevention failed. Evidence: M015 report, D009, M013 deferral list.

### Strengths

- Completes get-paid lifecycle (M015 organizational learning, 38/40 fit)
- One form → three outputs (clause, footer, email) — efficient MVP
- Only product with in-page suite nav (`index.html` links to P001/P002)
- Formal `suite: get-paid-toolkit` in `portfolio.yaml`
- Legal disclaimer present; tone presets match P002 pattern

### Weaknesses

- M013 originally rejected for "crowded template space" (score 30, portfolio story weaker)
- No `localStorage` (P002 has drafts; P003 does not)
- Template commoditization risk (M015 acknowledged)
- Legal sensitivity — "not legal advice" limits enterprise trust
- Thinnest feature depth of the three

### Implementation & UI quality

| Dimension | Assessment | Evidence |
|-----------|------------|----------|
| Code quality | Solid mid-tier | ~126 lines; three template blocks |
| UI quality | Professional suite member | Instrument Sans; suite badge; lighter than P002 |
| Technical complexity | Medium | Simpler than P002 sequence logic |
| Maintenance cost | Low–medium | Legal wording may need jurisdiction variants |

### Portfolio & revenue potential

- **Portfolio value:** Highest **strategic** value as suite connector
- **Revenue potential (documented future only):** M015 revenue score 4/5; mitigated by suite bundle. No explicit Pro tier in README.

### Expansion & integration

- Should feed P002: net days → default due date
- Deposit % overlaps M013 Deposit Calculator (rejected — redundant)

### Classification: **Merge into Suite**

Justification: Standalone commoditization risk is high; strategic value is almost entirely as the prevention layer in Get Paid Toolkit. Not sunset — active and necessary — but should not be marketed or developed as an independent product going forward.

---

## Cross-product comparison matrix

| Dimension | P001 | P002 | P003 |
|-----------|------|------|------|
| Mission selection score | 34/35 | 29/30 | 38/40 org fit |
| Recurring use | Low | High | Per new client |
| UI rank | 3rd | 1st | 2nd |
| Maintenance | Lowest | Highest | Low–med |
| Revenue path (documented) | Lead magnet | Platform wedge | Suite glue |
| Suite integration (UI) | README only | README only | In-page nav |
| Commoditization risk | High | Medium | High |
| Reinforces others? | Yes (rate) | Yes (chase) | Yes (terms) |
| Feels unrelated? | No | No | No |

**Verdict:** All three reinforce one another. None feel unrelated. Fragmentation is **go-to-market and UX**, not domain.

---

## Pairwise synergy analysis

| Pair | Relationship | Evidence |
|------|--------------|----------|
| P001 ↔ P002 | Sequential (indirect) | Rate informs pricing; chase handles collection — no code link |
| P001 ↔ P003 | Sequential (indirect) | Rate + terms = complete quote foundation — Quick Proposal bridges |
| P002 ↔ P003 | **Direct lifecycle** | M015: prevention before collection; terms should prefill chase |
| All three | Suite | M015 Get Paid Toolkit narrative; backlog suite deepening option |

---

## Investment summary

| Product | Class | Hold / Action |
|---------|-------|---------------|
| P001 | Supporting | Hold; light refresh when suite unifies |
| P002 | Flagship | Invest; primary monetization candidate |
| P003 | Merge into Suite | Hold; integrate UX, don't market standalone |

**Do not archive or sunset any product.** All are active, deployed, and domain-coherent.

---

## Product synergy recommendation

**Remain modules inside a larger suite — not independent products, not yet a single merged codebase.**

Suite design (evidence-based, not built this mission):

| Element | Recommendation | Evidence |
|---------|----------------|----------|
| **Navigation** | `/products/get-paid-toolkit/` landing + nav pills in all three `index.html` | M015 gap; P003 already has pills |
| **Branding** | Shared palette (sage/warm paper from P002/P003); P001 dark theme updated | Backlog; three visual identities noted |
| **Shared code** | `suite/tone.js`, `suite/copy.js`, `suite/storage.js` — optional shared folder | Duplicated tone chips in P002/P003 |
| **Shared UI** | Suite header component (HTML partial or copy-paste block) | P003 suite badge pattern |
| **Deployment** | Keep per-product URLs; add suite landing | Standards §7 `/products/` pattern |
| **Future expansion** | Scope Guard, Quick Proposal as P004/P005 within suite | M015 candidates #2, #3 |

**Not recommended now:** Single SPA, shared auth, or merged repo — violates M013 graduation path and overbuilds per Principles §7.
