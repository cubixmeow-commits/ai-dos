# Mission 005: Build the AI-DOS Showcase Page

**Status:** Complete — see [report.md](report.md)
**Executed by:** Codex 5.3

## Why this mission exists

AI-DOS is designed for cold-start continuity, but its canonical artifacts are
dense for first-time outside readers. This mission creates a static showcase
page that explains the system quickly without replacing repository truth.

## Tasks

1. Inspect repository source artifacts (`README.md`, `company/`, `tasks/`,
   and Missions 001-004) and derive showcase content from files only.
2. Create a static, mobile-first showcase at `/site/index.html` with styles in
   `/site/styles.css` (GitHub Pages friendly; no backend/build tooling).
3. Summarize: AI-DOS identity, mission timeline (001-005), learnings,
   governance flow, evidence-based sequencing, current status, and next mission.
4. Add a short Showcase Maintenance standard to `company/Standards.md`.
5. Update `tasks/Backlog.md` sequencing to:
   - Mission 005 = Build the AI-DOS Showcase Page
   - Mission 006 = Validate the Recommendation
   - Mission 007 = Build the Benchmark MVP (conditional on Mission 006)
6. Create Mission 005 records (`mission.md`, `report.md`).

## Constraints

- Do not build a generator.
- Do not add a frontend framework.
- Do not create a backend.
- Do not begin validation.
- Do not redesign governance.
- Do not duplicate large mission reports into the page.
- Keep the site polished but simple.
- Follow the Knowledge Preservation commit standard.

## Exit criteria

- `/site/index.html` exists.
- `/site/styles.css` exists.
- The page explains AI-DOS clearly to an outside reader.
- Missions 001-005 are represented.
- `company/Standards.md` includes Showcase Maintenance.
- `tasks/Backlog.md` is updated to 006/007 sequencing.
- Mission 005 report is complete.
- No validation work has begun.
