<!DOCTYPE html>
<html lang="de">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# place: http://ogp.me/ns/place#">

    <meta charset="UTF-8">
    <title>Astrologieratgeber | Relokationshoroskop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Erfahren Sie mehr über Relokation in der Astrologie und wie das Relokationshoroskop Ihnen Einblicke in die Veränderungen an Ihrem neuen Wohnort geben kann.">
    <meta name="keywords" content="Relokation Astrologie, Relokationshoroskop, Geburtshoroskop Ortsveränderung, astrologische Einflüsse beim Umzug">
    <link rel="canonical" href="https://astrologieratgeber.ch/relokationshoroskop" />
    <?php require_once 'head.php'; ?>
</head>

<body>
    <section class="maincontent subpage">
        <h1>Relokations&shy;horoskop</h1>
        <p>
            Die Relokation wird in der Astrologie als eine Ortsveränderung bezeichnet. Die Grundlage dafür ist wiederum das Geburtshoroskop (Radixhoroskop) aus dem das Relokationshoroskop abgeleitet wird. Dies sollte man erst tun, wenn man sich bereits entschieden hat, dass man seinen Wohnort wechselt. Mit dem Umzug tritt das Relokationshoroskop in Kraft. Das Geburtshoroskopes wird dann auf den neuen Ort, an dem man wohnen wird, berechnet. Bei naheliegenden Orten sind Unterscheide zum Geburtshoroskop oft nur gering, jedoch kann bereits der Aszendent wechseln und so ein zusätzliches Bild auf die neue Lebenssituation aufzeigen. Bei weit entfernten Orten ist die Häusereinteilung meist völlig anders und zeigen uns umso deutlicher die neuen astrologischen Einflüsse auf. Die Planetenkonstellationen und Aspekte bleiben immer dieselben. 
        </p> 
        <p>
            Ebenfalls nimmt jeder Mensch sein Geburtsbild überall hin mit, jedoch zeigt uns das Relokationshoroskop die neuen verstärkenden und schwächenden Färbungen und Prägungen auf den besagten Ort klar auf.
        </p>
        
        <div class="description">
            <p class="line gold dprice">
                <strong>Relokationshoroskop</strong>
                Preis: 290 Franken
            </p>
            <p class="line dwhat">
                <strong>Was erwartet Sie</strong> 
                Als Ihr Astrologe studiere und analysiere ich eine Stunde Ihr Relokationshoroskop und vergleiche es mit Ihrem Geburtshoroskop. Anschliessend nehmen wir uns 90 Minuten Zeit für eine persönliche Besprechung, die auf Wunsch als "Voice Record" festgehalten werden kann. Diese Session kann auch bequem online über Plattformen wie Zoom, Teams oder Skype abgehalten werden.
            </p>
        </div>

        <div class="booking" id="form">
            <p class="gold">
                <strong>Relokationshoroskop Buchen</strong>
                Bitte verwenden Sie das Formular, um Ihr Relokationshoroskop zu buchen. Innerhalb von drei Tagen werde ich mich mit Ihnen in Verbindung setzen, um einen geeigneten Termin in den nächsten drei Wochen zu vereinbaren.
            </p>

            <?php require_once('form.php'); ?>
            <form id="contact" method="post" action="#form" novalidate>
                <input type="hidden" name="anmeldung_typ" value="relokationshoroskop">           
                <fieldset>
                    <input placeholder="Vorname&#42;" type="text" name="vorname" value="<?= htmlspecialchars($vorname) ?>" tabindex="1">
                    <span class="error"><?= isset($errors["vorname"]) ? htmlspecialchars($errors["vorname"]) : htmlspecialchars($vorname_error) ?></span>
                </fieldset>
                <fieldset>
                    <input placeholder="Name&#42;" type="text" name="name" value="<?= htmlspecialchars($name) ?>" tabindex="2">
                    <span class="error"><?= isset($errors["name"]) ? htmlspecialchars($errors["name"]) : htmlspecialchars($name_error) ?></span>
                </fieldset>
                <fieldset>
                    <input placeholder="Geburtsort&#42;" type="text" name="geburtsort" value="<?= htmlspecialchars($geburtsort) ?>" tabindex="3">
                    <span class="error"><?= isset($errors["geburtsort"]) ? htmlspecialchars($errors["geburtsort"]) : htmlspecialchars($geburtsort_error) ?></span>
                </fieldset>
                <fieldset>
                    <input placeholder="Geburtsdatum (01.01.2001)&#42; " type="text" name="geburtsdatum" value="<?= htmlspecialchars($geburtsdatum) ?>" tabindex="4">
                    <span class="error"><?= isset($errors["geburtsdatum"]) ? htmlspecialchars($errors["geburtsdatum"]) : htmlspecialchars($geburtsdatum_error) ?></span>
                </fieldset>
                <fieldset>
                    <input placeholder="Geburtszeit (von amtlichem Geburtsschein)&#42; " type="text" name="geburtszeit" value="<?= htmlspecialchars($geburtszeit) ?>" tabindex="5">
                    <span class="error"><?= isset($errors["geburtszeit"]) ? htmlspecialchars($errors["geburtszeit"]) : htmlspecialchars($geburtszeit_error) ?></span>
                </fieldset>
                <fieldset>
                    <input placeholder="Email&#42;" type="text" name="email" value="<?= htmlspecialchars($email) ?>" tabindex="6">
                    <span class="error"><?= isset($errors["email"]) ? htmlspecialchars($errors["email"]) : htmlspecialchars($email_error) ?></span>
                </fieldset>
                <fieldset>
                    <input placeholder="Telefon&#42;" type="text" name="telefon" value="<?= htmlspecialchars($telefon) ?>" tabindex="7">
                    <span class="error"><?= isset($errors["telefon"]) ? htmlspecialchars($errors["telefon"]) : htmlspecialchars($telefon_error) ?></span>
                </fieldset>
                <fieldset>
                    <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Relokationshoroskop buchen</button>
                </fieldset>
            </form>
        </div>    
    </section>
    <div id="popup" class="popup">
        <h3>Vielen Dank für Ihre Buchung des Relokationshoroskops!</h3> 
        <p>
            Innerhalb von drei Tagen werde ich mich mit Ihnen in Verbindung setzen, um einen geeigneten Termin in den nächsten drei Wochen zu vereinbaren.<br><br>
            Stefan Haas <br>
            Astrologieratgeber
        </p>
        <button id="closePopup">Schliessen</button>
    </div>
    <script>
        function toggleBlur() {
            var subpage = document.querySelector('.subpage');
            subpage.classList.toggle('blurpop');
            
            var body = document.body;
            body.classList.toggle('freeze');
        }

        function showPopup() {
            var popup = document.getElementById('popup');
            popup.style.display = 'block';
            toggleBlur();
        }

        function closePopup() {
            var popup = document.getElementById('popup');
            popup.style.display = 'none';
            toggleBlur();
        }

        document.getElementById('closePopup').addEventListener('click', function() {
            closePopup();
        });
        <?php if (isset($success)) { ?>
            showPopup();
        <?php } ?>
    </script>
      
    
    <?php require_once 'nav.php'; ?>
    <?php require_once 'footernav.php'; ?>
    <?php require_once 'footer.php'; ?>
    <div class="starry-sky"></div>
    <?php require_once 'script.php'; ?>
    <?php require_once 'googleanalytics.php'; ?>
</body>
</html>
