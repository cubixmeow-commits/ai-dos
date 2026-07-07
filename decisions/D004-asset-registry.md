# Decision D004: Asset Registry Over File Index

**Status:** accepted  
**Related missions:** Mission 009

## Context

Mission 009 introduced a flat file index. The audit noted AI-DOS owns compilers, workflows, websites, and missions — not just files. Legacy `file-index` shims duplicated the canonical registry.

## Decision

Maintain **`system/assets.yaml`** as the canonical Asset Registry. A file is one asset type among many. Legacy `file-index` files were removed in Mission 011. Lookup and Command Center read compiled `repository.json` and `assets.yaml`.

## Alternatives considered

- **Keep parallel file-index.yaml** — backward compat but operator confusion.
- **Filesystem-only discovery** — no relationships or edit-safety metadata.
- **External asset CMDB** — rejected (repository-canonical).

## Why chosen

`depends_on` / `outputs` enable dependency validation and lookup without a graph database. Evolving Mission 009 in place avoided mission sprawl for schema upgrades.

## Evidence

- [missions/009-file-index-foundation/report.md](../missions/009-file-index-foundation/report.md) addendum
- [architecture-audit.md](../architecture-audit.md) Part 5, Part 13
- [company/Standards.md](../company/Standards.md) §5
