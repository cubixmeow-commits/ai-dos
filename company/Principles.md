# Principles

The constitution of AI-DOS. Every agent reads this before doing any work.
When a decision is unclear, these principles settle it — in order of appearance
if they conflict.

## §1 The repository is the product

The output of every mission is a more intelligent repository, not a chat
transcript. If value was created but not committed, it was not created.

## §2 Every mission must increase organizational intelligence

Each mission leaves behind, at minimum: what was done, why, what was decided,
and what should happen next. Leave the repository more intelligent than you
found it.

## §3 Hidden context is technical debt

Decisions, trade-offs, and rejected alternatives get written down where the
next agent will find them. "It was discussed" is not a location.

## §4 Every mission must pass the cold-start test

A stranger or fresh AI session must be able to clone the repository and
continue the work. Proof is mechanical, not self-graded: in the mission
report, cite the specific files and sections that answer the cold-start
questions. If a question has no file to point to, the mission is incomplete.

## §5 Evidence beats opinion

Claims in reports and decisions cite artifacts — files, commits, data,
measurements. Prefer "see X" over "we believe."

## §6 Optimize for an operator working primarily from an iPhone

Reports readable in under five minutes on a phone. Short sections, short
lines, one decision question at a time. The operator approves or rejects;
they do not dig.

## §7 Do not overbuild

Each mission creates only what it uses. No speculative folders, no
placeholder systems, no agents before the mission that needs them. Minimum
viable, always.

## §8 Git history is part of the product

Small, purposeful commits — one logical unit each — in the format:

```
M<mission-number>: <what> — <one-line why>
```
