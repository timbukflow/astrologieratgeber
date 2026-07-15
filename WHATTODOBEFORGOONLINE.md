ZUERST: DEPLOY AUF DIE TESTUMGEBUNG
===================================

Server-Anforderungen: PHP 8.0+ und Apache 2.4+ (beides bei Hostpoint Standard).

   [ ] config.php auf dem Server VON HAND anlegen
       Sie ist per .gitignore vom Repository ausgeschlossen, damit der
       Turnstile-Secret-Key nicht auf GitHub landet — sie kommt also NICHT
       per git pull mit.

       Fehlt sie oder fehlt ein Schlüssel darin, bricht die Seite mit einer
       500-Meldung ab und schreibt "KONFIGURATIONSFEHLER: ..." ins Fehlerlog.
       Das ist Absicht: besser eine Seite, die sichtbar streikt, als eine, die
       stillschweigend ohne Turnstile läuft und Buchungen falsch zustellt.

       ── Vorlage: config.php ──────────────────────────────────────────
       <?php
       return [
           'turnstile_site_key'   => '0x4AAA…',   // Cloudflare → Turnstile
           'turnstile_secret_key' => '0x4AAA…',   // geheim, nie ins Frontend
           'ga_measurement_id'    => '',          // G-XXXXXXXXXX, leer = kein Analytics
           'mail_to'              => 'stefan.haas@skema.ch',
           'mail_from'            => 'info@astrologieratgeber.ch',
           'staging'              => true,        // false = für Google freigeben
       ];
       ─────────────────────────────────────────────────────────────────
       Alle sechs Schlüssel müssen vorhanden sein. Die echten Werte stehen
       in Ivos lokaler config.php.

   [x] Turnstile: Domain der Testumgebung ist im Cloudflare-Dashboard
       hinterlegt (Turnstile → Widget → Hostname Management).

   [ ] Testbuchung abschicken und prüfen, ob die Mail bei
       stefan.haas@skema.ch ankommt (und nicht im Spam landet).
       Achtung: Buchungen von der Testumgebung landen damit bei Stefan.
       Zum Testen ohne ihn zu stören: mail_to vorübergehend auf die eigene
       Adresse setzen.

   Was auf der Testumgebung bereits richtig eingestellt ist:
     - staging => true   → noindex + robots.txt Disallow, Google bleibt draussen
     - HTTPS/www/HSTS in der .htaccess auskommentiert → kein Zertifikat nötig


VOR DEM LIVEGANG
================

Alles Folgende ist Konfiguration, kein Code. Reihenfolge 1–3 ist Pflicht,
4–6 sind Empfehlungen.


1. config.php ausfüllen  (liegt NICHT im Git — siehe .gitignore)
   ---------------------------------------------------------------
   [x] 'mail_to' => 'stefan.haas@skema.ch'  — steht richtig.
       Falls zwischenzeitlich zum Testen umgestellt: unbedingt zurücksetzen.
       Wird das vergessen, landen echte Kundenbuchungen woanders — und Stefan
       merkt nichts davon, weil das Formular sich völlig normal verhält.

   [ ] 'staging' => false
       Solange true, steht auf jeder Seite ein noindex-Meta und robots.txt
       sperrt alles. Das ist der eine Schalter, der die Seite für Google
       öffnet. Ohne ihn passiert nichts, egal was sonst eingerichtet ist.

   [x] 'turnstile_site_key' / 'turnstile_secret_key'  — ist eingetragen.

   [ ] Turnstile-Hostnames im Cloudflare-Dashboard vervollständigen
       (Turnstile → Widget → Hostname Management).
       Die Testdomain ist bereits eingetragen. Für den Livegang fehlen noch:
         astrologieratgeber.ch
         www.astrologieratgeber.ch
       Ohne sie bricht das Widget mit Fehler 110200 ab, es entsteht kein
       Token — und NIEMAND kann buchen. Das trifft still zu: die Seite sieht
       normal aus, nur das Absenden schlägt fehl.

   [ ] Danach die Testdomain aus der Hostname-Liste ENTFERNEN, damit das
       Widget nicht länger von der Testumgebung aus nutzbar ist.

       Zum lokalen Entwickeln: 127.0.0.1 eintragen oder die
       Cloudflare-Testschlüssel verwenden
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
