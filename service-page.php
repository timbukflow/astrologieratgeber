<?php
require_once __DIR__ . '/bootstrap.php';

$svc = service($service);

require __DIR__ . '/form.php';

$booking_confirmed = isset($_GET['ok']);

$page_title       = $svc['title'];
$page_description = $svc['description'];
$page_url         = SITE_URL . '/' . $svc['slug'];
$page_jsonld      = 'service';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <?php require __DIR__ . '/head.php'; ?>
</head>

<body>
    <?php require __DIR__ . '/nav.php'; ?>

    <main class="maincontent subpage" id="main">
        <h1><?= $svc['h1'] ?></h1>

        <?php foreach ($svc['intro'] as $paragraph): ?>
            <p><?= e($paragraph) ?></p>
        <?php endforeach; ?>

        <?php if (!empty($svc['image'])): ?>
            <div class="astromap">
                <img src="<?= e($svc['image']['src']) ?>" alt="<?= e($svc['image']['alt']) ?>"
                     width="920" height="500" loading="lazy" decoding="async">
            </div>
        <?php endif; ?>

        <?php if (!empty($svc['note'])): ?>
            <p class="note line"><?= e($svc['note']) ?></p>
        <?php endif; ?>

        <?php foreach ($svc['variants'] as $variant): ?>
            <div class="description">
                <p class="line gold dprice">
                    <strong><?= e($variant['name']) ?></strong>
                    Aufwand: <?= e(hours_label((float) $variant['hours'])) ?><br>
                    Stundenansatz: <?= e(rate_label()) ?>
                </p>
                <p class="line dwhat">
                    <strong>Was erwartet Sie</strong>
                    <?= e($variant['what']) ?>
                </p>
            </div>
        <?php endforeach; ?>

        <div class="booking" id="form">
            <p class="gold">
                <strong><?= e($svc['name']) ?> buchen</strong>
                <?= e($svc['booking_intro']) ?>
            </p>

            <?php require __DIR__ . '/form-fields.php'; ?>
        </div>
    </main>

    <?php if ($booking_confirmed): ?>
        <div id="popup" class="popup" role="dialog" aria-modal="true" aria-labelledby="popup-title">
            <h2 id="popup-title"><?= e($svc['popup_title']) ?></h2>
            <p>
                <?= e($svc['popup_text']) ?>
                <br><br>
                <?= e(SITE_OWNER) ?><br>
                <?= e(SITE_NAME) ?>
            </p>
            <button type="button" id="closePopup">Schliessen</button>
        </div>
    <?php endif; ?>

    <?php
    require __DIR__ . '/footernav.php';
    require __DIR__ . '/footer.php';
    ?>
    <div class="starry-sky" aria-hidden="true"></div>
    <?php
    require __DIR__ . '/script.php';
    require __DIR__ . '/googleanalytics.php';
    ?>
</body>
</html>
