# Migrations & Data Evolution Guide

## 1) Migration Planning
- Identify schema change type: additive, transformative, destructive.
- Prefer backward-compatible phased rollout when possible.
- Explicitly document impact on existing workflows, ACL scope, and integrations.

## 2) Safe Migration Practices
- Keep migrations deterministic and idempotent where practical.
- Separate schema migration from heavy data backfill jobs when needed.
- Use batching for large updates; avoid long locks.
- Provide rollback/mitigation strategy for production failures.

## 3) Data Integrity Rules
- Preserve referential integrity and ownership fields.
- Avoid implicit status remapping without business sign-off.
- Add defaults carefully; validate legacy records.

## 4) Validation Before Release
- Run migrations on realistic data snapshot/staging.
- Verify critical read/write paths after migration.
- Confirm indexes and constraints match query usage.

## 5) Definition of Done (Migrations)
- Migration impact documented.
- Dry-run and verification complete.
- Rollback/mitigation steps recorded.
