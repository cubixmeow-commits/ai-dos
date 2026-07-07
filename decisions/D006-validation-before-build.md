# Decision D006: Validate Before Build (Invoice Tool)

**Status:** accepted — validation in progress (Mission 006 Phase B paused)  
**Related missions:** Mission 003, Mission 006

## Context

Mission 003 recommended a freelancer invoice follow-up tool at **Medium** confidence. Principles §5 and Mission 003 explicitly routed product build to validation, not immediate implementation.

## Decision

Run **Mission 006 validation** (evidence ledger, locked thresholds, operator interviews, smoke test) before any Portfolio Project build. A "do not build" outcome is a successful Mission 006.

## Alternatives considered

- **Build immediately after Mission 003** — faster but violates evidence routing.
- **Abandon candidate without validation** — loses learning opportunity.
- **Merge P001 into AI-DOS repo** — rejected; Portfolio Projects stay product-agnostic per Mission 007.

## Why chosen

Confidence routing is a core OS behavior. Mission 006 Phase model becomes template for future validation missions.

## Evidence

- [missions/003-prove-the-loop/report.md](../missions/003-prove-the-loop/report.md) — Medium confidence
- [missions/006-validate-recommendation/phase-a-thresholds.md](../missions/006-validate-recommendation/phase-a-thresholds.md)
- [missions/007-design-v2/architecture.md](../missions/007-design-v2/architecture.md) §4.11 Portfolio Projects
