<?php
require_once __DIR__ . '/bootstrap.php';

$page_title       = SITE_NAME . ' | ' . SITE_OWNER;
$page_description = 'Seriöse astrologische Deutung von Stefan Haas in Uster: Geburtshoroskop, Partnerschaft, Jahresprognose, Astromedizin – für ein besseres Selbstverständnis.';
$page_url         = SITE_URL . '/';
$page_jsonld      = 'home';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <?php require __DIR__ . '/head.php'; ?>
</head>

<body>
    <?php require __DIR__ . '/nav.php'; ?>

    <main id="main">
        <section class="intro maincontent">
            <div class="sun" aria-hidden="true">
                <div class="innercirclesun"></div>
                <div class="outercirclesun">
                    <img src="img/sun-circle.svg" alt="" width="300" height="300">
                </div>
            </div>
            <p class="line intro-claim">
                Astrologie eröffnet uns die Möglichkeit, uns selbst besser zu verstehen.
                Als aufschlussreicher Ratgeber begleitet sie uns und weist uns den Weg
                auf unserer individuellen Lebensreise.
            </p>
        </section>

        <section class="maincontent">
            <h1>Astrologie&shy;ratgeber</h1>
            <p>
                Als Astrologieratgeber ist es meine Intention, Ihnen seriösen und fundierten Rat durch astrologische Deutung anzubieten. Dies eröffnet Ihnen einen umfassenderen Blick auf Ihre Situation und unterstützt Sie dabei, klare Entscheidungen für eine erfüllte Gegenwart und eine zielgerichtete Zukunft zu treffen.
            </p>
            <p>
                Astrologie ist eine uralte symbolische Sprache, entstanden aus der Beobachtung der lebendigen Natur, insbesondere des Himmels. Früher waren Menschen enger mit der Natur verbunden, daher begannen sie, diese "Sprache" zu verstehen und zu interpretieren. Seefahrer orientierten sich unter anderm am Polarstern. Heute erfassen wir die Welt oft intellektuell und technologisch, während frühere Generationen den Himmel beobachteten, um Zusammenhänge zu erkennen.
            </p>

            <div class="astrocirclecontainer">
                <img src="img/astro-circle.svg" alt="Astrologisches Horoskoprad mit Tierkreiszeichen, Häusern und Planetenpositionen"
                     width="1600" height="1600" loading="lazy" decoding="async">
            </div>

            <p>
                Unser Sonnensystem ist ein lebendiger Organismus, von dem wir ein Teil sind. Der Astrologe übersetzt die symbolische Sprache des Sonnensystems mithilfe eines spezifisch berechneten Horoskops in verständliche Worte. "Horoskop" bedeutet übersetzt "Stundenschau" oder "Blick in die Stunde". Astrologie ist eine Deutungskunst, die aus der Erkenntnis der Verbindungen zwischen Mensch und Kosmos hervorgegangen ist. Sie interpretiert die Blickbeziehungen, die die Planeten im Moment der Geburt zueinander hatten. So entsteht eine Art Röntgenaufnahme der inneren und äußeren Aspekte eines Menschen. Astrologie vermag die jedem Menschen individuelle Denk,- Gefühls-und Handlungsweise zu beleuchten, unterstützt die Selbsterkenntnis und lässt uns unsere eigene Wesensart besser verstehen.
            </p>
            <p class="line gold center">
                Astrologie kann auch Ihnen wertvolle Einsichten bieten, denn die Sterne machen geneigt - sie zwingen nicht.
            </p>
        </section>
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
