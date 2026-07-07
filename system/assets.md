# AI-DOS Asset Registry

**Deployment root:** https://cubixmeow.com/ai-dos/

Canonical machine-readable source: [assets.yaml](assets.yaml)

The Asset Registry is AI-DOS's canonical understanding of everything it owns.
A **file** is one asset type among many. Full lookup: `site/data/repository.json`.

---

## Quick answers

| Question | Where to look |
|----------|---------------|
| Where is this implemented? | `source.path` in [assets.yaml](assets.yaml) or tables below |
| What URL opens it? | [Public URLs](#public-urls) |
| What generated this? | `depends_on` / parent `outputs` in assets.yaml |
| Is it safe to edit? | `editable: true` — generated assets are `editable: false` |
| What depends on it? | `outputs` field lists downstream asset IDs |

---

## Public URLs

| Asset | Path | URL |
|-------|------|-----|
| compile.php | `compiler/compile.php` | https://cubixmeow.com/ai-dos/compiler/compile.php |
| index.html | `site/index.html` | https://cubixmeow.com/ai-dos/site/ |
| styles.css | `site/styles.css` | https://cubixmeow.com/ai-dos/site/styles.css |
| missions.json | `site/data/missions.json` | https://cubixmeow.com/ai-dos/site/data/missions.json |
| organization.json | `site/data/organization.json` | https://cubixmeow.com/ai-dos/site/data/organization.json |
| invoice-tool.html | `site/validation/invoice-tool.html` | https://cubixmeow.com/ai-dos/site/validation/invoice-tool.html |

---

## Key relationships

| Producer | Outputs |
|----------|---------|
| `compiler-compile-php` | `site-data-organization-json`, `site-data-missions-json`, `site-index-html`, `site-styles-css` |
| `asset-registry` | `file-index-legacy-shim`, `file-index-md-legacy`, `asset-registry-md` |

---

## Assets by type

### compiler

#### `compiler-compile-php` — compile.php
- **Path:** `compiler/compile.php` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** Runs the PHP Repository Compiler; scans repository and emits site artifacts.
- **Depends on:** `asset-registry`, `company-standards-md`, `company-identity-md`, `tasks-backlog-md`
- **Outputs:** `site-data-organization-json`, `site-data-missions-json`, `site-index-html`, `site-styles-css`
- **Notes:** Public URL assumes PHP execution on host; may 403 if not configured.

### directory

#### `missions-001-bootstrap` — Mission folder: missions/001-bootstrap
- **Path:** `missions/001-bootstrap/` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Bootstrap repository structure and first mission loop.
- **Outputs:** `missions-001-bootstrap-report-md`
- **Notes:** Historical brief references pre-renumbering Mission 002/003.

#### `missions-002-knowledge-preservation` — Mission folder: missions/002-knowledge-preservation
- **Path:** `missions/002-knowledge-preservation/` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Formalize Knowledge Preservation commit standard.
- **Outputs:** `missions-002-knowledge-preservation-report-md`

#### `missions-003-prove-the-loop` — Mission folder: missions/003-prove-the-loop
- **Path:** `missions/003-prove-the-loop/` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** First full research cycle; recommended invoice follow-up tool.
- **Outputs:** `missions-003-prove-the-loop-report-md`

#### `missions-004-close-governance-loop` — Mission folder: missions/004-close-governance-loop
- **Path:** `missions/004-close-governance-loop/` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Formalize merge-to-main as durable mission approval.
- **Outputs:** `missions-004-close-governance-loop-report-md`

#### `missions-005-showcase-page` — Mission folder: missions/005-showcase-page
- **Path:** `missions/005-showcase-page/` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Build static visual reader at site/index.html.
- **Outputs:** `missions-005-showcase-page-report-md`
- **Notes:** Showcase now compiler-generated per Mission 008.

#### `missions-006-validate-recommendation` — Mission folder: missions/006-validate-recommendation
- **Path:** `missions/006-validate-recommendation/` · **Status:** paused · **Editable:** yes · **source**
- **Purpose:** Validate Mission 003 invoice tool recommendation with real evidence.
- **Notes:** Paused at Phase B — operator interviews and smoke test.

#### `missions-007-design-v2` — Mission folder: missions/007-design-v2
- **Path:** `missions/007-design-v2/` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Design AI-DOS V2 architecture and implementation sequencing.
- **Outputs:** `missions-007-design-v2-report-md`
- **Notes:** V2 architecture approved; implementation spans M008+.

#### `missions-008-repository-compiler` — Mission folder: missions/008-repository-compiler
- **Path:** `missions/008-repository-compiler/` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Build first PHP Repository Compiler and Mission Control site.
- **Outputs:** `missions-008-repository-compiler-report-md`

#### `missions-009-file-index-foundation` — Mission folder: missions/009-file-index-foundation
- **Path:** `missions/009-file-index-foundation/` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Create canonical master file index for operator mobile lookup.
- **Outputs:** `missions-009-file-index-foundation-report-md`

### file

#### `readme-md` — README.md
- **Path:** `README.md` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** Cold-start entry point for strangers and agents cloning the repository.
- **Notes:** Mission numbering in §4 may lag Backlog; Backlog is authoritative for queue.

#### `company-identity-md` — Identity.md
- **Path:** `company/Identity.md` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** Defines what AI-DOS is and why it exists.
- **Notes:** Compiler reads §1 for active_strategy text.

#### `company-principles-md` — Principles.md
- **Path:** `company/Principles.md` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** Constitutional rules every agent follows before work.
- **Notes:** Changes rarely; operational detail belongs in Standards.

#### `company-standards-md` — Standards.md
- **Path:** `company/Standards.md` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** Operational standards that evolve as AI-DOS learns.
- **Notes:** File Index section added in Mission 009.

#### `compiler-readme-md` — README.md
- **Path:** `compiler/README.md` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** Documents compiler inputs, outputs, and how to run locally.

#### `missions-001-bootstrap-mission-md` — mission.md
- **Path:** `missions/001-bootstrap/mission.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 001 brief — smallest useful repository structure.

#### `missions-001-bootstrap-report-md` — report.md
- **Path:** `missions/001-bootstrap/report.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 001 outcome and cold-start proof.
- **Depends on:** `missions-001-bootstrap`
- **Notes:** Predates What AI-DOS Learned template.

#### `missions-002-knowledge-preservation-mission-md` — mission.md
- **Path:** `missions/002-knowledge-preservation/mission.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 002 brief.

#### `missions-002-knowledge-preservation-report-md` — report.md
- **Path:** `missions/002-knowledge-preservation/report.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 002 outcome; Standards §1 commit format.
- **Depends on:** `missions-002-knowledge-preservation`

#### `missions-003-prove-the-loop-evaluation-md` — evaluation.md
- **Path:** `missions/003-prove-the-loop/evaluation.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Evaluation criteria and scoring for Mission 003 research.

#### `missions-003-prove-the-loop-mission-md` — mission.md
- **Path:** `missions/003-prove-the-loop/mission.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 003 brief — research and product recommendation.

#### `missions-003-prove-the-loop-report-md` — report.md
- **Path:** `missions/003-prove-the-loop/report.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 003 outcome and Medium-confidence recommendation.
- **Depends on:** `missions-003-prove-the-loop`

#### `missions-003-prove-the-loop-research-md` — research.md
- **Path:** `missions/003-prove-the-loop/research.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Research artifact with evidence tiers for Mission 003 claims.
- **Notes:** Listed in compiler mission artifacts when present.

#### `missions-004-close-governance-loop-mission-md` — mission.md
- **Path:** `missions/004-close-governance-loop/mission.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 004 brief.

#### `missions-004-close-governance-loop-report-md` — report.md
- **Path:** `missions/004-close-governance-loop/report.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 004 outcome; Standards §2 mission approval.
- **Depends on:** `missions-004-close-governance-loop`

#### `missions-005-showcase-page-mission-md` — mission.md
- **Path:** `missions/005-showcase-page/mission.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 005 brief.

#### `missions-005-showcase-page-report-md` — report.md
- **Path:** `missions/005-showcase-page/report.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 005 outcome; Standards §3 showcase maintenance.
- **Depends on:** `missions-005-showcase-page`

#### `missions-006-validate-recommendation-evidence-ledger-md` — evidence-ledger.md
- **Path:** `missions/006-validate-recommendation/evidence-ledger.md` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** Consolidated external claims with evidence tiers for Mission 006.
- **Notes:** Phase C scoring uses this ledger.

#### `missions-006-validate-recommendation-mission-md` — mission.md
- **Path:** `missions/006-validate-recommendation/mission.md` · **Status:** paused · **Editable:** yes · **source**
- **Purpose:** Mission 006 brief and phase definitions.
- **Notes:** Do not modify per Mission 008 constraint unless Phase C resumes.

#### `missions-006-validate-recommendation-phase-a-thresholds-md` — phase-a-thresholds.md
- **Path:** `missions/006-validate-recommendation/phase-a-thresholds.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Pre-registered pass/fail thresholds for validation phases.
- **Notes:** Thresholds locked by operator 2026-07-07.

#### `missions-007-design-v2-architecture-md` — architecture.md
- **Path:** `missions/007-design-v2/architecture.md` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** Approved blueprint for AI-DOS V2 capabilities and compiler model.
- **Notes:** Describes system/ registry layer planned for post-M009 missions.

#### `missions-007-design-v2-mission-md` — mission.md
- **Path:** `missions/007-design-v2/mission.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 007 brief — principal architect mission.

#### `missions-007-design-v2-report-md` — report.md
- **Path:** `missions/007-design-v2/report.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 007 outcome and approved V2 sequencing.
- **Depends on:** `missions-007-design-v2`

#### `missions-008-repository-compiler-mission-md` — mission.md
- **Path:** `missions/008-repository-compiler/mission.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 008 brief.

#### `missions-008-repository-compiler-report-md` — report.md
- **Path:** `missions/008-repository-compiler/report.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 008 outcome; compiler truth rules and limitations.
- **Depends on:** `missions-008-repository-compiler`

#### `missions-009-file-index-foundation-mission-md` — mission.md
- **Path:** `missions/009-file-index-foundation/mission.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 009 brief.

#### `missions-009-file-index-foundation-report-md` — report.md
- **Path:** `missions/009-file-index-foundation/report.md` · **Status:** complete · **Editable:** yes · **source**
- **Purpose:** Mission 009 outcome and usage guide.
- **Depends on:** `missions-009-file-index-foundation`

#### `asset-registry-md` — assets.md
- **Path:** `system/assets.md` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** Human-readable Asset Registry companion for mobile operator use.
- **Depends on:** `asset-registry`
- **Notes:** Keep in sync with assets.yaml.

#### `asset-registry` — assets.yaml
- **Path:** `system/assets.yaml` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** Canonical AI-DOS Asset Registry — machine-readable map of everything AI-DOS owns.
- **Outputs:** `file-index-legacy-shim`, `file-index-md-legacy`, `asset-registry-md`
- **Notes:** Evolved from file-index.yaml in Mission 009 follow-up. A file is one asset type among many.

#### `file-index-md-legacy` — file-index.md (legacy companion)
- **Path:** `system/file-index.md` · **Status:** deprecated · **Editable:** yes · **source**
- **Purpose:** Redirects readers to system/assets.md.
- **Depends on:** `asset-registry-md`
- **Notes:** Generated from same data as YAML; keep in sync.

#### `file-index-legacy-shim` — file-index.yaml (legacy shim)
- **Path:** `system/file-index.yaml` · **Status:** deprecated · **Editable:** yes · **source**
- **Purpose:** Backward-compatibility pointer to the canonical asset registry.
- **Depends on:** `asset-registry`
- **Notes:** Canonical registry is system/assets.yaml.

#### `tasks-backlog-md` — Backlog.md
- **Path:** `tasks/Backlog.md` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** Ordered queue of upcoming missions; top item is next after operator approval.
- **Notes:** Compiler extracts next mission from

### generated-file

#### `site-data-missions-json` — missions.json
- **Path:** `site/data/missions.json` · **Status:** active · **Editable:** **no** · **generated**
- **Purpose:** Structured mission data compiled from missions/*/mission.md and report.md.
- **Depends on:** `compiler-compile-php`
- **Notes:** Source wins on conflict; regenerate via compile.php.

#### `site-data-organization-json` — organization.json
- **Path:** `site/data/organization.json` · **Status:** active · **Editable:** **no** · **generated**
- **Purpose:** Organization state compiled from company docs, Backlog, missions, and file index.
- **Depends on:** `compiler-compile-php`, `asset-registry`
- **Notes:** Includes file_index summary when system/file-index.yaml exists.

#### `site-styles-css` — styles.css
- **Path:** `site/styles.css` · **Status:** active · **Editable:** **no** · **generated**
- **Purpose:** Visual styles for Mission Control; preserves Mission 005 identity.
- **Notes:** Compiler appends Mission Control rules once; do not hand-edit.

### github-action

#### `github-workflows-compile-site-yml` — compile-site.yml
- **Path:** `.github/workflows/compile-site.yml` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** CI job that runs Repository Compiler on push/PR to main.
- **Depends on:** `compiler-compile-php`
- **Notes:** Verifies compile success; does not auto-commit or deploy.

### template

#### `workflow-templates-missiontemplate-md` — MissionTemplate.md
- **Path:** `workflow/Templates/MissionTemplate.md` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** Copy template for new mission.md and report.md files.

### website

#### `site-index-html` — index.html
- **Path:** `site/index.html` · **Status:** active · **Editable:** **no** · **generated**
- **Purpose:** Mission Control showcase UI; loads compiled JSON client-side.
- **Depends on:** `site-data-organization-json`, `site-data-missions-json`, `site-styles-css`
- **Notes:** Regenerated by compiler; manual edits overwritten.

#### `site-validation-invoice-tool-html` — invoice-tool.html
- **Path:** `site/validation/invoice-tool.html` · **Status:** active · **Editable:** yes · **source**
- **Purpose:** Mission 006 Phase B landing-page smoke test for invoice follow-up validation.
- **Notes:** Do not link from main showcase; operator must configure form endpoint before launch.

---

*Maintained by Mission 009. Schema v2. Last updated 2026-07-07.*
