# Mission 006: Validate the Recommendation

**Status:** In progress — Phase A complete; awaiting operator confirmation
of thresholds (see [phase-a-thresholds.md](phase-a-thresholds.md))
**Executed by:** Claude Fable 5

## Why this mission exists

Mission 003 recommended building a standalone invoice follow-up tool for
freelancers at **Medium** confidence, and explicitly routed the next
product step to validation rather than build
([003 report §Decision confidence](../003-prove-the-loop/report.md)).
This mission closes those confidence gaps with a real validation process:
verified (or honestly still-unverified) statistics, a competitor teardown,
pre-registered pass/fail thresholds, and real-world evidence gathered by
the operator.

The mission is judged on two independent axes, kept separate throughout:

- **Repository Question:** did AI-DOS execute a proper validation process —
  real evidence, pre-registered thresholds, honest scoring?
- **Market Question:** does this product deserve to exist?

A clean process that concludes "do not build" is a **successful**
Mission 006, not a failed one.

## Phases

The mission has a real-world critical path the agent cannot walk alone,
so it runs in three phases:

- **Phase A (agent, this session):** verify statistics, tear down
  competitors, draft validation instruments, pre-register thresholds and
  failure predictions, then stop at an approval gate.
- **Phase B (operator, outside any session):** conduct 5–10 freelancer
  interviews and run the landing-page smoke test for the agreed window;
  return with raw results.
- **Phase C (agent, follow-up session):** score results against the
  Phase A thresholds exactly as confirmed, rate Decision Confidence,
  apply the decision rule, score the Phase A predictions, and write
  `report.md`.

## Tasks

### Phase A

1. **A1 — Verify the core statistics.** Attempt to fetch-verify the
   Bonsai and IPSE late-payment studies (currently [S]/[U]-tier). Record
   every URL including blocked attempts. If still blocked, say so plainly.
2. **A2 — Competitor teardown.** Pricing and features for Landolio,
   autoremind.ai, InvoicifyAI, with evidence tiers.
3. **A3 — Design the validation instruments.** Draft (do not launch) a
   freelancer interview script with operator sourcing guidance, and a
   landing-page smoke test at `/site/validation/invoice-tool.html`,
   clearly marked as a test artifact.
4. **A4 — Pre-registered thresholds.** Concrete numeric pass/fail/
   inconclusive thresholds, justified against Mission 003 evidence and
   A2 pricing, set before any real-world data exists.
5. **A5 — Evidence Ledger.** Every Phase A claim in one table:
   Claim / Source / Tier / URL / Verified / Used by
   ([evidence-ledger.md](evidence-ledger.md)).
6. **A6 — "If We Are Wrong" pre-mortem.** Pre-registered predictions of
   how this recommendation fails, for Phase C to score.

Phase A ends with an interim note asking exactly one question:
`Confirm these validation thresholds and launch the smoke test as
designed? Y/N` — a real gate; once confirmed, thresholds are locked.

### Phase C (follow-up session, once Phase B data exists)

1. **C1** — Score actual results against the confirmed thresholds; no
   retroactive adjustment. Verdict: Pass / Fail / Inconclusive.
2. **C2** — Rate Decision Confidence (High/Medium/Low, no percentages).
3. **C3** — Apply the decision rule; exactly one of three outcomes:
   **A. Proceed to Build** (Pass → recommend Mission 007: Build the
   Benchmark MVP); **B. Return to Shortlist** (Fail); **C. Continue
   Validation** (Inconclusive → name exactly what's missing). No fourth
   option.
4. **C4** — Score the A6 predictions against actual Phase B results.
5. **C5** — Cold-start verification by file citation.

## Abort condition

If Phase A or C uncovers decisive, specific, cited evidence that
invalidates the recommendation entirely (named competitor ships the exact
feature at scale, acquisition, platform ships it natively), stop, document
the evidence and reasoning, and recommend returning to the Mission 003
shortlist. Evidence outranks the mission plan.

**Phase A assessment: not triggered.** Stripe's native reminders are
long-standing and basic (email-only, limited cadence) — the bundled-feature
risk Mission 003 already priced in, not new evidence. No acquisition or
at-scale standalone launch was found. The material new fact — Landolio's
core follow-up tool is free — tightens the thresholds (see
phase-a-thresholds.md §4) but is not a decisive invalidation.

## Constraints

- Do not begin implementation of the product itself, regardless of outcome.
- Do not fabricate, simulate, or estimate real-world data. Thin or messy
  Phase B data is reported as such; "insufficient evidence" is a
  legitimate verdict.
- Do not adjust thresholds after seeing results.
- Follow the commit standard (Standards §1.1) throughout.
- The only Standards change this mission makes is formalizing the
  evidence-tier scheme as §1.3 (its second use, per Standards §1).
- No new governance objects, Programs, or documents beyond those
  specified here.

## Exit criteria

Phase A is complete when `phase-a-thresholds.md` exists, contains the
updated evidence tiers, the instruments, the thresholds with reasoning,
and the pre-registered predictions, and ends with its one confirmation
question — then stops.

The full mission is complete when:

- Statistics are verified or explicitly marked still-unverified with reasons.
- Competitor teardown is documented.
- Real (not simulated) interview and/or smoke-test results have been
  scored against the pre-registered thresholds.
- A Pass/Fail/Inconclusive verdict is stated with Decision Confidence.
- The decision rule has been applied.
- Cold-start verification passes by file citation.
- `report.md` includes "What AI-DOS Learned" and ends with the one
  approval question matching the verdict.
