<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Lesson.php';
require_once __DIR__ . '/../src/LessonRepository.php';
require_once __DIR__ . '/../src/SimpleMarkdown.php';

use OroLearningPlatform\LessonRepository;
use OroLearningPlatform\SimpleMarkdown;

$repository = new LessonRepository(__DIR__ . '/../content/lessons');
$markdown = new SimpleMarkdown();
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

$css = <<<'CSS'
<style>
    :root { color-scheme: light dark; }
    body{font-family:Inter,Arial,sans-serif;max-width:1080px;margin:2rem auto;padding:0 1rem;line-height:1.5;}
    .card{border:1px solid #ddd;border-radius:12px;padding:1rem;margin:.75rem 0;background:#fff1;}
    .meta{color:#666;font-size:.9rem;}
    code{background:#f4f4f4;padding:.1rem .3rem;border-radius:4px;color:#111;}
    .pill{display:inline-block;background:#eef3ff;padding:.25rem .5rem;border-radius:999px;margin-right:.25rem;}
    form.filters{display:flex;gap:.5rem;flex-wrap:wrap;margin:1rem 0 1.5rem;}
    input,select,button{padding:.45rem .55rem;border:1px solid #bbb;border-radius:8px;}
    pre{background:#0f172a;color:#f8fafc;padding:1rem;border-radius:8px;overflow:auto;}
    .section{margin-top:1.5rem;}
</style>
CSS;

if ($path === '/' || $path === '/index.php') {
    $module = trim((string)($_GET['module'] ?? ''));
    $layer = trim((string)($_GET['layer'] ?? ''));
    $query = trim((string)($_GET['q'] ?? ''));

    $lessons = $repository->findAll($module ?: null, $layer ?: null, $query ?: null);
    $modules = $repository->availableModules();
    $layers = $repository->availableLayers();

    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><title>Oro Learning Platform</title>' . $css . '</head><body>';
    echo '<h1>OroCommerce 6.1 Developer Learning Platform</h1>';
    echo '<p>Search-driven, task-based learning mapped to official Oro architecture patterns.</p>';

    echo '<form class="filters" method="get" action="/">';
    echo '<input type="search" name="q" placeholder="Search tasks, layers, extension points..." value="' . htmlspecialchars($query) . '">';

    echo '<select name="module"><option value="">All modules</option>';
    foreach ($modules as $m) {
        $selected = $module === $m ? ' selected' : '';
        echo '<option value="' . htmlspecialchars($m) . '"' . $selected . '>' . htmlspecialchars($m) . '</option>';
    }
    echo '</select>';

    echo '<select name="layer"><option value="">All layers</option>';
    foreach ($layers as $l) {
        $selected = $layer === $l ? ' selected' : '';
        echo '<option value="' . htmlspecialchars($l) . '"' . $selected . '>' . htmlspecialchars($l) . '</option>';
    }
    echo '</select>';

    echo '<button type="submit">Apply</button>';
    echo '<a href="/" style="padding:.45rem .55rem;">Reset</a>';
    echo '</form>';

    echo '<p class="meta">Showing ' . count($lessons) . ' lesson(s).</p>';

    foreach ($lessons as $lesson) {
        echo '<article class="card">';
        echo '<h3>' . htmlspecialchars($lesson->title) . '</h3>';
        echo '<p class="meta">Module: <code>' . htmlspecialchars($lesson->module) . '</code> | Difficulty: <code>' . htmlspecialchars($lesson->difficulty) . '</code></p>';
        echo '<p>' . htmlspecialchars($lesson->summary) . '</p>';
        foreach ($lesson->layers as $l) {
            echo '<span class="pill">' . htmlspecialchars($l) . '</span>';
        }
        echo '<p><a href="/lesson?id=' . urlencode($lesson->id) . '">Open lesson</a></p>';
        echo '</article>';
    }

    if (count($lessons) === 0) {
        echo '<p>No lessons found for the selected filters.</p>';
    }

    echo '</body></html>';
    exit;
}

if ($path === '/lesson') {
    $id = trim((string)($_GET['id'] ?? ''));
    $lesson = $repository->findById($id);

    if ($lesson === null) {
        http_response_code(404);
        echo '<h1>Lesson not found</h1><p><a href="/">Back to catalog</a></p>';
        exit;
    }

    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><title>' . htmlspecialchars($lesson->title) . '</title>' . $css . '</head><body>';
    echo '<p><a href="/">← Back to catalog</a></p>';
    echo '<h1>' . htmlspecialchars($lesson->title) . '</h1>';
    echo '<p><strong>Summary:</strong> ' . htmlspecialchars($lesson->summary) . '</p>';

    echo '<div class="section"><h3>Problem Statement</h3><p>' . htmlspecialchars($lesson->problemStatement) . '</p></div>';
    echo '<div class="section"><h3>Oro Architectural Context</h3><p>' . htmlspecialchars($lesson->architectureContext) . '</p></div>';

    echo '<div class="section"><h3>Layers</h3>';
    foreach ($lesson->layers as $layer) {
        echo '<span class="pill">' . htmlspecialchars($layer) . '</span>';
    }
    echo '</div>';

    echo '<div class="section"><h3>Required Extension Points</h3><ul>';
    foreach ($lesson->extensionPoints as $point) {
        echo '<li><code>' . htmlspecialchars($point) . '</code></li>';
    }
    echo '</ul></div>';

    echo '<div class="section"><h3>Step-by-Step Implementation</h3><ol>';
    foreach ($lesson->steps as $step) {
        echo '<li>' . htmlspecialchars($step) . '</li>';
    }
    echo '</ol></div>';

    echo '<div class="section"><h3>Common Mistakes</h3><ul>';
    foreach ($lesson->commonMistakes as $mistake) {
        echo '<li>' . htmlspecialchars($mistake) . '</li>';
    }
    echo '</ul></div>';

    echo '<div class="section"><h3>Why This Is the Correct Oro Pattern</h3><p>' . htmlspecialchars($lesson->patternRationale) . '</p></div>';

    echo '<div class="section"><h3>Final Working Example (Snippet)</h3>';
    echo $markdown->toHtml("```php\n" . $lesson->sourceSnippet . "\n```");
    echo '</div>';

    echo '<div class="section"><h3>Official Pattern Reference</h3><p>' . htmlspecialchars($lesson->officialPatternReference) . '</p></div>';

    echo '</body></html>';
    exit;
}

http_response_code(404);
echo '<h1>Page not found</h1><p><a href="/">Back to catalog</a></p>';
