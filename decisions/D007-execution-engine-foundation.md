# Decision D007: Execution Engine as Next Layer (Foundation Only)

**Status:** accepted — architectural contract; not implemented  
**Related missions:** Mission 011

## Context

After Mission 010, AI-DOS has Repository → Memory → Asset Registry → Intelligence → Compiler → Command Center. The architecture audit and operator direction require preparation for **cloud agent orchestration from iPhone** without claiming capabilities that do not exist.

## Decision

Define an **Execution Engine** subsystem as the next architectural layer — documented in `system/execution-engine.md`, **not implemented** in Mission 011. Decision records (`decisions/`) are one input to future execution planning. Mission 012 may implement foundation pieces.

## Alternatives considered

- **Implement orchestration in Mission 011** — audit warned against drift; too much too soon.
- **Skip Execution Engine; more registries** — misaligns with operator goal (coordinate AI work).
- **External orchestration SaaS as source of truth** — violates repository-canonical.

## Why chosen

Separates **memory + intelligence** (built) from **execution** (planned). Command Center shows Execution as "Foundation only / Planned." Preserves merge-based governance.

## Evidence

- [architecture-audit.md](../architecture-audit.md) Part 14, Part 16
- [system/execution-engine.md](../system/execution-engine.md)
- Mission 011 report — audit adoption record
