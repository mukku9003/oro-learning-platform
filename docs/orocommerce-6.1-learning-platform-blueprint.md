# OroCommerce 6.1 Developer Learning Platform
## Technical Product Vision & Execution Blueprint

## 1) Product Mission
Build a task-driven learning platform that helps developers implement **real OroCommerce 6.1 customizations** using official extension patterns instead of ad-hoc workarounds.

This platform closes the gap between fragmented documentation and production-ready implementation by organizing knowledge into practical modules, each mapped to Oro architecture layers.

---

## 2) Problem Framing

### Current pain points
- Oro documentation is broad but spread across many sections.
- Most examples are feature-focused, not end-to-end task walkthroughs.
- Developers struggle to map business requirements to Oro extension points.
- Teams lose time validating whether a solution follows Oro standards.

### Common developer questions
- How do I customize storefront header blocks without breaking theme inheritance?
- Which files control PLP/PDP layouts and how should they be extended?
- How do I create and register a custom bundle correctly?
- How should enum fields be added using migration + entity extend standards?
- How can website-level visibility/toggles be implemented in a reusable way?

---

## 3) Strategic Objectives
1. Transform Oro 6.1 docs into structured, scenario-driven tutorials.
2. Enforce official Oro patterns for migrations, layouts, themes, and entity extend.
3. Provide production-grade examples (bundle skeletons + working snippets).
4. Support onboarding from Symfony/Magento/PHP backgrounds.
5. Create a scalable curriculum that can grow into advanced tracks.

---

## 4) Target Users
- Junior OroCommerce developers
- Symfony/PHP engineers transitioning to Oro
- Magento developers moving into Oro B2B ecosystem
- Freelancers implementing custom B2B storefront workflows
- Engineering managers onboarding new Oro team members

---

## 5) Learning Design Principles
Each lesson must include:
1. **Problem Statement**
2. **Oro Architectural Context**
3. **Required Extension Points**
4. **Folder Structure**
5. **Step-by-Step Implementation**
6. **Why this is the correct Oro pattern**
7. **Common mistakes / anti-patterns**
8. **Final working example**
9. **Code snippet(s)**
10. **Reference to official Oro pattern**

### Quality gate (definition of done per lesson)
- Uses extension over hard override whenever possible.
- Uses layout/theme systems in standard way.
- Uses migration/entity extend mechanisms correctly.
- Includes reproducible steps and command sequence.
- Includes explicit “why” section explaining design decisions.

---

## 6) Curriculum Map (Task-Based)

## Module 1 — Bundle Architecture & Setup
**Outcomes:** Developers can create a custom bundle using proper Oro registration and migration/extend patterns.

**Key topics**
- Bundle creation and registration
- `services.yaml` and DI design
- Entity scaffolding
- Migrations and data fixtures
- Enum attribute standards

**Practice tasks**
- Create `ProductBadgeBundle`
- Add enum field using `addEnumField`
- Generate enum code via `ExtendHelper::buildEnumCode`
- Seed options using `EnumOptionRepository`
- Run `oro:migration:data:load`
- Run `oro:entity-extend:update`

---

## Module 2 — Storefront Layout System
**Outcomes:** Developers can safely extend storefront UI using layout updates, blocks, data providers, and themes.

**Key topics**
- `layout.yml` anatomy
- Block tree manipulation
- Twig block templates
- Layout data providers
- Theme and asset inheritance

**Practice tasks**
- Customize header structure
- Extend navigation area with custom block
- Override block template in standard layout scope
- Add website-level visibility condition

---

## Module 3 — PLP (Product Listing Page) Customization
**Outcomes:** Developers can add product-level presentation logic on listing views while respecting Oro architecture.

**Key topics**
- PLP layout updates
- Datagrid integration patterns
- Filters and visibility rules
- Badge rendering strategy

**Practice tasks**
- Add “New” badge on PLP
- Render custom product attribute in card/list row
- Add website-level show/hide behavior
- Inject custom blog/content block into PLP

---

## Module 4 — PDP (Product Detail Page) Customization
**Outcomes:** Developers can implement conditional content and reusable data-provider-driven blocks on PDP.

**Key topics**
- PDP layout updates
- Conditional rendering
- Attribute presentation
- Data provider injection

**Practice tasks**
- Add dynamic badge logic
- Show/hide promotional blocks by website scope
- Inject blog/marketing content section
- Add reusable promotional UI component

---

## Module 5 — Entity & Extend System
**Outcomes:** Developers can extend entities with proper schema evolution and admin integration.

**Key topics**
- ExtendEntityBundle fundamentals
- Enum fields and relations
- Doctrine migration strategy
- Fixtures and ACL consistency

**Practice tasks**
- Add product tag attribute
- Create enum attribute
- Create relation to custom entity
- Add backend form integration

---

## Module 6 — Admin UI Customization
**Outcomes:** Developers can customize admin grids/forms/configuration in secure and maintainable ways.

**Key topics**
- Datagrid configuration
- Form extensions
- Controller/application layering
- Twig extension strategy
- ACL integration

**Practice tasks**
- Add custom product grid column
- Add custom system configuration section
- Create website-level toggle setting

---

## 7) Platform Capabilities

## 7.1 Search-Driven Problem Index
Index each tutorial by:
- Problem statement and synonyms
- Oro layer (Backend / Frontend / Layout / Entity / Migration / Admin UI)
- Required extension points
- Difficulty level
- Oro version compatibility (6.1 baseline)

Each indexed item links to:
- Architecture explanation
- Step guide
- File tree
- Working snippet
- “Why this pattern” rationale

## 7.2 Official Pattern Compliance Engine
Each lesson includes a rule checklist:
- No direct core hacks
- Uses supported extension points
- Uses migration + extend rules for schema changes
- Layout/theme updates follow inheritance model
- ACL and scope handling included where relevant

## 7.3 Practical Learning Application
Provide a sample training project:
- `OroLearningDemoApp`
  - `CustomBundleExample`
  - `ProductBadgeBundle`
  - `WebsiteContentBundle`
  - `LayoutCustomizationBundle`

The app acts as lab material for each module and enables clone-and-run learning paths.

---

## 8) System Architecture

## Backend
- Symfony-based app structure (Oro-aligned)
- Markdown lesson source with frontmatter metadata
- Snippet/version tagging (Oro 6.1)
- Search index generation pipeline

## Frontend
- Task-based navigation UI
- File tree visualization panel
- Before/after code comparison
- Step completion tracking
- “Pattern compliance” checklist view

## Content Model (proposed)
```yaml
id: m2-header-customization
module: storefront-layout
title: Customize Storefront Header with Layout Updates
oro_version: 6.1
layers:
  - frontend
  - layout
difficulty: intermediate
extension_points:
  - layout_update
  - twig_block
  - data_provider
prerequisites:
  - module-1-bundle-setup
deliverables:
  - custom header block
  - visibility by website setting
```

---

## 9) Execution Plan

## Phase 1 — Foundation (Weeks 1–2)
- Define lesson schema and metadata model
- Build markdown renderer + snippet component
- Implement baseline navigation and module shells
- Seed first 6–8 lessons (one per module)

## Phase 2 — Practical Labs (Weeks 3–5)
- Build `OroLearningDemoApp` scaffold
- Add runnable bundle examples for modules 1–4
- Add command-run guides and expected outputs
- Introduce anti-pattern callouts

## Phase 3 — Search + Pattern Enforcement (Weeks 6–7)
- Implement searchable problem index
- Add architecture-layer filters
- Add pattern-checklist UI and lesson QA process

## Phase 4 — Scale Content (Weeks 8+)
- Expand lessons to advanced tracks
- Add workflow, MQ, performance, caching modules
- Add onboarding pathways by role (junior, backend, frontend)

---

## 10) Governance & Content Operations

### Authoring standards
- One task = one lesson = one verifiable outcome
- Every code snippet must include target file path
- Every lesson must declare extension points explicitly
- Include “Common Mistakes” section in all modules

### Review workflow
1. Draft lesson
2. Technical validation against Oro 6.1 patterns
3. Run-through in demo app
4. Publish with version tag and changelog

### Versioning
- Baseline track for Oro 6.1
- Changelog per lesson when Oro minor versions change
- Deprecation notes for outdated patterns

---

## 11) Success Metrics
- Time-to-first-working-customization (new developer)
- Lesson completion rate by module
- Search-to-solution conversion rate
- Reduction in repeated internal support questions
- Number of production tasks completed using platform templates

---

## 12) Risks & Mitigations
- **Risk:** Oro minor updates invalidate examples.
  - **Mitigation:** Version tags + quarterly compatibility review.

- **Risk:** Content becomes too theoretical.
  - **Mitigation:** Mandatory runnable deliverable for each lesson.

- **Risk:** Over-reliance on overrides.
  - **Mitigation:** Pattern checklist blocks non-compliant drafts.

---

## 13) Long-Term Expansion
- Advanced certification tracks
- Performance and caching specialization
- API extension track (REST/GraphQL where applicable)
- Workflow & message queue labs
- Role-specific onboarding plans for enterprise teams

---

## 14) Final Technical Summary
Create a **task-oriented, standard-compliant OroCommerce 6.1 learning platform** that converts fragmented documentation into structured, real-world implementation modules. Prioritize official Oro extension architecture (bundle setup, layouts, PLP/PDP customization, entity extend, migrations, enum fields, website-level configuration), backed by runnable examples and explicit pattern rationale.
