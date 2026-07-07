# Mission 008: Build the Repository Compiler

**Status:** Complete — see [report.md](report.md)
**Executed by:** GPT-5.5 (Cursor Cloud Agent)

## Why this mission exists

Mission 007 approved AI-DOS V2 with a central innovation: the repository
is organizational source code, and the **Repository Compiler (PHP)**
transforms that source into disposable human interfaces. This mission
builds the first working compiler — minimal but real.

## Mission Objective

Build a PHP-based Repository Compiler that reads existing repository
artifacts and generates structured JSON plus a static Mission Control
website. The repository remains canonical. Generated artifacts are
disposable.

## Tasks

1. Create `compiler/compile.php` and `compiler/README.md`.
2. Generate `site/data/missions.json` from mission artifacts.
3. Generate `site/data/organization.json` from repository state.
4. Rebuild `site/index.html` as Mission Control powered by generated JSON.
5. Update `site/styles.css` (preserve existing visual identity).
6. Add `.github/workflows/compile-site.yml` for compile-on-merge.
7. Add Repository Compiler standard to `company/Standards.md` §4.
8. Update `tasks/Backlog.md` — Mission 008 complete; queue Mission 009.
9. Create mission records and `report.md`.

## Constraints

- PHP only. No Node, Python, database, or backend.
- No fabricated metrics or claims not traceable to repository files.
- Do not implement full V2 architecture (no `system/` registry yet).
- Do not modify Mission 006 artifacts — reference paused status only.
- Follow Knowledge Preservation commit standard.

## Exit criteria

- PHP compiler exists and runs successfully.
- `missions.json` and `organization.json` generated from repository files.
- Mission Control site loads from generated JSON.
- GitHub Action exists or limitation documented.
- Standards §4 documents compiler truth rules.
- Report complete with approval question for Mission 009.
