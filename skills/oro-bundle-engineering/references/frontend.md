# Frontend/UI Extension Guide (Oro)

## 1) UI Principles
- Keep business decisions server-side or workflow-driven.
- UI should reflect ACL/workflow state, not replace it.
- Reuse Oro UI components and layout mechanisms before custom JS.

## 2) Secure UI
- Escape all output by default.
- Never trust client-side validation alone.
- Respect CSRF protections on mutating actions.
- Avoid exposing sensitive IDs/data in markup when unnecessary.

## 3) Maintainable Frontend Patterns
- Prefer configuration/layout updates over template copy-paste forks.
- Keep JS components focused and loosely coupled.
- Avoid hardcoding URLs, labels, or role checks in templates/scripts.

## 4) Review Checklist (Frontend)
- ACL-based visibility verified.
- Workflow state displayed from backend source of truth.
- No duplicated business logic between JS and PHP.
- Accessibility and translation hooks considered.
