# Product Opportunities — Mission 016

**Method:** Brainstorm ≥20 ideas from repository deferrals, mission reports, and pattern analysis. Score each. Reject most. Select strongest for post-suite roadmap.

**Scoring dimensions (1–5 each, max 20):** portfolio fit, build effort inverse, revenue potential (documented reasoning only), strategic importance, AI-DOS learning value.

No fabricated market validation. Revenue scores reflect **reasoning from repo evidence**, not customer data.

---

## Opportunity pool (24 ideas)

### Tier 1 — Get Paid Toolkit extensions (from M013/M015 deferrals)

| # | Product | Target customer | Problem | Portfolio fit | Effort | Revenue | Selected? |
|---|---------|-----------------|---------|---------------|--------|---------|-----------|
| 1 | **Scope Guard** | Freelancers facing scope creep | Hard to say "no" professionally | 5 | 5–7h | 3 | **YES** |
| 2 | **Quick Proposal** | Freelancers quoting new work | Proposals slow; P001 rate disconnected | 5 | 8–10h | 4 | **YES** |
| 3 | Deposit Calculator | Freelancers starting projects | How much upfront deposit | 3 | 3h | 2 | NO |
| 4 | Invoice Due-Date Cash Flow View | Freelancers managing cash | When money arrives | 3 | 6h | 2 | NO |
| 5 | Late Fee Calculator | Freelancers with overdue invoices | What fee to charge | 3 | 2h | 2 | NO |
| 6 | Payment Reminder Schedule Planner | Freelancers pre-planning chases | When to send reminders | 4 | 4h | 3 | NO |
| 7 | Client Onboarding Email Pack | Freelancers starting engagements | Welcome + expectations email | 4 | 4h | 3 | NO |
| 8 | Invoice Footer Library | Freelancers polishing invoices | Professional footer snippets | 3 | 3h | 2 | NO |

### Tier 2 — M003/M006 platform path (deferred SaaS)

| # | Product | Target customer | Problem | Portfolio fit | Effort | Revenue | Selected? |
|---|---------|-----------------|---------|---------------|--------|---------|-----------|
| 9 | **Invoice Follow-Up SaaS** | Freelancers with repeat late payers | Automate chase until paid | 5 | Multi-mission | 5 | **CONDITIONAL** |
| 10 | Stripe Payment Link Helper | Freelancers collecting payment | Easy pay link in reminders | 4 | 4h | 3 | MAYBE (P002 addon) |
| 11 | Client Payment Portal | Freelancers | Client self-serve status | 3 | High | 4 | NO |
| 12 | Recurring Invoice Tracker | Retainer freelancers | Track recurring billing | 3 | High | 3 | NO |

### Tier 3 — Suite infrastructure (not standalone products)

| # | Initiative | Target | Problem | Portfolio fit | Effort | Revenue | Selected? |
|---|------------|--------|---------|---------------|--------|---------|-----------|
| 13 | **Get Paid Toolkit Landing Page** | Freelancers discovering suite | Fragmented product URLs | 5 | 4–6h | 3 | **YES (M017)** |
| 14 | Shared Suite JS Module | Internal | Duplicated tone/copy code | 4 | 3h | 0 | **YES (M017)** |
| 15 | Suite Analytics (privacy-first) | Operator | No usage signal | 4 | 6h | 0 | **YES (M017)** |
| 16 | Unified Suite Branding | Freelancers | Three visual identities | 5 | 6h | 2 | **YES (M017)** |

### Tier 4 — M003/M014 rejected dev utilities

| # | Product | Target | Problem | Portfolio fit | Effort | Revenue | Selected? |
|---|---------|-----------------|---------|---------------|--------|---------|-----------|
| 17 | JSON Explorer | Developers | Pretty-print JSON | 1 | 4h | 1 | NO |
| 18 | Markdown Table Builder | Developers | Build tables | 1 | 3h | 1 | NO |
| 19 | Regex Lab | Developers | Test regex | 1 | 5h | 1 | NO |
| 20 | Changelog Draft Generator | Developers | Write changelogs | 2 | 4h | 2 | NO |

### Tier 5 — M003 rejected market expansions

| # | Product | Target | Problem | Portfolio fit | Effort | Revenue | Selected? |
|---|---------|-----------------|---------|---------------|--------|---------|-----------|
| 21 | Habit Tracker | Consumers | Build habits | 0 | High | 2 | NO |
| 22 | SEO Directory Builder | Marketers | Directory sites | 0 | High | 3 | NO |
| 23 | Podcast Show Notes AI | Podcasters | Show notes | 0 | Medium | 2 | NO |
| 24 | AI Resume Tailor | Job seekers | Tailor resume | 1 | Medium | 3 | NO |

---

## Rejection rationale (summary)

| Rejected cluster | Why rejected | Evidence |
|------------------|--------------|----------|
| Deposit Calculator, Late Fee Calc, Cash Flow View | Redundant with P003 deposit % and P001 math | M015 #4 rejected; M013 scores |
| Dev utilities (17–20) | M014 explicitly rejected; breaks freelancer ICP | M014 brainstorm discard |
| Consumer/random SaaS (21–24) | M003 scanned and discarded 14 candidates | M003 research.md |
| Client portal, recurring tracker | Platform scope; violates finished-beats-ambitious | M013, Principles §7 |
| Invoice Footer Library | Subset of P003 outputs | P003 already generates footers |

---

## Selected opportunities (ranked)

Scoring: customer value (CV), implementation effort inverse (IE), strategic importance (SI), revenue potential reasoning (RP), portfolio value (PV), AI-DOS learning (AL). Weighted judgment from repo evidence — not personal preference.

| Rank | Opportunity | CV | IE | SI | RP | PV | AL | Total /40 | Notes |
|------|-------------|----|----|----|----|----|----|-------------|-------|
| **1** | **Suite unification (13–16 bundle)** | 5 | 5 | 5 | 3 | 5 | 4 | **27** | Mission 016 recommendation B |
| **2** | **Scope Guard (P004)** | 4 | 4 | 4 | 3 | 4 | 4 | **23** | M015 #2; margin protection |
| **3** | **Quick Proposal (P005)** | 4 | 3 | 4 | 4 | 5 | 3 | **23** | P001 extension; shareable output |
| **4** | **M006 Phase B completion** | 5 | 2 | 5 | 5 | 3 | 5 | **25** | Gates SaaS path — operator-dependent |
| **5** | Invoice Follow-Up SaaS | 5 | 1 | 5 | 5 | 5 | 4 | **25** | **Conditional** on M006 outcome |
| **6** | Stripe Payment Link Helper | 3 | 4 | 3 | 3 | 3 | 2 | **18** | P002 Pro tier addon |
| **7** | Payment Reminder Schedule Planner | 3 | 4 | 3 | 3 | 3 | 2 | **18** | Overlaps P002/P003 |

**Note on ranks 4–5:** M006 and SaaS score high strategically but are **blocked on operator fieldwork** (M006 Phase B). Suite unification ranks #1 because it is **executable immediately** without validation gate.

---

## Next product selection (evidence-based)

**Mission 017 should NOT jump to Product 004 before suite unification.**

Sequence:

1. **Suite infrastructure** (landing, branding, cross-links, analytics) — not a numbered product but required by recommendation B
2. **P004 Scope Guard** — if building next product: M015 scored 33/40; M013 deferral; same copy-tool pattern; extends suite to **margin protection** (adjacent to get-paid)
3. **P005 Quick Proposal** — after P004 or in parallel only if suite shell exists (needs P001 rate handoff story)

**Do not select next:**

- Invoice Follow-Up SaaS — until M006 Phase B completes or is formally sunset (D006)
- Dev utilities — rejected twice (M014, M003)
- Deposit Calculator — redundant with P003

---

## Revenue opportunity reasoning (no fabricated data)

| Opportunity | Revenue reasoning | Risk |
|-------------|-------------------|------|
| Suite unification | Enables bundle positioning; Landolio sells "Getting Paid Toolkit" products (M006) | No WTP proof for bundle either |
| Scope Guard | Change-order emails → future paid template packs | Lower frequency than invoice chase |
| Quick Proposal | Shareable proposals → Pro tier (M015 revenue 4/5) | More UI than copy-tool |
| Invoice SaaS | M003 original thesis; M006 I3 threshold for WTP | Landolio free; feature-not-product |
| Analytics | Operator learning only v1 | Not revenue; enables evidence |

**Honest statement:** No product has revenue. All monetization is **hypothesis documented in READMEs and mission reports**. M006 exists precisely because M003 revenue assumptions were Medium confidence.
