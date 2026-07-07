# AI-DOS V2 Architecture

**Version:** 0.2 (approved — operator decisions incorporated)
**Status:** Approved — implementation begins Mission 008
**Author:** Principal architect mission (GPT-5.5, Cursor Cloud Agent)
**Approved:** 2026-07-07 — operator decisions recorded in §13

---

## §0 How to read this document

This is the blueprint for AI-DOS Version 2. It describes **capabilities**
— what the operating system does — not a file tree to copy blindly.

V1 proved that a Git repository can function as organizational memory for
AI-assisted development. V2 asks: *what architecture would an AI software
company deserve if it were designed today, with two years of hindsight?*

**Non-negotiable constraints carried forward from V1:**

| Constraint | Meaning in V2 |
|---|---|
| Repository is canonical | Git on `main` remains source of truth; no external database of record |
| Generated artifacts are disposable | Showcase, indexes, dashboards are compiled outputs — never cited as truth |
| Governance is merge-as-approval | Operator approval is durable only when merged into `main` |
| Operator is final decision-maker | Automation proposes; operator approves |
| Never fabricate | Capabilities report only what exists in artifacts |

**Primary user (unchanged, sharpened):**

One independent software developer, directing cloud AI agents primarily
from an iPhone. Every subsystem must make that person more effective per
minute of attention spent.

### §0.1 The central innovation: organizational source code

AI-DOS is not just a collection of markdown files.

**The repository is the source code of the organization.** Missions,
decisions, evidence, principles, standards, and governance artifacts are
**organizational source code** — versioned, reviewable, merge-governed.

The **Repository Compiler (PHP)** transforms that source into human-
friendly and agent-friendly representations. Nothing compiled is
canonical. The repository is canonical. Everything else is compiled from it.

This is one of the central innovations of AI-DOS V2: AI-DOS treats an
organization the way a traditional compiler treats source code.

---

## §1 Vision: AI-DOS two years from now

In 2028, AI-DOS is not a coding assistant and not a project manager. It
is an **operating system for a one-person AI software company** — a
company that happens to have one human operator and many interchangeable
AI workers.

A fresh agent cloning `main` at 07:00 can answer, without chat history:

1. What is this organization, what does it believe, and what is it building?
2. What missions are active, blocked, or awaiting approval?
3. What decisions were made, what alternatives were rejected, and why?
4. What evidence supports the current product direction?
5. What should I work on, under what constraints, with what handoff format?
6. What did the last agent do, and what did it leave incomplete?

The operator, reviewing from a phone during a commute, sees:

- One **approval inbox** — at most one decision per mission, never a wall of diffs
- One **status surface** — compiled, current, under two minutes to read
- Clear **blockers** — what requires human action vs. what agents can continue

The repository contains no application server. It contains **organizational
source code** — typed artifacts, capability definitions, governance —
and a **Repository Compiler (PHP)** that transforms repository state into
disposable views: static website, mission timeline, decision timeline,
knowledge graph, operator dashboard, AI agent context packages, repository
analytics, status reports, and more. Multiple **Portfolio Projects** can
sit under one operator without merging their histories into the OS repo.

---

## §2 V1 audit: what exists today

*Source: repository inspection on `main`, 2026-07-07. Every claim below
is verifiable from cited files.*

### §2.1 What works (preserve the insight, not always the shape)

| Strength | Evidence | V2 implication |
|---|---|---|
| Repository-as-product | [company/Identity.md](../company/Identity.md) §1 | Keep — sharpen with typed artifacts |
| Governing principle §0 | [company/Principles.md](../company/Principles.md) §0 | Keep — becomes compiler validation rule |
| Mission loop | [README.md](../README.md) §2 | Evolve into Mission Engine state machine |
| Commit-level memory | [company/Standards.md](../company/Standards.md) §1.1 | Keep — indexed by Organizational Memory |
| Merge-as-approval | [company/Standards.md](../company/Standards.md) §2 | Keep — becomes Decision Engine terminal state |
| Evidence tiering | [company/Standards.md](../company/Standards.md) §1.3 | Keep — becomes Evidence System core |
| Cold-start test | [company/Principles.md](../company/Principles.md) §4 | Keep — automated by Repository Compiler |
| iPhone-readable reports | [company/Principles.md](../company/Principles.md) §6 | Keep — Operator Mission Control requirement |
| Showcase reader | [site/index.html](../site/index.html) | Keep — first Repository Compiler output |
| Honest confidence routing | [missions/003-prove-the-loop/report.md](../003-prove-the-loop/report.md) | Keep — Decision Engine pattern |

### §2.2 What breaks at scale (the case for V2)

**1. Discovery is archaeological.**

There is no machine-readable index of organizational state. A fresh agent
must grep across `missions/`, `company/`, `tasks/`, and git log. Missions
001–006 required multiple renumbering addenda because forward pointers
lived in many files ([missions/003-prove-the-loop/report.md](../003-prove-the-loop/report.md) addenda, [missions/004-close-governance-loop/report.md](../004-close-governance-loop/report.md)).

*V2 fix:* Repository Compiler produces `dist/state.json` (disposable) and
`system/manifest.yaml` (canonical pointer graph).

**2. Decisions are buried inside mission reports.**

Rejected alternatives appear in narrative prose. There is no first-class
decision record queryable independently of the mission that produced it.
Mission 003's rejection of Candidates A and B is excellent content trapped
in [evaluation.md](../003-prove-the-loop/evaluation.md) and report sections.

*V2 fix:* Decision Engine with typed `decision` artifacts.

**3. Mission lifecycle is convention, not contract.**

Status lives in inconsistent places: `mission.md` headers, report headers,
Backlog prose, showcase badges. Mission 006's three-phase model
(Phase A/B/C) is sophisticated but exists only in one mission's brief.

*V2 fix:* Mission Engine with explicit states, phases, and blocking reasons.

**4. Agent coordination is implicit.**

`Executed by:` in mission.md is the only structured agent metadata.
There is no handoff schema, no model-routing guidance, no "what the next
agent needs" block beyond cold-start citations.

*V2 fix:* Agent Coordination capability with briefs and handoff packets.

**5. Showcase maintenance is manual and drift-prone.**

[company/Standards.md](../company/Standards.md) §3 requires manual updates.
Mission 005 acknowledged this risk in its report. The showcase already
drifted once (Mission 006 Phase A updates required explicit commits).

*V2 fix:* Repository Compiler owns showcase generation.

**6. Single-repo assumption.**

AI-DOS has no abstraction for operating multiple products under one
operator. Mission 006's validation work happens to concern one candidate
product, but the OS needs a product-agnostic model for all future work.

*V2 fix:* Portfolio Projects capability — generic workflow, not
product-specific architecture.

**7. No automation surface.**

Everything requires an operator to spawn an agent manually. No triggers, no
scheduled health checks, no "repository intelligence" measurement despite
recorded intent in Principles.md.

*V2 fix:* Automation capability (propose-only until operator approves).

**8. Backlog is not a queue — it is a paragraph.**

[tasks/Backlog.md](../tasks/Backlog.md) holds one "Next" item and a
"Later" section. It cannot express parallel tracks (AI-DOS vs. Portfolio
Projects), dependencies, or blocked missions.

*V2 fix:* Mission Engine queue artifact with structured entries.

### §2.3 What V1 got right that V2 must not destroy

- **Git history as audit trail** — never move "why" out of commits
- **Annotation over rewriting** — migration uses addenda, not history surgery
- **Minimum viable per mission** — capabilities ship incrementally
- **Evidence before build** — Decision Engine inherits confidence routing
- **No fabricated metrics** — compiler validates claims against artifacts

---

## §3 Architectural stance

### §3.1 The core shift: files are storage, capabilities are the product

V1 organized by folder (`company/`, `missions/`, `tasks/`). That was
correct for bootstrap (Principles §7). V2 organizes by **capability** —
a named subsystem with defined inputs, outputs, invariants, and artifacts.

Folders remain as **storage layouts** chosen for human legibility and Git
ergonomics. Capabilities are how agents *think* about the system.

```
┌─────────────────────────────────────────────────────────────┐
│                    OPERATOR MISSION CONTROL                  │
│         (iPhone control plane — reads compiled state)        │
└─────────────────────────┬───────────────────────────────────┘
                          │ approves / unblocks
┌─────────────────────────▼───────────────────────────────────┐
│                      MISSION ENGINE                          │
│    lifecycle · queue · phases · blocking · handoffs          │
└─┬─────────┬─────────┬─────────┬─────────┬─────────┬─────────┘
  │         │         │         │         │         │
  ▼         ▼         ▼         ▼         ▼         ▼
┌────┐  ┌────────┐ ┌──────┐ ┌────────┐ ┌───────┐ ┌──────────┐
│Org │  │Decision│ │Evid- │ │Knowledge│ │Agent  │ │Portfolio │
│Mem │  │Engine  │ │ence  │ │System   │ │Coord  │ │Projects  │
└─┬──┘  └───┬────┘ └──┬───┘ └────┬───┘ └───┬───┘ └────┬─────┘
  │         │         │          │         │          │
  └─────────┴─────────┴──────────┴─────────┴──────────┘
                          │
              ┌───────────▼───────────┐
              │ REPOSITORY COMPILER   │
              │        (PHP)          │
              │  source → disposable  │
              └───────────┬───────────┘
                          │
              ┌───────────▼───────────┐
              │  WEBSITE · TIMELINES · │
              │  DASHBOARD · CONTEXT · │
              │  ANALYTICS · REPORTS   │
              │  (all disposable)      │
              └───────────────────────┘
                          │
              ┌───────────▼───────────┐
              │  AUTOMATION           │
              │  (propose missions)   │
              └───────────────────────┘
```

### §3.2 Layer model

| Layer | Role | Canonical? |
|---|---|---|
| **Artifacts** | Typed markdown + YAML files committed to Git | Yes |
| **System registry** | Schemas, capability defs, manifest | Yes |
| **Compiler** | Repository Compiler (PHP) reads source → writes disposable outputs | Tooling in `tools/compiler/` |
| **Control plane** | Static HTML or GitHub-native UI reading compiled state | Disposable views |
| **Agents** | Stateless workers; read registry + artifacts | External |

No layer above Git becomes source of truth.

### §3.3 Design invariants

1. **Cold-start in one read.** `system/manifest.yaml` + compiler output
   must answer all six questions from §1 Vision without grepping.
2. **One approval question per gate.** Operator attention is the scarcest
   resource (Principles §6).
3. **Phases are explicit.** Any mission splitting agent/operator work
   (like Mission 006) uses Mission Engine phase contracts — not ad hoc
   section headers.
4. **Decisions are immutable once merged.** Amend with new decisions;
   never rewrite old ones.
5. **Compiler failure is visible.** If canonical artifacts are
   inconsistent, compiler emits errors into `dist/compile-report.md` —
   not silent drift.

### §3.4 Repository Compiler (PHP) as defining subsystem

V2 is not "markdown files plus a website." It is **organizational source
code plus a compiler.**

| Organizational source code | Compiled output (disposable) |
|---|---|
| Missions, phases, queue state | Mission timeline |
| Decisions + alternatives | Decision timeline |
| Evidence ledgers | Evidence summaries |
| Principles, standards, playbooks | Knowledge graph, architecture docs |
| Portfolio Project registry | Portfolio pages |
| Manifest + index | Operator dashboard, status reports |
| Full repository state | AI agent context packages, repository analytics |
| All of the above | Static website (showcase) |

The Repository Compiler (PHP) is implemented entirely in PHP because
AI-DOS itself is built in PHP: one language, one development ecosystem,
deployable anywhere AI-DOS runs, executable directly in GitHub Actions.

---

## §4 Capability reference

Each capability has: **purpose**, **canonical artifacts**, **interfaces**,
**invariants**, and **V1 migration**.

### §4.1 Organizational Memory

**Purpose:** Unified, queryable organizational state across commits,
missions, decisions, evidence, and standards. Answers "what does this
organization know?" without archaeology.

**Canonical artifacts:**

| Artifact | Location (proposed) | Role |
|---|---|---|
| `manifest.yaml` | `system/manifest.yaml` | Pointer graph to all canonical entry points |
| `index.yaml` | `system/index.yaml` | Machine-readable mission/decision/evidence registry |
| Commits | Git log | Change-level rationale (unchanged) |
| Principles | `company/Principles.md` | Beliefs (unchanged path) |
| Standards | `company/Standards.md` | Operations (unchanged path) |

**`system/manifest.yaml` (sketch):**

```yaml
version: 2
updated_by: mission-007
entry_points:
  identity: company/Identity.md
  principles: company/Principles.md
  standards: company/Standards.md
  queue: system/queue.yaml
  active_missions:
    - id: "006"
      path: missions/006-validate-recommendation/
      phase: B
      blocked_on: operator
  portfolio_projects:
    - id: aidos
      repo: .
      role: operating_system
      status: active
    - id: P001
      name: null  # assigned when validation passes
      role: portfolio_project
      status: candidate
      origin_mission: "006"
      note: First candidate Portfolio Project; product-agnostic workflow applies to all future projects
```

**Interfaces:**

- **Read:** agents read `manifest.yaml` first; follow pointers
- **Write:** missions update `index.yaml` entries on open/close
- **Query:** compiler aggregates index + git log into `dist/memory-snapshot.json`

**Invariants:**

- Every pointer in manifest must resolve to an existing file on `main`
- `index.yaml` entries must cite evidence tiers for factual claims
- Manifest updates are part of mission completion — not optional

**V1 migration:** Mission 008 generates initial `manifest.yaml` and
`index.yaml` from existing missions 001–007. Historical missions are
indexed retroactively; no content moves.

**Alternative considered:** *Graph database or SQLite in repo.*

Rejected. Violates "repository is canonical" spirit; introduces merge
conflicts on binary/stateful files; requires runtime. Git + YAML indexes
achieve 90% of query benefit at zero infrastructure cost.

**Alternative considered:** *Single README mega-index maintained by hand.*

Rejected. Already failed — README §4 drifted across four renumberings.
Manual indexes do not scale (V1 audit §2.2 item 1).

---

### §4.2 Mission Engine

**Purpose:** Formal lifecycle management for missions — states, phases,
dependencies, queue position, blocking reasons, and handoff requirements.

**Canonical artifacts:**

| Artifact | Location | Role |
|---|---|---|
| `queue.yaml` | `system/queue.yaml` | Ordered mission queue with parallel tracks |
| `mission.md` | `missions/NNN-name/mission.md` | Brief (unchanged convention) |
| `report.md` | `missions/NNN-name/report.md` | Outcome (unchanged convention) |
| `handoff.yaml` | `missions/NNN-name/handoff.yaml` | Machine-readable next-agent packet |
| Phase artifacts | `missions/NNN-name/phase-*.md` | Named phases (optional) |

**Mission states:**

```
PROPOSED → APPROVED → IN_PROGRESS → REVIEW → AWAITING_MERGE → COMPLETE
                ↓                      ↓
             DEFERRED              ABORTED
```

**Phase model** (for missions with operator critical path):

```
Phase A (agent) → GATE → Phase B (operator) → Phase C (agent) → REPORT
```

Mission 006 is the template. V2 formalizes what it demonstrated.

**`system/queue.yaml` (sketch):**

```yaml
tracks:
  - id: aidos-core
    description: AI-DOS operating system evolution
    next:
      - id: "008"
        title: V2 Foundation
        blocked_by: mission-007-merge
  - id: portfolio-projects
    description: Portfolio Projects — products AI-DOS manages for the operator
    next:
      - id: "006"
        title: Validate the Recommendation
        state: in_progress
        phase: B
        blocked_on: operator
        note: Mission 006 validates the first candidate Portfolio Project
    gated:
      - id: P001-build
        title: Build Portfolio Project MVP
        gated_by: mission-006-pass
        note: First project only; future projects use the same workflow
```

**Interfaces:**

- **Open mission:** agent creates folder + queue entry + index entry
- **Phase gate:** agent ends phase artifact with exactly one Y/N question
- **Complete mission:** report.md + handoff.yaml + queue update + manifest bump
- **Operator unblock:** merge or explicit `operator-note.md` in mission folder

**Invariants:**

- One mission folder per mission ID — IDs never reused
- Queue `next` items must reference existing or planned mission IDs
- Phase gates cannot be skipped in artifacts (operator may override via merge)
- Parallel tracks must declare independence or dependency explicitly

**V1 migration:** Extract current Backlog into `queue.yaml`. Mission 006
becomes first mission with formal phase metadata. Renumbering collisions
(Mission 007 reclaim) resolved in queue with explicit notes.

**Alternative considered:** *GitHub Issues as mission tracker.*

Rejected. Splits canonical state across platforms; breaks cold-start on
clone; violates repository-as-product. Issues may link *to* missions but
cannot be source of truth.

**Alternative considered:** *Keep Backlog.md only.*

Rejected. Cannot express parallel tracks, phases, or blocked-on-operator
states — all of which already exist in practice (Mission 006 Phase B).

---

### §4.3 Decision Engine

**Purpose:** First-class decision records with alternatives, confidence,
evidence links, and supersession chains. Decisions are organizational
memory, not mission footnotes.

**Canonical artifacts:**

| Artifact | Location | Role |
|---|---|---|
| `decision.yaml` | `decisions/DDD-slug/decision.yaml` | Structured decision record |
| `decision.md` | `decisions/DDD-slug/decision.md` | Human-readable narrative |
| Supersession links | YAML `supersedes:` / `superseded_by:` | Amendment chain |

**`decision.yaml` (sketch):**

```yaml
id: D003
title: Recommend invoice follow-up tool as benchmark product
status: active  # active | superseded | reversed
confidence: medium
mission: "003"
date: 2026-07-07
chosen: Candidate C — standalone invoice follow-up for freelancers
alternatives:
  - name: Candidate A — AI changelog tool
    outcome: rejected
    reason_ref: missions/003-prove-the-loop/evaluation.md#revenue-potential
  - name: Candidate B — testimonial collection tool
    outcome: rejected
    reason_ref: missions/003-prove-the-loop/evaluation.md#incumbent-gravity
evidence:
  - ref: missions/003-prove-the-loop/research.md
    tier: S
confidence_gaps:
  - Verify Bonsai/IPSE statistics
  - Freelancer willingness to pay for standalone chaser
superseded_by: null
```

**Interfaces:**

- **Record decision:** mission creates decision artifact before report
- **Route confidence:** medium/low confidence auto-creates validation mission in queue
- **Supersede:** new decision references old; old status → superseded
- **Query:** compiler lists active decisions in `dist/decisions.json`

**Invariants:**

- No decision without at least one documented alternative
- Confidence ratings use High/Medium/Low — no fabricated percentages
- [U]-tier evidence cannot be load-bearing (Standards §1.3 rule inherited)
- Decisions are immutable post-merge; amendments are new decisions

**V1 migration:** Retroactively create `D003` from Mission 003 artifacts.
Future decisions use native format. Mission reports *reference* decisions
instead of restating them (extends Standards §1.2 division of memory).

**Alternative considered:** *Decisions stay embedded in reports only.*

Rejected. Mission 003 proved high-value decisions generate cross-mission
references (006 validates 003). Embedded decisions required three addenda
when missions renumbered. Separate artifacts stabilize pointers.

---

### §4.4 Evidence System

**Purpose:** Structured evidence collection, tiering, ledgers, and
claim-to-decision traceability. Extends Standards §1.3 into a full
capability.

**Canonical artifacts:**

| Artifact | Location | Role |
|---|---|---|
| `evidence-ledger.md` | Per-mission or per-decision | Claim registry (Mission 006 pattern) |
| `evidence.yaml` | `evidence/E-slug/evidence.yaml` | Reusable evidence bundles |
| Tier rules | `company/Standards.md` §1.3 | Normative definitions (exists) |

**Evidence lifecycle:**

```
Claim surfaced → Source recorded → Tier assigned → Used-by linked → Verified or blocked
```

**Interfaces:**

- **Register claim:** ledger row with URL, tier, fetch status
- **Block fetch:** record 403/proxy denial (Mission 006 pattern — L1)
- **Link to decision:** `used_by` field points to decision ID
- **Upgrade tier:** new fetch attempt updates ledger; never silently upgrades

**Invariants:**

- No claim from memory (Mission 003 rule — now systemic)
- Blocked fetch log is mandatory when network denies access
- Commercial-bias flag on vendor-published statistics
- Compiler warns if active decision depends on [U]-only evidence

**V1 migration:** Mission 006 `evidence-ledger.md` becomes template.
Mission 003 research.md indexed as legacy evidence bundle.

**Alternative considered:** *External fact-checking service integration.*

Rejected for V2. Adds infrastructure, violates minimalism, creates
non-Git canonical state. Revisit at Portfolio scale if operator runs
many research missions.

---

### §4.5 Knowledge System

**Purpose:** Governed beliefs (Principles), evolving operations
(Standards), patterns, and agent-readable playbooks. The constitution
and its amendments.

**Canonical artifacts (mostly unchanged paths):**

| Artifact | Location | Role |
|---|---|---|
| Identity | `company/Identity.md` | What/why |
| Principles | `company/Principles.md` | Beliefs — rare changes |
| Standards | `company/Standards.md` | Operations — evolve often |
| Playbooks | `knowledge/playbooks/*.md` | How-to for recurring mission types |

**New in V2: playbooks.**

Mission 006 invented a three-phase validation playbook in its brief.
V2 extracts recurring patterns into `knowledge/playbooks/`:

- `research-mission.md` — evidence tiers, rubric, confidence routing
- `validation-mission.md` — Phase A/B/C, pre-registered thresholds
- `governance-mission.md` — standards changes, renumbering protocol
- `implementation-mission.md` — Portfolio Project build pattern

**Interfaces:**

- **Amend principle:** requires dedicated governance mission + operator approval
- **Add standard:** any mission may propose; compiler checks format
- **Apply playbook:** mission brief references playbook ID

**Invariants:**

- Principles §0 gate remains — new rules must reduce guessing
- Playbooks are advisory; missions may deviate with documented reason
- Standards changes cite the mission that demonstrated the need

**V1 migration:** No content moves. Mission 008 creates playbooks by
extracting patterns from missions 002–006.

---

### §4.6 Repository Compiler (PHP)

**Purpose:** Transform organizational source code (canonical repository
state) into disposable, human-friendly and agent-friendly representations.
Eliminate manual showcase drift. Make cold-start verification mechanical.
This is a **defining subsystem** of AI-DOS V2 — not an accessory tool.

**The compiler metaphor:**

```
Organizational source code          Repository Compiler (PHP)
(missions, decisions, evidence,  →   transforms repository state  →  Disposable artifacts
 governance, portfolio registry)        into outputs
```

**Inputs (organizational source code — canonical):**

- `system/manifest.yaml`, `system/index.yaml`, `system/queue.yaml`
- `company/*`, `missions/*`, `decisions/*`, `system/portfolio.yaml`
- Git log (for recent activity)

**Outputs (disposable — none are canonical):**

| Output | Consumer | Regenerated when |
|---|---|---|
| Static website (`site/`) | Public, operator | Any canonical change |
| Mission timeline | Showcase, dashboard | Mission state changes |
| Decision timeline | Showcase, agents | Decision artifacts change |
| Knowledge graph | Agents, architecture docs | Knowledge artifacts change |
| Architecture documentation | Agents, outsiders | Registry or standards change |
| Portfolio pages | Operator, outsiders | Portfolio registry changes |
| Operator dashboard (`site/inbox.html`) | iPhone operator | Gate reached |
| AI agent context packages (`dist/context/`) | Cloud agents | Any canonical change |
| Repository analytics (`dist/analytics.json`) | Operator, automation | Any canonical change |
| Status reports (`dist/status-report.md`) | Operator | Any canonical change |
| `dist/state.json` | Agents, automation | Any canonical change |
| `dist/compile-report.md` | Agents fixing drift | Compile errors |
| `dist/cold-start-answers.md` | Fresh agent onboarding | Any canonical change |

**Compiler properties:**

- **Language:** PHP — AI-DOS is built in PHP; one ecosystem, one deploy target
- **Idempotent:** same source → same outputs
- **Fail-loud:** broken pointers → non-zero exit + report
- **No network:** compiles from repo only
- **Sub-5-second:** runs in GitHub Actions on merge to `main`
- **Deployable anywhere AI-DOS runs** — no Node, Python, or SaaS dependency

**Implementation shape (Mission 009):**

PHP application in `tools/compiler/` — not a framework. Single entry
point:

```bash
php tools/compiler/compile.php
```

GitHub Actions executes PHP directly. No build step beyond `composer
install` if dependencies are needed.

**V1 migration:** Existing `site/index.html` becomes compiler template
output. Manual CSS may remain hand-edited until Mission 010 styling pass.

**Alternative considered:** *Python or Node for the compiler.*

Rejected. Operator decision: AI-DOS is built in PHP. A second language
splits the development ecosystem, complicates deployment, and prevents the
compiler from running anywhere AI-DOS runs without additional tooling.

**Alternative considered:** *Keep manual showcase forever.*

Rejected. Mission 005 report acknowledged drift risk; Mission 006 already
required manual showcase commits. Drift is not theoretical — it happened.

**Alternative considered:** *Full static site generator (Hugo, Astro).*

Rejected. Over-engineering for current scale (Principles §7). A focused
PHP compiler matches actual complexity. Revisit if portfolio exceeds ~20
missions.

---

### §4.7 AI Agent Coordination

**Purpose:** Make agent handoffs explicit — who executes, what model class
fits, what context to load, what done means.

**Canonical artifacts:**

| Artifact | Location | Role |
|---|---|---|
| `handoff.yaml` | Per-mission | Next-agent packet |
| `agent-brief.md` | Per-mission or playbook | Role-specific instructions |
| Model hints | `handoff.yaml` → `recommended_executor` | Routing guidance |

**`handoff.yaml` (sketch):**

```yaml
mission: "006"
phase: C
prior_phase_artifact: phase-a-thresholds.md
executor_hint: claude-sonnet  # reasoning-heavy scoring
read_first:
  - system/manifest.yaml
  - missions/006-validate-recommendation/phase-a-thresholds.md
  - missions/006-validate-recommendation/evidence-ledger.md
operator_inputs_expected:
  - interview notes (raw)
  - smoke test signup count
done_when:
  - report.md complete with verdict
  - decision D003 updated or superseded
  - queue.yaml portfolio-projects track updated
do_not:
  - adjust thresholds in phase-a-thresholds.md
  - begin product implementation
```

**Interfaces:**

- **Spawn:** operator or automation reads handoff → launches agent
- **Complete:** agent writes handoff for next phase or marks terminal
- **Route:** architecture vs. implementation missions get different hints

**Model routing guidance (organizational, not enforced):**

| Mission type | Suggested executor | Rationale |
|---|---|---|
| Architecture / design | GPT-class (long context, doc gen) | Mission 007 evidence |
| Careful implementation | Claude-class | Operator preference per user query |
| Governance / audit | Any — low creativity | Mechanical verification |
| Research / evidence | Model with best network fetch | Environment-dependent |

**V1 migration:** Add `handoff.yaml` to Mission 006 Phase C spec retroactively
in index (content written when Phase C opens). Template update in
`workflow/Templates/`.

**Alternative considered:** *Agent persona files (`/agents/Researcher.md`).*

Rejected in Mission 001 (no agent needed) and Mission 003 (same). V2 agrees:
personas ossify; **handoffs** describe work, not identity. Playbooks > personas.

---

### §4.8 Operator Mission Control

**Purpose:** iPhone-first control plane — approval inbox, status dashboard,
blocker visibility. Minimize operator digging (Principles §6).

**Surfaces:**

1. **Approval Inbox** (`site/inbox.html` compiled)
   - Lists missions awaiting Y/N
   - One question per mission — full question text visible without tap-through
   - Links to report.md anchor — not raw diffs

2. **Status Dashboard** (section of showcase)
   - Active missions by track
   - Blocked-on-operator highlights
   - Last merge timestamp

3. **GitHub merge as approve button**
   - Unchanged from V1 — merge IS approval
   - Inbox explains what merge means for this mission

**Operator workflows:**

| Scenario | V2 experience |
|---|---|
| Morning check | Open inbox → 0–1 items → read < 2 min |
| Mission 006 Phase B | Dashboard shows "blocked on operator" |
| Approve V2 design | Merge Mission 007 branch → inbox clears |
| Spawn next agent | Read handoff.yaml summary in inbox or report |

**Invariants:**

- No approval question buried below fold of report
- Inbox is compiled — never hand-edited
- Push notifications optional future (GitHub PR notifications suffice for V2.0)

**Alternative considered:** *Custom mobile app.*

Rejected. Violates minimalism; App Store friction; operator already uses
GitHub mobile + browser. Static HTML inbox is sufficient.

**Alternative considered:** *Chat-based approval (Telegram/Slack bot).*

Rejected as canonical. Chat approval is advisory (Standards §2). Bot may
*notify* but cannot record approval — merge only.

---

### §4.9 Showcase

**Purpose:** Public-facing, two-minute comprehension layer for outsiders.
Pure compiler output in V2.

**V2 changes:**

- `site/index.html` generated from template + `dist/state.json`
- CSS may remain hand-maintained (styling is not organizational truth)
- Mission timeline auto-includes all indexed missions
- Footer retains: "Repository artifacts remain canonical"

**Content sections (compiler-fed):**

- System premise (from Identity)
- Mission timeline (from index.yaml)
- Active decisions (from decisions/)
- Evidence summary (from active decision confidence)
- Governance flow (from Standards §2)
- Current state (from queue.yaml)
- Portfolio overview (when multiple repos exist)

**V1 migration:** Mission 005 design becomes compiler template. Visual
identity preserved — compiler fills content slots only.

---

### §4.10 Automation

**Purpose:** Propose missions and health checks without removing operator
authority. Automation **proposes**; operator **approves**.

**V2.0 automation (conservative):**

| Trigger | Action | Requires approval? |
|---|---|---|
| Mission merged | Recompile showcase + inbox | No |
| Weekly cron | Compiler health check mission proposal | Yes — mission created |
| Decision confidence gaps | Suggest validation mission | Yes |
| Manifest pointer broken | Open "repair" mission proposal | Yes |
| Phase B timeout (30d) | Flag blocked mission in inbox | No — visibility only |

**Canonical artifacts:**

| Artifact | Location | Role |
|---|---|---|
| `automation.yaml` | `system/automation.yaml` | Enabled triggers |
| Proposed missions | `missions/_proposed/` | Staging — not active until approved |

**Invariants:**

- Automation never merges to `main`
- Automation never fabricates evidence or metrics
- Proposed missions clearly marked `status: proposed`
- Operator can disable all triggers in `automation.yaml`

**V2.1+ (not V2.0):** Auto-spawn cloud agents on gate clearance.

**Alternative considered:** *Full autonomous agent loops.*

Rejected. Violates operator-as-final-decision-maker. Mission 006 Phase B
proves human-in-the-loop is load-bearing for real-world validation.

---

### §4.11 Portfolio Projects

**Purpose:** AI-DOS manages **Portfolio Projects** — products the operator
builds under AI-DOS governance. Each project uses the same workflow:
research → decision → validation → build. The architecture is
product-agnostic; no project-specific subsystems.

Mission 006 happens to validate the **first candidate** Portfolio Project
(origin: Mission 003 decision D003). Future projects follow exactly the
same pattern with new Portfolio Project IDs.

**Model:**

```
Operator
├── AI-DOS (this repo) — operating system, organizational source code
└── Portfolio Projects
    ├── P001 (candidate — validation in Mission 006)
    ├── P002 (future)
    └── ...
```

Each Portfolio Project with application code lives in its **own
repository**. AI-DOS tracks projects in `system/portfolio.yaml`; it does
not host product code.

**Canonical artifacts (in AI-DOS repo):**

```yaml
# system/portfolio.yaml
projects:
  - id: aidos
    repo: github.com/org/ai-dos
    role: operating_system
    status: active
  - id: P001
    name: null  # assigned when project graduates from candidate
    repo: null
    role: portfolio_project
    status: candidate
    workflow_stage: validation
    origin:
      decision: D003
      mission: "006"
```

**Workflow stages (same for every Portfolio Project):**

```
Candidate → Validation → Approved → Build → Active → Archived
```

Mission 006 is at `validation` for P001. Mission 008+ does not special-
case P001 in the architecture — only in the registry data.

**Interfaces:**

- **Register candidate:** decision + queue entry in `portfolio-projects` track
- **Advance stage:** validation mission completes → registry update
- **Spawn project repo:** mission creates repo when project reaches `build`
- **Cross-repo missions:** AI-DOS missions reference project repos by ID

**Alternative considered:** *Monorepo — all products in `/products/`.*

Rejected. Conflates OS evolution with product code; pollutes cold-start for
agents working on AI-DOS itself; git clone weight grows unbounded.

**Alternative considered:** *No portfolio — stay single-repo forever.*

Rejected. Operator strategy makes AI-DOS the primary product; Portfolio
Projects are how the operator runs a software company, not just one app.

**Alternative considered:** *Invoice-tool-specific architecture in AI-DOS.*

Rejected. Operator decision: Mission 006's invoice tool is the first
candidate Portfolio Project, not a special case. Product-specific logic
belongs in the project's own repo, not the OS.

---

### §4.12 Future Expansion

**Purpose:** Extension model without speculative building.

**Extension points (defined, not implemented):**

| Extension | Hook | When to build |
|---|---|---|
| Custom compilers | `tools/compiler/plugins/` | Mission 020+ if needed |
| New artifact types | `system/schemas/` | When a mission demonstrates need |
| External integrations | `system/integrations.yaml` | Stripe, email — product repos |
| Repository Intelligence Score | Principles.md recorded intent | Mission 018+ |
| Multi-operator | `system/operators.yaml` | Not planned — single operator invariant |

**Plugin rules:**

- Plugins cannot override Principles
- New artifact types require schema + mission
- Integrations are never canonical — artifacts record integration *state*

---

## §5 Storage layout (V2 target)

Capabilities, not folders. But folders persist for Git ergonomics:

```
/
├── company/              # Knowledge System (beliefs + standards)
├── knowledge/            # Knowledge System (playbooks) — NEW
├── system/               # Registry layer — NEW
│   ├── manifest.yaml
│   ├── index.yaml
│   ├── queue.yaml
│   ├── portfolio.yaml
│   ├── automation.yaml
│   └── schemas/
├── missions/             # Mission Engine artifacts (unchanged pattern)
├── decisions/            # Decision Engine — NEW
├── evidence/             # Evidence System bundles — NEW (optional per mission)
├── tasks/                # DEPRECATED after Mission 009 — kept as redirect
├── workflow/             # Templates
├── tools/                # Repository Compiler (PHP) — NEW
│   └── compiler/
│       └── compile.php
├── dist/                 # DISPOSABLE compiler output — gitignored
└── site/                 # Showcase (generated HTML + hand CSS)
```

**`tasks/Backlog.md` deprecation:**

After `queue.yaml` is live and compiler emits human-readable queue view,
Backlog.md becomes a generated redirect: "See system/queue.yaml". Migration
in Mission 009 with addendum — not deletion.

---

## §6 Data flows

### §6.1 Mission execution flow

```
Operator approves mission N via merge
        ↓
Agent reads manifest.yaml → handoff.yaml → playbooks
        ↓
Agent executes → commits (Standards §1.1) → updates artifacts
        ↓
Agent writes report.md + handoff.yaml + index/queue updates
        ↓
Compiler runs → showcase + inbox + state.json
        ↓
Operator sees inbox question → merge approves mission N+1
```

### §6.2 Decision + evidence flow

```
Research mission produces evidence-ledger.md
        ↓
Decision mission creates decisions/DDD/ with alternatives
        ↓
Confidence routing writes queue.yaml validation entry
        ↓
Validation mission references decision ID (not restated rationale)
        ↓
Pass → portfolio.yaml product status update
Fail → new decision supersedes D003
```

### §6.3 Cold-start flow

```
git clone → read system/manifest.yaml
        ↓
php tools/compiler/compile.php → dist/cold-start-answers.md
        ↓
Agent has full organizational context in < 30 seconds
```

### §6.4 Compile-on-merge (GitHub Actions — approved)

Operator approved compile-on-merge. Governance is unchanged: only
**generated artifacts** are automated. Operator approval is never
automated.

```
Merge to main
        ↓
GitHub Actions (trigger: push to main)
        ↓
Run Repository Compiler (PHP)
  php tools/compiler/compile.php
        ↓
Generate all derived artifacts
  (website, timelines, dashboard, context packages, analytics, reports)
        ↓
Commit dist/ + site/ outputs (or publish to GitHub Pages)
        ↓
Website updated — operator reviews via GitHub Mobile as today
```

**What automation does:** recompile disposable outputs from canonical source.

**What automation never does:** merge missions, approve decisions, spawn
agents without operator action, or modify organizational source code.

Mission 009 implements the workflow. Mission 016 formalizes it in
`system/automation.yaml`.

---

## §7 Governance (V2)

V1 governance is sound. V2 adds structure, not new philosophy.

| Rule | V1 | V2 enhancement |
|---|---|---|
| Approval = merge | Standards §2 | Unchanged |
| Chat advisory only | Standards §2 | Unchanged |
| One Y/N per gate | Convention | Compiler validates report ending |
| Mission numbering | Ad hoc renumbering | Queue IDs permanent; titles can change |
| Historical preservation | Addenda | Unchanged — decisions supersede, not erase |

**Renumbering protocol (new standard — propose in Mission 008):**

1. Never reuse mission IDs
2. Update `queue.yaml` + `index.yaml` — not prose in five files
3. Historical missions get addenda only
4. Compiler fails if index references missing folder

---

## §8 Repository Intelligence Score (RIS)

Recorded intent exists in [company/Principles.md](../company/Principles.md).
V2 designs but does not implement.

**Proposed definition:**

RIS measures §0 compliance — "can a future agent guess?" — as a compile-time
score:

| Check | Weight |
|---|---|
| Manifest pointers resolve | 20% |
| Active decisions have evidence links | 20% |
| Queue matches mission folder states | 15% |
| Reports end with approval question | 10% |
| Commits follow Standards §1.1 (sample) | 15% |
| No [U]-only load-bearing claims on active decisions | 10% |
| Showcase compiles without error | 10% |

RIS emits to `dist/intelligence-score.json`. Mission 018 implements.

---

## §9 Security and trust model

- **No secrets in repo.** API keys live in CI/agent environment only.
- **No unverified auto-execution.** Automation proposes missions; operator merges.
- **Evidence tiers prevent fabricated confidence.** Compiler warns on [U] load-bearing.
- **Merge authority = operator authority.** GitHub branch protection enforced.
- **Agent untrusted.** Any agent may hallucinate; artifacts must cite files.

---

## §10 Migration roadmap (V1 → V2)

Phased. No big-bang rewrite.

| Phase | Missions | Outcome |
|---|---|---|
| **Foundation** | 008–009 | `system/` registry + retroactive index |
| **Compiler** | 009–010 | Repository Compiler (PHP): showcase, dashboard, all derived artifacts |
| **Decisions** | 011 | `decisions/D003` retroactive + template |
| **Mission Engine** | 012 | `queue.yaml` replaces Backlog |
| **Playbooks** | 013 | Extract 002–006 patterns |
| **Agent handoffs** | 014 | handoff.yaml template + Mission 006 Phase C |
| **Portfolio Projects** | 015 | `portfolio.yaml` registry; generic project workflow |
| **Automation** | 016–017 | Compile-on-merge CI + health proposals |
| **RIS** | 018 | Intelligence score |

**Parallel track:** Mission 006 validates first candidate Portfolio Project
(P001). If validation passes, build happens in a separate project repo
using the standard Portfolio Project workflow — not special-case architecture.

**Compatibility:** V1 agents can still read markdown during migration.
`manifest.yaml` is additive. Compiler warnings guide transition.

---

## §11 Major rejected alternatives (summary)

| Decision | Alternative | Why it lost |
|---|---|---|
| Storage | External database | Non-Git canonical state; merge conflicts; infrastructure |
| Missions | GitHub Issues | Split truth; cold-start failure |
| Showcase | Manual forever | Drift already observed (M005 risk, M006 updates) |
| Products | Monorepo | OS/product concern collision; clone bloat |
| Products | Invoice-specific OS architecture | Product-agnostic Portfolio Projects (operator decision) |
| Agents | Persona files | Mission 001/003 rejected; handoffs > personas |
| Compiler language | Python or Node | Operator chose PHP — AI-DOS is PHP; one ecosystem |
| Compiler | Hugo/Astro SSG | Over-engineering for current scale |
| Approval | Chat bot canonical | Standards §2 — merge only is durable |
| Control plane | Native mobile app | Friction; GitHub Mobile sufficient |
| Automation | Full autonomy | Operator authority; M006 human loop |
| Decisions | Embedded in reports only | Renumbering pain; cross-mission pointers fragile |

---

## §12 Non-goals (V2)

- Becoming a chat interface
- Replacing Git with a custom VCS
- Multi-tenant SaaS AI-DOS hosting
- Python or Node runtimes for core subsystems
- External databases as canonical state
- Real-time collaborative editing
- Agent marketplace
- Built-in LLM inference
- Competing with GitHub as forge

---

## §13 Operator decisions (recorded 2026-07-07)

The operator approved the V2 architecture with these binding decisions:

| # | Decision | Resolution |
|---|---|---|
| 1 | Repository Compiler language | **PHP** — AI-DOS is built in PHP; one language, one ecosystem; GitHub Actions runs PHP directly; deployable anywhere AI-DOS runs |
| 2 | Repository Compiler concept | **Organizational source code → compiler → disposable artifacts.** Central innovation of V2. Repository is canonical; everything else is compiled |
| 3 | Portfolio Projects | **Product-agnostic abstraction.** AI-DOS manages Portfolio Projects. Mission 006's invoice tool is the first candidate only — same workflow for all future projects |
| 4 | Mission 007 identity | **Officially: Design AI-DOS V2.** Benchmark application moves into Portfolio Projects; no longer the repository's primary focus |
| 5 | GitHub Actions | **Compile-on-merge approved.** Merge → Actions → PHP compiler → derived artifacts → website updated. Governance unchanged; approval never automated |
| 6 | Operator interface | **GitHub Mobile preserved.** Compiled dashboard and inbox serve the iPhone operator |

No open architectural questions remain. Mission 008 implements.

---

## §14 Success criteria for V2 architecture

V2 architecture succeeds when:

1. A fresh agent reads `manifest.yaml` and starts correct work in one session
2. Operator approval workflow fits in < 5 minutes on iPhone
3. Showcase never drifts from canonical state (compiler enforced)
4. Mission 006 Phase C can execute using V2 handoff artifacts
5. Decision D003 is queryable without opening Mission 003 report
6. Parallel tracks (AI-DOS + Portfolio Projects) visible in queue without confusion
7. Repository Compiler (PHP) runs in GitHub Actions with no extra language runtimes
8. No capability requires infrastructure beyond Git + PHP compile-on-merge

---

*End of architecture document. Implementation missions begin at Mission 008.*
