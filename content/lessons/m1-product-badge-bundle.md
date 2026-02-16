---
id: m1-product-badge-bundle
title: Create ProductBadgeBundle and Add Product Badge Enum
module: module-1-bundle-architecture
difficulty: intermediate
layers: backend|entity|migration
summary: Build a custom Oro bundle that introduces a product badge enum field using official migration and extend patterns.
problem_statement: The business needs reusable product badges like New and Trending without core modifications.
architecture_context: Use bundle-level migrations plus Entity Extend to keep schema changes and UI metadata maintainable.
extension_points: custom_bundle|migration|entity_extend|enum_field|data_fixture
steps: Create bundle and register it|Add migration with addEnumField|Build enum code with ExtendHelper::buildEnumCode|Insert enum options via fixture/repository|Run oro migrations and entity extend update
common_mistakes: Editing core entity files directly|Skipping entity-extend update command|Hardcoding enum IDs instead of enum code
pattern_rationale: Oro extend + migration APIs preserve upgradability and keep metadata synchronized across environments.
official_pattern_reference: OroCommerce 6.1 Backend > Entities > Extend Entities and Migrations documentation sections.
---
$enumCode = ExtendHelper::buildEnumCode('product', 'badge');
$this->addEnumField(
    $schema,
    'oro_product',
    'product_badge',
    $enumCode,
    false,
    false,
    [
        'extend' => ['owner' => ExtendScope::OWNER_CUSTOM],
        'datagrid' => ['is_visible' => DatagridScope::IS_VISIBLE_TRUE],
    ]
);

// Apply changes:
// php bin/console oro:migration:load --force
// php bin/console oro:entity-extend:update --force
