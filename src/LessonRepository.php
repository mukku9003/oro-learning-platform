<?php

declare(strict_types=1);

namespace OroLearningPlatform;

final class LessonRepository
{
    public function __construct(private readonly string $lessonsDirectory)
    {
    }

    /** @return Lesson[] */
    public function findAll(): array
    {
        $files = glob($this->lessonsDirectory . '/*.md') ?: [];
        $lessons = [];

        foreach ($files as $file) {
            $lessons[] = $this->parseLessonFile($file);
        }

        usort($lessons, static fn(Lesson $a, Lesson $b): int => strcmp($a->id, $b->id));

        return $lessons;
    }

    public function findById(string $id): ?Lesson
    {
        foreach ($this->findAll() as $lesson) {
            if ($lesson->id === $id) {
                return $lesson;
            }
        }

        return null;
    }

    private function parseLessonFile(string $file): Lesson
    {
        $contents = file_get_contents($file);
        if ($contents === false) {
            throw new \RuntimeException('Unable to read lesson file: ' . $file);
        }

        if (!preg_match('/^---\n(.*?)\n---\n(.*)$/s', $contents, $matches)) {
            throw new \RuntimeException('Invalid lesson frontmatter format: ' . $file);
        }

        $frontmatterText = trim($matches[1]);
        $body = trim($matches[2]);
        $meta = $this->parseFrontmatter($frontmatterText);

        return new Lesson(
            id: (string)($meta['id'] ?? ''),
            title: (string)($meta['title'] ?? 'Untitled'),
            module: (string)($meta['module'] ?? 'unassigned'),
            difficulty: (string)($meta['difficulty'] ?? 'unknown'),
            summary: (string)($meta['summary'] ?? ''),
            problemStatement: (string)($meta['problem_statement'] ?? ''),
            architectureContext: (string)($meta['architecture_context'] ?? ''),
            extensionPoints: $this->parseList((string)($meta['extension_points'] ?? '')),
            steps: $this->parseList((string)($meta['steps'] ?? '')),
            commonMistakes: $this->parseList((string)($meta['common_mistakes'] ?? '')),
            patternRationale: (string)($meta['pattern_rationale'] ?? ''),
            officialPatternReference: (string)($meta['official_pattern_reference'] ?? ''),
            sourceSnippet: $body,
        );
    }

    /** @return array<string, string> */
    private function parseFrontmatter(string $frontmatterText): array
    {
        $result = [];

        foreach (preg_split('/\n/', $frontmatterText) as $line) {
            $line = trim((string)$line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            $parts = explode(':', $line, 2);
            if (count($parts) !== 2) {
                continue;
            }

            $key = trim($parts[0]);
            $value = trim($parts[1]);
            $result[$key] = $value;
        }

        return $result;
    }

    /** @return string[] */
    private function parseList(string $raw): array
    {
        if ($raw === '') {
            return [];
        }

        $parts = array_map(static fn(string $item): string => trim($item), explode('|', $raw));

        return array_values(array_filter($parts, static fn(string $item): bool => $item !== ''));
    }
}
