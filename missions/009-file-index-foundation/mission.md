# Mission 009: File Index Foundation

**Status:** Complete — see [report.md](report.md)
**Executed by:** Composer (Cursor Cloud Agent)

## Why this mission exists

AI-DOS needs one reliable place to answer: what file exists, where it is,
what it does, whether it is source or generated, whether it is safe to edit,
what public URL maps to it, and which mission created or last changed it.
Mission 007 V2 architecture planned a `system/` registry layer; this mission
delivers the first permanent piece — the master file index.

## Mission Objective

Create a canonical master file index (`system/file-index.yaml` plus
`system/file-index.md`), update Standards, integrate a summary into the
Repository Compiler output, and index Missions 001–008 retroactively.

## Tasks

1. Create `system/file-index.yaml` — machine-readable canonical registry.
2. Create `system/file-index.md` — iPhone-friendly human companion.
3. Index README, company docs, Backlog, all mission folders, compiler,
   site files, site/data, GitHub workflow, validation page, architecture files.
4. Map public URLs using deployment root `https://cubixmeow.com/ai-dos/`.
5. Add File Index section to `company/Standards.md`.
6. Update Repository Compiler to include file index summary in
   `site/data/organization.json` when practical.
7. Update `tasks/Backlog.md` — queue next mission after 009.
8. Create mission records and `report.md`.

## Constraints

- Do not redesign AI-DOS or unrelated site design.
- Do not fabricate file purposes; mark uncertain entries with "needs verification."
- Keep descriptions short and useful.
- Follow Knowledge Preservation commit standard.

## Exit criteria

- `file-index.yaml` and `file-index.md` exist and cover required paths.
- Standards §5 documents file index maintenance rules.
- Compiler includes `file_index` in organization.json (or limitation documented).
- Report complete with approval question for Mission 010.
