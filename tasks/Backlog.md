# Backlog

The queue of upcoming missions, in order. The top item is next. A mission
starts only after the operator approves the previous mission's report.

## Next: Mission 011 — Decision Intelligence Layer

**Goal:** Bootstrap the Decision Engine — queryable decision records derived
from mission artifacts, per V2 architecture (Mission 007).

**Scope** (from [Mission 007 architecture](../missions/007-design-v2/architecture.md)):

- Decision record format and storage under repository (no database)
- Compiler integration for decision lookup
- Coordinate with Repository Intelligence lookup (Mission 010)

**Explicitly out of scope:** Mission 006 artifact changes; full Mission Engine.

**Note:** Operator requested a **full architecture review** after Mission 010
before major new capability work. Mission 011 should begin only after that review.

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
- `system/file-index.yaml` / `file-index.md` — legacy compatibility shims
- Standards §5 — asset registry maintenance rules
- Compiler `asset_registry` + derived `file_index` in `organization.json`

See [missions/009-file-index-foundation/report.md](../missions/009-file-index-foundation/report.md).

## Paused: Mission 006 — Validate the Recommendation

Mission 006 remains **paused at Phase B** — operator-executed freelancer
interviews and landing-page smoke test. Thresholds locked per
[phase-a-thresholds.md](../missions/006-validate-recommendation/phase-a-thresholds.md).
Phase C begins when raw results return.

## Later

- **Mission 012 — Mission Engine & Queue Migration**
- **Mission 013 — Derived Artifact Generation** (expand compiler outputs)
- Full V2 sequence: [missions/007-design-v2/report.md](../missions/007-design-v2/report.md)
