# Mission 010 Report: Repository Intelligence Foundation

**Status:** Complete
**Executed by:** Composer (Cursor Cloud Agent)

## Executive summary

Mission 010 creates the **Repository Intelligence Layer** — the permanent
infrastructure that teaches AI-DOS how to think about what exists. Building
on the Repository Compiler (Mission 008) and Asset Registry (Mission 009), this
mission adds manifest compilation, context packages, dependency validation, and
repository lookup. All outputs are generated views; the repository remains
canonical.

---

## Repository Manifest

**Source:** [system/manifest.yaml](../../system/manifest.yaml)  
**Compiled:** [site/data/manifest.json](../../site/data/manifest.json)

The manifest is a pointer graph — it references where truth lives without
duplicating it:

- Missions, Backlog, Asset Registry, architecture, compiler, standards
- Context packages and dependency report compiled paths

At compile time the compiler resolves: current/next mission, completed/active/
paused missions, architecture version, compiler version, asset registry version,
repository health, and generated artifact versions.

---

## Context Packages

**Source:** [system/context-packages.yaml](../../system/context-packages.yaml)  
**Compiled:** [site/data/context-packages.json](../../site/data/context-packages.json)

Five lightweight packages reduce unnecessary repository scanning:

| Package | Purpose |
|---------|---------|
| Mission Context | Execute or review missions |
| Architecture Context | V2 design and implementation |
| Compiler Context | Compiler and CI changes |
| Website Context | Mission Control and site artifacts |
| Governance Context | Standards, principles, governance |

Each package lists resolved file paths only (includes + globs expanded at compile time).

---

## Dependency Validation

**Compiled:** [site/data/dependency-report.json](../../site/data/dependency-report.json)

Validates Asset Registry relationships:

- Broken paths (source files missing on disk)
- Missing asset IDs in `depends_on` / `outputs`
- Circular dependencies
- Malformed public URLs

**Policy:** report only — never auto-repair.

Current status after compile: see `dependency-report.json` (healthy at mission completion).

---

## Repository Lookup

**Compiled:** [site/data/repository.json](../../site/data/repository.json)

Lookup indexes exported from the Asset Registry:

- `lookup.by_id` — query by asset ID
- `lookup.by_path` — query by repository path
- `lookup.by_type` — assets grouped by type
- `query_examples` — precomputed answers (compiler location, organization.json generator, editability, public URLs)

No repository grep required for supported questions.

---

## Command Center updates

Mission Control ([site/index.html](../../site/index.html)) adds Repository Intelligence cards:

- Repository Intelligence summary (health, versions, package count)
- Repository Manifest
- Context Packages
- Dependency Health (issues list, capped at 8 in UI)
- Asset Relationships (compiler → outputs chain)

All values load from generated JSON — no hardcoded facts.

---

## Compiler changes

- New: [compiler/RepositoryIntelligence.php](../../compiler/RepositoryIntelligence.php)
- Compiler version: `1.3.0-mission-010`
- Exports: `manifest.json`, `context-packages.json`, `dependency-report.json`, `repository.json`
- CI: PHP `yaml` extension required (`.github/workflows/compile-site.yml`)

---

## Standards

Added **§6 Repository Intelligence** to [company/Standards.md](../../company/Standards.md).

---

## What AI-DOS Learned

This mission changed AI-DOS itself in the following ways:

- **Repository Intelligence is permanent infrastructure** — manifest, context
  packages, dependency validation, and lookup are now compiler-owned capabilities.
- **Agents get superpowers from generated JSON** — context packages and lookup
  indexes eliminate blind repository scanning for common task classes.
- **Health is measurable** — dependency validation produces a machine-readable
  report without mutating source files.
- **Pointer graphs beat duplication** — manifest.yaml references truth; compiler
  resolves live values at compile time.
- **Foundation milestone reached** — Compiler + Asset Registry + Repository
  Intelligence + organizational memory + Command Center warrant a full
  architecture review before the next major phase.

---

Approve Mission 011: Decision Intelligence Layer? Y/N
