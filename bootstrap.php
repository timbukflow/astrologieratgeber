<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

const SITE_URL  = 'https://astrologieratgeber.ch';
const SITE_NAME = 'Astrologieratgeber';
const SITE_OWNER = 'Stefan Haas';

const HOURLY_RATE = 160;

/** Schluessel, die config.php enthalten muss. Vorlage: WHATTODOBEFORGOONLINE.php */
const CONFIG_KEYS = [
    'turnstile_site_key',
    'turnstile_secret_key',
    'ga_measurement_id',
    'mail_to',
    'mail_from',
    'staging',
];

/**
 * Fehlt config.php oder ein Schluessel darin, bricht die Seite hier ab.
 * Absichtlich laut: Ein stiller Rueckfall auf Beispielwerte wuerde bedeuten,
 * dass Turnstile inaktiv ist und Buchungen an die falsche Adresse gehen —
 * ohne dass man der Seite von aussen etwas ansieht.
 */
function config(?string $key = null, mixed $default = null): mixed
{
    static $config = null;

    if ($config === null) {
        $file = __DIR__ . '/config.php';

        if (!is_file($file)) {
            config_abbruch('config.php fehlt. Benoetigte Schluessel: '
                . implode(', ', CONFIG_KEYS));
        }

        $config = require $file;

        if (!is_array($config)) {
            config_abbruch('config.php gibt kein Array zurueck.');
        }

        $fehlend = array_diff(CONFIG_KEYS, array_keys($config));
        if ($fehlend) {
            config_abbruch('config.php fehlen Schluessel: ' . implode(', ', $fehlend));
        }
    }

    if ($key === null) {
        return $config;
    }
    return $config[$key] ?? $default;
}

function config_abbruch(string $grund): never
{
    error_log('KONFIGURATIONSFEHLER: ' . $grund);
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    exit("Die Seite ist zurzeit nicht verfügbar.\n"
        . "Bitte melden Sie sich unter info@astrologieratgeber.ch oder 044 442 02 23.\n");
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Slug der aufgerufenen Seite, z. B. "preise" fuer /preise und /preise.php.
 * Basiert auf REQUEST_URI und nicht auf SCRIPT_NAME: Front-Controller wie der
 * von Valet setzen SCRIPT_NAME auf ihre eigene server.php, womit die
 * Navigation keine Seite mehr erkennen wuerde.
 */
function current_page(): string
{
    static $page = null;
    if ($page === null) {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $page = basename(is_string($path) && $path !== '' ? $path : '/', '.php');
        if ($page === '') {
            $page = 'index';
        }
    }
    return $page;
}

function services(): array
{
    static $services = null;
    if ($services === null) {
        $services = require __DIR__ . '/services.php';
    }
    return $services;
}

function service(string $slug): array
{
    $services = services();
    if (!isset($services[$slug])) {
        http_response_code(404);
        require __DIR__ . '/404.php';
        exit;
    }
    return $services[$slug] + ['slug' => $slug];
}

/**
 * Breite und Hoehe einer SVG aus ihrer viewBox. Fuer die width/height-Attribute
 * am <img>: Sie reservieren den Platz, bevor das Bild geladen ist, und
 * verhindern damit das Springen des Layouts.
 * Ergebnis wird gecacht — die Datei wird pro Aufruf hoechstens einmal gelesen.
 */
function svg_size(string $path, array $fallback = [900, 540]): array
{
    static $cache = [];
    if (isset($cache[$path])) {
        return $cache[$path];
    }

    $file = __DIR__ . '/' . ltrim($path, '/');
    $head = is_file($file) ? (string) file_get_contents($file, false, null, 0, 600) : '';

    if (preg_match('/viewBox="\s*[\d.-]+\s+[\d.-]+\s+([\d.]+)\s+([\d.]+)/', $head, $m)) {
        $cache[$path] = [(int) round((float) $m[1]), (int) round((float) $m[2])];
    } else {
        $cache[$path] = $fallback;
    }

    return $cache[$path];
}

function format_hours(float $h): string
{
    return rtrim(rtrim(number_format($h, 1, '.', ''), '0'), '.');
}

function hours_label(float $hours): string
{
    return 'ca. ' . format_hours($hours) . 'h';
}

function rate_label(): string
{
    return 'CHF ' . HOURLY_RATE . '.–';
}

function turnstile_enabled(): bool
{
    return config('turnstile_site_key') !== '' && config('turnstile_secret_key') !== '';
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_valid(?string $token): bool
{
    return is_string($token)
        && !empty($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

// Konfiguration sofort einlesen und pruefen. Muss hier stehen und nicht erst
// beim ersten config()-Aufruf: Bis dahin haette die Seite schon HTML
// ausgegeben, und http_response_code(500) waere wirkungslos ("headers already
// sent"). Der Besucher saehe eine halb gerenderte Seite mit Status 200.
config();

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => !empty($_SERVER['HTTPS']),
    ]);
    session_start();
}
