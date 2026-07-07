# Identity

## §1 What AI-DOS Is

AI-DOS is a Git-native operating system for AI-assisted software development.

It is not an application. It is not a framework you install. **The repository
itself is the product.** Everything the organization knows — its goals, its
rules, its history, its open work — lives in versioned files that any human
or AI agent can read cold and act on.

## §2 Why AI-DOS Exists

AI models, coding agents, and tools are interchangeable workers. What is not
interchangeable is organizational intelligence: the accumulated record of what
was decided, why, what worked, and what comes next.

Today that intelligence usually dies in chat history. A session ends, the
context is gone, and the next agent starts from zero. AI-DOS exists to fix
that single failure:

> **Hidden context is technical debt.** If a decision is not written into the
> repository, it did not happen.

AI-DOS makes the repository the durable memory, so that any fresh agent —
or any human, including an operator working from a phone — can clone it and
continue the work without asking anyone anything.

## §3 How Work Happens

Work happens in **missions**: discrete, numbered units of work, each with a
written brief (`mission.md`) and a written outcome (`report.md`) under
`/missions/`. A mission is complete only when a stranger could read the
repository afterward and understand what happened and what to do next.

The rules every mission follows live in [Principles.md](Principles.md).
The queue of upcoming work lives in [/tasks/Backlog.md](../tasks/Backlog.md).
