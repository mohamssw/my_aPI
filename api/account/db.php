<?php

function database(): PDO
{
    $url = getenv('DATABASE_URL');
    if (!$url) {
        throw new RuntimeException('DATABASE_URL is not configured');
    }

    $parts = parse_url($url);
    if (!$parts || empty($parts['host'])) {
        throw new RuntimeException('DATABASE_URL is invalid');
    }

    $dsn = 'pgsql:host=' . $parts['host']
        . ';port=' . ($parts['port'] ?? 5432)
        . ';dbname=' . ltrim((string) ($parts['path'] ?? ''), '/');

    return new PDO($dsn, urldecode((string) ($parts['user'] ?? '')), urldecode((string) ($parts['pass'] ?? '')), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}
