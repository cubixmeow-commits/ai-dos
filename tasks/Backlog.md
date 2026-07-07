# Backlog

The queue of upcoming missions, in order. The top item is next. A mission
starts only after the operator approves the previous mission's report.

## Next: Mission 009 — V2 Foundation & Sequencing Reconciliation

**Goal:** Create the `system/` registry layer (`manifest.yaml`, `index.yaml`,
`portfolio.yaml`) and reconcile README.md with approved V2 architecture
(Mission 007). Retroactively index Missions 001–008.

**Scope** (from [Mission 007 report](../missions/007-design-v2/report.md)):

- `system/manifest.yaml` — pointer graph to canonical entry points
- `system/index.yaml` — machine-readable mission registry
- `system/portfolio.yaml` — Portfolio Projects registry (P001 candidate)
- Reconcile README.md mission numbering and current state
- Add renumbering protocol to Standards
- No compiler changes required — Mission 008 compiler already operational

**Explicitly out of scope:** full V2 capability implementation; Mission 006
artifact changes.

## Mission 008 Record — Build the Repository Compiler

Mission 008 built the first **Repository Compiler (PHP)** at
`compiler/compile.php`. It reads mission and company artifacts and generates:

- `site/data/missions.json`
- `site/data/organization.json`
- `site/index.html` (Mission Control interface)
- `site/styles.css`

The repository is organizational source code. Compiler outputs are
disposable views. See [company/Standards.md](../company/Standards.md) §4.

## Paused: Mission 006 — Validate the Recommendation

Mission 006 remains **paused at Phase B** — operator-executed freelancer
interviews and landing-page smoke test. Thresholds locked per
[phase-a-thresholds.md](../missions/006-validate-recommendation/phase-a-thresholds.md).
Phase C begins when raw results return. This backlog entry is unchanged;
only compiler-generated status reflects the pause.

## Later

- **Mission 010 — Derived Artifact Generation** (expand compiler outputs per V2 architecture)
- **Mission 011 — Decision Engine Bootstrap**
- **Mission 012 — Mission Engine & Queue Migration**

Full V2 sequence: [missions/007-design-v2/report.md](../missions/007-design-v2/report.md)
