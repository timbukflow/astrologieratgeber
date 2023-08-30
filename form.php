<?php
    // Function to sanitize user input to prevent XSS attacks
    function sanitizeInput($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    function validateForm() {
    global $vorname, $name, $geburtsort, $geburtsdatum, $geburtszeit, $email, $telefon;

    $errors = [];

    if (empty($_POST["vorname"])) {
        $errors["vorname"] = "Vorname ist erforderlich";
    } else {
        $vorname = filter_var($_POST["vorname"], FILTER_SANITIZE_STRING);
        if (empty($vorname)) {
            $errors["vorname"] = "Es sind nur Buchstaben erlaubt";
        }
    }

    if (empty($_POST["name"])) {
        $errors["name"] = "Name ist erforderlich";
    } else {
        $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
        if (empty($name)) {
            $errors["name"] = "Es sind nur Buchstaben erlaubt";
        }
    }

    if (empty($_POST["geburtsort"])) {
        $errors["geburtsort"] = "Geburtsort ist erforderlich";
    } else {
        $geburtsort = filter_var($_POST["geburtsort"], FILTER_SANITIZE_STRING);
        if (empty($geburtsort)) {
            $errors["geburtsort"] = "Es sind nur Buchstaben erlaubt";
        }
    }

    if (empty($_POST["geburtsdatum"])) {
        $errors["geburtsdatum"] = "Geburtsdatum ist erforderlich";
    } else {
        $geburtsdatum = filter_var($_POST["geburtsdatum"], FILTER_SANITIZE_STRING);
        if (empty($geburtsdatum)) {
            $errors["geburtsdatum"] = "Es sind nur Zahlen erlaubt";
        }
    }

    if (empty($_POST["geburtszeit"])) {
        $errors["geburtszeit"] = "Geburtszeit ist erforderlich";
    } else {
        $geburtszeit = filter_var($_POST["geburtszeit"], FILTER_SANITIZE_STRING);
        if (empty($geburtszeit)) {
            $errors["geburtszeit"] = "Es sind nur Zahlen erlaubt";
        }
    }

    if (empty($_POST["email"])) {
        $errors["email"] = "Email ist erforderlich";
    } else {
        $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $errors["email"] = "Diese Email Adresse ist nicht korrekt";
        }
    }

    if (empty($_POST["telefon"])) {
        $errors["telefon"] = "Telefonnummer ist erforderlich";
    } else {
        $telefon = $_POST["telefon"];
        $telefon = preg_replace('/[^0-9]/', '', $telefon);
        
        if (strlen($telefon) < 10) {
            $errors["telefon"] = "Ungültige Telefonnummer";
        }
    }

    return $errors;
}

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (isset($_POST["anmeldung_typ"])) {
            $anmeldung_typ = $_POST["anmeldung_typ"];
            $anmeldung_bezeichnung = "";
    
            if ($anmeldung_typ == "geburtshoroskop") {
                $anmeldung_bezeichnung = "Geburtshoroskop";
                // Hier die Aktion für die Ball-Anmeldung
                // ...
            } elseif ($anmeldung_typ == "sonne") {
                $anmeldung_bezeichnung = "Sonne-Anmeldung";
                // Hier die Aktion für die Sonne-Anmeldung
                // ...
            } elseif ($anmeldung_typ == "tee") {
                $anmeldung_bezeichnung = "Tee-Anmeldung";
                // Hier die Aktion für die Tee-Anmeldung
                // ...
            }
        }
        $errors = validateForm();

        if (empty($errors)) {
            $message_body = "";
            unset($_POST["submit"]);
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    $value = implode(", ", $value);
                }
                $message_body = "Anmeldung zur Veranstaltung: " . $anmeldung_bezeichnung . "\n\n";
                $message_body .= "Vorname: " . sanitizeInput($vorname) . "\n";
                $message_body .= "Name: " . sanitizeInput($name) . "\n";
                $message_body .= "Geburtsort: " . sanitizeInput($geburtsort) . "\n";
                $message_body .= "Geburtsdatum: " . sanitizeInput($geburtsdatum) . "\n";
                $message_body .= "Geburtszeit: " . sanitizeInput($geburtszeit) . "\n";
                $message_body .= "Email: " . sanitizeInput($email) . "\n";
                $message_body .= "Telefon: " . sanitizeInput($telefon) . "\n"; 
            }

            $headers = "From: info@astrologieratgeber.ch";
            $to = "ivoschwizer@gmail.com";
            $subject = "Anmeldung zur Veranstaltung: " . $anmeldung_bezeichnung;
            
            $headers .= "\r\nContent-Type: text/plain; charset=utf-8\r\n";
            
            if (mail($to, $subject, $message_body, $headers)){
                $success = "";
                $vorname = $name = $geburtsort = $geburtsdatum = $geburtszeit = $email = $telefon = "";
            }
        } else {
            $vorname = isset($_POST["vorname"]) ? $_POST["vorname"] : "";
            $name = isset($_POST["name"]) ? $_POST["name"] : "";
            $geburtsort = isset($_POST["geburtsort"]) ? $_POST["geburtsort"] : "";
            $geburtsdatum = isset($_POST["geburtsdatum"]) ? $_POST["geburtsdatum"] : "";
            $geburtszeit = isset($_POST["geburtszeit"]) ? $_POST["geburtszeit"] : "";
            $email = isset($_POST["email"]) ? $_POST["email"] : "";
            $telefon = isset($_POST["telefon"]) ? $_POST["telefon"] : "";
        }
    }
?>