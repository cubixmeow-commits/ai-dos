# Mission 003 Candidate Evaluation

Scores are 1–5. Every score is justified in §2; evidence references point
to [research.md](research.md) sections and its source register (§6).
All three candidates already passed the Stage 0 constraint gate
(research.md §2) — scoring compares survivors, it does not re-litigate
constraints.

**Candidates**
- **A** — AI changelog/release-notes tool (dev-facing)
- **B** — Testimonial-collection tool (freelancers/small business)
- **C** — Freelancer invoice follow-up ("get paid on time") tool

## §1 Score summary

| Category | A | B | C |
|---|---|---|---|
| Demonstrates AI-DOS | 5 | 3 | 3 |
| Portfolio value | 4 | 2 | 4 |
| Revenue potential | 2 | 3 | 4 |
| Time to MVP | 4 | 4 | 4 |
| Infrastructure simplicity | 4 | 3 | 4 |
| Operator fit (iPhone-first) | 3 | 4 | 4 |
| Future expansion | 3 | 3 | 4 |
| Implementation risk (5 = lowest risk) | 3 | 2 | 3 |
| **Total** | **28** | **24** | **30** |

## §2 Score justifications

**Demonstrates AI-DOS** — A:5 an AI reading git history to produce
human-readable narrative is literally AI-DOS's own thesis (commits as
organizational memory); B:3, C:3 both demonstrate the workflow (agents
building a real SaaS) but the product itself says nothing about AI-DOS.

**Portfolio value** — A:4 dev-tool audience overlaps with people who would
evaluate AI-DOS itself; B:2 "another Senja clone" is a weak story in a
category with a beloved incumbent (research.md §4); C:4 a quantified,
relatable business problem (29%/85% late-payment stats, research.md §5)
makes a strong "found real pain, shipped a fix" narrative.

**Revenue potential** — A:2 the generation step is commoditized: GitHub
generates release notes natively, git-cliff (12k★, verified) and
release-drafter (3.9k★, verified) are free, and several AI micro-SaaS
already ship (research.md §3); the paying segment ($29–$249/mo) buys
communication platforms, not generation. B:3 willingness to pay proven at
$16–$60/mo but price-anchored low by an incumbent with a generous free
tier (research.md §4). C:4 category willingness-to-pay proven by invoicing
suites; multiple independent sources quantify the pain; only small/new
standalone entrants found (research.md §5).

**Time to MVP** — A:4 git API + LLM + hosted page; B:4 form + widget +
wall (video kept out of MVP); C:4 invoice record + scheduled email
sequence + Stripe payment link. All bounded; none scores 5 because each
still needs auth, billing, and a dashboard.

**Infrastructure simplicity** — A:4 GitHub OAuth + LLM API, no storage
burden; B:3 video testimonials (category table stakes per research.md §4)
mean upload/storage/transcoding soon after MVP; C:4 transactional email +
cron + Stripe — commodity plumbing.

**Operator fit (iPhone-first)** — A:3 works, but users are desk-bound
developers and debugging git edge cases skews desktop; B:4 and C:4 are
form-and-dashboard web apps whose admin and customer interactions fit a
phone.

**Future expansion** — A:3 expands sideways into the crowded announcement
space; B:3 expands into reviews/case studies, all contested; C:4 natural
ladder: reminders → deposits → contracts → cash-flow forecasting, adjacent
to money (research.md §5 competitor ladder).

**Implementation risk** — A:3 tech is easy but distribution against free
is hard; B:2 must out-execute a cheap, liked incumbent on its home turf;
C:3 email deliverability and "is this a feature or a product" are real but
addressable risks.

## §3 Failure analysis (mandatory, all three)

**A — AI changelog tool: most likely failure = competing with free.**
GitHub's native generation, 12k-star git-cliff, and existing AI wrappers
mean the buyer must pay for something the platform gives away. Death looks
like: launch, dev-community applause, near-zero conversion because the
free path is good enough. Secondary: LLM cost per large repo scan
compresses margin at low price points.

**B — Testimonial tool: most likely failure = incumbent gravity.**
Senja is cheaper than the previous leader, well-reviewed, and has the
category's most generous free tier (research.md §4, noting the source
bias). A newcomer wins only by outspending on marketing or finding an
unserved niche this research did not surface. Death looks like: feature
parity achieved, CAC exceeds LTV indefinitely. Secondary: video storage
costs arrive early; differentiation claims unprovable.

**C — Invoice follow-up tool: most likely failure = feature, not product.**
Wave/FreshBooks/Bonsai bundle reminders; if freelancers only trust their
invoicing platform to touch client communication, a standalone chaser has
no seat at the table. Death looks like: signups from pain-aware users who
churn once their platform's built-in reminder is "good enough." Secondary:
email deliverability (reminders landing in spam destroy the core promise);
sensitive tone — a robot dunning a human client can damage the freelancer's
relationship; CAC in a space where incumbents own the audience.

## §4 Outcome

**C wins on total (30) and, more importantly, on the shape of its
evidence:** its pain is quantified by multiple independent sources, while
A's weakness (free competition) is the *best-verified fact in the entire
mission* — the only two [V]-tier facts gathered (git-cliff 12k★,
release-drafter 3.9k★) both count against A's revenue. B loses on
incumbent gravity with the thinnest, most biased evidence base. A's
thematic elegance for AI-DOS is real (Demonstrates AI-DOS: 5) but the
mission brief scores it as one category among eight, not a trump card.

The recommendation and its confidence rating are in
[report.md](report.md).
