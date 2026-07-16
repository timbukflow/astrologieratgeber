<?php
const RATE_LIMIT_WINDOW = 3600;
const MAX_SUBMISSIONS   = 3;
const MIN_FILL_SECONDS  = 3;

const WUNSCHTAGE = [
    'mo' => 'Montag',
    'di' => 'Dienstag',
    'mi' => 'Mittwoch',
    'do' => 'Donnerstag',
    'fr' => 'Freitag',
];

/** Feste Sprechzeit — wird angezeigt, nicht abgefragt. */
const TERMINZEIT = 'Termine finden vormittags zwischen 8 und 12 Uhr statt.';

$errors = [];

const MAX_FRAGE_LAENGE = 500;

$text_fields = [
    'vorname', 'name', 'geburtsort', 'geburtsdatum', 'geburtszeit',
    'email', 'telefon', 'frage1', 'frage2', 'frage3', 'nachricht',
];
if (!empty($svc['partner_fields'])) {
    $text_fields = array_merge($text_fields, [
        'partner_name', 'partner_geburtsort', 'partner_geburtsdatum', 'partner_geburtszeit',
    ]);
}

$form_values = array_fill_keys($text_fields, '');
$form_values['wunschtage'] = [];

function valid_date(string $value): bool
{
    if (!preg_match('/^(\d{1,2})\.(\d{1,2})\.(\d{4})$/', trim($value), $m)) {
        return false;
    }
    return checkdate((int) $m[2], (int) $m[1], (int) $m[3])
        && (int) $m[3] >= 1900
        && (int) $m[3] <= (int) date('Y');
}

function valid_time(string $value): bool
{
    return (bool) preg_match('/^([01]?\d|2[0-3])[:.][0-5]\d$/', trim($value));
}

function pick_options(mixed $input, array $allowed): array
{
    if (!is_array($input)) {
        return [];
    }
    return array_values(array_intersect($input, array_keys($allowed)));
}

function option_labels(array $keys, array $allowed): string
{
    if (!$keys) {
        return 'keine Angabe';
    }
    return implode(', ', array_map(static fn(string $k): string => $allowed[$k], $keys));
}

function mail_header_safe(string $value): string
{
    return trim(str_replace(["\r", "\n", "%0a", "%0d"], '', $value));
}

function turnstile_passed(string $token, string $remote_ip): bool
{
    $payload = http_build_query([
        'secret'   => config('turnstile_secret_key'),
        'response' => $token,
        'remoteip' => $remote_ip,
    ]);

    $context = stream_context_create(['http' => [
        'method'        => 'POST',
        'header'        => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content'       => $payload,
        'timeout'       => 8,
        'ignore_errors' => true,
    ]]);

    $raw = @file_get_contents(
        'https://challenges.cloudflare.com/turnstile/v0/siteverify',
        false,
        $context
    );

    if ($raw === false) {
        error_log('Turnstile: Verifizierung nicht erreichbar, Anfrage durchgelassen.');
        return true;
    }

    return (bool) (json_decode($raw, true)['success'] ?? false);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return;
}

if (!csrf_valid($_POST['csrf_token'] ?? null)) {
    $errors['form'] = 'Ihre Sitzung ist abgelaufen. Bitte senden Sie das Formular erneut ab.';
}

$looks_like_bot = false;

if (!empty($_POST['website'])) {
    $looks_like_bot = true;
    error_log('Buchungsformular: Honeypot ausgeloest.');
}

$rendered_at = (int) ($_POST['rendered_at'] ?? 0);
if ($rendered_at > 0 && (time() - $rendered_at) < MIN_FILL_SECONDS) {
    $looks_like_bot = true;
    error_log('Buchungsformular: Zeitfalle ausgeloest.');
}

if ($looks_like_bot) {
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?ok=1#form');
    exit;
}

$_SESSION['submissions'] = array_values(array_filter(
    $_SESSION['submissions'] ?? [],
    static fn(int $t): bool => $t > time() - RATE_LIMIT_WINDOW
));

if (count($_SESSION['submissions']) >= MAX_SUBMISSIONS) {
    $errors['form'] = 'Es sind bereits mehrere Buchungen von Ihnen eingegangen. '
        . 'Bitte melden Sie sich direkt unter info@astrologieratgeber.ch.';
}

foreach ($text_fields as $field) {
    $form_values[$field] = trim((string) ($_POST[$field] ?? ''));
}

$form_values['wunschtage'] = pick_options($_POST['wunschtage'] ?? [], WUNSCHTAGE);

$required_labels = [
    'vorname'      => 'Vorname',
    'name'         => 'Name',
    'geburtsort'   => 'Geburtsort',
    'geburtsdatum' => 'Geburtsdatum',
    'email'        => 'Email',
    'telefon'      => 'Telefon',
];
if (!empty($svc['partner_fields'])) {
    $required_labels += [
        'partner_name'         => 'Name der zweiten Person',
        'partner_geburtsort'   => 'Geburtsort der zweiten Person',
        'partner_geburtsdatum' => 'Geburtsdatum der zweiten Person',
    ];
}

foreach ($required_labels as $field => $label) {
    if ($form_values[$field] === '') {
        $errors[$field] = $label . ' ist erforderlich';
    }
}

foreach (['geburtsdatum', 'partner_geburtsdatum'] as $field) {
    if (!isset($errors[$field]) && isset($form_values[$field]) && $form_values[$field] !== ''
        && !valid_date($form_values[$field])) {
        $errors[$field] = 'Bitte im Format 01.01.2001 angeben';
    }
}

foreach (['geburtszeit', 'partner_geburtszeit'] as $field) {
    if (!isset($errors[$field]) && isset($form_values[$field]) && $form_values[$field] !== ''
        && !valid_time($form_values[$field])) {
        $errors[$field] = 'Bitte im Format 14:30 angeben';
    }
}

if (!isset($errors['email']) && !filter_var($form_values['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Diese Email Adresse ist nicht korrekt';
}

if (!isset($errors['telefon'])) {
    $digits = preg_replace('/[^0-9]/', '', $form_values['telefon']);
    if (strlen($digits) < 8 || strlen($digits) > 15) {
        $errors['telefon'] = 'Ungültige Telefonnummer';
    }
}

foreach (['frage1', 'frage2', 'frage3'] as $field) {
    if (mb_strlen($form_values[$field]) > MAX_FRAGE_LAENGE) {
        $errors[$field] = 'Bitte fassen Sie die Frage kürzer (max. ' . MAX_FRAGE_LAENGE . ' Zeichen)';
    }
}

if (mb_strlen($form_values['nachricht']) > 2000) {
    $errors['nachricht'] = 'Bitte fassen Sie sich etwas kürzer (max. 2000 Zeichen)';
}

if (!$errors && turnstile_enabled()) {
    $token = (string) ($_POST['cf-turnstile-response'] ?? '');
    if ($token === '' || !turnstile_passed($token, $_SERVER['REMOTE_ADDR'] ?? '')) {
        $errors['form'] = 'Die Sicherheitsprüfung ist fehlgeschlagen. Bitte versuchen Sie es erneut.';
    }
}

if ($errors) {
    return;
}

$lines = ['Buchung: ' . $svc['name'], ''];
$lines[] = 'Vorname: '      . $form_values['vorname'];
$lines[] = 'Name: '         . $form_values['name'];
$lines[] = 'Geburtsort: '   . $form_values['geburtsort'];
$lines[] = 'Geburtsdatum: ' . $form_values['geburtsdatum'];
$lines[] = 'Geburtszeit: '  . ($form_values['geburtszeit'] ?: 'keine Angabe');
$lines[] = 'Email: '        . $form_values['email'];
$lines[] = 'Telefon: '      . $form_values['telefon'];

if (!empty($svc['partner_fields'])) {
    $lines[] = '';
    $lines[] = '— Zweite Person —';
    $lines[] = 'Name: '         . $form_values['partner_name'];
    $lines[] = 'Geburtsort: '   . $form_values['partner_geburtsort'];
    $lines[] = 'Geburtsdatum: ' . $form_values['partner_geburtsdatum'];
    $lines[] = 'Geburtszeit: '  . ($form_values['partner_geburtszeit'] ?: 'keine Angabe');
}

$fragen = array_values(array_filter([
    $form_values['frage1'],
    $form_values['frage2'],
    $form_values['frage3'],
], static fn(string $f): bool => $f !== ''));

$lines[] = '';
$lines[] = '— Anliegen —';
if ($fragen) {
    foreach ($fragen as $i => $frage) {
        $lines[] = ($i + 1) . '. ' . $frage;
    }
} else {
    $lines[] = 'keine Angabe';
}

$lines[] = '';
$lines[] = '— Terminwunsch —';
$lines[] = 'Tage: ' . option_labels($form_values['wunschtage'], WUNSCHTAGE);

if ($form_values['nachricht'] !== '') {
    $lines[] = '';
    $lines[] = 'Nachricht:';
    $lines[] = $form_values['nachricht'];
}

$body = implode("\n", $lines);

$from     = mail_header_safe((string) config('mail_from'));
$reply_to = mail_header_safe($form_values['email']);
$headers  = [
    'From: ' . SITE_NAME . ' <' . $from . '>',
    'Reply-To: ' . $reply_to,
    'Content-Type: text/plain; charset=utf-8',
    'X-Mailer: PHP/' . phpversion(),
];

$subject = mail_header_safe('Buchung: ' . $svc['name']);

// -f setzt den Envelope-Sender (Return-Path) auf die eigene Domain. SPF prueft
// diesen Wert, nicht den From-Header — ohne -f traegt der Server hier seinen
// eigenen Hostnamen ein und die Pruefung laeuft gegen die falsche Domain.
$sent = mail(
    config('mail_to'),
    $subject,
    $body,
    implode("\r\n", $headers),
    '-f' . $from
);

if (!$sent) {
    error_log('Buchungsmail konnte nicht versendet werden: ' . $svc['slug']);
    $errors['form'] = 'Ihre Buchung konnte technisch nicht übermittelt werden. '
        . 'Bitte melden Sie sich direkt unter info@astrologieratgeber.ch oder '
        . 'telefonisch unter 044 442 02 23.';
    return;
}

$_SESSION['submissions'][] = time();

unset($_SESSION['csrf_token']);
header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?ok=1#form');
exit;
