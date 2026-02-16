<?php

declare(strict_types=1);

namespace OroLearningPlatform;

final class SimpleMarkdown
{
    public function toHtml(string $markdown): string
    {
        $lines = preg_split('/\R/', $markdown) ?: [];
        $html = [];
        $inCode = false;
        $inList = false;

        foreach ($lines as $line) {
            $trimmed = rtrim($line);

            if (str_starts_with($trimmed, '```')) {
                if ($inCode) {
                    $html[] = '</code></pre>';
                    $inCode = false;
                } else {
                    if ($inList) {
                        $html[] = '</ul>';
                        $inList = false;
                    }

                    $html[] = '<pre><code>';
                    $inCode = true;
                }

                continue;
            }

            if ($inCode) {
                $html[] = htmlspecialchars($line, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "\n";

                continue;
            }

            if (preg_match('/^\s*-\s+(.+)$/', $trimmed, $matches) === 1) {
                if (!$inList) {
                    $html[] = '<ul>';
                    $inList = true;
                }

                $html[] = '<li>' . $this->inline((string)$matches[1]) . '</li>';

                continue;
            }

            if ($inList) {
                $html[] = '</ul>';
                $inList = false;
            }

            if ($trimmed === '') {
                continue;
            }

            if (preg_match('/^(#{1,3})\s+(.+)$/', $trimmed, $matches) === 1) {
                $level = strlen((string)$matches[1]);
                $html[] = sprintf('<h%d>%s</h%d>', $level, $this->inline((string)$matches[2]), $level);

                continue;
            }

            $html[] = '<p>' . $this->inline($trimmed) . '</p>';
        }

        if ($inList) {
            $html[] = '</ul>';
        }

        if ($inCode) {
            $html[] = '</code></pre>';
        }

        return implode("\n", $html);
    }

    private function inline(string $text): string
    {
        $escaped = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $escaped = preg_replace('/`([^`]+)`/', '<code>$1</code>', $escaped) ?? $escaped;

        return preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $escaped) ?? $escaped;
    }
}
