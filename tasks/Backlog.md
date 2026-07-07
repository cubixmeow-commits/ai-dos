# Backlog

The queue of upcoming missions, in order. The top item is next. A mission
starts only after the operator approves the previous mission's report.

## Next: Mission 005 — Validate the Recommendation

**Goal:** Close the confidence gaps behind Mission 003's Medium-confidence
recommendation (a standalone invoice follow-up tool for freelancers) before
committing to a build.

**Scope** (from the [Mission 003
report](../missions/003-prove-the-loop/report.md) §"What would increase
confidence"):

- Independently verify the core late-payment statistics (Bonsai, IPSE
  studies) — upgrade them from search-snippet to verified evidence.
- 5–10 short freelancer interviews: how they chase invoices today; would
  they trust a standalone tool to email their clients.
- Pricing/feature teardown of the three small competitors found
  (Landolio, autoremind.ai, InvoicifyAI).
- Landing-page smoke test with a pass/fail signup threshold **agreed with
  the operator before launch**.
- Report ends with a single Y/N question for Mission 005.

**Decision rule:** if validation passes, Mission 006 = Build the Benchmark
MVP; if it fails, return to Mission 003's shortlist with the new evidence.

**Explicitly out of scope:** building the product, writing application
code.

## Later

- **Mission 006 — Build the Benchmark MVP** (conditional on Mission 005
  passing its validation thresholds).
