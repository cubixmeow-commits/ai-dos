# Mission 008 Report: Build the Repository Compiler

**Status:** Complete
**Executed by:** GPT-5.5 (Cursor Cloud Agent)

## Executive summary

Mission 008 delivers the first working **Repository Compiler (PHP)**.
AI-DOS now reads its own organizational source code — mission artifacts,
company docs, and Backlog — and compiles a static **Mission Control**
interface under `site/`. The repository remains canonical; all compiler
output is disposable and regenerable.

---

## What was built

| Artifact | Purpose |
|---|---|
| [compiler/compile.php](../../compiler/compile.php) | PHP compiler — scans repository, emits JSON + site |
| [compiler/README.md](../../compiler/README.md) | How to run the compiler |
| [site/data/missions.json](../../site/data/missions.json) | Structured mission data (one object per mission) |
| [site/data/organization.json](../../site/data/organization.json) | Organization state derived from repository files |
| [site/index.html](../../site/index.html) | Mission Control UI — loads generated JSON |
| [site/styles.css](../../site/styles.css) | Styles (preserves Mission 005 visual identity + additions) |
| [.github/workflows/compile-site.yml](../../.github/workflows/compile-site.yml) | Compile-on-merge verification |
| [company/Standards.md](../../company/Standards.md) §4 | Repository Compiler truth rules |
| [tasks/Backlog.md](../../tasks/Backlog.md) | Mission 009 queued; Mission 006 pause recorded |

---

## What the compiler reads

**Required inputs:**

- `/missions/*/mission.md` — title, status, executed_by
- `/missions/*/report.md` — status, summary, approval question, what AI-DOS learned, confidence
- `/company/Identity.md` — active strategy text
- `/company/Standards.md` — governance model reference
- `/tasks/Backlog.md` — next mission

**Optional inputs** (listed per mission in `artifacts` when present):

- `architecture.md`, `evidence-ledger.md`, `phase-a-thresholds.md`, `research.md`, `evaluation.md`

Parsing is tolerant — no front matter required. Fields omitted when not
computable from source files.

---

## What it generates

### `site/data/missions.json`

One object per mission folder with: `id`, `title`, `status`,
`status_category`, `path`, `summary`, `approval_question`,
`what_ai_dos_learned`, `executed_by`, `confidence`, `next_mission`,
`artifacts`.

Mission 006 is categorized `paused` (Phase B operator validation).
Mission 007 shows `approved` via status text. No fabricated fields.

### `site/data/organization.json`

Includes: `current_mission`, `next_mission`, `completed_mission_count`,
`paused_missions`, `active_strategy`, `canonical_branch`,
`governance_model`, `source_of_truth_statement`,
`mission_007_v2_architecture`, `strategic_pivot`,
`repository_compiler_concept`.

`completed_mission_count` is computed from missions with
`status_category: complete` (currently 6 — M001–M005, M007).

### Mission Control site

`site/index.html` fetches JSON and renders:

- Repository Compiler (PHP) concept
- Current state (no fabricated metrics)
- Mission timeline (all indexed missions)
- Paused missions (Mission 006)
- Strategic pivot (AI-DOS as primary product)
- Mission 007 V2 architecture approval status
- Governance flow
- Next mission (from Backlog.md)

---

## Repository-as-source-of-truth

1. **Canonical:** everything under `missions/`, `company/`, `tasks/`.
2. **Generated:** everything under `site/data/` and compiler-written
   `site/index.html`.
3. **Standards §4.1** codifies: generated views must not invent facts;
   source wins on conflict; outputs may be rebuilt anytime.
4. The old hand-maintained showcase metrics (e.g. "17 candidates scanned")
   are **removed** from the site — they were not computable from mission
   index files without reading research.md in full (future compiler pass).

---

## How to run

```bash
php compiler/compile.php
```

Requires PHP 8.1+. Outputs written to `site/data/`, `site/index.html`,
and `site/styles.css`.

---

## GitHub Action

`.github/workflows/compile-site.yml` runs on push/PR to `main`:

1. Checkout
2. Setup PHP 8.2
3. Run `php compiler/compile.php`
4. Verify JSON files exist and parse

**Limitation documented:** auto-commit of compiler output on every merge
is deferred. Mission work commits regenerated `site/` when organizational
state changes. The Action verifies the compiler succeeds — it does not
deploy or push commits.

---

## Limitations

- No `system/manifest.yaml` registry yet (Mission 009).
- Summaries use first paragraph heuristics — some early missions have thin summaries.
- Mission 001 predates "What AI-DOS Learned" template — field is null.
- Site requires HTTP server or GitHub Pages for JSON fetch (local `file://` will not load data).
- Styles.css appends Mission Control rules once; full CSS rewrite deferred.
- Decision timeline, knowledge graph, and agent context packages are V2 targets (Mission 010+).

---

## Decisions made

1. **Client-side JSON fetch** over embedded data — keeps `index.html` shell stable and data inspectable.
2. **Mission 006 = paused category** when mission.md reports Phase B — matches operator-blocked state without editing Mission 006 files.
3. **Dropped fabricated showcase metrics** — Principles §5 and mission constraints require traceable data only.
4. **CI verifies compile; does not auto-commit** — simpler than bot push; documented in workflow comments.

---

## Risks / weaknesses discovered

- UTF-8 sanitization required for some mission artifacts (em dashes, special chars).
- Backlog em-dash encoding must use Unicode-aware regex.
- Manual edits to generated `site/` files will be overwritten on compile.

---

## Cold-start verification

| Question | Answer location |
|---|---|
| How do I run the compiler? | [compiler/README.md](../../compiler/README.md) |
| What are compiler truth rules? | [company/Standards.md](../../company/Standards.md) §4 |
| What missions exist? | [site/data/missions.json](../../site/data/missions.json) |
| What is organizational state? | [site/data/organization.json](../../site/data/organization.json) |
| What is next mission? | [tasks/Backlog.md](../../tasks/Backlog.md) §Next |

---

## What AI-DOS Learned

This mission changed AI-DOS itself in the following ways:

- **First Repository Compiler (PHP) is operational** — organizational
  source code compiles into Mission Control.
- **Showcase is no longer hand-maintained** — Standards §3 notes compiler
  ownership; generated views replace manual HTML edits.
- **Compile-on-merge CI exists** — GitHub Actions verifies compiler on
  every push to `main` (Standards §4.2).
- **Paused mission state is machine-readable** — Mission 006 Phase B
  appears in `organization.json` without modifying Mission 006 artifacts.
- **Fabricated metrics removed from public site** — compiler only emits
  fields traceable to repository files.

---

Approve Mission 009: V2 Foundation & Sequencing Reconciliation? Y/N
