# Mission 003 Research Record

Everything cited here was accessed during Mission 003 (2026-07-07) via the
session's WebSearch and WebFetch tools. See §1 for what the tooling could
and could not verify — the evidence tiers below exist because of it.

## §1 Method and tooling constraints

- **Tools available:** WebSearch (returns titles, URLs, snippets) and
  WebFetch (full page fetch). The session's network policy **blocked
  WebFetch/curl to most domains** (HTTP 403 at the proxy); github.com was
  reachable. Blocked fetch attempts are recorded in §6.
- **Evidence tiers used throughout:**
  - **[V] Verified** — page fetched directly; claim read from content.
  - **[S] Search-accessed** — claim from a search-result snippet with URL;
    the page itself could not be fetched. Real source, unconfirmed content.
  - **[U] Unverified** — claim appeared in search summaries without a
    clearly attributable URL, or is secondhand. Used for context only.
- No claim below comes from memory. Anything I could not trace to a URL
  returned by a search or fetch during this mission was discarded.

## §2 Broad scan

Candidates considered against the Stage 0 constraints (buildable by one
dev, iPhone-manageable, demonstrates AI-DOS, bounded MVP, light infra,
portfolio story, realistic revenue, iterable). One line per discard;
constraint failures need no external evidence — they are gate failures.

| # | Candidate | Verdict | One-line reason |
|---|---|---|---|
| 1 | Podcast show-notes generator | Discard | Crowded with funded incumbents (Descript, Castmagic — see §6 sources 14–15) |
| 2 | Personal finance tracker | Discard | Bank connections (Plaid) = heavy infra + compliance burden |
| 3 | Native iOS app (any) | Discard | Xcode/Mac pipeline + App Store review breaks iPhone-managed, agent-driven iteration |
| 4 | Two-sided marketplace | Discard | Cold-start problem; not a bounded one-dev MVP |
| 5 | Browser extension | Discard | Not testable/manageable from iPhone; weak revenue norms |
| 6 | Habit tracker / todo app | Discard | Saturated free market; no realistic revenue; weak portfolio story |
| 7 | Niche SEO directory | Discard | Revenue is a slow SEO bet; thin engineering portfolio story |
| 8 | Link-in-bio tool | Discard | Saturated; entrenched free incumbent tier |
| 9 | QR menu builder | Discard | Requires local in-person sales; not iPhone-first operator work |
| 10 | Form builder | Discard | Saturated with strong free tiers |
| 11 | Screenshot/OG-image API (Bannerbear model, §6 source 1) | Discard | API products win on developer distribution/trust — weakest fit for a visible portfolio demo |
| 12 | Uptime monitor (BetterUptime model, §6 source 1) | Discard | Always-on distributed probing violates light-infra constraint |
| 13 | Waitlist/landing-page builder | Discard | Saturated; near-zero differentiation for an MVP |
| 14 | AI resume/cover-letter tailor | Discard | ChatGPT does this free; extreme post-2023 crowding |
| 15 | AI changelog/release-notes tool | **Shortlist A** | Passes all gates; thematic fit with AI-DOS; evidence findable |
| 16 | Testimonial-collection tool | **Shortlist B** | Passes all gates; market proven by Senja (§4); evidence findable |
| 17 | Freelancer invoice follow-up tool | **Shortlist C** | Passes all gates; strongest independent pain evidence (§5) |

**Shortlist rationale:** A, B, C pass every Stage 0 gate and carry three
*distinct* risk profiles — free-commoditization risk (A), dominant-incumbent
risk (B), feature-not-product risk (C) — so the deep dive compares failure
modes, not three variants of one bet. Category viability context: solo
founders sustain $5K–250K MRR micro-SaaS businesses **[S]** (§6 sources
1–2).

## §3 Deep research — Candidate A: AI changelog/release-notes tool

Idea: agent reads a repo's git history and drafts human-readable release
notes/changelog pages; sell to small SaaS teams.

**Pain evidence**
- Changelogs are widely disliked/neglected; one article claims research
  over "500+ Reddit and HackerNews comments" and "72% of developers
  struggle to locate changelogs" — **[U]** the source page
  (blog.getsimpledirect.com, §6 source 13) returned 403 on fetch; the
  percentage could not be confirmed and is used as context only.

**Existing solutions (competition)**
- git-cliff — free OSS changelog generator from git history,
  **12k stars** — **[V]** fetched https://github.com/orhun/git-cliff
- release-drafter — free GitHub Action, "Drafts your next release notes as
  pull requests are merged into master," **3.9k stars** — **[V]** fetched
  https://github.com/release-drafter/release-drafter
- GitHub natively auto-generates release notes from PRs/tags — **[S]**
  (§6 sources 16, 18)
- Paid announcement platforms: Headway $29/mo, Beamer from $49/mo,
  AnnounceKit from $79/mo, LaunchNotes $249/mo — **[S]** (§6 sources 10–12)
- AI-specific micro-SaaS already exists: releasethenotes.com,
  releasesnotes.dev, an "AI Release Notes" GitHub App, and n8n GPT-4
  templates — **[S]** (§6 sources 16–17)

**Observable gap:** paid tools price for product-marketing teams
($29–$249/mo); generators for developers are free. The generation step —
the part AI-DOS would showcase — is the commoditized part. No evidence
found of an underserved paying segment between "free CLI" and
"communication platform."

## §4 Deep research — Candidate B: testimonial-collection tool

Idea: collection forms + widget wall for freelancers/small businesses to
gather and display testimonials.

**Market/pain evidence**
- Senja reportedly reached **$1M ARR** on this exact problem — **[U]**
  secondhand listicle claim (§6 source 2); could not be fetched or
  confirmed.
- Willingness to pay is real at low price points: Senja $19/mo monthly
  ($16 annual); Testimonial.to $60/mo for comparable video plan — **[S]**
  (§6 sources 19–20; note source is Senja's own comparison content, a
  biased source).

**Existing solutions (competition)**
- Senja (generous free tier, described as most generous in category),
  Testimonial.to, Famewall, plus a long tail of alternatives — **[S]**
  (§6 sources 19–21).

**Observable gap:** none found. The incumbent is cheap, liked, and has a
generous free tier; differentiation would be marketing-led, not
product-led. Evidence here is also the thinnest of the three (and partly
incumbent-authored).

## §5 Deep research — Candidate C: freelancer invoice follow-up tool

Idea: standalone "get paid on time" tool — freelancer registers an invoice
(or connects Stripe), tool runs a polite escalating reminder sequence with
a payment link until paid.

**Pain evidence (multiple independent sources agree)**
- **29% of freelance invoices are paid at least a day late**; late rate for
  women 31% vs men 24%; software developers 29% — **[S]** Bonsai (invoicing
  platform) study, §6 source 3; fetch blocked (403).
- **85% of freelancers have invoices paid late at least some of the time;
  >1 in 5 are paid late more than half the time** — **[S]** §6 source 4.
- **71% of UK freelancers have experienced late payment; average overdue
  invoice sits 23 days past due** (attributed to a 2025 IPSE survey) —
  **[U]** appeared in search summary across §6 sources 5–6 without
  fetchable confirmation of the underlying survey.
- Unpaid freelancers owed **$6,000 on average** (attributed to Freelancers
  Union) — **[U]** search summary, ambiguous attribution (§6 sources 7–8).

**Existing solutions (competition)**
- Reminder features inside full invoicing suites: Wave, FreshBooks,
  Bonsai, HoneyBook — **[S]** (§6 sources 5, 9). Reminders are a feature
  of platforms freelancers must fully adopt.
- Dedicated small tools emerging: Landolio, autoremind.ai, InvoicifyAI —
  **[S]** (§6 sources 5–6, 22) — small/new entrants, no dominant standalone.
- An Indie Hackers founder publicly validating this exact idea — **[S]**
  §6 source 23 — evidence the niche is live and not yet won.

**Observable gap:** the pain is quantified by multiple independent sources,
yet the standalone follow-up niche has only small, new entrants; incumbents
bundle reminders inside platforms that demand full workflow migration. A
focused, adoptable-in-minutes chaser has room — but must prove it isn't
just a feature (see failure analysis, evaluation.md §3).

## §6 Source register (every URL accessed or returned this mission)

| # | URL | Tier | Used for |
|---|---|---|---|
| 1 | https://superframeworks.com/articles/best-micro-saas-ideas-solopreneurs | S | micro-SaaS viability context |
| 2 | https://www.vibrantsnap.com/blog/micro-saas-ideas-profitable-niches-2026 | S/U | solo-founder MRR range; Senja $1M ARR claim (U) |
| 3 | https://www.hellobonsai.com/blog/late-freelance-payment | S | 29% late-invoice stat; gender/profession split (fetch 403) |
| 4 | https://www.getinvoicefree.app/blog-freelance-invoice-late-payment.html | S | 85% / >1-in-5 stats |
| 5 | https://landolio.com/blog/automated-invoice-reminder-tools-freelancers | S | dedicated-tool landscape; IPSE claim surfaced here (U) |
| 6 | https://www.autoremind.ai/blog/invoice-reminders-freelancer-guide | S | competitor; reminder-sequence norms |
| 7 | https://clockify.me/late-invoice-statistics | S | late-invoice stats roundup (fetch 403) |
| 8 | https://www.kaplancollectionagency.com/business-advice/trickle-down-debt-how-late-client-payments-to-agencies-cascade-onto-freelancers/ | S | $6k-owed claim context (U attribution) |
| 9 | https://www.waveapps.com/invoicing | S | incumbent bundled reminders |
| 10 | https://www.worknotes.ai/blog/changelog-tools-pricing-comparison | S | Headway/Beamer/AnnounceKit/LaunchNotes pricing |
| 11 | https://announcekit.app/compare | S | AnnounceKit tiers ($79/$129/$339) |
| 12 | https://canny.io/blog/best-changelog-tools/ | S | changelog tool list (fetch 403) |
| 13 | https://blog.getsimpledirect.com/why-developers-hate-your-changelog-and-how-to-fix-it/ | U | "500+ comments"/"72%" claims (fetch 403 — unconfirmed) |
| 14 | https://www.descript.com/blog/article/the-best-ai-tools-for-podcast-show-notes-reviewed | S | podcast-tools crowding (discard #1) |
| 15 | https://www.castmagic.io/post/podcast-show-notes | S | podcast-tools crowding (discard #1) |
| 16 | https://github.com/marketplace/ai-github-release-notes | S | AI release-notes GitHub App exists |
| 17 | https://releasethenotes.com/ and https://www.releasesnotes.dev/ | S | AI release-notes micro-SaaS already shipping |
| 18 | https://arinco.com.au/blog/devops-enhanced-release-automation-with-githubs-ai-powered-release-notes/ | S | GitHub native release-notes generation |
| 19 | https://senja.io/pricing | S | Senja $19/mo ($16 annual) (fetch 403) |
| 20 | https://senja.io/compare/testimonial-to-alternative | S | Testimonial.to $60/mo comparison (incumbent-authored) |
| 21 | https://famewall.io/en/blog/senja-alternative/ | S | testimonial-tool long tail |
| 22 | https://www.invoicifyai.com/invoice-reminder-agent | S | dedicated chaser entrant |
| 23 | https://www.indiehackers.com/post/validating-a-simple-automated-reminder-tool-for-late-freelance-invoices-1188f8d732 | S | same-idea validation activity |
| 24 | https://github.com/orhun/git-cliff | **V** | 12k stars; free changelog generator |
| 25 | https://github.com/release-drafter/release-drafter | **V** | 3.9k stars; free release-notes drafting |

**Blocked fetch attempts (all HTTP 403 at proxy/origin):** sources 3, 7,
12, 13, 19; also https://hn.algolia.com/api/v1/search (Hacker News API) and
direct curl. Only github.com fetches succeeded.

## §7 Assumptions

| # | Assumption | Why necessary | Verified? | Influence on recommendation |
|---|---|---|---|---|
| 1 | Search snippets accurately reflect their source pages | Network policy blocked fetching most pages | **No** | High — most [S] evidence rests on it; reflected in Medium confidence |
| 2 | Cited prices are current (July 2026) | Pricing pages could not be fetched | **No** | Medium — pricing shapes the competition picture, not the winner |
| 3 | Target market is English-speaking, Stripe-payable | Needed to scope MVP claims | No (operator not asked) | Low — all three candidates assumed alike |
| 4 | "iPhone-manageable" = web app whose admin works in mobile Safari, built/operated via AI-DOS missions | Constraint needed an operational definition | Definition, not fact | Medium — drove discards #3, #5, #9 |
| 5 | LLM API cost won't dominate unit economics at MVP scale | Needed for candidates A and C viability | **No** | Low — same for all candidates |
