<?php

declare(strict_types=1);

namespace OroLearningPlatform;

final class LessonRepository
{
    /** @var Lesson[]|null */
    private ?array $cache = null;

    public function __construct(private readonly string $lessonsDirectory)
    {
    }

    /** @return Lesson[] */
    public function findAll(?string $module = null, ?string $layer = null, ?string $query = null): array
    {
        $lessons = $this->loadAll();

        if ($module !== null && $module !== '') {
            $lessons = array_values(array_filter(
                $lessons,
                static fn(Lesson $lesson): bool => $lesson->module === $module
            ));
        }

        if ($layer !== null && $layer !== '') {
            $lessons = array_values(array_filter(
                $lessons,
                static fn(Lesson $lesson): bool => in_array($layer, $lesson->layers, true)
            ));
        }

        if ($query !== null && $query !== '') {
            $needle = mb_strtolower($query);
            $lessons = array_values(array_filter($lessons, static function (Lesson $lesson) use ($needle): bool {
                $haystack = mb_strtolower(implode(' ', [
                    $lesson->title,
                    $lesson->summary,
                    $lesson->problemStatement,
                    implode(' ', $lesson->extensionPoints),
                    implode(' ', $lesson->layers),
                ]));

                return str_contains($haystack, $needle);
            }));
        }
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

    /** @return string[] */
    public function availableModules(): array
    {
        $modules = array_map(static fn(Lesson $lesson): string => $lesson->module, $this->loadAll());

        return $this->uniqueSorted($modules);
    }

    /** @return string[] */
    public function availableLayers(): array
    {
        $layers = [];

        foreach ($this->loadAll() as $lesson) {
            $layers = [...$layers, ...$lesson->layers];
        }

        return $this->uniqueSorted($layers);
    }

    public function findById(string $id): ?Lesson
    {
        foreach ($this->loadAll() as $lesson) {
    public function findById(string $id): ?Lesson
    {
        foreach ($this->findAll() as $lesson) {
            if ($lesson->id === $id) {
                return $lesson;
            }
        }

        return null;
    }

    /** @return Lesson[] */
    private function loadAll(): array
    {
        if ($this->cache !== null) {
            return $this->cache;
        }

        $files = glob($this->lessonsDirectory . '/*.md') ?: [];
        $lessons = [];

        foreach ($files as $file) {
            $lessons[] = $this->parseLessonFile($file);
        }

        usort($lessons, static fn(Lesson $a, Lesson $b): int => strcmp($a->id, $b->id));

        $this->cache = $lessons;

        return $lessons;
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

        $meta = $this->parseFrontmatter(trim($matches[1]));
        $this->assertRequiredMeta($meta, ['id', 'title', 'module']);

        return new Lesson(
            id: (string)$meta['id'],
            title: (string)$meta['title'],
            module: (string)$meta['module'],
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
            layers: $this->parseList($meta['layers'] ?? ''),
            extensionPoints: $this->parseList($meta['extension_points'] ?? ''),
            steps: $this->parseList($meta['steps'] ?? ''),
            commonMistakes: $this->parseList($meta['common_mistakes'] ?? ''),
            patternRationale: (string)($meta['pattern_rationale'] ?? ''),
            officialPatternReference: (string)($meta['official_pattern_reference'] ?? ''),
            sourceSnippet: trim((string)$matches[2]),
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

        foreach (preg_split('/\n/', $frontmatterText) ?: [] as $line) {
            $line = trim((string)$line);

        foreach (preg_split('/\n/', $frontmatterText) as $line) {
            $line = trim((string)$line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            [$key, $value] = array_pad(explode(':', $line, 2), 2, '');

            if ($value === '') {
                continue;
            }

            $result[trim($key)] = trim($value);
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

    /** @param array<string, string> $meta @param string[] $required */
    private function assertRequiredMeta(array $meta, array $required): void
    {
        foreach ($required as $field) {
            if (!isset($meta[$field]) || trim($meta[$field]) === '') {
                throw new \RuntimeException(sprintf('Lesson metadata field "%s" is required.', $field));
            }
        }
    }

    /** @param string|string[] $raw @return string[] */
    private function parseList(string|array $raw): array
    {
        if (is_array($raw)) {
            return array_values(array_filter(array_map('trim', $raw), static fn(string $item): bool => $item !== ''));
        }

    /** @return string[] */
    private function parseList(string $raw): array
    {
        if ($raw === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode('|', $raw)), static fn(string $item): bool => $item !== ''));
    }

    /** @param string[] $values @return string[] */
    private function uniqueSorted(array $values): array
    {
        $values = array_values(array_unique($values));
        sort($values);

        return $values;
        $parts = array_map(static fn(string $item): string => trim($item), explode('|', $raw));

        return array_values(array_filter($parts, static fn(string $item): bool => $item !== ''));
    }
}
