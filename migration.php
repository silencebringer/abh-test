<?php

use App\Connections\Database;

require_once __DIR__ . '/vendor/autoload.php';

$migrationsDir = __DIR__ . '/migrations';

if (!is_dir($migrationsDir)) {
    throw new Exception('Migrations directory not exists');
}

$migrations = glob($migrationsDir . '/*.php');

sort($migrations);

$pdo = Database::connection();

foreach ($migrations as $migrationFile) {
    echo "Running migration: " . basename($migrationFile) . PHP_EOL;

    try {
        $migration = require $migrationFile;

        if (!is_callable($migration)) {
            throw new RuntimeException(
                'Migration must return a callable: ' . basename($migrationFile)
            );
        }

        $migration($pdo);

        echo "Done." . PHP_EOL;
    } catch (Throwable $e) {
        echo "Failed: " . $e->getMessage() . PHP_EOL;

        exit(1);
    }
}