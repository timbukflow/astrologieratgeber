<?php
require_once __DIR__ . '/bootstrap.php';

$page_title       = SITE_NAME . ' | Über mich';
$page_description = 'Stefan Haas, Astrologe in Uster: seit 2015 in der Astrologie, mit Ausbildung in psychologischer Astrologie. Mein Weg und mein Verständnis der Deutungskunst.';
$page_url         = SITE_URL . '/uebermich';
$page_jsonld      = 'about';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <?php require __DIR__ . '/head.php'; ?>
</head>

<body>
    <?php require __DIR__ . '/nav.php'; ?>

    <main class="maincontent subpage" id="main">
        <h1>Über mich</h1>
        <p>
            Mein Zugang zur Astrologie begann 2015 – ausgelöst durch die präzisen Deutungen des Astrologen Matthias Häberli. Aus anfänglichem Interesse entwickelte sich eine fundierte Auseinandersetzung mit der Horoskopdeutung.
        </p>
        <p>
            Seitdem bilde ich mich kontinuierlich durch Selbststudium, Ausbildungen in psychologischer Astrologie und persönlichem Einzelunterricht weiter.
        </p>
        <p>
            In meiner Arbeit als Med. Masseur und Schulleiter der SKEMA Kampfkunstschule Uster habe ich über die Jahre viele Horoskope analysiert. Dabei wird mir immer wieder der Wert der Astrologie für Orientierung, Sinnfindung und persönliche Entwicklung bewusst.
        </p>
        <p>
            Astrologie verstehe ich als Ratgeber für konkrete Lebensfragen – vergleichbar mit einem inneren „Wetterbericht“, der aufzeigt, wo wir aktuell stehen.
        </p>
        <p>
            Gleichzeitig fordert sie uns dazu auf, unser Schicksal in die eigenen Hände zu nehmen und Verantwortung für unser Tun und Handeln zu übernehmen.
        </p>
        <p>
            In der Gegenwart legen wir das Fundament für unsere Zukunft. Je klarer wir unsere Denk-, Fühl- und Handlungsmuster erkennen, desto weiser können wir auch herausfordernde Zeiten meistern.
        </p>
        <p class="line gold center">
            <?= e(SITE_OWNER) ?> <br>
            Ihr Astrologieratgeber
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
