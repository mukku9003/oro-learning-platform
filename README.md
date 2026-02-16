# OroCommerce 6.1 Developer Learning Platform (Working MVP)

This repository contains a runnable, task-driven MVP for the OroCommerce 6.1 learning platform.

## Current capabilities

- Lesson catalog page with:
  - full-text search (`q`)
  - module filter (`module`)
  - architecture layer filter (`layer`)
- Lesson detail page with the full learning structure:
  - problem statement
  - Oro architecture context
  - required extension points
  - implementation steps
  - common mistakes
  - pattern rationale
  - official reference
  - final working snippet
- Markdown lesson source files with frontmatter metadata
- Lightweight parser/repository to load, search, and filter lessons

## Run locally

```bash
php -S 127.0.0.1:8080 -t public
```

Then open:

- `http://127.0.0.1:8080/`
- `http://127.0.0.1:8080/lesson?id=m1-product-badge-bundle`

## Lesson metadata format

```text
---
id: m2-storefront-header-layout
title: Customize Storefront Header with Layout Update
module: module-2-storefront-layout
difficulty: intermediate
layers: frontend|layout|theme
summary: ...
problem_statement: ...
architecture_context: ...
extension_points: layout_update|twig_template|theme_inheritance
steps: Step A|Step B|Step C
common_mistakes: Mistake A|Mistake B
pattern_rationale: ...
official_pattern_reference: ...
---
<snippet or markdown body>
```

## Merge conflict note
If your PR UI still shows stale conflicts, update your branch with the latest target branch revision and push again:

```bash
git fetch origin
git rebase origin/<target-branch>
# or: git merge origin/<target-branch>
```

This branch now contains clean, validated versions of the previously conflicted files (`README.md`, `public/index.php`, `src/Lesson.php`, `src/LessonRepository.php`, `content/lessons/m1-product-badge-bundle.md`, `docs/architecture/mvp-implementation-plan.md`).

## Next implementation targets

1. Add filesystem-based snippet include support and path labeling.
2. Add persistent progress tracking (file or sqlite).
3. Add version tags and compatibility badges (6.1 baseline).
4. Add module navigation pages and completion milestones.
