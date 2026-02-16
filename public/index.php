<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Lesson.php';
require_once __DIR__ . '/../src/LessonRepository.php';

use OroLearningPlatform\LessonRepository;

$repository = new LessonRepository(__DIR__ . '/../content/lessons');
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

if ($path === '/' || $path === '/index.php') {
    $lessons = $repository->findAll();

    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><title>Oro Learning Platform</title>';
    echo '<style>body{font-family:Arial,sans-serif;max-width:900px;margin:2rem auto;padding:0 1rem;}';
    echo '.card{border:1px solid #ddd;border-radius:8px;padding:1rem;margin:.75rem 0;}';
    echo '.meta{color:#666;font-size:.9rem;} code{background:#f4f4f4;padding:.1rem .3rem;border-radius:4px;}</style></head><body>';
    echo '<h1>OroCommerce 6.1 Developer Learning Platform</h1>';
    echo '<p>Task-driven lessons mapped to Oro architecture patterns.</p>';
    echo '<h2>Lesson Catalog</h2>';

    foreach ($lessons as $lesson) {
        echo '<div class="card">';
        echo '<h3>' . htmlspecialchars($lesson->title) . '</h3>';
        echo '<p class="meta">Module: <code>' . htmlspecialchars($lesson->module) . '</code> | Difficulty: <code>' . htmlspecialchars($lesson->difficulty) . '</code></p>';
        echo '<p>' . htmlspecialchars($lesson->summary) . '</p>';
        echo '<a href="/lesson?id=' . urlencode($lesson->id) . '">Open lesson</a>';
        echo '</div>';
    }

    echo '</body></html>';
    exit;
}

if ($path === '/lesson') {
    $id = $_GET['id'] ?? '';
    $lesson = $repository->findById((string)$id);

    if ($lesson === null) {
        http_response_code(404);
        echo '<h1>Lesson not found</h1><p><a href="/">Back to catalog</a></p>';
        exit;
    }

    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><title>' . htmlspecialchars($lesson->title) . '</title>';
    echo '<style>body{font-family:Arial,sans-serif;max-width:900px;margin:2rem auto;padding:0 1rem;} pre{background:#f8f8f8;padding:1rem;border-radius:8px;overflow:auto;} .pill{display:inline-block;background:#eef3ff;padding:.25rem .5rem;border-radius:999px;margin-right:.25rem;} code{background:#f4f4f4;padding:.1rem .3rem;border-radius:4px;}</style></head><body>';
    echo '<p><a href="/">← Back to catalog</a></p>';
    echo '<h1>' . htmlspecialchars($lesson->title) . '</h1>';
    echo '<p><strong>Problem:</strong> ' . htmlspecialchars($lesson->problemStatement) . '</p>';
    echo '<p><strong>Architecture Context:</strong> ' . htmlspecialchars($lesson->architectureContext) . '</p>';

    echo '<h3>Extension Points</h3>';
    foreach ($lesson->extensionPoints as $point) {
        echo '<span class="pill">' . htmlspecialchars($point) . '</span>';
    }

    echo '<h3>Steps</h3><ol>';
    foreach ($lesson->steps as $step) {
        echo '<li>' . htmlspecialchars($step) . '</li>';
    }
    echo '</ol>';

    echo '<h3>Common Mistakes</h3><ul>';
    foreach ($lesson->commonMistakes as $mistake) {
        echo '<li>' . htmlspecialchars($mistake) . '</li>';
    }
    echo '</ul>';

    echo '<h3>Why this pattern</h3>';
    echo '<p>' . htmlspecialchars($lesson->patternRationale) . '</p>';

    echo '<h3>Source snippet</h3>';
    echo '<pre>' . htmlspecialchars($lesson->sourceSnippet) . '</pre>';

    echo '<p><strong>Official reference:</strong> ' . htmlspecialchars($lesson->officialPatternReference) . '</p>';

    echo '</body></html>';
    exit;
}

http_response_code(404);
echo '<h1>Page not found</h1><p><a href="/">Back to catalog</a></p>';
