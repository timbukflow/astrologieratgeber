<!DOCTYPE html>
<html lang="de">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# place: http://ogp.me/ns/place#">

    <meta charset="UTF-8">
    <title>Astrologieratgeber | Stundenastrologie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Erfahren Sie mehr über die Stundenastrologische Konstellation, eine präzise und verifizierbare astrologische Methode, die ohne Geburtshoroskop auskommt. Erhalten Sie Antworten auf Ihre Fragen und lassen Sie sich von den momentanen Zeitqualitäten leiten.">
    <meta name="keywords" content="Stundenastrologische Konstellation, Stundenastrologie, Stundenhoroskop, astrologische Methode, Frage und Antwort, Zeitqualität, persönliche Einverständnis, Lösungsfindung">
    <link rel="canonical" href="https://astrologieratgeber.ch/stundenastrologie" />
    <?php require_once 'head.php'; ?>
</head>

<body>
    <section class="maincontent subpage">
        <h1>Stundenastrologie</h1>
        <p>
            In dem Moment, in welchem eine Frage auftaucht und verstanden wird, ist sie «geboren». Diese «Stundenastrologische Konstellation» wird in seiner momentanen Zeitqualität festgehalten und gedeutet. Stundenastrologie ist die älteste astrologische Technik, die ohne Geburtshoroskop auskommt und am meisten auf seine Richtigkeit überprüfbar ist. Das Stundenhoroskop spiegelt gewissermassen die eigenen Motive und Empfindungen wieder, welche zu der gegebenen Situation und der sich daraus resultierenden Frage passen. Dadurch wird man schrittweise zu der (eigenen) Lösung geführt. Das unbestimmte Gefühl, welches zur Frage geführt hat, klärt sich. Auf konkrete Fragen erhält man ganz konkrete Antworten. Ich behalte mir vor, bestimmte Fragen nicht anzunehmen. 
        </p> 
        <p>
            Wenn es sich um Fragen im Zusammenhang mit weiteren Personen handelt, erwarte ich das persönliche Einverständnis dieser Personen.
        </p>
        
        <div class="description">
            <p class="line gold dprice">
                <strong>Stundenastrologie</strong>
                Preis: 150 Franken
            </p>
            <p class="line dwhat">
                <strong>Was erwartet Sie</strong> 
                Sie stellen mir Ihre Frage und erläutern mögliche wichtige Hintergrundinformationen. Sobald ich Ihre Frage vollständig verstanden habe, erstelle ich das Stundenhoroskop. Anschliessend nehmen wir uns 45 Minuten Zeit für eine persönliche Besprechung, die auf Wunsch als "Voice Record" festgehalten werden kann. Diese Session kann auch bequem online über Plattformen wie Zoom, Teams oder Skype abgehalten werden.
            </p>
        </div>

        <div class="booking" id="form">
            <p class="gold">
                <strong>Stundenastrologie Buchen</strong>
                Bitte verwenden Sie das Formular, um Ihre Stundenastrologie zu buchen. Innerhalb von drei Tagen werde ich mich mit Ihnen in Verbindung setzen, um einen geeigneten Termin in der nächsten Woche zu vereinbaren.
            </p>

            <?php require_once('form.php'); ?>
            <form id="contact" method="post" action="#form" novalidate>
                <input type="hidden" name="anmeldung_typ" value="stundenastrologie">           
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
                    <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Stundenastrologie buchen</button>
                </fieldset>
            </form>
        </div>    
    </section>
    <div id="popup" class="popup">
        <h3>Vielen Dank für Ihre Buchung der Stundenastrologie!</h3> 
        <p>
            Innerhalb von drei Tagen werde ich mich mit Ihnen in Verbindung setzen, um einen geeigneten Termin in der nächsten Woche zu vereinbaren.<br><br>
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
