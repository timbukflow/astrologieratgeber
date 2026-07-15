ZUERST: DEPLOY AUF DIE TESTUMGEBUNG
===================================

Server-Anforderungen: PHP 8.0+ und Apache 2.4+ (beides bei Hostpoint Standard).

   [ ] config.php auf dem Server VON HAND anlegen
       Sie ist per .gitignore vom Repository ausgeschlossen, damit der
       Turnstile-Secret-Key nicht auf GitHub landet. Sie kommt also NICHT
       per git pull mit. Vorlage: config.example.php kopieren und die Werte
       aus der lokalen config.php übernehmen.

       Fehlt sie, läuft die Seite trotzdem — aber mit config.example.php:
       Turnstile inaktiv, Mail an den Beispielempfänger. Von aussen ist das
       nicht zu sehen. Im Server-Fehlerlog steht dann eine Zeile
       "config.php fehlt — Fallback auf config.example.php".

   [ ] Turnstile: Domain der Testumgebung im Cloudflare-Dashboard eintragen
       (Turnstile → Widget → Hostname Management).
       Fehlt sie, bricht das Widget mit Fehler 110200 ab, es entsteht kein
       Token, und NIEMAND kann buchen. Die Seite sieht dabei normal aus —
       nur das Absenden schlägt fehl.

   [ ] Testbuchung abschicken und prüfen, ob die Mail bei
       ivoschwizer@gmail.com ankommt (und nicht im Spam landet).

   Was auf der Testumgebung bereits richtig eingestellt ist:
     - staging => true      → noindex + robots.txt Disallow, Google bleibt draussen
     - mail_to  => Ivo      → Buchungen gehen zum Testen an dich
     - HTTPS/www/HSTS in der .htaccess auskommentiert → kein Zertifikat nötig


VOR DEM LIVEGANG
================

Alles Folgende ist Konfiguration, kein Code. Reihenfolge 1–3 ist Pflicht,
4–6 sind Empfehlungen.


1. config.php ausfüllen  (liegt NICHT im Git — siehe .gitignore)
   ---------------------------------------------------------------
   [ ] 'mail_to' => 'stefan.haas@skema.ch'
       ZURZEIT AUF TESTBETRIEB: Buchungen gehen an ivoschwizer@gmail.com.
       Wird das vergessen, landen echte Kundenbuchungen bei Ivo statt bei
       Stefan — und Stefan merkt nichts davon, weil das Formular sich völlig
       normal verhält. Zuerst umstellen, dann alles andere.

   [ ] 'staging' => false
       Solange true, steht auf jeder Seite ein noindex-Meta und robots.txt
       sperrt alles. Das ist der eine Schalter, der die Seite für Google
       öffnet. Ohne ihn passiert nichts, egal was sonst eingerichtet ist.

   [x] 'turnstile_site_key' / 'turnstile_secret_key'  — ist eingetragen.

   [ ] WICHTIG: Turnstile-Hostnames im Cloudflare-Dashboard ergänzen
       (Turnstile → Widget → Hostname Management).
       Ein Widget akzeptiert NUR die dort gelisteten Domains. Auf jeder
       anderen bricht es mit Fehler 110200 ab, es entsteht kein Token —
       und damit kann NIEMAND mehr buchen. Das trifft still zu: die Seite
       sieht normal aus, nur das Absenden schlägt fehl.
       Einzutragen sind:
         astrologieratgeber.ch
         www.astrologieratgeber.ch
         <die Domain der Testumgebung>
       Zum lokalen Entwickeln zusätzlich 127.0.0.1 und localhost, oder
       vorübergehend die Cloudflare-Testschlüssel verwenden
       (Site 1x00000000000000000000AA / Secret 1x0000000000000000000000000000000AA
        — bestehen immer, gehören NIE auf die Live-Seite).

   [ ] 'ga_measurement_id'  (Format G-XXXXXXXXXX)
       Solange leer, erscheint weder Analytics noch der Cookie-Banner —
       das ist beabsichtigt: ein Banner ohne Cookies wäre sinnlos.


2. .htaccess: HTTPS scharf schalten
   ---------------------------------------------------------------
   [ ] Block "HTTPS erzwingen" einkommentieren
   [ ] Block "www entfernen" einkommentieren
       Beide sind auskommentiert, weil die Testumgebung kein Zertifikat hat.
       Ohne sie sind http/https bzw. mit/ohne www doppelter Inhalt für Google.

   [ ] Strict-Transport-Security einkommentieren — aber ERST, wenn HTTPS
       nachweislich sauber läuft. Ein voreiliges max-age sperrt Besucher aus,
       wenn das Zertifikat klemmt.


3. Mailversand prüfen
   ---------------------------------------------------------------
   [ ] Eine Testbuchung über jedes Formular abschicken und prüfen, ob die
       Mail ankommt — und NICHT im Spam landet.
   [ ] SPF-Eintrag der Domain kontrollieren (Hostpoint-Panel). PHP mail()
       mit From: info@astrologieratgeber.ch geht ohne gültiges SPF/DKIM
       gerne in den Spam-Ordner. Falls das passiert: auf SMTP-Versand
       umstellen (PHPMailer) statt an mail() zu schrauben.
   [ ] Antworten testen: "Antworten" im Mailprogramm muss beim Kunden landen
       (Reply-To trägt dessen Adresse), nicht bei einem selbst.


4. Google Search Console
   ---------------------------------------------------------------
   [ ] Property anlegen und verifizieren
   [ ] Sitemap einreichen: https://astrologieratgeber.ch/sitemap.xml
       (wird dynamisch aus services.php erzeugt und ist damit immer aktuell)
   [ ] Rich-Results-Test laufen lassen: search.google.com/test/rich-results
       Erwartet werden LocalBusiness, Service und BreadcrumbList.


5. Weiterleitungen von anderen Domains
   ---------------------------------------------------------------
   [ ] Wie gehabt auf astrologieratgeber.ch zeigen lassen (301, nicht 302).


6. Offene inhaltliche Punkte
   ---------------------------------------------------------------
   [x] Preise: erledigt. Abrechnung neu auf Stundenbasis.
       Stundenansatz steht als HOURLY_RATE in bootstrap.php (aktuell 160).
       Eine Änderung dort wirkt auf alle Seiten, die Preisübersicht und das
       JSON-LD gleichzeitig.
       Der Aufwand je Angebot steht in services.php als 'hours' => 4
       und erscheint auf der Seite als "ca. 4h".

   [x] Texte: erledigt. Alle sechs Angebote haben Stefans eigene Texte.

   [ ] Bei der Astromedizin den rechtlichen Hinweis ('note') NICHT ersatzlos
       streichen. Astrologische Aussagen zu Gesundheit berühren HMG und UWG;
       ohne klare Abgrenzung zur Medizin ist die Seite angreifbar. Umformulieren
       gerne — die Abgrenzung selbst sollte stehen bleiben.
