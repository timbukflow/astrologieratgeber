<?php
require_once __DIR__ . '/bootstrap.php';

http_response_code(404);

$page_title       = SITE_NAME . ' | Seite nicht gefunden';
$page_description = 'Diese Seite existiert nicht.';
$page_url         = SITE_URL . '/';
$page_noindex     = true;
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <?php require __DIR__ . '/head.php'; ?>
</head>

<body>
    <?php require __DIR__ . '/nav.php'; ?>

    <main class="maincontent subpage" id="main">
        <h1>Seite nicht gefunden</h1>
        <p>
            Die aufgerufene Seite gibt es nicht – möglicherweise wurde sie verschoben
            oder der Link enthält einen Tippfehler.
        </p>
        <p class="line gold">
            Hier finden Sie weiter:
        </p>
        <ul class="notfound-list">
            <li><a href="index">Zur Startseite</a></li>
            <li><a href="preise">Preise und Angebote</a></li>
            <li><a href="uebermich">Über mich</a></li>
        </ul>
        <p>
            Sie erreichen mich auch direkt unter
            <a class="gold" href="tel:+41444420223">044 442 02 23</a> oder
            <a class="gold" href="mailto:info@astrologieratgeber.ch">info@astrologieratgeber.ch</a>.
        </p>
    </main>

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
