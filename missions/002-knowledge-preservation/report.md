# Mission 002 Report: Formalize the Knowledge Preservation Standard

**Status:** Complete. 9 files touched, 7 `M002:` commits.

## What was changed and why

Mission level only — change-level rationale lives in the `M002:` commits
(`git log --grep=^M002`), per [Standards.md §1.2](../../company/Standards.md).

- **company/Standards.md** (new) — holds operational standards; first
  standard is Knowledge Preservation, including the commit format and the
  reports-vs-commits division of memory.
- **company/Principles.md** — gained governing principle §0 ("Never make a
  future agent guess"), a per-principle trace back to §0, the link
  explaining the Principles/Standards split, and the recorded (unbuilt)
  intent for a future Repository Intelligence Score.
- **missions/001-bootstrap/** — report gained an addendum; brief gained a
  renumbering note. Mission 001's Git history and organic commit format
  were left untouched as evidence of how the standard was discovered.
- **workflow/Templates/MissionTemplate.md** (new) — the mission template,
  with the required `Executed by:` field and "What AI-DOS Learned" section.
- **tasks/Backlog.md, README.md** — Prove the Loop renumbered to
  Mission 003; README now points at Standards.md and lists the new files.
- **missions/002-knowledge-preservation/** — this mission's brief and
  report.

## Decisions made

1. **The new principle is §0, not a renumbered §1.** Renumbering §1–§8
   would have silently broken existing citations ("Principles §7" in the
   Backlog and Mission 001 report) — creating exactly the stale references
   this mission forbids.
2. **The commit-format text moved out of Principles §8 into Standards
   §1.1.** Leaving the old format in the constitution would have
   contradicted the new standard; §8 keeps the belief, Standards keeps the
   mechanics.
3. **Historical references were annotated, not erased.** Mission 001's
   brief and report still contain the words "Mission 002" in their original
   sense, each under an explicit note stating those references now mean
   Mission 003. Rewriting them was rejected per the do-not-rewrite-history
   constraint.

## Dogfooding confirmation

- Every commit in this mission uses the Standards §1.1 format
  (subject + `Why:` + `Future benefit:`) — verify with `git log`.
- This mission is the first executed under the new template:
  [mission.md](mission.md) carries `Executed by: Claude Fable 5`, and this
  report carries the required "What AI-DOS Learned" section below.

## Stale-reference check

`grep -rn "Mission 002"` across the repo: every forward-looking file
(README §4, Backlog, Standards) says Mission 003 = Prove the Loop. The only
remaining old-sense occurrences are inside Mission 001's preserved brief and
report, each directly under an annotation explaining the renumbering — a
reader never has to guess. No unexplained stale reference remains.

## Impact on Mission 003

No impact on Mission 003's scope. Only its number, folder name
(`missions/003-prove-the-loop/`), and process changed: it will be the second
mission executed under the new template and commit standard.

## Risks / weaknesses discovered

- The commit standard is enforced only by convention; nothing checks it.
  Acceptable for now (Principles §7) — a check could ride along with the
  future Repository Intelligence Score.
- Mission 001's cold-start citations (its report §"Cold-Start Test") now
  route through renamed sections; the addendum bridges this, but it shows
  reports citing live files can drift as those files evolve.

## What AI-DOS Learned

This mission changed AI-DOS itself in the following ways:

- It gained a governing principle (§0) that all other principles reduce to,
  and a test for admitting new ones.
- It gained the Principles/Standards split: beliefs that rarely change vs.
  operating rules that evolve.
- It gained its first operational standard: commits preserve change-level
  rationale; reports summarize at mission level and reference commits
  instead of restating them.
- It gained a mission template making "which AI executed this" and "what
  did this mission change about AI-DOS" mandatory, queryable fields.
- It learned that mission numbering is provisional until a mission starts —
  the operator can insert missions — and that the correct response is
  annotation, not history rewriting.
- It recorded (without building) the intent for a Repository Intelligence
  Score to measure §0 over time.

---

Approve Mission 003: Prove the Loop? Y/N
