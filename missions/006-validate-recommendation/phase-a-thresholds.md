# Mission 006 — Phase A Interim Note: Instruments & Pre-Registered Thresholds

**Status:** Phase A complete, 2026-07-07. This note is the approval gate
between Phase A (agent desk work) and Phase B (operator-executed
interviews + smoke test). Once the operator confirms, the thresholds in
§4 are **locked** and cannot be adjusted after seeing results.

> **Gate result: CONFIRMED — thresholds locked.** The operator answered
> **Y** to the §6 question on 2026-07-07. Per Standards §2 the merge of
> this branch into `main` is the permanent record of that approval. From
> this point, §4 may not be edited; Phase C scores against it verbatim.

Evidence backing every claim referenced here:
[evidence-ledger.md](evidence-ledger.md) (cited below as L#).
Tiers per [Standards §1.3](../../company/Standards.md).

## §1 Task A1 outcome — statistics still unverified, and why

This session attempted to fetch-verify the Mission 003 core statistics.
**Every fetch was blocked at the network gateway** (HTTP 403 CONNECT
rejection — a session network-policy denial, verified via proxy
diagnostics, not an origin block). The full attempt log is in the ledger
(evidence-ledger.md §2). Consequences, stated plainly:

- The Bonsai 29% statistic and the 85% / >1-in-5 statistics **remain
  [S]-tier** — search-accessed, never read from their pages (L1, L3).
  They are *not* verified facts, and Phase B interviews are now the only
  independent check on them available to this organization.
- The IPSE 71% / 23-days claim is **upgraded [U]→[S]**: a specific IPSE
  campaign page now anchors it, but the figures still reach us only
  through a competitor's content marketing, so it stays context-only with
  a bias flag (L4).
- New context on the Bonsai study surfaced (3 years of platform invoicing
  data, 100k+ freelancers — L2) but a platform that sells invoicing tools
  is a seller of the cure measuring the disease; see prediction P3.

If a future session runs under a less restricted network policy, upgrading
L1 and L3 to [V] is the first thing it should do.

## §2 Task A2 — competitor teardown

All rows [S]-tier; no competitor page could be fetched directly (ledger §2).

| | Landolio (L5–L6) | autoremind.ai (L7–L8) | InvoicifyAI (L9–L10) |
|---|---|---|---|
| What it actually is | UK-focused, purpose-built invoice follow-up tool | **General** AI follow-up reminder tool (email/Slack/Teams); invoices are a use case | AI receptionist + CRM + invoicing suite for local service businesses |
| Core chaser pricing | **Free** | Free: 1 active reminder, ≤3 follow-ups. Pro: **$9/mo** ($7.50/mo annual) | $129/mo Professional bundle; collections is 1 of 4 voice agents. Standalone chaser: **waitlist only** |
| Reminder features | Pre-due/on-due/overdue sequences, friendly→firm tone control, who-owes-what dashboard | AI-written messages, auto tone escalation, stops on reply, natural-language setup | Voice agent calls customers, logs outcomes, schedules follow-ups |
| Monetization | £7 Invoice Email Pack; "Getting Paid Toolkit" one-off products | Subscription | Subscription (suite) |
| Distribution | Heavy content marketing (their blog is the top search source for this niche's statistics) | Product-led, multi-use-case | Service-business vertical |

**What changed versus Mission 003's picture:**

1. **The most direct competitor is free.** Mission 003 treated "no
   dominant standalone" as an open paid niche. Landolio's core sequences
   cost £0; it monetizes with one-off digital products. Willingness to
   pay for a *standalone* chaser is now the single most doubtful
   assumption, and threshold I3 exists specifically to test it.
2. **InvoicifyAI was mischaracterized.** It is not a small standalone
   entrant; it is a $129/mo suite whose standalone chaser is pre-launch
   (L9–L10). The standalone niche is therefore even emptier than
   Mission 003 thought — one free tool, one generic tool, one waitlist —
   which cuts both ways: less competition, and less proof anyone pays.
3. **The SMB-adjacent space is dense.** Stripe ships basic native
   reminders (email-only, limited cadence — L11) and a thick layer of
   Stripe-integrated dunning tools serves SMBs (Chaser, Paidnice,
   PayRequest, NudgePe — L12). The freelancer segment is the only gap;
   drift upmarket and the product collides with incumbents immediately.

**Abort condition assessed and not triggered:** no named competitor
shipping the exact product at scale, no acquisition, no new native
platform launch — Stripe's reminders are long-standing and were already
priced into Mission 003's "feature, not product" risk.

## §3 Task A3 — validation instruments (drafted, NOT launched)

### §3.1 Freelancer interview script

Rules for the operator: ask about **past behavior before pitching
anything** (Q1–Q4 come strictly before Q5); never lead; record answers
verbatim per interviewee, including refusals and non-answers; 15 minutes
is enough. Do not mention price before Q7; let them name numbers first.

1. Tell me about the last time an invoice was paid late. What happened,
   and how late was it?
2. How do you currently keep track of which invoices are overdue —
   a tool, a spreadsheet, memory?
3. Walk me through what you actually do when an invoice goes overdue.
   First nudge, second nudge, escalation? How does writing those emails
   feel?
4. Have you tried any tool for this (including your invoicing app's
   built-in reminders)? Why did you keep or abandon it?
5. *(Concept — read verbatim:)* "Imagine a standalone tool: you register
   an invoice or connect Stripe, and it sends polite, escalating
   reminders with a payment link — in your name — until the invoice is
   paid." What's your first reaction?
6. Would you let a tool email your clients on your behalf? What exactly
   would worry you about that?
7. What would it have to do for you to pay for it — and what monthly
   price would feel fair? *(Do not suggest a number.)*
8. Some invoicing apps bundle reminders for free. What would make you
   use a separate tool instead of — or on top of — that?
9. What would convince you the reminders won't damage the client
   relationship?
10. We're opening a small free beta next month. Want in? *(Counts as
    commitment ONLY if they give an email address for it — politeness
    doesn't count.)*

**Where to find 5–10 freelancers** (places to look, no access assumed):
r/freelance and r/freelanceWriters (check each subreddit's self-promo
rules; use designated feedback threads), Indie Hackers (including the
founder publicly validating this same idea — Mission 003 research.md §6
source 23 — a conversation, not a customer), freelancer communities such
as Freelancing Females and Leapers (UK, IPSE-adjacent), plus the
operator's own network/LinkedIn. Aim for at least 3 interviewees with no
prior relationship to the operator.

### §3.2 Landing-page smoke test

Draft at [`/site/validation/invoice-tool.html`](../../site/validation/invoice-tool.html)
— a static, self-contained page clearly marked (in-page and in comments)
as a Mission 006 validation artifact, not part of any product. It states
the Mission 003 value proposition, shows an honest "planned pricing:
~$9/month" anchor (matching the paid competitor price point, L8) so
signups are price-qualified, and captures email signups.

**Before launch the operator must** (marked `OPERATOR TODO` in the file):

1. Connect the form to a real endpoint (e.g., Formspree, Tally,
   Buttondown). Until then the page refuses submissions with an honest
   "not collecting signups yet" message — it will not fake success.
2. Add a visitor counter (a privacy-friendly one like GoatCounter or
   Plausible; the page has a commented slot). **Without a visitor count
   the conversion threshold S1 cannot be scored.**
3. Decide traffic channels (same communities as §3.1, plus anywhere the
   operator can post honestly). Record where traffic came from.

## §4 Task A4 — pre-registered thresholds

Set now, before any real-world data exists, precisely so results cannot
bend them. With N≈8 interviews these are coarse counts, not statistics —
that is acknowledged and is why the smoke test exists as a second,
independent signal.

**Honesty note on benchmarks:** no external landing-page conversion
benchmark could be evidence-verified under this session's network policy,
so S1 is justified by decision economics (what the business would need),
not by an industry benchmark cited from memory — citing from memory is
exactly what Standards §1.3 forbids.

### Interviews (target N=8; scoring valid if 6–10 completed)

| # | Criterion | Pass | Fail | Inconclusive | Justification |
|---|---|---|---|---|---|
| I1 | Pain is real: interviewee reports a late invoice within ~6 months AND describes manually chasing it | ≥5 of 8 | ≤3 of 8 | 4 of 8 | The [S] statistics claim 85% experience late payment (L3). Requiring 62.5% is a *discount* on that claim; if a discounted bar fails among people who self-select into talking about invoicing, the core [S] statistics are misleading for our segment (see P3) |
| I2 | Trust the core mechanic: would let a standalone tool email clients in their name | ≥4 of 8 | ≤2 of 8 | 3 of 8 | Mission 003's tone/trust risk. The product is dead without delegated sending, so this is a 50% bar on the make-or-break assumption — no Mission 003 evidence quantifies it, which is why it must be measured |
| I3 | Willingness to pay: commits to the beta (gives email) AND names a fair price ≥$5/mo unprompted | ≥3 of 8 | ≤1 of 8 | 2 of 8 | The direct competitor is free (L5) and the paid anchor in the category is $9/mo (L8). $5/mo is the floor below which a standalone can't out-earn a £7 one-off product; 37.5% is deliberately demanding because interview commitments overstate real conversion |

### Smoke test (window: 14 days from launch; validity floor: ≥100 unique visitors)

| # | Criterion | Pass | Fail | Inconclusive |
|---|---|---|---|---|
| S1 | Unique-visitor → email-signup conversion on a price-anchored page | ≥5% | <2% (with ≥100 visitors) | 2–5%, or <100 visitors in 14 days (traffic failure, not demand failure — fix the channel, not the verdict) |

Justification for 5%/2%: the page asks for a near-zero-cost yes (an email
for early access) while honestly displaying a ~$9/mo price anchor.
Against a free incumbent (L5), fewer than 1-in-50 interested visitors
leaving an email cannot support a paid standalone — that is a Fail
regardless of how it "feels." 100 visitors is the floor at which whole
percentage points stop being single-person noise (5% = 5 signups).

### Combined verdict rule (pre-registered)

- **PASS** — I1, I2, I3 all pass AND S1 passes.
- **FAIL** — any of: I1 fails (pain stats contradicted), I2 fails (trust
  barrier decisive), I3 fails (no willingness to pay), or S1 fails with a
  valid sample.
- **INCONCLUSIVE** — everything else, including decisively conflicting
  signals (e.g., interviews pass but S1 fails). Maps to Outcome C
  (Continue Validation) with the missing piece named.

If only one instrument produces valid data (e.g., interviews happen but
traffic never reaches 100 visitors), the overall verdict can be at best
INCONCLUSIVE — a single instrument cannot produce a PASS.

## §5 Task A6 — If We Are Wrong (pre-registered, for Phase C to score)

Assume it is six months from now and the recommendation is judged to have
failed. These are predictions of *why*, made from evidence available
today. Phase C must score each one **Held / Refuted / Untested**, citing
actual Phase B data — not rewrite this section.

- **P1 — "Willingness to pay" never transferred.** Mission 003 inferred
  willingness to pay from freelancers paying for invoicing *suites*. The
  standalone niche's actual price is being set at zero by Landolio
  (L5–L6). This is the Mission 003 assumption most likely to prove false.
  *Scored by:* I3 and S1.
- **P2 — The trust barrier, not the pain, is decisive.** Interviews
  confirm pain loudly (I1 passes) but freelancers refuse delegated
  client-facing dunning (I2 fails). If so, Mission 003 weighted
  quantified pain too heavily relative to its own tone-risk finding.
  *Scored by:* I1 vs I2 split.
- **P3 — The [S] statistics are seller-inflated.** The pain numbers come
  from parties selling the cure: an invoicing platform (L1–L2) and a
  competitor's content marketing (L4). If I1 fails its discounted bar,
  the true lesson is: discount seller-authored statistics by default.
  *Scored by:* I1.
- **P4 — Feature-not-product wins in practice.** Visitors and
  interviewees respond "my invoicing app / Stripe already does this"
  (L11–L12). Predicted observable: Q8 answers cluster on "wouldn't use a
  separate tool," and smoke-test conversion dies despite page interest.
  *Scored by:* Q8 answers and S1.
- **P5 — Distribution, not demand, bottlenecks the test.** The operator
  cannot get 100 visitors in 14 days from community posting alone, and
  the mission stalls at Inconclusive-by-traffic. If so, AI-DOS must learn
  that a validation design is incomplete without a traffic plan.
  *Scored by:* visitor count vs the 100 floor.

The single assumption most likely to prove false: **P1** (bundled-suite
willingness-to-pay transferring to a standalone tool). The signal AI-DOS
should learn to weight more heavily next time, if these predictions hold:
**a free incumbent in the exact niche outweighs any quantity of
quantified pain.**

## §6 Interim decision

Phase A is complete: statistics honestly still-unverified with the block
documented (§1, ledger §2), teardown done (§2), instruments drafted but
not launched (§3), thresholds pre-registered (§4), failure predictions
pre-registered (§5). The abort condition was checked and not triggered.

Phase B is the operator's: 5–10 interviews using §3.1, smoke test per
§3.2 for 14 days, then return with raw results (verbatim interview notes,
signup count, unique-visitor count, traffic sources) for Phase C scoring.

Confirm these validation thresholds and launch the smoke test as designed? Y/N
