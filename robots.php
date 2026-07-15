<?php
require_once __DIR__ . '/bootstrap.php';

header('Content-Type: text/plain; charset=utf-8');

if (config('staging')) {
    echo "# Testumgebung — Indexierung gesperrt.\n";
    echo "# Freigabe: in config.php 'staging' => false setzen.\n";
    echo "User-agent: *\n";
    echo "Disallow: /\n";
    return;
}

echo "User-agent: *\n";
echo "Disallow: /impressum\n";
echo "Disallow: /datenschutz\n";
echo "Allow: /\n";
echo "\n";
echo 'Sitemap: ' . SITE_URL . "/sitemap.xml\n";
