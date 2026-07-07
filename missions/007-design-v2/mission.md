# Mission 007: Design AI-DOS V2

**Status:** Complete — see [report.md](report.md)
**Executed by:** GPT-5.5 (Cursor Cloud Agent)

## Why this mission exists

The operator made a strategic decision: **AI-DOS itself is now the primary
product.** Mission 006 continues independently as validation of the first
candidate Portfolio Project and is intentionally left untouched by this
mission.

Missions 001–006 grew AI-DOS organically — principles, standards, governance,
evidence tiering, a showcase reader — but the system still behaves like a
convention-heavy folder of markdown files. V2 reframes the repository as
**organizational source code** compiled by the **Repository Compiler (PHP)**
into disposable artifacts. That worked-for-bootstrap shape will not scale
to an operating system for an AI software company.

This mission designs Version 2: the architecture AI-DOS should grow into
over the next two years, working backwards from that future state.

## Role

Behave as the **principal software architect** hired to redesign AI-DOS.
Do not behave like a project manager. Do not optimize for implementation
order. Do not reduce ambition because work spans multiple future missions.

Imagine AI-DOS two years from now. Then define the architecture that
deserves to exist.

## Strategic context

- Inspect the repository on `main` before writing anything.
- The repository is the source of truth — not this brief.
- Mission 006 (Validate the Recommendation) is **out of scope** and must
  not be modified.
- **Operator decision (2026-07-07):** Mission 007 is officially **Design
  AI-DOS V2.** The first candidate Portfolio Project (origin: Mission 003
  recommendation, validation: Mission 006) is no longer the repository's
  primary focus. Portfolio Projects use a product-agnostic workflow defined
  in [architecture.md](architecture.md) §4.11.
- Mission numbering collision: Backlog still lists "Mission 007 = Build the
  Benchmark MVP." This mission **reclaims Mission 007** for V2 design.
  Mission 008 reconciles Backlog and README.

## Design philosophy

- Challenge every assumption. Question every existing abstraction.
- Do not preserve structures simply because they already exist.
- If a better architecture exists: replace it, explain why, document migration.
- Elegance beats familiarity.
- Optimize for exactly one user: an independent developer directing cloud
  AI agents primarily from an iPhone.

## Repository rules (non-negotiable)

- Repository is canonical.
- Generated artifacts are disposable.
- Governance is merge-as-approval.
- Operator remains final decision-maker.
- Never fabricate capabilities.
- Never fabricate metrics.
- Never invent work that hasn't happened.

## Tasks

1. **Repository audit** — read all canonical artifacts on `main`; document
   what AI-DOS currently is, what works, and what breaks at scale.
2. **Capability model** — define AI-DOS V2 as a set of capabilities (not
   folders). Invent better capabilities where they exist.
3. **Architecture document** — write a substantial blueprint at
   `architecture.md` covering every major subsystem, interfaces, data
   flows, migration from V1, and rejected alternatives.
4. **Implementation sequence** — propose missions beginning with Mission
   008. Describe what each accomplishes. Do not gate them. Do not build them.
5. **Mission report** — summarize audit findings, key architectural bets,
   migration risks, and cold-start verification.

## Operator decisions (approved 2026-07-07)

The operator approved V2 architecture with these binding decisions,
incorporated into [architecture.md](architecture.md):

1. **Repository Compiler (PHP)** — not Python or Node; one language ecosystem
2. **Organizational source code** — repository is canonical; compiler output is disposable
3. **Portfolio Projects** — product-agnostic; Mission 006 validates first candidate only
4. **Mission 007 = Design AI-DOS V2** — official identity
5. **Compile-on-merge** — GitHub Actions runs PHP compiler; approval never automated
6. **GitHub Mobile** — operator interface preserved

## Constraints

- **Design only.** No implementation code, no new runtime services, no CI
  beyond what exists.
- **Do not modify Mission 006** or any file under
  `missions/006-validate-recommendation/`.
- **Do not update Backlog.md or README.md** in this mission — Mission 008
  owns sequencing reconciliation after operator approval.
- Every commit follows the Knowledge Preservation standard.

## Deliverables

- `missions/007-design-v2/mission.md` (this file)
- `missions/007-design-v2/report.md`
- `missions/007-design-v2/architecture.md`

## Exit criteria

- A stranger can read the three deliverables and understand what AI-DOS V2
  is, why it differs from V1, and what Mission 008 should build first.
- Every major architectural decision documents at least one serious
  alternative and why it lost.
- Report ends with exactly:
  `Approve the AI-DOS V2 architecture and proposed build sequence beginning
  with Mission 008? Y/N`
- Cold-start verification passes by file citation.
