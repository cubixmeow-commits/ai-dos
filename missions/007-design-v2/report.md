# Mission 007 Report: Design AI-DOS V2

**Status:** Complete — approved; operator decisions incorporated
**Executed by:** GPT-5.5 (Cursor Cloud Agent)

## Executive summary

AI-DOS V1 proved that a Git repository can function as organizational
memory for AI-assisted development. Six missions established principles,
standards, governance, evidence tiering, and a showcase reader. That was
the correct bootstrap.

V1 does not scale. Discovery is archaeological, decisions live inside
mission prose, mission lifecycle is convention-only, showcase drifts
manually, and a single Backlog paragraph cannot express parallel tracks
(AI-DOS evolution vs. Portfolio Projects).

**AI-DOS V2** reframes the system around a central innovation: **the
repository is organizational source code.** The **Repository Compiler
(PHP)** transforms that source into disposable artifacts — static website,
mission timeline, decision timeline, operator dashboard, AI agent context
packages, repository analytics, and more. Twelve capabilities sit above
this compiler layer. The repository remains canonical. The operator
remains final decision-maker. Mission 006 is untouched.

**Operator approved** this architecture on 2026-07-07 with binding
decisions recorded in [architecture.md](architecture.md) §13.

Full blueprint: [architecture.md](architecture.md).

---

## What was changed and why

Mission-level summary — change-level rationale in `M007:` commits per
[Standards.md §1.2](../../company/Standards.md).

| Deliverable | Purpose |
|---|---|
| [mission.md](mission.md) | Brief for this design mission |
| [architecture.md](architecture.md) | Substantial V2 blueprint — capabilities, flows, migration, alternatives |
| [report.md](report.md) | This file — audit summary, build sequence, operator decisions |

**Intentionally not changed:**

- `missions/006-validate-recommendation/` — operator directive; Phase B
  continues independently
- `tasks/Backlog.md`, `README.md` — sequencing reconciliation deferred to
  Mission 008
- `site/index.html` — Repository Compiler (PHP) will own this in Mission 009

---

## Operator decisions (approved 2026-07-07)

| # | Decision | Resolution |
|---|---|---|
| 1 | Compiler language | **PHP** — AI-DOS is built in PHP; one ecosystem; GitHub Actions runs PHP directly |
| 2 | Central concept | **Organizational source code → Repository Compiler (PHP) → disposable artifacts** |
| 3 | Portfolio | **Portfolio Projects** — product-agnostic; Mission 006 invoice tool is first candidate only |
| 4 | Mission 007 | **Officially: Design AI-DOS V2** — not benchmark build |
| 5 | CI/CD | **Compile-on-merge approved** — merge → Actions → PHP compiler → publish website |
| 6 | Operator UI | **GitHub Mobile preserved** — compiled dashboard serves iPhone operator |

Full detail: [architecture.md](architecture.md) §3.4, §4.6, §4.11, §6.4, §13.

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
5. **Single-track Backlog** — cannot express parallel AI-DOS vs. Portfolio
   Project tracks while Mission 006 Phase B blocks on operator.
6. **No agent handoff contract** — `Executed by:` is the only structured
   agent metadata.
7. **No Portfolio Projects model** — AI-DOS is the primary product but
   architecture had no product-agnostic project workflow.

Details and V2 fixes: [architecture.md](architecture.md) §2–§4.

---

## Key architectural decisions

| Decision | Choice | Serious alternative rejected |
|---|---|---|
| Central metaphor | Organizational source code + compiler | Markdown files + manual website (V1) |
| Compiler | Repository Compiler (PHP) | Python or Node — splits ecosystem |
| Mental model | Capabilities over folders | Folder-only organization (V1) |
| Registry layer | `system/manifest.yaml` + `index.yaml` | README mega-index — drifted |
| Mission queue | `system/queue.yaml` with parallel tracks | GitHub Issues — splits truth |
| Decisions | First-class `decisions/` artifacts | Embedded in reports only |
| Derived artifacts | All compiler output — disposable | Manual HTML — drift observed |
| Products | Portfolio Projects (generic workflow) | Invoice-specific OS architecture |
| Agents | Handoff packets + playbooks | Persona files — rejected in M001/M003 |
| Automation | Compile-on-merge + propose-only missions | Full autonomy — violates operator authority |
| Approval | Merge-to-main (unchanged) | Chat bot as canonical — Standards §2 |
| Operator UI | GitHub Mobile + compiled dashboard | Native app — unnecessary friction |

Each decision includes full rationale in [architecture.md](architecture.md)
§4 and §11.

---

## Proposed build sequence (Mission 008+)

Approved. Not gated. Not built. Descriptions only.

### Mission 008 — V2 Foundation & Sequencing Reconciliation

Create `system/manifest.yaml`, `system/index.yaml`, and
`system/schemas/`. Retroactively index Missions 001–007. Reconcile
Backlog.md and README.md: Mission 007 = Design AI-DOS V2. Register
Portfolio Projects abstraction in `system/portfolio.yaml` with P001 as
first candidate. Add renumbering protocol to Standards. No compiler yet.

### Mission 009 — Repository Compiler (PHP) — Core

Build `tools/compiler/compile.php` — reads organizational source code →
emits `dist/state.json`, `dist/compile-report.md`,
`dist/cold-start-answers.md`, `dist/context/` agent packages. Wire
GitHub Actions compile-on-merge workflow per architecture.md §6.4.
Compiler fail-loud on broken pointers.

### Mission 010 — Derived Artifact Generation

Repository Compiler (PHP) generates static website, mission timeline,
decision timeline, operator dashboard (`site/inbox.html`). Preserve
Mission 005 visual identity. Deprecate manual showcase content updates
(Standards §3 amendment).

### Mission 011 — Decision Engine Bootstrap

Create `decisions/` structure. Retroactively publish `D003` from Mission
003 artifacts. Add decision template to workflow. Reports reference
decision IDs.

### Mission 012 — Mission Engine & Queue Migration

Create `system/queue.yaml` with `aidos-core` and `portfolio-projects`
tracks. Migrate Backlog.md content. Formalize mission state machine and
phase model.

### Mission 013 — Knowledge Playbooks

Extract recurring patterns from Missions 002–006 into
`knowledge/playbooks/` — research, validation, governance, Portfolio
Project implementation.

### Mission 014 — Agent Handoff Standard

Add `handoff.yaml` to mission template. Write Mission 006 Phase C
handoff when operator returns Phase B data. Update workflow templates.

### Mission 015 — Portfolio Projects Registry

Finalize `system/portfolio.yaml`. Document generic project workflow
stages. If Mission 006 has passed, advance P001 to `build` and open
project repo; if not, registry only.

### Mission 016 — Automation: Compile on Merge

Formalize `system/automation.yaml`. Document approved workflow: merge →
GitHub Actions → PHP compiler → publish. Weekly health-check mission
*proposal* (approval needed).

### Mission 017 — Automation: Staleness & Blockers

Inbox flags for operator-blocked missions. Manifest pointer repair
proposals. Phase B timeout visibility.

### Mission 018 — Repository Intelligence Score

Implement RIS per architecture.md §8. Emit `dist/intelligence-score.json`.
Record as Standards §4.

### Later (019+)

Custom compiler plugins, integration hooks, multi-repo compiler — only
when a mission demonstrates need (Principles §7).

### Parallel track (unchanged)

**Mission 006** — validates first candidate Portfolio Project (P001).
If Pass → build in separate project repo via standard Portfolio Project
workflow. If Fail → return to Mission 003 shortlist per existing decision
rule. No product-specific architecture in AI-DOS repo.

---

## Migration risks

| Risk | Mitigation |
|---|---|
| V1/V2 artifact coexistence confuses agents | `manifest.yaml` declares `version: 2`; compiler emits cold-start doc |
| Renumbering collision (M007 reclaim) | Mission 008 reconciles queue; never reuse IDs |
| PHP compiler adds CI complexity | Single `compile.php`, sub-5s, fail-loud; Mission 009 scope minimal |
| Over-engineering | Each mission creates one capability; Principles §7 enforced |
| Mission 006 Phase C needs V2 handoffs | Mission 014 can land before Phase C; handoff is additive |

---

## Cold-start verification

A stranger cloning `main` after this mission merges can answer:

| Question | File |
|---|---|
| What is AI-DOS V2? | [architecture.md](architecture.md) §0.1, §1 |
| What is the central innovation? | [architecture.md](architecture.md) §3.4 — organizational source code |
| Why PHP for the compiler? | [architecture.md](architecture.md) §4.6, §13 |
| What are Portfolio Projects? | [architecture.md](architecture.md) §4.11 |
| What capabilities exist? | [architecture.md](architecture.md) §4 |
| What did the operator decide? | [architecture.md](architecture.md) §13; this report §Operator decisions |
| What should Mission 008 build? | This report §Proposed build sequence |
| Is Mission 006 affected? | [mission.md](mission.md) Constraints — no |

All questions resolve to specific files and sections. Verification passes.

---

## What AI-DOS Learned

This mission changed AI-DOS itself in the following ways:

- **Strategic pivot documented:** AI-DOS is the primary product; Portfolio
  Projects (not a single benchmark app) is how the operator runs a software
  company.
- **Central innovation named:** organizational source code compiled by
  Repository Compiler (PHP) into disposable artifacts — the defining V2
  concept.
- **V2 capability model defined:** twelve capabilities over a compiler
  layer; storage layout is implementation detail.
- **PHP chosen for compiler:** one language ecosystem with AI-DOS itself;
  deployable anywhere; GitHub Actions native.
- **Portfolio Projects abstraction:** product-agnostic workflow; Mission
  006 validates first candidate P001 only.
- **Mission 007 identity fixed:** Design AI-DOS V2 — operator decision.
- **Compile-on-merge approved:** automation generates artifacts only;
  governance and approval remain merge-based.
- **Decision Engine gap named:** Mission 003 → queryable `decisions/D003`.
- **Mission 006 Phase model validated:** template for Mission Engine
  phase contracts.
- **Recorded (not built):** Repository Intelligence Score — Mission 018.

---

## Approval record

**Approved:** 2026-07-07 — operator approved V2 architecture with
decisions incorporated into [architecture.md](architecture.md) §13.

**Next:** Mission 008 — V2 Foundation & Sequencing Reconciliation.
