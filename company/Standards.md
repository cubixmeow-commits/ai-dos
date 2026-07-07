# Standards

Operational standards for AI-DOS. The split with
[Principles.md](Principles.md): **Principles state what AI-DOS believes and
change rarely; Standards state how AI-DOS operates and evolve as the system
learns.** A new standard is added here when a mission formalizes one.

## §1 Knowledge Preservation

AI-DOS preserves organizational memory in multiple forms: **commits, mission
reports, decisions, and research.** Each form gets a formal standard here
when a mission demonstrates the need for one. Commits are the first
formalized standard (Mission 002, from a pattern observed during
Mission 001). Standards for the other forms are not missing — they have
simply not been formalized yet, and will be added to this section when
they are.

### §1.1 Commit standard

Every commit message follows:

```
<Mission ID>: <what changed>
Why: <why this change was made — the decision, not just the action>
Future benefit: <who or what this helps later, and how>
```

Example:

```
M014: create pricing model

Why: needed before Stripe integration; pricing assumptions had to be
explicit before payment logic could be written.
Future benefit: future agents can implement billing without re-deriving
pricing assumptions or asking the operator.
```

Commits remain small and purposeful — one logical unit each
(Principles §8).

### §1.2 Division of memory

**The mission report summarizes what changed at the mission level. The
commit log preserves the rationale at the change level.** Reports may
explain mission-level reasoning, but should reference commits for
change-level rationale rather than restating it — if the same change-level
reasoning appears in both places, the separation has broken down.

## §2 Mission Approval

Mission reports conclude with one approval question. Operator approval
becomes official only after the mission's work is merged into `main`.
The merge commit is the permanent organizational record of approval.
Chat approvals are advisory and temporary.

A mission is not complete until merged. AI-DOS preserves institutional
memory inside Git, not conversations.

Lifecycle:

```text
Mission proposed
        ↓
Mission executed
        ↓
Mission reviewed
        ↓
Operator approves
        ↓
Merged into main
        ↓
Repository becomes canonical
```

## §3 Showcase Maintenance

The showcase page (`/site/index.html`) is a visual reader, not the source of
truth. Mission files, reports, Standards, and Backlog remain canonical.

If a mission changes AI-DOS history, current status, next mission, standards,
or product direction, it updates the showcase before completion. The mission
report remains canonical; the showcase summarizes it for outside readers.
