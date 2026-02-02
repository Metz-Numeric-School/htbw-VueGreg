<?php
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
header("Content-Security-Policy: default-src 'self'; style-src 'self' https://cdn.jsdelivr.net; script-src 'self' https://cdn.jsdelivr.net; font-src 'self' https://cdn.jsdelivr.net data:;");

session_start([
    'cookie_httponly' => true,
    'cookie_secure' => true,
    'cookie_samesite' => 'Strict',
    'use_strict_mode' => true,
    'use_only_cookies' => true,
]);

// Load routes from config/routes.json
$routesFile = __DIR__ . '/routes.json';
$routes = file_exists($routesFile) ? json_decode(file_get_contents($routesFile), true) : [];

// Détecter le chemin absolu du projet
$projectDir = realpath(__DIR__ . '/../');

// Vérifier si un fichier .env.local existe et charger
$envFileLocal = $projectDir . '/.env.local';
$envFile = file_exists($envFileLocal) ? '.env.local' : '.env';

// Charger Dotenv
$dotenv = Dotenv\Dotenv::createImmutable($projectDir, $envFile);
$dotenv->load();
