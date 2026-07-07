# Decision D003: Merge-to-Main as Durable Approval

**Status:** accepted  
**Related missions:** Mission 004

## Context

Mission approvals could be recorded in chat, in report headers, or only when merged to `main`. Inconsistent approval created governance drift.

## Decision

Operator approval is **durable only when mission work is merged into `main`**. Chat approval is advisory. The merge commit is the permanent organizational record.

## Alternatives considered

- **Chat-only approval** — fast but not versioned.
- **Report header "approved" without merge** — stale if branch never merges.
- **External approval tool** — violates repository-canonical constraint.

## Why chosen

Aligns approval with Git audit trail. Supports cold-start: `main` always reflects approved state. Principles §6: operator reviews one question, merge completes the loop.

## Evidence

- [company/Standards.md](../company/Standards.md) §2
- [missions/004-close-governance-loop/report.md](../missions/004-close-governance-loop/report.md)
