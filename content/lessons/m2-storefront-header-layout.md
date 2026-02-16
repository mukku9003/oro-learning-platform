---
id: m2-storefront-header-layout
title: Customize Storefront Header with Layout Update
module: module-2-storefront-layout
difficulty: intermediate
layers: frontend|layout|theme
summary: Add a custom header promo block using Oro layout updates and Twig block templates.
problem_statement: Marketing needs a reusable storefront header promo area per website without overriding core templates.
architecture_context: Use layout update YAML and dedicated block template to preserve inheritance and upgrade safety.
extension_points: layout_update|twig_template|theme_inheritance|website_scope
steps: Create storefront layout update file for header page|Add block to existing header container|Bind block to Twig template|Read website-level setting in data provider|Render or hide block by website scope
common_mistakes: Replacing full base layout for small change|Hardcoding website IDs in template|Adding inline JS/CSS in Twig block
pattern_rationale: Layout update actions are composable and keep customizations isolated from core storefront structure.
official_pattern_reference: OroCommerce 6.1 Frontend > Layouts and Theme Inheritance sections.
---
layout:
    actions:
        - '@add':
              id: learning_header_promo
              parentId: header_row
              blockType: container
              options:
                  vars:
                      visible: '=data["website_content_provider"].isHeaderPromoVisible()'
