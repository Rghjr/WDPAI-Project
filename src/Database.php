<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
    private static ?PDO $connection = null;

    private function __construct()
    {
    }

    public static function getConnection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $env = self::loadEnvFallback();

        $host = self::env('DB_HOST', $env) ?: 'db';
        $port = self::env('DB_PORT', $env) ?: '5432';
        $dbName = self::env('POSTGRES_DB', $env);
        $user = self::env('POSTGRES_USER', $env);
        $password = self::env('POSTGRES_PASSWORD', $env);

        if ($dbName === '' || $user === '') {
            throw new RuntimeException('Database configuration is missing in environment variables.');
        }

        $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s;sslmode=prefer', $host, $port, $dbName);

        try {
            self::$connection = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $exception) {
            throw new RuntimeException('Nie udało się połączyć z bazą danych.', 0, $exception);
        }

        return self::$connection;
    }

    /**
     * @param array<string, string> $fallback
     */
    private static function env(string $key, array $fallback): string
    {
        $value = getenv($key);
        if (is_string($value) && $value !== '') {
            return $value;
        }

        if (isset($_ENV[$key]) && is_string($_ENV[$key]) && $_ENV[$key] !== '') {
            return $_ENV[$key];
        }

        if (isset($_SERVER[$key]) && is_string($_SERVER[$key]) && $_SERVER[$key] !== '') {
            return $_SERVER[$key];
        }

        return $fallback[$key] ?? '';
    }

    /**
     * @return array<string, string>
     */
    private static function loadEnvFallback(): array
    {
        $envPath = dirname(__DIR__) . '/.env';
        if (!is_file($envPath) || !is_readable($envPath)) {
            return [];
        }

        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return [];
        }

        $vars = [];
        foreach ($lines as $line) {
            $trimmed = trim($line);
            if ($trimmed === '' || str_starts_with($trimmed, '#')) {
                continue;
            }

            $pos = strpos($trimmed, '=');
            if ($pos === false) {
                continue;
            }

            $key = trim(substr($trimmed, 0, $pos));
            $val = trim(substr($trimmed, $pos + 1));
            $val = trim($val, "\"'");
            $vars[$key] = $val;
        }

        return $vars;
    }
}
