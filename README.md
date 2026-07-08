# AI-DOS

AI-DOS is an experiment in running software development as a Git-native
operating system for AI agents. There is no application here — **the
repository itself is the product.** AI coding agents do the work in discrete,
documented "missions," and everything an organization normally keeps in
people's heads or chat logs — goals, rules, decisions, history, next steps —
is committed as versioned files instead. The test of success is simple: a
complete stranger (human or AI) can clone this repository cold and continue
the work, and a human operator can steer the whole thing from a phone by
reviewing one approval question per mission.

## §1 What is this?

The full identity and rationale live in
[company/Identity.md](company/Identity.md). The rules every agent follows
live in [company/Principles.md](company/Principles.md).

## §2 How it operates

1. A **mission** is defined in `/missions/<number>-<name>/mission.md` — the
   brief an agent executes against.
2. An AI agent executes the mission, committing small, purposeful commits
   that follow the commit standard in
   [company/Standards.md](company/Standards.md). Git history is part of the
   record.
3. The agent writes `report.md` in the same folder: what was created, what
   was decided, what was rejected, risks found, and a recommended next
   mission — readable in under five minutes on a phone.
4. The report ends with a single **approval question**. Approval becomes
   official only when the operator merges the mission work into `main`.
   Chat approval is advisory and temporary.
5. Upcoming work waits in [tasks/Backlog.md](tasks/Backlog.md).

`main` is the canonical source of truth for approved organizational state.

Every mission must pass the **cold-start test**: its report must prove, by
citing specific files, that a fresh session could pick up from here.

## §3 Where things are

| Path | Purpose |
|---|---|
| `company/` | Identity, Principles, and Standards — who we are, how we work |
| `missions/` | One folder per mission: brief + report |
| `decisions/` | Durable architectural decision records |
| `system/` | Asset Registry, manifest, context packages, execution engine, plans |
| `compiler/` | Repository Compiler (PHP) — generates `site/` |
| `site/` | Mission Control — public entry point (`/site/`) |
| `tasks/Backlog.md` | The queue of upcoming missions |
| `workflow/Templates/` | Templates for recurring artifacts (missions) |
| `products/` | Portfolio projects (external product code) |

**Canonical URLs:** Command Center `https://cubixmeow.com/ai-dos/site/` ·
Compiler `https://cubixmeow.com/ai-dos/compiler/compile.php` (build tool only).

## §4 Current state

Missions **001–005** established governance, showcase, and merge-based approval.
**Mission 006** (portfolio validation) is **paused** at Phase B.
**Missions 007–011** built AI-DOS V2 foundations:

- **Mission 007** — V2 architecture approved. See
  [missions/007-design-v2/report.md](missions/007-design-v2/report.md).
- **Mission 008** — Repository Compiler (PHP). See
  [missions/008-repository-compiler/report.md](missions/008-repository-compiler/report.md).
- **Mission 009** — Asset Registry (`system/assets.yaml`). See
  [missions/009-file-index-foundation/report.md](missions/009-file-index-foundation/report.md).
- **Mission 010** — Repository Intelligence Layer. See
  [missions/010-repository-intelligence/report.md](missions/010-repository-intelligence/report.md).
- **Mission 011** — Architecture audit integration; decision records;
  Execution Engine foundation (documented, not implemented). See
  [missions/011-architecture-integration/report.md](missions/011-architecture-integration/report.md).
- **Mission 012** — Minimal Execution Engine (plans, roles, context routing). See
  [missions/012-execution-engine-foundation/report.md](missions/012-execution-engine-foundation/report.md).
- **Mission 013** — Billable Rate Calculator (P001). See
  [missions/013-first-external-product/report.md](missions/013-first-external-product/report.md).
- **Mission 014** — Invoice Chase (P002), built autonomously by AI-DOS. See
  [missions/014-ai-dos-independent-product-test/report.md](missions/014-ai-dos-independent-product-test/report.md).
- **Mission 015** — Payment Terms Studio (P003), selected from organizational memory before code. See
  [missions/015-organizational-product-strategy/report.md](missions/015-organizational-product-strategy/report.md).
- **Mission 016** — Portfolio Intelligence; strategic direction: **Get Paid Toolkit** suite. See
  [missions/016-portfolio-intelligence/report.md](missions/016-portfolio-intelligence/report.md).

**Next:** Mission 017 — Execute the Strategic Product Roadmap. See [tasks/Backlog.md](tasks/Backlog.md).

**Portfolio:** [products/001-billable-rate-calculator/](products/001-billable-rate-calculator/) · [products/002-invoice-chase/](products/002-invoice-chase/)

**Mission Control:** [site/index.html](site/index.html) — compile with
`php compiler/compile.php` after source changes.
