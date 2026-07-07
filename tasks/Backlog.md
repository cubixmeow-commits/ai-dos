# Backlog

The queue of upcoming missions, in order. The top item is next. A mission
starts only after the operator approves the previous mission's report.

## Next: Mission 013 — Build the First External Product Using AI-DOS

**Goal:** Use the Execution Engine to build a **real software product** — not
more AI-DOS infrastructure.

**Scope:**

- Operator selects product candidate (e.g. invoice follow-up from Mission 003/006
  or a new MVP) in `missions/013-*/mission.md`
- Execute via execution plan work units routed to Cursor and Claude Code
- Mission report proves cold-start continuity and product deliverable

**Execution plan (proposed):** [system/execution-plans/mission-013-first-external-product.yaml](../system/execution-plans/mission-013-first-external-product.yaml)

**Explicitly out of scope:** AI-DOS infrastructure unless blocking the product.

## Mission 012 Record — Execution Engine Foundation

Mission 012 implemented the minimal Execution Engine:

- `system/execution-engine.yaml` — coordination model
- `system/worker-roles.yaml` — capability roles + Cursor/Claude Code mapping
- `system/execution-plans/` — sample plans including Mission 013 proposal
- `compiler/ExecutionEngine.php` → `site/data/execution-engine.json`
- Command Center Execution section
- Standards §10

See [missions/012-execution-engine-foundation/report.md](../missions/012-execution-engine-foundation/report.md).

## Mission 011 Record — Architecture Integration

Mission 011 integrated the independent architecture audit without redesigning V2:

- Reconciled README, Standards, deployment URLs, and entry points
- Removed legacy `file-index` shims; `system/assets.yaml` is sole registry
- Created `decisions/` with seven decision records + `decisions.json`
- Documented Execution Engine foundation (`system/execution-engine.md`)
- Strengthened Repository Intelligence lookup (context packages, reverse deps)
- Updated Mission Control architecture stack and deployment clarity

See [missions/011-architecture-integration/report.md](../missions/011-architecture-integration/report.md).

## Paused: Mission 006 — Validate the Recommendation

Mission 006 remains **paused at Phase B** — operator-executed freelancer
interviews and landing-page smoke test. Mission 013 may resume validation
evidence or choose another product candidate.

## Later

- Full V2 sequence: [missions/007-design-v2/report.md](../missions/007-design-v2/report.md)
