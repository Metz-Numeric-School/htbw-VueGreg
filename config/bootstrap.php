<?php

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
