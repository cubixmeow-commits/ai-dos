# Decision D005: Repository Intelligence Layer

**Status:** accepted  
**Related missions:** Mission 010

## Context

Mission 009 answered "what exists." Agents still scanned the full repository for context, dependencies, and navigation. Mission 010 audit recommended intelligence data structures before more registry files.

## Decision

Add a permanent **Repository Intelligence** layer: manifest pointer graph, context packages, dependency validation (report-only), and repository lookup indexes. Implemented in `compiler/RepositoryIntelligence.php`; compiled to `site/data/manifest.json`, `context-packages.json`, `dependency-report.json`, `repository.json`.

## Alternatives considered

- **More YAML registries first** (`index.yaml`, `portfolio.yaml`) — audit said reconcile and decide before multiplying registries.
- **Live PHP query API** — requires runtime server; violates static hosting model.
- **Agent-side grep only** — does not scale; wastes context window.

## Why chosen

Teaches AI-DOS how to think about what exists without fabricating behavior. Pointer manifest avoids duplicating mission state. Context packages reduce scan surface for agents.

## Evidence

- [missions/010-repository-intelligence/report.md](../missions/010-repository-intelligence/report.md)
- [company/Standards.md](../company/Standards.md) §6
- [architecture-audit.md](../architecture-audit.md) Part 7
