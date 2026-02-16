<?php

declare(strict_types=1);

namespace OroLearningPlatform;

/**
 * Immutable lesson view model loaded from markdown frontmatter + body.
 */
final class Lesson
{
    /**
     * @param string[] $layers
     * @param string[] $extensionPoints
     * @param string[] $steps
     * @param string[] $commonMistakes
     */
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $module,
        public readonly string $difficulty,
        public readonly string $summary,
        public readonly string $problemStatement,
        public readonly string $architectureContext,
        public readonly array $layers,
        public readonly array $extensionPoints,
        public readonly array $steps,
        public readonly array $commonMistakes,
        public readonly string $patternRationale,
        public readonly string $officialPatternReference,
        public readonly string $sourceSnippet,
    ) {
    }
}
