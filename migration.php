<?php

$migrationsDir = __DIR__ . '/migrations';

if (!is_dir($migrationsDir)) {
    throw new Exception('Migrations directory not exists');
}

$migrations = glob($migrationsDir . '/*.php');

sort($migrations);

$config = require __DIR__ . '/config.php';

$pdo = new PDO(
    "mysql:host={$config['database']['host']};dbname={$config['database']['database']}",
    $config['database']['username'],
    $config['database']['password'],
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]
);

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