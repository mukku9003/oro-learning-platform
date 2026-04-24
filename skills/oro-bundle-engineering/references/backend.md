# Backend Extension Guide (Oro + Symfony + PHP)

## 1) Layering Rules
- Controller: parse request, invoke service, return response.
- Application service: orchestration and transaction boundaries.
- Domain service/entity: business invariants.
- Repository: query composition and persistence helpers.
- Infrastructure adapters: external systems, queue publishers, file/storage adapters.

## 2) Oro-Centric Design
- Prefer Oro entities with ownership metadata.
- Define ACL resources for each sensitive action.
- Use workflows/operations for lifecycle transitions instead of `if status == ...` scattered logic.
- Use datagrids/search indexing hooks where list/search behavior is required.
- Use message queue for async side effects (emails, integrations, expensive recalculation).

## 3) Anti-Patterns to Reject
- Fat controllers containing validation, persistence, and transition logic.
- Hardcoded statuses in constants with ad-hoc transition checks.
- Raw SQL for business operations that should be ORM-managed.
- Cross-bundle tight coupling through direct concrete class usage.
- Silent catch-and-ignore error handling.

## 4) Validation & Error Handling
- Use Symfony Validator constraints at DTO/form/entity boundaries.
- Distinguish business errors (user-fixable) vs system errors (operational).
- Return clear, localized user messages while logging technical details.

## 5) Test Expectations
- Unit tests: domain/application services.
- Integration tests: repositories, migrations, message handlers.
- Functional tests: ACL and workflow transitions through HTTP/API.

## 6) Definition of Done (Backend)
- Business rule placement is outside controllers.
- ACL and ownership checks verified.
- Workflow transitions cover lifecycle.
- No unjustified direct SQL.
- Tests added/updated and passing.
