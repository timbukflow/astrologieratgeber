<?php
require_once __DIR__ . '/bootstrap.php';

$page_title       = SITE_NAME . ' | Impressum';
$page_description = 'Impressum von Astrologieratgeber Stefan Haas, Ackerstrasse 56, 8610 Uster.';
$page_url         = SITE_URL . '/impressum';
$page_noindex     = true;
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <?php require __DIR__ . '/head.php'; ?>
</head>

<body>
    <?php require __DIR__ . '/nav.php'; ?>

    <main class="maincontent subpage datenschutz" id="main">
        <h1>Impressum</h1>

        <h2 class="gold">Verantwortlich für den Inhalt:</h2>
        <p>Astrologieratgeber<br>
        Stefan Haas<br>
        Ackerstrasse 56<br>
        8610 Uster<br><br>
        Telefon 044 442 02 23<br>
        info@astrologieratgeber.ch<br>
        <a href="https://astrologieratgeber.ch">www.astrologieratgeber.ch</a></p>

        <h2 class="gold">Copyright</h2>
        <p>Das Copyright für sämtliche Inhalte dieser Website liegt bei Astrologieratgeber<br>
        Stefan Haas, Uster.</p>

        <h2 class="gold">Konzept und Technische Umsetzung</h2>
        <p>Schwizer Design GmbH<br>
        Gallusstrasse 43<br>
        CH-9000 St. Gallen<br>
        <a href="https://schwizerdesign.ch" rel="noopener">schwizerdesign.ch</a></p>

        <h2 class="gold">Haftungshinweis</h2>
        <p>Trotz sorgfältiger inhaltlicher Kontrolle übernehmen wir keine Haftung für die Inhalte externer Links. Für den Inhalt der verlinkten Seiten sind ausschließlich deren Betreiber verantwortlich.</p>

        <h2 class="gold">Urheberrecht</h2>
        <p>Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem schweizerischen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechts bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen Gebrauch gestattet.</p>
    </main>

    <?php require __DIR__ . '/footer.php'; ?>
    <div class="starry-sky" aria-hidden="true"></div>
    <?php
    require __DIR__ . '/script.php';
    require __DIR__ . '/googleanalytics.php';
    ?>
</body>
</html>
