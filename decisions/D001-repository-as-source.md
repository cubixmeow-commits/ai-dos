# Decision D001: Repository as Organizational Source Code

**Status:** accepted  
**Related missions:** Mission 007, Mission 008

## Context

AI-DOS V1 proved that a Git repository can hold organizational memory. V2 asked whether the repository should remain a documentation store or become something stronger.

## Decision

The repository is **organizational source code**. Missions, decisions, evidence, principles, standards, and governance artifacts are versioned source. Human and agent interfaces are **compiled disposable views** under `site/`.

## Alternatives considered

- **Documentation-only repo** — markdown files without a compiler layer.
- **External database of record** — SQLite or SaaS for organizational state.
- **Chat-as-memory** — rely on agent session history.

## Why chosen

Git on `main` already governs approval. A compiler model makes “generated vs canonical” enforceable (Standards §4). No external database preserves solo-operator simplicity and iPhone-readable source files.

## Evidence

- [missions/007-design-v2/architecture.md](../missions/007-design-v2/architecture.md) §0.1, §3.4
- [company/Identity.md](../company/Identity.md) §1
- [missions/008-repository-compiler/report.md](../missions/008-repository-compiler/report.md)
