# Mission 004: Close the Governance Loop

**Status:** Complete — see [report.md](report.md)
**Executed by:** Codex 5.3

## Why this mission exists

An external audit found a governance gap: approved mission work lived on a
feature branch while `main` remained stale. That broke AI-DOS's core rule
("Never make a future agent guess") because a fresh clone of `main` could not
reconstruct the actual approved state.

This mission closes that loop by making mission approval Git-native:
repository state on `main`, not chat context, is the durable record.

## Tasks

1. Verify from repository evidence whether `main` is canonical for Missions
   001-003, including Standards, recommendation, and backlog sequencing.
2. Add a formal Mission Approval standard to
   [company/Standards.md](../../company/Standards.md), including lifecycle and
   merge-based approval rules.
3. Resequence forward-looking mission numbering:
   - Mission 004 = Close the Governance Loop
   - Mission 005 = Validate the Recommendation
   - Mission 006 = Build the Benchmark MVP (conditional on Mission 005)
4. Add dated addenda where historical reports reference Mission 004 as
   validation; preserve historical text rather than rewriting it.
5. Create this mission brief and report.
6. Run a repository consistency audit and cold-start verification from `main`
   references.

## Constraints

- Do not begin validation work.
- Do not create Governance.md.
- Do not add speculative standards.
- Do not redesign AI-DOS.
- Do not rewrite history; use dated addenda.
- Every commit follows the Knowledge Preservation standard.

## Exit criteria

- `main` canonical status for Missions 001-003 is verified from repo evidence.
- `company/Standards.md` contains Mission Approval.
- `missions/004-close-governance-loop/` includes mission and report files.
- Mission numbering is consistent for forward-looking references.
- Cold-start verification succeeds from file citations.
- Repository consistency audit passes with no unexplained stale references.
- No validation work has started.
