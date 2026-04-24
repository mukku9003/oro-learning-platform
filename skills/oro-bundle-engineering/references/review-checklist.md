# Oro Extension Code Review Checklist

Classify findings: **Blocker**, **Major**, **Minor**, **Suggestion**.

## A. Architecture & Design
- [ ] Requirement mapped to Oro concepts (entity, ACL, workflow, UI/API).
- [ ] Layering respected (no business logic in controller/template).
- [ ] Extension points used; no core bundle modifications.
- [ ] Dependencies point to abstractions where reasonable.

## B. Workflow & Business Rules
- [ ] Lifecycle modeled with workflow/operations (no hardcoded state maze).
- [ ] Transition guards are explicit and testable.
- [ ] Side effects are consistent across entry points (UI/API/async).

## C. Security
- [ ] ACL/ownership enforced on all sensitive actions.
- [ ] Input validation exists and is meaningful.
- [ ] No SQL injection/XSS/CSRF regressions.
- [ ] Sensitive data handling and logging are safe.

## D. Data & Persistence
- [ ] Doctrine-first approach; raw SQL justified and parameterized.
- [ ] Migrations are safe and reviewed for data integrity.
- [ ] Transaction and concurrency behavior considered.

## E. Reliability & Operations
- [ ] Error handling strategy is consistent.
- [ ] Async processing is used where needed.
- [ ] Logs/monitoring provide actionable diagnostics.

## F. Quality
- [ ] Unit/integration/functional tests cover critical paths.
- [ ] Naming, typing, and PSR/Symfony standards followed.
- [ ] Dead code, duplication, and over-complex methods addressed.

## Review Summary Template
- **Scope reviewed:**
- **Blockers:**
- **Majors:**
- **Minors:**
- **Suggestions:**
- **Go/No-Go Recommendation:**
