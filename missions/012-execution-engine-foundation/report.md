# Mission 012 Report — Execution Engine Foundation

**Mission:** Minimal Execution Engine  
**Status:** Complete — pending operator merge approval  
**Compiler version:** 1.5.0-mission-012

---

## Summary

Mission 012 implemented the **minimum Execution Engine** AI-DOS needs to
coordinate real product-building work. The operator can turn one request into a
structured plan with work units, roles, context packages, and paste-ready
routing for **Cursor** and **Claude Code**.

Nothing runs automatically. The merge still owns approval.

---

## What was built

| Artifact | Purpose |
|----------|---------|
| `system/execution-engine.yaml` | Coordination model, work unit types, context routing, execution flow |
| `system/worker-roles.yaml` | Eight capability roles + Cursor/Claude Code practical mappings |
| `system/execution-plans/example-inventory-saas.yaml` | Sample intake (inventory SaaS request) |
| `system/execution-plans/mission-013-first-external-product.yaml` | Proposed next mission plan |
| `compiler/ExecutionEngine.php` | Compiles engine state → `execution-engine.json` |
| `site/data/execution-engine.json` | Disposable Command Center view |
| Command Center Execution section | Roles, flow, latest plan, build status |
| Standards §10 | Execution Engine operational rules |

---

## Why it exists

AI-DOS stopped being a project that only documents itself. The operator's goal:
stand in a grocery-store line, open GitHub on an iPhone, approve one PR, and
keep running an AI software company.

Mission 012 is the **last infrastructure mission**. Everything after this should
build **companies and products**.

---

## Execution model

```text
Operator request
    → mission intake (structured objective + scope)
    → work decomposition (independent units)
    → role assignment (from worker-roles.yaml)
    → context routing (from context-packages.yaml)
    → execution plan (system/execution-plans/*.yaml)
    → operator approval (merge)
    → manual worker execution (paste plan into Cursor or Claude Code)
```

Plans are **recommendations**. The Execution Engine stops before execution.

---

## Worker model

Roles describe **capabilities**, not brands:

| Role | Typical tool |
|------|----------------|
| Principal Architect | Claude Code |
| Research Specialist | Claude Code |
| Reviewer | Claude Code |
| Implementation Engineer | Cursor |
| Backend Engineer | Cursor |
| Frontend Builder | Cursor |
| QA Engineer | Cursor |
| Documentation Writer | Cursor |

Future models attach to roles without changing the execution model.

---

## Context routing

Work unit types map to context packages in `execution-engine.yaml`. Examples:

- **research** → `mission-context`, `governance-context`
- **architecture** → `architecture-context`, `governance-context`
- **frontend / ui** → `website-context`, `architecture-context`
- **backend** → `compiler-context`, `architecture-context`

Repository Intelligence answers routing questions via `execution-engine.json`
→ `query_answers`.

---

## Repository integration

- Plans are canonical in `system/execution-plans/`
- Roles in `system/worker-roles.yaml`
- Model in `system/execution-engine.yaml`
- Asset Registry updated with all new assets
- Manifest references execution sources and compiled JSON

---

## Compiler integration

`ExecutionEngine.php` reads YAML sources and emits:

- worker roles and tool summary
- execution flow steps
- context routing table
- all execution plans
- latest proposed plan (Mission 013)
- build status (explicitly: no autonomous execution, no worker history)
- query answers for Repository Intelligence

---

## Command Center integration

New **Execution Engine** section displays:

- Engine status and capability counts
- Worker roles list
- Execution flow (8 steps)
- Latest execution plan with Cursor/Claude routing counts
- Build status and next product mission pointer

Architecture stack shows Execution as **active** (planning), not autonomous.

---

## How it supports Cursor + Claude Code

1. Operator defines objective (or uses sample plan).
2. Execution plan lists work units with `role`, `practical_tool`, and `context_packages`.
3. Operator copies units into the right tool:
   - **Claude Code** — research, architecture, review units
   - **Cursor** — implementation, UI, testing, documentation units
4. Worker attaches context package files from the repository.
5. Results commit per Knowledge Preservation standard.
6. Operator merges when satisfied.

See `mission-013-first-external-product.yaml` → `routing_summary` for a full example.

---

## What it does NOT do yet

- Autonomous agent spawning
- Background workers or task queues
- External APIs or cloud execution
- Live execution tracking or worker history
- Automatic merge or approval
- Product code (deferred to Mission 013)

---

## How it prepares AI-DOS to build a real product

Mission 013's execution plan is already in the repository. It decomposes
first-product work into seven units with clear role and tool assignments.
When the operator approves Mission 013, agents follow the plan — AI-DOS
coordinates, humans and tools execute.

Candidate product: invoice follow-up tool (Mission 003/006) or operator choice
at Mission 013 start.

---

## What AI-DOS learned

- **Roles beat brands** — storing capabilities separately from Cursor/Claude
  mapping future-proofs the execution model.
- **Plans are source** — YAML in `execution-plans/` is canonical; JSON is a view.
- **Minimal is enough** — six capabilities without orchestration servers let the
  operator coordinate from a phone.
- **Infrastructure must end** — Mission 012 is the deliberate stopping point
  before building external software.
- **Paste is execution** — until cloud APIs exist, copy-paste into workers is
  honest orchestration.

---

## Cold-start proof

1. Read `system/execution-engine.yaml` and `system/worker-roles.yaml`
2. Open `system/execution-plans/mission-013-first-external-product.yaml`
3. Compile: `php compiler/compile.php`
4. Command Center → Execution Engine section
5. `site/data/execution-engine.json` → `routing_guide` and `query_answers`

---

## Next mission (proposed — not started)

**Mission 013: Build the First External Product Using AI-DOS**

Use the Execution Engine to ship a real product. No more AI-DOS infrastructure
unless blocking the product.

---

Approve Mission 013: Build the First External Product Using AI-DOS? Y/N
