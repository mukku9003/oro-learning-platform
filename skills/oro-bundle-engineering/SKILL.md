---
name: oro-bundle-engineering
description: Senior workflow for designing, implementing, reviewing, and hardening OroPlatform/OroCommerce custom bundles and extensions in Symfony/PHP with ACL, workflows, Doctrine best practices, secure coding, and maintainable architecture.
---

# Oro Bundle Engineering Skill

Use this skill when the task is to build, extend, refactor, or review Oro bundles/extensions.

## Outcomes
- Translate business requirements into Oro-native design.
- Produce maintainable architecture (not “quick patch in one file”).
- Enforce security and platform conventions (ACL, ownership, workflows, config-driven behavior).
- Deliver code review quality gates before merge.

## Senior Engineer Workflow (always follow)
1. **Clarify & Scope**
   - Identify business outcome, actors, permissions, lifecycle/status model, integrations, and non-functional needs.
   - Convert vague asks into explicit acceptance criteria.
2. **Translate to Oro Concepts**
   - Map domain concepts to Entities, Ownership, Organization scope, ACLs, Workflows, Message Queue, UI forms/grids, APIs.
   - Prefer configuration and extension points over core edits.
3. **Design Before Coding**
   - Create a short HLD: modules, boundaries, data flow, failure modes, auditability, migration impact.
   - Create LLD checklist: commands, event listeners/subscribers, services, validators, workflows, API/resources.
4. **Implement Layered Solution**
   - Keep controllers thin.
   - Put business rules into domain/application services and workflows.
   - Use Doctrine ORM/repositories; avoid raw SQL unless justified.
5. **Security & Compliance Pass**
   - ACL, CSRF, validation, escaping, secure defaults, least privilege.
6. **Review Across Layers**
   - Validate request→controller→service→persistence→workflow→UI/API flow.
   - Validate transaction boundaries and async behavior.
7. **Verification**
   - Run static checks, tests, migration dry-runs, and manual scenario checks.

## Non-Negotiable Rules
- Do **not** modify Oro core bundles directly.
- Do **not** hardcode statuses/state machines in PHP when workflow can model them.
- Do **not** place domain logic in controllers, form types, Twig templates, or migrations.
- Do **not** bypass ACL/ownership checks.
- Do **not** use direct DB queries for routine domain operations; prefer Doctrine entities/repositories.
- Do **not** introduce service locator anti-patterns when explicit DI is possible.

## Architecture Guardrails
- **Boundaries:** Controller/Application Service/Domain/Infrastructure responsibilities are explicit.
- **Configuration-driven first:** Use Oro config, datagrids, workflows, system configuration, feature toggles.
- **Extensibility:** Prefer events, listeners, strategy services, and interfaces over condition-heavy procedural code.
- **Async by design:** Long-running or external I/O tasks should use message queue/async handlers.
- **Observability:** Include meaningful logging context and predictable error paths.

## Security Baseline
- Enforce ACL annotations/config and ownership model checks.
- Validate all input (Symfony Validator/Form constraints).
- Escape output in templates; avoid unsafe HTML rendering.
- Use parameterized queries when raw DB access is unavoidable.
- Prevent CSRF for state-changing operations.
- Keep secrets outside code and avoid leaking sensitive payloads in logs.

## Coding Standards
- Symfony and PSR standards (PSR-1/12; autoloading; interfaces where needed).
- Strong typing and clear method contracts.
- Small, testable services; avoid god classes.
- Domain names should reflect business language.

## Required Pre-Implementation Plan Template
Before writing code, produce this plan:
1. Requirement summary (business + technical).
2. Oro mapping (entity, ACL, workflow, UI/API, integration).
3. Data flow (request to persistence and side effects).
4. HLD (components and responsibilities).
5. Migration/config change plan.
6. Test plan (unit/integration/functional/manual).
7. Risks and rollback plan.

## Required Code Review Checklist
Always run `references/review-checklist.md` and attach findings by severity.

## Task-Specific References
- Backend implementation rules: `references/backend.md`
- Frontend/UI extension rules: `references/frontend.md`
- Migration & data evolution rules: `references/migrations.md`
- Review and approval checklist: `references/review-checklist.md`

## Output Contract For Agents
For every implementation task, output sections in this order:
1. **Plan** (using the required template)
2. **Proposed Architecture** (HLD + critical design choices)
3. **Implementation Steps**
4. **Security/ACL/Workflow Considerations**
5. **Tests & Verification**
6. **Code Review Findings (self-review)**
7. **Open Questions / Approval Needed**
