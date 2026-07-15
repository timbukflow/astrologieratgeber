<?php
require_once __DIR__ . '/bootstrap.php';

$page_title       = SITE_NAME . ' | Preise und Angebote';
$page_description = 'Alle astrologischen Angebote von Stefan Haas mit Aufwand und Stundenansatz: Geburtshoroskop, Partnerschaft, Jahresprognose, Astromedizin, Relokation.';
$page_url         = SITE_URL . '/preise';
$page_jsonld      = 'offers';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <?php require __DIR__ . '/head.php'; ?>
</head>

<body>
    <?php require __DIR__ . '/nav.php'; ?>

    <main class="maincontent subpage" id="main">
        <h1>Preise und Angebote</h1>

        <div class="preiscontainer">
            <?php foreach (services() as $slug => $svc_item): ?>
                <?php foreach ($svc_item['variants'] as $variant): ?>
                    <div class="preislayer">
                        <h2 class="gold"><?= e($variant['name']) ?></h2>
                        <p><?= e($variant['summary']) ?></p>
                        <p class="gold aufwand">
                            <span>Aufwand: <?= e(hours_label((float) $variant['hours'])) ?></span>
                            <span>Stundenansatz: <?= e(rate_label()) ?></span>
                        </p>
                        <div class="payBtncont">
                            <a class="payBtn" href="<?= e($slug) ?>#form">Buchen</a>
                            <a class="payBtn bBtn" href="<?= e($slug) ?>">Angebot</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>

        <p class="line gold center">
            Die Bezahlung erfolgt nach der Terminvereinbarung. Sie erhalten von mir
            einen persönlichen Zahlungslink.
        </p>
    </main>

    <?php
    require __DIR__ . '/footer.php';
    ?>
    <div class="starry-sky" aria-hidden="true"></div>
    <?php
    require __DIR__ . '/script.php';
    require __DIR__ . '/googleanalytics.php';
    ?>
</body>
</html>
