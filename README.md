# OroCommerce 6.1 Developer Learning Platform (MVP Scaffold)

This repository now contains the **first runnable foundation** of the learning platform described in the blueprint.

## What is included

- A minimal PHP web app entrypoint (`public/index.php`)
- Lesson storage in markdown files with frontmatter metadata (`content/lessons/*.md`)
- A lightweight lesson repository and frontmatter parser (`src/*`)
- A simple lesson list page and lesson detail page
- A starter architecture note for next implementation phases

## Run locally

```bash
php -S 127.0.0.1:8080 -t public
```

Then open:

- `http://127.0.0.1:8080/` → lesson catalog
- `http://127.0.0.1:8080/lesson?id=m1-product-badge-bundle` → sample lesson

## Project structure

```text
public/
  index.php
src/
  Lesson.php
  LessonRepository.php
content/
  lessons/
    m1-product-badge-bundle.md
docs/
  architecture/
    mvp-implementation-plan.md
  orocommerce-6.1-learning-platform-blueprint.md
```

## Next steps

1. Add module navigation and filters by Oro layer.
2. Add code snippet renderer with file path labels.
3. Add progress tracking and lesson completion state.
4. Add search index generation and query UI.
