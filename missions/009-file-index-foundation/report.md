# Mission 009 Report: File Index Foundation

**Status:** Complete
**Executed by:** Composer (Cursor Cloud Agent)

## Executive summary

Mission 009 creates AI-DOS's permanent **master file index** — a single
canonical registry so the operator can find any important file and its public
URL from a phone. `system/file-index.yaml` is the machine-readable source;
`system/file-index.md` is the human-readable companion. The Repository Compiler
now includes a `file_index` summary in `organization.json`.

---

## What was indexed

| Category | Paths indexed |
|---|---|
| Root & company | `README.md`, `company/Identity.md`, `company/Principles.md`, `company/Standards.md` |
| Tasks & templates | `tasks/Backlog.md`, `workflow/Templates/MissionTemplate.md` |
| System registry | `system/file-index.yaml`, `system/file-index.md` |
| Compiler | `compiler/compile.php`, `compiler/README.md` |
| Site (generated) | `site/index.html`, `site/styles.css`, `site/data/missions.json`, `site/data/organization.json` |
| Validation | `site/validation/invoice-tool.html` |
| Workflow | `.github/workflows/compile-site.yml` |
| Missions 001–009 | Each mission folder plus `mission.md`, `report.md`, and notable artifacts |
| Architecture | `missions/007-design-v2/architecture.md` |

**Total entries in file-index.yaml:** 47 (including Mission 009 artifacts).

---

## How to use the file index

1. **On iPhone / quick lookup** — open [system/file-index.md](../../system/file-index.md).
   The "Quick lookup — public URLs" table lists every web-accessible path.
2. **For agents and tooling** — read [system/file-index.yaml](../../system/file-index.yaml).
   Each entry has `path`, `type`, `status`, `purpose`, `source_or_generated`,
   `safe_to_edit`, `public_url`, and mission provenance fields.
3. **Before editing** — check `safe_to_edit`. Generated site files must be
   changed via `php compiler/compile.php`, not by hand.
4. **After major file changes** — update both YAML and MD before mission
   completion (Standards §5).
5. **Via Mission Control** — `organization.json` includes a `file_index` object
   with deployment root, entry count, and per-entry summary fields.

---

## Public URLs mapped

Deployment root: **https://cubixmeow.com/ai-dos/**

| Path | Public URL |
|---|---|
| `site/index.html` | https://cubixmeow.com/ai-dos/site/ |
| `site/styles.css` | https://cubixmeow.com/ai-dos/site/styles.css |
| `site/data/missions.json` | https://cubixmeow.com/ai-dos/site/data/missions.json |
| `site/data/organization.json` | https://cubixmeow.com/ai-dos/site/data/organization.json |
| `site/validation/invoice-tool.html` | https://cubixmeow.com/ai-dos/site/validation/invoice-tool.html |
| `compiler/compile.php` | https://cubixmeow.com/ai-dos/compiler/compile.php |

All repository-only artifacts (missions, company docs, Backlog, system index)
have `public_url: null`.

---

## Compiler integration

The Repository Compiler (`compiler/compile.php`) now reads
`system/file-index.yaml` and adds a `file_index` block to
`site/data/organization.json`:

- `deployment_root`, `version`, `last_updated`, `entry_count`
- `entries[]` with `path`, `type`, `status`, `public_url`, `safe_to_edit`,
  `source_or_generated`

**Parser approach:** uses PHP `yaml_parse()` when the extension is available;
otherwise a minimal subset parser for AI-DOS's flat entry list (no nested YAML).

**Limitation:** the subset parser does not support arbitrary YAML features.
Full fidelity always comes from `file-index.yaml` directly.

---

## Standards update

Added **§5 File Index** to [company/Standards.md](../../company/Standards.md):
canonical YAML source, MD companion, maintenance obligation per mission, and
compiler summary note.

---

## Backlog change

Mission 009 (File Index Foundation) supersedes the prior Backlog entry for
"V2 Foundation & Sequencing Reconciliation" as Mission 009. V2 registry work
(`manifest.yaml`, `index.yaml`, `portfolio.yaml`) moves to **Mission 010**.

---

## What AI-DOS Learned

This mission changed AI-DOS itself in the following ways:

- **Permanent file registry exists** — `system/file-index.yaml` answers
  "what exists, where, and is it safe to edit?" without grepping the repo.
- **Mobile operator path** — `file-index.md` is structured for iPhone review
  with a public-URL quick table at the top.
- **Compiler exposes file index** — Mission Control JSON now carries file
  index metadata for programmatic lookup.
- **Maintenance is standardized** — Standards §5 requires index updates when
  major files are created, removed, or materially changed.
- **V2 registry sequencing clarified** — file index is the first `system/`
  artifact; manifest/index/portfolio registries remain Mission 010 scope.

---

## Addendum: Asset Registry upgrade (Mission 009 follow-up)

*Same mission, no new mission number. The file index evolved into the Asset
Registry per AI-DOS subsystem improvement practice.*

### What changed

| Before (v1) | After (v2) |
|---|---|
| `file-index.yaml` indexed files only | `assets.yaml` registers all asset types |
| Flat `path` / `type` fields | Full schema: `id`, `source.path`, `public.url`, `depends_on`, `outputs`, etc. |
| No relationships | Key pipelines linked (compiler → JSON → Mission Control) |
| `file_index` in organization.json | `asset_registry` canonical + derived `file_index` for compat |

### New canonical files

- [system/assets.yaml](../../system/assets.yaml) — 49 assets, schema v2
- [system/assets.md](../../system/assets.md) — human-readable registry

### Asset types supported

`file`, `directory`, `compiler`, `generated-file`, `website`, `workflow`,
`github-action`, `template`, `prompt`, `mission`, `api`, `service` — extensible
without schema redesign.

### Key relationships documented

| Asset ID | Depends on | Outputs |
|---|---|---|
| `compiler-compile-php` | `asset-registry`, company docs, Backlog | `organization.json`, `missions.json`, Mission Control, styles |
| `site-data-organization-json` | `compiler-compile-php`, `asset-registry` | — |
| `site-index-html` | organization + missions JSON, styles | — |
| Mission folders | — | corresponding `report.md` assets |

### Compiler update

`organization.json` now includes:

- **`asset_registry`** — summarized assets with relationships (canonical source: `assets.yaml`)
- **`file_index`** — derived v1-compat view (not a second source of truth)

### How to use the Asset Registry

Answer these from [assets.md](../../system/assets.md) or [assets.yaml](../../system/assets.yaml):

1. **Where is this implemented?** → `source.path`
2. **What URL opens it?** → `public.url` or Public URLs table in assets.md
3. **What generated this?** → parent asset's `outputs` or child's `depends_on`
4. **Is it safe to edit?** → `editable` (false for generated assets)
5. **What depends on it?** → `outputs` lists downstream asset IDs

### What AI-DOS learned (addendum)

- **Subsystem evolution beats mission sprawl** — refining Mission 009 in place
  kept history cleaner than opening Mission 010 for a schema upgrade.
- **Files are assets, not the whole model** — compilers, workflows, websites,
  and missions are first-class registry entries.
- **Simple references suffice** — `depends_on` / `outputs` asset IDs replace
  the need for a graph database.
- **Backward compatibility is cheap** — legacy shims and derived JSON views
  let old tools keep working while the registry grows.

---

Approve Mission 010: V2 Foundation & Sequencing Reconciliation? Y/N
