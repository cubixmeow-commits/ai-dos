# AI-DOS File Index

**Deployment root:** https://cubixmeow.com/ai-dos/

One place to answer: what exists, where it lives, what it does, whether it is safe to edit, and what public URL maps to it.

Machine-readable source: [file-index.yaml](file-index.yaml)

---

## Quick lookup — public URLs

| What | Path | Public URL |
|------|------|------------|
| Mission Control | `site/index.html` | https://cubixmeow.com/ai-dos/site/ |
| Missions data | `site/data/missions.json` | https://cubixmeow.com/ai-dos/site/data/missions.json |
| Organization state | `site/data/organization.json` | https://cubixmeow.com/ai-dos/site/data/organization.json |
| Styles | `site/styles.css` | https://cubixmeow.com/ai-dos/site/styles.css |
| Validation smoke test | `site/validation/invoice-tool.html` | https://cubixmeow.com/ai-dos/site/validation/invoice-tool.html |
| Compiler (if PHP enabled) | `compiler/compile.php` | https://cubixmeow.com/ai-dos/compiler/compile.php |

Repository-only files have no public URL.

---

## Root & company

### README.md
- **Type:** readme · **Status:** active
- **Purpose:** Cold-start entry point for strangers and agents.
- **Source / generated:** source · **Safe to edit:** yes
- **Mission:** 001 · **Last update:** 001
- **Notes:** §4 mission list may lag Backlog.

### company/Identity.md
- **Type:** company · **Status:** active
- **Purpose:** What AI-DOS is and why it exists.
- **Source / generated:** source · **Safe to edit:** yes
- **Mission:** 001

### company/Principles.md
- **Type:** company · **Status:** active
- **Purpose:** Constitutional rules for every agent.
- **Source / generated:** source · **Safe to edit:** yes
- **Mission:** 001 · **Last update:** 002

### company/Standards.md
- **Type:** company · **Status:** active
- **Purpose:** Operational standards (commits, governance, compiler, file index).
- **Source / generated:** source · **Safe to edit:** yes
- **Mission:** 002 · **Last update:** 009

---

## Tasks & templates

### tasks/Backlog.md
- **Type:** tasks · **Status:** active
- **Purpose:** Ordered mission queue; top item is next after approval.
- **Source / generated:** source · **Safe to edit:** yes
- **Mission:** 001 · **Last update:** 009

### workflow/Templates/MissionTemplate.md
- **Type:** template · **Status:** active
- **Purpose:** Copy template for new missions.
- **Source / generated:** source · **Safe to edit:** yes
- **Mission:** 001

---

## System registry

### system/file-index.yaml
- **Type:** system · **Status:** active
- **Purpose:** Canonical machine-readable file map (source of truth for this index).
- **Source / generated:** source · **Safe to edit:** yes
- **Mission:** 009

### system/file-index.md
- **Type:** system · **Status:** active
- **Purpose:** This file — human-readable index for mobile.
- **Source / generated:** source · **Safe to edit:** yes
- **Mission:** 009

---

## Compiler

### compiler/compile.php
- **Type:** compiler · **Status:** active
- **Purpose:** PHP Repository Compiler entry point.
- **Source / generated:** source · **Safe to edit:** yes
- **Public URL:** https://cubixmeow.com/ai-dos/compiler/compile.php
- **Mission:** 008 · **Last update:** 009
- **Notes:** Public URL assumes PHP on host.

### compiler/README.md
- **Type:** compiler · **Status:** active
- **Purpose:** How to run the compiler locally.
- **Source / generated:** source · **Safe to edit:** yes
- **Mission:** 008

---

## Site (generated — do not hand-edit)

### site/index.html
- **Type:** site · **Status:** active
- **Purpose:** Mission Control UI.
- **Source / generated:** generated · **Safe to edit:** no
- **Public URL:** https://cubixmeow.com/ai-dos/site/
- **Mission:** 005 · **Last update:** 008

### site/styles.css
- **Type:** site · **Status:** active
- **Purpose:** Showcase styles.
- **Source / generated:** generated · **Safe to edit:** no
- **Public URL:** https://cubixmeow.com/ai-dos/site/styles.css
- **Mission:** 005 · **Last update:** 008

### site/data/missions.json
- **Type:** site-data · **Status:** active
- **Purpose:** Compiled mission registry.
- **Source / generated:** generated · **Safe to edit:** no
- **Public URL:** https://cubixmeow.com/ai-dos/site/data/missions.json
- **Mission:** 008

### site/data/organization.json
- **Type:** site-data · **Status:** active
- **Purpose:** Compiled organization state (+ file index summary).
- **Source / generated:** generated · **Safe to edit:** no
- **Public URL:** https://cubixmeow.com/ai-dos/site/data/organization.json
- **Mission:** 008 · **Last update:** 009

### site/validation/invoice-tool.html
- **Type:** validation · **Status:** active
- **Purpose:** Mission 006 smoke test — not a product page.
- **Source / generated:** source · **Safe to edit:** yes
- **Public URL:** https://cubixmeow.com/ai-dos/site/validation/invoice-tool.html
- **Mission:** 006
- **Notes:** Do not link from showcase; configure form before launch.

---

## GitHub workflow

### .github/workflows/compile-site.yml
- **Type:** workflow · **Status:** active
- **Purpose:** CI compile verification on push/PR to main.
- **Source / generated:** source · **Safe to edit:** yes
- **Mission:** 008

---

## Missions

| ID | Folder | Status | Purpose |
|----|--------|--------|---------|
| 001 | `missions/001-bootstrap/` | complete | Bootstrap repository structure |
| 002 | `missions/002-knowledge-preservation/` | complete | Knowledge Preservation standard |
| 003 | `missions/003-prove-the-loop/` | complete | First research cycle; invoice tool rec |
| 004 | `missions/004-close-governance-loop/` | complete | Merge-to-main approval |
| 005 | `missions/005-showcase-page/` | complete | Static showcase (now compiler-owned) |
| 006 | `missions/006-validate-recommendation/` | paused | Validate recommendation — Phase B |
| 007 | `missions/007-design-v2/` | complete | V2 architecture design |
| 008 | `missions/008-repository-compiler/` | complete | PHP Repository Compiler |
| 009 | `missions/009-file-index-foundation/` | complete | Master file index |

Each mission folder contains `mission.md` (brief) and `report.md` (outcome) unless noted.

### Notable mission artifacts

| Path | Purpose |
|------|---------|
| `missions/003-prove-the-loop/research.md` | Research with evidence tiers |
| `missions/003-prove-the-loop/evaluation.md` | Evaluation criteria |
| `missions/006-validate-recommendation/phase-a-thresholds.md` | Locked validation thresholds |
| `missions/006-validate-recommendation/evidence-ledger.md` | External claims ledger |
| `missions/007-design-v2/architecture.md` | Approved V2 architecture blueprint |

---

## How to use

1. **Find a file** — search this page or `file-index.yaml` by path or type.
2. **Check before editing** — `safe_to_edit: false` means regenerate via `php compiler/compile.php`.
3. **Open on phone** — use Public URL column for web-accessible files.
4. **After major changes** — update `file-index.yaml` and this file before mission completion (Standards §5).

---

*Maintained by Mission 009. Last updated 2026-07-07.*
