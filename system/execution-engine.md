# Execution Engine — Architectural Contract (Foundation Only)

**Status:** Planned — not implemented  
**Defined by:** Mission 011 (Architecture Integration)  
**Implementation:** Mission 012 and later (operator approval required)

---

## Purpose

The Execution Engine is the next layer above Repository Intelligence. It coordinates **how work runs** — not what the repository remembers.

The repository remains canonical organizational **memory**. The operating system is the **intelligence and execution layer** built on top of it. This document defines interfaces only. No cloud orchestration, agent spawning, or external APIs exist yet.

## Position in the stack

```text
Repository (Git on main)
        ↓
Organizational Memory (missions, decisions, commits)
        ↓
Asset Registry (system/assets.yaml)
        ↓
Repository Intelligence (manifest, lookup, context packages)
        ↓
Execution Engine          ← THIS DOCUMENT (planned)
        ↓
Repository Compiler
        ↓
Command Center (operator + visitors)
```

## Responsibilities (future)

| Responsibility | Description |
|----------------|-------------|
| Mission decomposition | Break approved missions into executable steps with clear handoffs |
| Capability matching | Map step types to agent capabilities (research, implement, review) |
| Context generation | Select context packages + decision records + mission artifacts per step |
| Agent routing | Propose which agent profile runs which step (operator approves) |
| Parallel execution planning | Identify independent steps; serialize conflicts |
| Execution tracking | Record what ran, what blocked, what awaits merge |
| Merge readiness | Verify commits, reports, registry updates before approval question |

## Inputs (canonical sources)

- `tasks/Backlog.md` — queue
- `missions/*/mission.md`, `report.md` — mission state
- `decisions/*.md` — durable decisions
- `system/context-packages.yaml` — compiled context package definitions
- `site/data/repository.json` — lookup indexes (generated)
- `company/Principles.md`, `Standards.md` — constraints

## Outputs (future, generated)

Proposed disposable artifacts (names tentative):

- `site/data/execution-plan.json` — proposed steps for active mission
- `site/data/execution-state.json` — blocked / running / awaiting operator
- Command Center **Execution** card (only when data exists — never fabricated)

## Interfaces (contract sketch)

```yaml
# Future: system/execution-engine.yaml (not created until Mission 012+)
interfaces:
  plan_mission:
    input: mission_id
    output: execution_plan  # steps[], dependencies[], context_packages[]
  match_capability:
    input: step_type
    output: capability_id, required_context_packages[]
  readiness_check:
    input: mission_id
    output: merge_ready: bool, blockers[]
```

## Explicit non-goals (Mission 011)

- No background services or daemons
- No database
- No automatic agent spawning
- No automatic merge or approval
- No fabricated metrics or agent rosters
- No composite "intelligence scores"

## Governance

Execution Engine proposals are **advisory**. Operator approval remains merge-to-main (Standards §2). Execution plans must cite repository evidence (Principles §5).

## Related decisions

- [D007](../decisions/D007-execution-engine-foundation.md) — this layer approved as foundation only
