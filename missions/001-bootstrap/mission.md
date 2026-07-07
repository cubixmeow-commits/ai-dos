# Mission 001: Bootstrap the Repository

**Status:** Complete — see [report.md](report.md)

> **Note (added in Mission 002):** references to "Mission 002" in this brief
> predate a renumbering. The Prove-the-Loop research cycle described below
> is now **Mission 003**; Mission 002 became "Formalize the Knowledge
> Preservation Standard." This brief is preserved as written.

## Objective

Create the smallest useful repository structure required to run Mission 002
("Prove the Loop" — a full research cycle that selects the first benchmark
app).

## Constraints

- Do not overbuild: no speculative folders, no placeholder systems.
- No agent files unless Mission 001 directly requires one. Each mission
  creates only what it uses (Mission 002 creates the Researcher).
- No application code. Do not pick the benchmark app yet.
- Hard cap: 10 files maximum. Needing more must be justified in the report,
  not acted on.
- Small purposeful commits: `M001: <what> — <one-line why>`. A single
  "initial commit" fails the mission.

## Required Outcome (cold-start test)

A stranger or fresh AI session must be able to clone the repository and
answer, by pointing at specific files:

1. What is AI-DOS?
2. Why does it exist?
3. How does it operate?
4. What happened during Mission 001?
5. What should Mission 002 do next?

## Deliverables

- `company/Identity.md` and `company/Principles.md`
- `README.md` written for a zero-context outside reader
- `tasks/Backlog.md` with Mission 002 queued
- `report.md` in this folder, ending with a single Y/N approval question,
  readable in under five minutes on a phone
