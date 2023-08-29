<!DOCTYPE html>
<html lang="de">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# place: http://ogp.me/ns/place#">

    <meta charset="UTF-8">
    <title>Astrologieratgeber | Geburtshoroskop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Entdecken Sie Ihr Geburtshoroskop: Einzigartige Karte der kosmischen Konstellationen bei Ihrer Geburt. Erfahren Sie, wie es Einsicht in Charakter, Emotionen und Lebensrichtung bietet – für bewusstes und erfülltes Leben.">
    <meta name="keywords" content="Geburtshoroskop, kosmische Konstellationen, Persönlichkeit, Lebensrichtung, astronomische Einflüsse, Charakterzüge, Emotionen, Selbstentdeckung, Potenzialentfaltung, bewusstes Leben">
    <link rel="canonical" href="https://astrologieratgeber.ch/geburtshoroskop" />
    <?php require_once 'head.php'; ?>
</head>

<body>
    <section class="maincontent subpage">
        <h1>Geburtshoroskop</h1>
        <p>
            Das Geburtshoroskop ist eine einzigartige Karte der kosmischen Konstellationen zum Zeitpunkt Ihrer Geburt. Es zeigt die Positionen von Planeten, Sonne und Mond in Bezug auf Ihre Geburtszeit und -ort. Diese astronomischen Konstellationen beeinflussen Ihre Charakterzüge, Emotionen und Lebensrichtungen. Das Geburtshoroskop bietet wertvolle Einblicke in Ihre Persönlichkeit und Lebensrichtung, um bewusster und erfüllter zu leben.
        </p> 
        <p>
            Indem es Licht auf verborgene Muster wirft, kann Ihr Geburtshoroskop Ihnen helfen, sich selbst besser zu verstehen, Potenziale zu entfalten und Herausforderungen zu meistern. Es ist eine Karte zu Ihrem Innersten und ein Instrument zur Selbstentdeckung.
        </p>
        
        <div class="descriptioncont">
            <p class="line gold dprice">
                <strong>Geburtshoroskop</strong>
                Preis: 590 Franken
            </p>
            <p class="line dwhat">
                <strong>Was erwartet Sie</strong> 
                Als Ihr Astrologe studiere und analysiere ich eine Stunde Ihr Geburtshoroskop. Anschliessend nehmen wir uns drei Stunden Zeit für eine persönliche Besprechung, die auf Wunsch als "Voice Record" festgehalten werden kann. Diese Session kann auch bequem online über Plattformen wie Zoom, Teams oder Skype abgehalten werden.
            </p>
        </div>

        <div class="descriptioncont">
            <p class="line gold dprice">
                <strong>Geburtshoroskop <br> Spezial</strong>
                Preis: 690 Franken <br>
            </p>
            <p class="line dwhat">
                <strong>Was erwartet Sie</strong> 
                Als Ihr Astrologe studiere und analysiere ich zwei Stunden Ihr Geburtshoroskop bis ins Detail. Anschliessend nehmen wir uns drei Stunden Zeit für eine persönliche Besprechung, die auf Wunsch als "Voice Record" festgehalten werden kann. Diese Session kann auch bequem online über Plattformen wie Zoom, Teams oder Skype abgehalten werden. 
            </p>
        </div>

        <div class="bookingcont">
            <p class="gold">
                <strong>Geburtshoroskop Buchen</strong>
                Bitte verwenden Sie das Formular, um Ihr Geburtshoroskop zu buchen. Innerhalb von drei Tagen werde ich mich mit Ihnen in Verbindung setzen, um einen geeigneten Termin innerhalb der nächsten drei Wochen zu vereinbaren.
            </p>

            <?php require_once('form.php'); ?>

            <form id="contact" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" novalidate>

              <fieldset>
                <input placeholder="Vorname&#42;" type="text" name="vorname" value="<?= htmlspecialchars($vorname) ?>" tabindex="2" autofocus>
                <span class="error"><?= isset($errors["vorname"]) ? htmlspecialchars($errors["vorname"]) : htmlspecialchars($vorname_error) ?></span>
              </fieldset>

              <fieldset>
                <input placeholder="Name&#42;" type="text" name="name" value="<?= htmlspecialchars($name) ?>" tabindex="3">
                <span class="error"><?= isset($errors["name"]) ? htmlspecialchars($errors["name"]) : htmlspecialchars($name_error) ?></span>
              </fieldset>

              <fieldset>
                <input placeholder="Geburtsort&#42;" type="text" name="geburtsort" value="<?= htmlspecialchars($geburtsort) ?>" tabindex="4">
                <span class="error"><?= isset($errors["geburtsort"]) ? htmlspecialchars($errors["geburtsort"]) : htmlspecialchars($geburtsort_error) ?></span>
              </fieldset>

              <fieldset>
                <input placeholder="Geburtsdatum (01.01.2001)&#42; " type="text" name="geburtsdatum" value="<?= htmlspecialchars($geburtsdatum) ?>" tabindex="5">
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
                <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Geburtshoroskop Buchen</button>
              </fieldset>
            </form>

            <div id="popup" class="popup">
              <h1>Vielen Dank für Ihr Interesse!</h1> 
              <p>Ihre An- oder Abmeldung haben wir erhalten. Eine persönliche Bestätigung Ihrer Anmeldung erhalten Sie in den nächsten Tagen per E-Mail.<br><br>
              Herzliche Grüsse <br> 
              Jonas Müller <br>
              Leiter Niederlassung Bern</p>
              <button id="closePopup">Alles klar!</button>
            </div>

        </div>
        
    </section>
      
    
    <?php require_once 'nav.php'; ?>
    <?php require_once 'footer.php'; ?>
    <div class="starry-sky"></div>
    <?php require_once 'script.php'; ?>
    <?php require_once 'googleanalytics.php'; ?>
</body>
</html>
