# Mission 007 Report: Design AI-DOS V2

**Status:** Complete
**Executed by:** GPT-5.5 (Cursor Cloud Agent)

## Executive summary

AI-DOS V1 proved that a Git repository can function as organizational
memory for AI-assisted development. Six missions established principles,
standards, governance, evidence tiering, and a showcase reader. That was
the correct bootstrap.

V1 does not scale. Discovery is archaeological, decisions live inside
mission prose, mission lifecycle is convention-only, showcase drifts
manually, and a single Backlog paragraph cannot express parallel tracks
(AI-DOS evolution vs. Mission 006 benchmark validation).

**AI-DOS V2** reframes the system as twelve capabilities over a typed
artifact layer, with a Repository Compiler producing disposable views
(showcase, operator inbox, cold-start answers). The repository remains
canonical. The operator remains final decision-maker. Mission 006 is
untouched.

Full blueprint: [architecture.md](architecture.md).

---

## What was changed and why

Mission-level summary — change-level rationale in `M007:` commits per
[Standards.md §1.2](../../company/Standards.md).

| Deliverable | Purpose |
|---|---|
| [mission.md](mission.md) | Brief for this design mission |
| [architecture.md](architecture.md) | Substantial V2 blueprint — capabilities, flows, migration, alternatives |
| [report.md](report.md) | This file — audit summary, build sequence, approval gate |

**Intentionally not changed:**

- `missions/006-validate-recommendation/` — operator directive; Phase B
  continues independently
- `tasks/Backlog.md`, `README.md` — sequencing reconciliation deferred to
  Mission 008 after operator approval
- `site/index.html` — compiler will own this in Mission 009

---

## V1 audit findings (repository evidence)

### What AI-DOS currently is

Per [company/Identity.md](../../company/Identity.md) §1 and
[README.md](../../README.md): a Git-native operating system where the
repository *is* the product. Work happens in numbered missions
(`mission.md` + `report.md`). Organizational intelligence lives in
versioned files. Approval is merge-to-main
([company/Standards.md](../../company/Standards.md) §2).

### What works and must survive

- Governing principle §0 — "Never make a future agent guess"
- Commit-level rationale standard (Standards §1.1)
- Merge-as-approval governance (Standards §2)
- Evidence tiering formalized in Standards §1.3 (Mission 006)
- Cold-start test as quality gate (Principles §4)
- iPhone-readable reports (Principles §6)
- Confidence-based roadmap routing (Mission 003 → validation before build)

### What breaks at scale

1. **No machine-readable index** — four mission renumberings required
   dated addenda across multiple files (M003, M004, M005 reports).
2. **Decisions trapped in mission prose** — Mission 003's Candidate A/B/C
   evaluation is excellent but not independently queryable.
3. **Mission lifecycle is implicit** — Mission 006's Phase A/B/C model is
   sophisticated but exists only in one brief; status scattered across
   mission headers, Backlog, and showcase badges.
4. **Showcase drift** — Mission 005 flagged manual maintenance risk;
   Mission 006 required explicit showcase commits (632145e).
5. **Single-track Backlog** — cannot express parallel AI-DOS vs. benchmark
   tracks while Mission 006 Phase B blocks on operator.
6. **No agent handoff contract** — `Executed by:` is the only structured
   agent metadata.
7. **No portfolio model** — AI-DOS is becoming primary product but
   architecture still assumes one repo for everything.

Details and V2 fixes: [architecture.md](architecture.md) §2–§4.

---

## Key architectural decisions

| Decision | Choice | Serious alternative rejected |
|---|---|---|
| Mental model | Capabilities over folders | Folder-only organization (V1) — fails at scale |
| Registry layer | `system/manifest.yaml` + `index.yaml` | README mega-index — drifted across renumberings |
| Mission queue | `system/queue.yaml` with parallel tracks | GitHub Issues — splits canonical truth |
| Decisions | First-class `decisions/` artifacts | Embedded in reports only — pointer fragility |
| Showcase | Repository Compiler output | Manual HTML — drift already observed |
| Products | Portfolio of repos | Monorepo `/products/` — OS/product collision |
| Agents | Handoff packets + playbooks | Persona files — rejected in M001/M003 |
| Automation | Propose-only missions | Full autonomy — violates operator authority |
| Approval | Merge-to-main (unchanged) | Chat bot as canonical — Standards §2 forbids |

Each decision includes full rationale in [architecture.md](architecture.md)
§4 and §11.

---

## Proposed build sequence (Mission 008+)

Not gated. Not built. Descriptions only.

### Mission 008 — V2 Foundation & Sequencing Reconciliation

Create `system/manifest.yaml`, `system/index.yaml`, and
`system/schemas/`. Retroactively index Missions 001–007. Reconcile
Backlog.md and README.md with reclaimed Mission 007 numbering. Add
renumbering protocol to Standards. Resolve benchmark build numbering
(proposed: Portfolio track, not Mission 008). No compiler yet — hand-
validated YAML.

### Mission 009 — Repository Compiler (Core)

Build `tools/compiler/` — reads system registry + missions → emits
`dist/state.json`, `dist/compile-report.md`, `dist/cold-start-answers.md`.
Wire GitHub Action to compile on merge. Compiler fail-loud on broken
pointers.

### Mission 010 — Showcase & Operator Inbox Generation

Compiler generates `site/index.html` content from templates. Add
`site/inbox.html` — approval inbox for iPhone operator. Preserve Mission
005 visual identity. Deprecate manual showcase content updates (Standards
§3 amendment).

### Mission 011 — Decision Engine Bootstrap

Create `decisions/` structure. Retroactively publish `D003` (invoice tool
recommendation) from Mission 003 artifacts. Add decision template to
workflow. Update Mission Template — reports reference decision IDs.

### Mission 012 — Mission Engine & Queue Migration

Create `system/queue.yaml` with `aidos-core` and `benchmark-product`
tracks. Migrate Backlog.md content. Formalize mission state machine and
phase model. Mark `tasks/Backlog.md` as generated redirect.

### Mission 013 — Knowledge Playbooks

Extract recurring patterns from Missions 002–006 into
`knowledge/playbooks/` — research, validation, governance, implementation.
Missions reference playbooks by ID.

### Mission 014 — Agent Handoff Standard

Add `handoff.yaml` to mission template. Write Mission 006 Phase C
handoff when operator returns Phase B data. Document model routing
guidance (architecture vs. implementation). Update workflow templates.

### Mission 015 — Portfolio Registry

Create `system/portfolio.yaml`. Define benchmark product slot gated on
Mission 006. Document separate-repo creation criteria. If Mission 006 has
passed by then, open product repo; if not, registry only.

### Mission 016 — Automation: Compile on Merge

Formalize `system/automation.yaml`. Merge-triggered compile (no approval
needed). Weekly health-check mission *proposal* (approval needed).

### Mission 017 — Automation: Staleness & Blockers

Inbox flags for operator-blocked missions exceeding threshold. Manifest
pointer repair proposals. Phase B timeout visibility.

### Mission 018 — Repository Intelligence Score

Implement RIS per architecture.md §8. Emit `dist/intelligence-score.json`.
Record as Standards §4.

### Later (019+)

Custom compiler plugins, integration hooks, multi-repo compiler, advanced
agent auto-spawn — only when a mission demonstrates need (Principles §7).

### Parallel track (unchanged by this mission)

**Mission 006** — Validate the Recommendation (Phase B in progress).
If Pass → **Benchmark MVP build** in a new product repository under
Portfolio (not AI-DOS repo). If Fail → return to Mission 003 shortlist
per existing decision rule.

---

## Migration risks

| Risk | Mitigation |
|---|---|
| V1/V2 artifact coexistence confuses agents | `manifest.yaml` declares `version: 2`; compiler emits cold-start doc |
| Renumbering collision (M007 reclaim) | Mission 008 reconciles queue; never reuse IDs |
| Compiler adds CI complexity | Single script, sub-5s, fail-loud; Mission 009 scope is minimal |
| Over-engineering | Each mission creates one capability; Principles §7 enforced |
| Mission 006 Phase C needs V2 handoffs | Mission 014 can land before Phase C; handoff is additive |

---

## Cold-start verification

A stranger cloning `main` after this mission merges can answer:

| Question | File |
|---|---|
| What is AI-DOS V2? | [architecture.md](architecture.md) §0–§1 |
| Why redesign now? | [architecture.md](architecture.md) §2; this report §V1 audit |
| What capabilities exist? | [architecture.md](architecture.md) §4 |
| What changed vs. V1? | [architecture.md](architecture.md) §2.2, §10 |
| What was rejected and why? | [architecture.md](architecture.md) §11 |
| What should Mission 008 build? | This report §Proposed build sequence; [architecture.md](architecture.md) §10 |
| Is Mission 006 affected? | [mission.md](mission.md) Constraints — no |
| What is the approval question? | This report final line |

All questions resolve to specific files and sections. Verification passes.

---

## What AI-DOS Learned

This mission changed AI-DOS itself in the following ways:

- **Strategic pivot documented:** AI-DOS is the primary product; benchmark
  validation (Mission 006) continues as an independent Portfolio track.
- **V2 capability model defined:** twelve capabilities replace folder-
  thinking as the organizational mental model, with storage layout as
  implementation detail.
- **Repository Compiler identified as critical path:** manual showcase
  maintenance is a proven drift vector; compilation is the highest-ROI
  V2 investment after the system registry.
- **Decision Engine gap named:** Mission 003's excellent decision work
  should become queryable `decisions/D003` — not remain prose in a report.
- **Mission 006 Phase model validated:** three-phase agent/operator/agent
  flow is the template for Mission Engine phase contracts.
- **Portfolio separation decided:** product code leaves this repo; AI-DOS
  remains the operating system, not a monorepo.
- **Mission 007 reclaimed:** V2 design supersedes Backlog's "Build
  Benchmark MVP" numbering; reconciliation is Mission 008's job.
- **Recorded (not built):** Repository Intelligence Score designed in
  architecture.md §8 for Mission 018.

---

Approve the AI-DOS V2 architecture and proposed build sequence beginning with Mission 008? Y/N
