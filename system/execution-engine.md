# Execution Engine — Minimal Implementation

**Status:** Minimal implementation (Mission 012)  
**Defined by:** Mission 011 (contract), Mission 012 (implementation)  
**Sources:** `system/execution-engine.yaml`, `system/worker-roles.yaml`, `system/execution-plans/`

---

## Purpose

The Execution Engine coordinates **how work is planned** — not what the repository remembers.

It turns one operator request into a structured execution plan for cloud AI workers. The operator works from an iPhone. **Cursor** and **Claude Code** are the first practical tools, mapped through **roles** (not brands).

The repository remains canonical organizational **memory**. Plans under `system/execution-plans/` are source recommendations. `site/data/execution-engine.json` is a disposable compiled view.

## What it does (Mission 012)

| Capability | Description |
|------------|-------------|
| Mission intake | Structure operator requests into objectives and scope |
| Work decomposition | Break missions into work units (research, backend, UI, etc.) |
| Worker assignment | Assign units to capability roles from `worker-roles.yaml` |
| Context routing | Map work unit types to context packages |
| Execution plans | Publish YAML plans for paste into workers |
| Operator approval | Stop after plan; merge remains approval |

## What it does NOT do

- Autonomous agent spawning
- Background workers or task queues
- External APIs or cloud execution
- Fabricated worker history or multi-agent execution claims
- Automatic merge or approval

## Position in the stack

```text
Repository → Memory → Asset Registry → Intelligence → Execution Engine → Compiler → Command Center
```

Execution Engine is **active** for planning. Worker execution is **manual** — operator pastes plans into Cursor or Claude Code.

## Routing (practical)

| Tool | Primary roles |
|------|----------------|
| **Claude Code** | Principal Architect, Research Specialist, Reviewer |
| **Cursor** | Implementation Engineer, Backend/Frontend, QA, Documentation |

See `system/worker-roles.yaml` for the full role model.

## Governance

Execution plans are **advisory**. Operator approval remains merge-to-main (Standards §2, §10).

## Related decisions

- [D007](../decisions/D007-execution-engine-foundation.md) — Execution Engine layer approved
