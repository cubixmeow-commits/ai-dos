# Repository Compiler (PHP)

The Repository Compiler reads AI-DOS organizational source code from the
repository and generates disposable Mission Control artifacts.

## What it reads

Required:

- `/missions/*/mission.md`
- `/missions/*/report.md` (when present)
- `/company/Principles.md`
- `/company/Standards.md`
- `/tasks/Backlog.md`

Optional (included in mission artifact lists when present):

- `/missions/*/architecture.md`
- `/missions/*/evidence-ledger.md`
- `/missions/*/phase-a-thresholds.md`

## What it generates

```text
site/data/missions.json
site/data/organization.json
site/data/manifest.json
site/data/context-packages.json
site/data/dependency-report.json
site/data/repository.json
site/data/decisions.json
site/index.html
site/styles.css
```

Modules: `RepositoryIntelligence.php`, `DecisionRecords.php`.

Requires PHP 8.1+ with `yaml` extension for manifest and context package parsing.

None of these outputs are canonical. Repository artifacts are canonical.

## Run locally

From the repository root:

```bash
php compiler/compile.php
```

Requires PHP 8.1+ (uses `str_contains`, `str_starts_with`).

## GitHub Actions

On push to `main`, `.github/workflows/compile-site.yml` runs the compiler
and verifies it exits successfully. See that workflow for deployment
notes.

## Deployment

- **Command Center (public):** `https://cubixmeow.com/ai-dos/site/`
- **Compiler (build):** `https://cubixmeow.com/ai-dos/compiler/compile.php`

See [company/Standards.md](../company/Standards.md) §7 Deployment.

## Truth rules

See [company/Standards.md](../company/Standards.md) §4 Repository Compiler.
