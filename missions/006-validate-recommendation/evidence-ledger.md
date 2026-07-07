# Mission 006 Evidence Ledger (Phase A)

Every claim gathered in Phase A (2026-07-07), in one table, so a future
agent can check "what facts exist" without rereading every file. Tiers
per [Standards §1.3](../../company/Standards.md): **[V]** fetched &
verified · **[S]** search-accessed only · **[U]** unverified.

Mission 003 claims are **not** duplicated here; they remain registered in
[003 research.md §6](../003-prove-the-loop/research.md). Rows below either
update a Mission 003 claim's tier or are new to Phase A.

A caution that applies to every [S] row: search-result summaries are
synthesized by the search tool. A claim is recorded here only when tied to
a specific returned URL, but the page content itself was never read —
snippet fidelity is still the load-bearing assumption (Mission 003
research.md §7, assumption #1).

## §1 Claims

| # | Claim | Source | Tier | URL | Verified | Used by |
|---|---|---|---|---|---|---|
| 1 | 29% of freelance invoices paid ≥1 day late; women 31% vs men 24%; software developers 29% | Bonsai (invoicing platform) study | S (unchanged from M003) | https://www.hellobonsai.com/blog/late-freelance-payment | No — fetch 403 (gateway policy denial), retried this session | Threshold I1; landing-page copy |
| 2 | Bonsai study methodology: 3 years of invoicing data across a 100k+-freelancer platform; invoices >$20k ~3× more likely late | Bonsai study, via search snippet | S (new detail) | https://www.hellobonsai.com/blog/late-freelance-payment | No — same block | Context; seller-bias flag (P3) |
| 3 | 85% of freelancers paid late at least sometimes; >1 in 5 late more than half the time | getinvoicefree.app blog | S (unchanged from M003) | https://www.getinvoicefree.app/blog-freelance-invoice-late-payment.html | No — fetch 403, retried this session | Threshold I1 justification |
| 4 | 71% of UK freelancers have experienced late payment; average overdue invoice 23 days past due (attributed to 2025 IPSE survey) | IPSE via Landolio blog (competitor content marketing — bias flag) | **S (upgraded from U)** — an attributable IPSE campaign page now identified, but figures still trace only through third-party snippets | https://www.ipse.co.uk/campaigns/prompt-payment/late-payment-within-the-self-employed-sector (blocked); https://landolio.com/blog/automated-invoice-reminder-tools-freelancers (blocked) | No — both fetches 403 | Context only, per §1.3 rules |
| 5 | Landolio: UK-focused, purpose-built invoice follow-up tool; core automated reminders **free**; customizable pre-due/on-due/overdue sequences; friendly→firm tone control; who-owes-what dashboard | Landolio site + blog snippets, dev.to posts by Landolio | S | https://landolio.com/ ; https://dev.to/landolio/a-simple-invoice-follow-up-system-for-uk-freelancers-who-are-tired-of-chasing-payments-143k | No — fetches 403 | Teardown; thresholds I3, S1; predictions P1 |
| 6 | Landolio monetizes via one-off digital products: £7 Invoice Email Pack; "Getting Paid Toolkit" (37 templates & contract clauses); ~25 free tools as content marketing | Landolio product pages + dev.to snippets | S | https://landolio.com/products/getting-paid-toolkit | No | Threshold I3 price floor |
| 7 | autoremind.ai is a **general** AI follow-up reminder tool (email, Slack, Teams) with auto-escalating tone; invoice chasing is a marketed use case, not the product | autoremind.ai site snippets | S | https://www.autoremind.ai/ | No — fetch 403 | Teardown |
| 8 | autoremind.ai pricing: free plan (1 active reminder, ≤3 follow-ups); Pro $9/mo or $7.50/mo annual ($90/yr) with 10 active reminders, unlimited follow-ups, AI messages, analytics; 7-day trial | autoremind.ai via search snippet | S | https://www.autoremind.ai/ (pricing surfaced in search results) | No | Threshold I3 price floor; landing-page price anchor |
| 9 | InvoicifyAI is an AI receptionist + CRM + invoicing suite for local service businesses ("From Missed Call to Booked Job to Paid Invoice"); Professional bundle $129/mo incl. 200 reception minutes; invoice collections is one of 4 voice agents | invoicifyai.com snippets, slashdot.org listing | S | https://www.invoicifyai.com/ ; https://slashdot.org/software/p/InvoicifyAI/ | No — fetch 403 | Teardown (corrects M003 characterization) |
| 10 | InvoicifyAI's standalone invoice-reminder product ("Get Paid Faster Without The Awkward Conversations") is in a **waitlist** phase | waitlist subdomain snippet | S | https://waitlist.invoicifyai.com/ | No | Teardown — the standalone gap is still open |
| 11 | Stripe Invoicing has native automatic reminders: email-only, on/off with limited before/on/after-due scheduling, Stripe's default template, no per-customer cadence | Stripe docs + PayRequest blog (a reminder-tool vendor — bias flag) | S | https://docs.stripe.com/invoicing/automatic-collection ; https://payrequest.io/blog/stripe-invoice-reminders-limitations-2026 | No — not fetched | Abort-condition check (negative); prediction P4 |
| 12 | A dense adjacent ecosystem of Stripe-integrated SMB accounts-receivable/dunning tools exists: Chaser, Paidnice, PayRequest, NudgePe, Payment Hunter | search results (multiple vendor sites) | S | https://www.chaserhq.com/integrations/stripe ; https://www.paidnice.com/integrations/stripe ; https://nudgepe.com/blog/stripe-reminders-not-enough ; https://paymenthunter.bot/blog/payment-reminder-tool-with-stripe-integration | No | Teardown context; prediction P4 |

## §2 Blocked fetch attempts (this session, 2026-07-07)

All returned HTTP 403. Proxy diagnostics (`__agentproxy/status`) show
`connect_rejected: gateway answered 403 to CONNECT (policy denial)` — the
block is the session's **network policy at the gateway**, not the origin
sites. This is the same constraint Mission 003 recorded.

| URL attempted | Purpose |
|---|---|
| https://www.hellobonsai.com/blog/late-freelance-payment | Verify claim #1 (twice: WebFetch + curl) |
| https://www.getinvoicefree.app/blog-freelance-invoice-late-payment.html | Verify claim #3 |
| https://clockify.me/late-invoice-statistics | Corroborating stats roundup |
| https://www.ipse.co.uk/campaigns/prompt-payment/late-payment-within-the-self-employed-sector | Verify claim #4 (WebFetch + curl) |
| https://cpa.co.uk/forty-one-percent-of-the-uks-freelancers-are-consistently-paid-late/ | Corroborate claim #4 |
| https://landolio.com/blog/automated-invoice-reminder-tools-freelancers | Teardown + claim #4 chain |
| https://landolio.com/pricing | Teardown pricing |
| https://www.autoremind.ai | Teardown pricing |
| https://www.invoicifyai.com/invoice-reminder-agent | Teardown |
| https://dev.to/landolio/a-simple-invoice-follow-up-system-for-uk-freelancers-who-are-tired-of-chasing-payments-143k | Teardown |
| https://web.archive.org/web/2026/https://www.hellobonsai.com/blog/late-freelance-payment | Archive route around the block (tool-level refusal) |

Direct `curl` was also blocked for every tested host, including
github.com, confirming the gateway policy applies session-wide.

## §3 Net effect on Mission 003's evidence picture

- **No claim could be upgraded to [V].** The core pain statistics
  (claims 1, 3) remain [S]; "still-unverified" is recorded plainly rather
  than paraphrased as fact.
- **One upgrade U→S** (claim 4, IPSE): a specific IPSE campaign URL now
  anchors the claim, with an explicit bias flag because the figures reach
  us via a competitor's content marketing.
- **One correction:** Mission 003 grouped InvoicifyAI with "small
  standalone entrants." Claims 9–10 show it is a $129/mo service-business
  suite whose standalone chaser is pre-launch. The standalone niche is
  therefore: one free UK-focused tool (Landolio), one generic reminder
  tool ($9/mo), one waitlist.
- **One new competitive fact that matters most:** the most direct
  competitor's core product is **free** (claim 5). This does not trigger
  the abort condition — Landolio is small and the niche remains unowned —
  but it directly pressures the revenue assumption and is priced into
  threshold I3 and prediction P1.
