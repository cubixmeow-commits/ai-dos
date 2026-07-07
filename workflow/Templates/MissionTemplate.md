# Mission Template

Copy this when opening a new mission folder
(`/missions/<number>-<name>/`). Every mission has two files: `mission.md`
(the brief) and `report.md` (the outcome). Commits follow
[company/Standards.md §1.1](../../company/Standards.md).

## mission.md

```markdown
# Mission <number>: <Title>

**Status:** <Planned | In progress | Complete — see report.md>
**Executed by:** <model name and version>

## Why this mission exists
<the problem or trigger, in the repo's own terms>

## Tasks
<numbered, concrete>

## Constraints
<what is explicitly out of scope>

## Exit criteria
<how a stranger verifies the mission is done>
```

**`Executed by:` is required.** It is in addition to Git's `Co-Authored-By`
trailer, not a replacement: it makes "which AI worked on which mission"
queryable directly from the mission file, without grepping commit history.

## report.md

```markdown
# Mission <number> Report: <Title>

**Status:** <Complete | Aborted — why>

## What was changed and why
<mission level — reference commits for change-level rationale,
per Standards.md §1.2>

## Decisions made
<including rejected alternatives>

## Risks / weaknesses discovered

## What AI-DOS Learned

This mission changed AI-DOS itself in the following ways:
<...>

---

Approve Mission <next-number>: <next title>? Y/N
```

**"What AI-DOS Learned" is required in every report.** It documents changes
to the operating system itself, not the products it builds. If a mission
genuinely changed nothing about AI-DOS itself, the section must say so
explicitly rather than being omitted.
