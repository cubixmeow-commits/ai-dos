# Mission 010: Repository Intelligence Foundation

**Status:** Complete — see [report.md](report.md)
**Executed by:** Composer (Cursor Cloud Agent)

## Why this mission exists

Mission 008 created the Repository Compiler. Mission 009 created the Asset
Registry. AI-DOS now knows **what exists**. Mission 010 teaches AI-DOS
**how to think about what exists** — the intelligence layer every future
mission will use.

The repository remains canonical. This mission builds systems that understand,
validate, search, and package repository knowledge automatically.

## Objectives

Create the **Repository Intelligence Layer** with four permanent capabilities:

1. Repository Manifest (`system/manifest.yaml`)
2. Context Packages (`system/context-packages.yaml`)
3. Dependency Validation (from Asset Registry relationships)
4. Repository Lookup (compiler-exported indexes)

## Tasks

1. Create `system/manifest.yaml` — pointer graph; no duplicated facts.
2. Create `system/context-packages.yaml` — five agent context packages.
3. Build `compiler/RepositoryIntelligence.php` — manifest, packages, validation, lookup.
4. Extend compiler to export `manifest.json`, `context-packages.json`,
   `dependency-report.json`, `repository.json`.
5. Add Repository Intelligence cards to Mission Control (Command Center).
6. Add Standards §6 — Repository Intelligence subsystem.
7. Update Backlog — queue Mission 011.
8. Create mission records and `report.md`.

## Constraints

- Repository remains canonical; generated artifacts disposable.
- Do not fabricate information.
- Do not redesign previous missions.
- No database or external services.
- Dependency validation reports only — never auto-repair.
- Follow Knowledge Preservation commit standard.

## Exit criteria

- All four intelligence capabilities operational via compiler.
- Command Center surfaces manifest, packages, dependency health, relationships.
- Standards §6 documents the subsystem.
- Report complete with approval question for Mission 011.
