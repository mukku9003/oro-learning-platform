---
id: m3-plp-new-badge
title: Add New Badge on Product Listing Page (PLP)
module: module-3-plp-customization
difficulty: advanced
layers: frontend|layout|datagrid
summary: Render a New badge on PLP product tiles by combining product attributes and layout rendering.
problem_statement: Merchandising needs fast visibility for newly launched products on listing pages.
architecture_context: Store badge data in extend entity and render through listing layout/template layer.
extension_points: product_attribute|layout_update|twig_block|visibility_rule
steps: Add product badge attribute to product entity|Expose attribute in listing data source|Extend PLP item template|Render badge only for matching values|Validate output by website scope
common_mistakes: Computing heavy badge logic directly in Twig|Using direct DB calls in template|Ignoring cache invalidation and scope
pattern_rationale: Separating data retrieval from rendering keeps listing performant and aligns with Oro storefront architecture.
official_pattern_reference: OroCommerce 6.1 Storefront > Product Listing customization and Layout docs.
---
{% if product.productBadge and product.productBadge.id == 'new' %}
    <span class="product-badge product-badge--new">New</span>
{% endif %}
