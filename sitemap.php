<?php
require_once __DIR__ . '/bootstrap.php';

header('Content-Type: application/xml; charset=utf-8');

function lastmod(string $file): string
{
    $path = __DIR__ . '/' . $file;
    return date('c', is_file($path) ? filemtime($path) : time());
}

$pages = [
    ['loc' => SITE_URL . '/',          'priority' => '1.00', 'file' => 'index.php'],
    ['loc' => SITE_URL . '/uebermich', 'priority' => '0.80', 'file' => 'uebermich.php'],
    ['loc' => SITE_URL . '/preise',    'priority' => '0.80', 'file' => 'preise.php'],
];

foreach (services() as $slug => $svc_item) {
    $pages[] = [
        'loc'      => SITE_URL . '/' . $slug,
        'priority' => '0.80',

        'file'     => 'services.php',
    ];
}

echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($pages as $page): ?>
    <url>
        <loc><?= e($page['loc']) ?></loc>
        <lastmod><?= e(lastmod($page['file'])) ?></lastmod>
        <priority><?= e($page['priority']) ?></priority>
    </url>
<?php endforeach; ?>
</urlset>
