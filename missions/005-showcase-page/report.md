# Mission 005 Report: Build the AI-DOS Showcase Page

**Status:** Complete.

## What changed

Mission-level summary only; change-level rationale is preserved in `M005:`
commits per [Standards.md §1.2](../../company/Standards.md).

- Created a static showcase:
  - [site/index.html](../../site/index.html)
  - [site/styles.css](../../site/styles.css)
- Updated roadmap sequencing in
  [tasks/Backlog.md](../../tasks/Backlog.md):
  - Mission 006 = Validate the Recommendation
  - Mission 007 = Build the Benchmark MVP (conditional on Mission 006 passing)
- Added a short Showcase Maintenance standard to
  [company/Standards.md](../../company/Standards.md) §3.
- Updated [README.md](../../README.md) §4 so mission numbering and status align
  with this mission's outcomes.
- Added Mission 005 records:
  - [mission.md](mission.md)
  - this report.

## Why the showcase matters

AI-DOS has strong canonical documentation, but first-time readers still need a
fast visual narrative. The showcase improves approachability, portfolio value,
and comprehension speed while preserving Git-native governance rules.

This mission keeps the distinction explicit: the showcase is a reader layer for
humans; mission/report artifacts remain the organizational memory.

## How the page uses repository artifacts

The showcase content was sourced from repository files, not chat history:

- Identity and core framing:
  [company/Identity.md](../../company/Identity.md) and
  [README.md](../../README.md)
- Operating rules and governance lifecycle:
  [company/Principles.md](../../company/Principles.md) and
  [company/Standards.md](../../company/Standards.md)
- Mission outcomes and learning trail:
  [missions/001-bootstrap/report.md](../001-bootstrap/report.md) through
  [missions/004-close-governance-loop/report.md](../004-close-governance-loop/report.md)
- Current queue and next mission:
  [tasks/Backlog.md](../../tasks/Backlog.md)

The footer in `/site/index.html` states canonical precedence explicitly: if
there is a conflict, repository artifacts win.

## How future missions maintain it

Standards §3 now requires updating `/site/index.html` whenever a mission changes
history, current status, next mission, standards, or product direction.

This keeps the showcase synchronized without introducing generators or
additional infrastructure. Maintenance remains simple and mission-scoped.

## Risks / weaknesses discovered

- Manual showcase updates can drift if a mission updates Backlog/Standards but
  forgets `/site/index.html`; the new standard mitigates this by making updates
  an explicit completion requirement.
- The showcase intentionally summarizes; deep detail still requires reading
  canonical mission files.

## What AI-DOS Learned

This mission changed AI-DOS itself in the following ways:

- AI-DOS gained a public-facing visual reader that improves outside
  comprehension without relocating canonical truth.
- AI-DOS now has an explicit maintenance rule tying showcase updates to mission
  completion when state changes.
- Governance and evidence-first sequencing can be communicated clearly in a
  static artifact while preserving repository-first authority.

---

Approve Mission 006: Validate the Recommendation? Y/N
