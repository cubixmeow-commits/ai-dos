# AI-DOS

AI-DOS is an experiment in running software development as a Git-native
operating system for AI agents. There is no application here — **the
repository itself is the product.** AI coding agents do the work in discrete,
documented "missions," and everything an organization normally keeps in
people's heads or chat logs — goals, rules, decisions, history, next steps —
is committed as versioned files instead. The test of success is simple: a
complete stranger (human or AI) can clone this repository cold and continue
the work, and a human operator can steer the whole thing from a phone by
answering one approval question per mission.

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
4. The report ends with a single **Y/N approval question**. The human
   operator answers it; that answer starts the next mission.
5. Upcoming work waits in [tasks/Backlog.md](tasks/Backlog.md).

Every mission must pass the **cold-start test**: its report must prove, by
citing specific files, that a fresh session could pick up from here.

## §3 Where things are

| Path | Purpose |
|---|---|
| `company/` | Identity, Principles, and Standards — who we are, how we work |
| `missions/` | One folder per mission: brief + report |
| `tasks/Backlog.md` | The queue of upcoming missions |
| `workflow/Templates/` | Templates for recurring artifacts (missions) |

## §4 Current state

- **Mission 001 (Bootstrap)** — complete. See
  [missions/001-bootstrap/report.md](missions/001-bootstrap/report.md).
- **Mission 002 (Formalize the Knowledge Preservation Standard)** —
  complete. See
  [missions/002-knowledge-preservation/report.md](missions/002-knowledge-preservation/report.md).
- **Mission 003 (Prove the Loop)** — next up, pending operator approval.
  See [tasks/Backlog.md](tasks/Backlog.md).
