# Decision D002: PHP Repository Compiler

**Status:** accepted  
**Related missions:** Mission 007, Mission 008

## Context

V2 requires a compiler to transform organizational source into Mission Control, JSON indexes, and agent context packages. A language and runtime had to be chosen.

## Decision

Implement the **Repository Compiler in PHP** at `compiler/compile.php`, runnable via CLI (`php compiler/compile.php`) and verified in GitHub Actions. PHP matches the operator's deployment host (cubixmeow.com).

## Alternatives considered

- **Node.js compiler** — better AI-toolchain fit, extra runtime on host.
- **Python compiler** — common in AI workflows, not native to current host.
- **No compiler** — manual HTML/JSON maintenance (Mission 005 proved drift-prone).

## Why chosen

One language ecosystem with deploy target; GitHub Actions support; no application server required. Mission 008 delivered a working compiler without overbuilding.

## Evidence

- [missions/007-design-v2/report.md](../missions/007-design-v2/report.md) — operator approved PHP
- [compiler/README.md](../compiler/README.md)
- [company/Standards.md](../company/Standards.md) §4
