<?php
$page_title       = $page_title       ?? SITE_NAME . ' | ' . SITE_OWNER;
$page_description = $page_description ?? 'Astrologie eröffnet uns die Möglichkeit, uns selbst besser zu verstehen. Als aufschlussreicher Ratgeber begleitet sie uns und weist uns den Weg auf unserer individuellen Lebensreise.';
$page_url         = $page_url         ?? SITE_URL . '/';
$page_image       = $page_image       ?? SITE_URL . '/img/og-image.jpg';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page_title) ?></title>
<meta name="description" content="<?= e($page_description) ?>">
<link rel="canonical" href="<?= e($page_url) ?>">
<meta name="author" content="<?= e(SITE_OWNER) ?>">

<?php
$noindex = config('staging') || !empty($page_noindex);
?>
<meta name="robots" content="<?= $noindex ? 'noindex, nofollow' : 'index, follow' ?>">

<meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
<meta property="og:title" content="<?= e($page_title) ?>">
<meta property="og:description" content="<?= e($page_description) ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?= e($page_url) ?>">
<meta property="og:image" content="<?= e($page_image) ?>">
<meta property="og:locale" content="de_CH">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($page_title) ?>">
<meta name="twitter:description" content="<?= e($page_description) ?>">
<meta name="twitter:image" content="<?= e($page_image) ?>">

<meta name="format-detection" content="telephone=yes">

<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#ebcf87">
<meta name="msapplication-TileColor" content="#041f41">
<meta name="theme-color" content="#041f41">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="/main.css?v=<?= @filemtime(__DIR__ . '/main.css') ?: '2' ?>">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap"></noscript>

<?php require __DIR__ . '/jsonld.php'; ?>
