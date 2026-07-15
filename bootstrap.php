<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

const SITE_URL  = 'https://astrologieratgeber.ch';
const SITE_NAME = 'Astrologieratgeber';
const SITE_OWNER = 'Stefan Haas';

const HOURLY_RATE = 160;

function config(?string $key = null, mixed $default = null): mixed
{
    static $config = null;
    if ($config === null) {
        $file = __DIR__ . '/config.php';
        if (is_file($file)) {
            $config = require $file;
        } else {
            // Die Seite laeuft weiter, aber ohne Turnstile und mit dem
            // Beispiel-Empfaenger. Ohne diesen Eintrag im Log faellt das
            // niemandem auf — die Seite sieht voellig normal aus.
            error_log('config.php fehlt — Fallback auf config.example.php. '
                . 'Turnstile ist damit inaktiv und mail_to zeigt auf den Beispielwert.');
            $config = require __DIR__ . '/config.example.php';
        }
    }
    if ($key === null) {
        return $config;
    }
    return $config[$key] ?? $default;
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
