# Backlog

The queue of upcoming missions, in order. The top item is next. A mission
starts only after the operator approves the previous mission's report.

## Next: Mission 012 — Execution Engine Foundation

**Goal:** Implement the first concrete pieces of the Execution Engine
architectural contract defined in Mission 011 — still no cloud orchestration,
background services, or fabricated automation.

**Scope** (from [system/execution-engine.md](../system/execution-engine.md)):

- `system/execution-engine.yaml` interface sketch (if approved)
- Compiler exposure of execution-plan placeholders derived only from repository state
- Command Center Execution card (foundation only — never imply live orchestration)

**Explicitly out of scope:** External APIs, agent spawning, databases, auto-merge.

## Mission 011 Record — Architecture Integration

Mission 011 integrated the independent architecture audit without redesigning V2:

- Reconciled README, Standards, deployment URLs, and entry points
- Removed legacy `file-index` shims; `system/assets.yaml` is sole registry
- Created `decisions/` with seven decision records + `decisions.json`
- Documented Execution Engine foundation (`system/execution-engine.md`)
- Strengthened Repository Intelligence lookup (context packages, reverse deps)
- Updated Mission Control architecture stack and deployment clarity

See [missions/011-architecture-integration/report.md](../missions/011-architecture-integration/report.md).

## Mission 010 Record — Repository Intelligence Foundation

Mission 010 created the Repository Intelligence Layer:

- `system/manifest.yaml` — pointer graph (source)
- `system/context-packages.yaml` — five agent context packages
- `compiler/RepositoryIntelligence.php` — manifest, packages, validation, lookup
- `site/data/manifest.json`, `context-packages.json`, `dependency-report.json`, `repository.json`
- Command Center Repository Intelligence cards
- Standards §6

See [missions/010-repository-intelligence/report.md](../missions/010-repository-intelligence/report.md).

## Mission 009 Record — File Index Foundation → Asset Registry

Mission 009 created the canonical registry layer, which evolved within the
same mission from a file index to the **Asset Registry**:

- `system/assets.yaml` — canonical Asset Registry (v2 schema)
- `system/assets.md` — iPhone-friendly companion
- Standards §5 — asset registry maintenance rules
- Compiler `asset_registry` summary in `organization.json`; full lookup in `repository.json`

Legacy `file-index` shims were removed in Mission 011.

See [missions/009-file-index-foundation/report.md](../missions/009-file-index-foundation/report.md).

## Paused: Mission 006 — Validate the Recommendation

Mission 006 remains **paused at Phase B** — operator-executed freelancer
interviews and landing-page smoke test. Thresholds locked per
[phase-a-thresholds.md](../missions/006-validate-recommendation/phase-a-thresholds.md).
Phase C begins when raw results return.

## Later

- **Mission 013 — Derived Artifact Generation** (expand compiler outputs)
- Full V2 sequence: [missions/007-design-v2/report.md](../missions/007-design-v2/report.md)
