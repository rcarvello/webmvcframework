#!/usr/bin/env php
<?php
/**
 * CLI Bean Generator
 * Generates PHP bean class(es) for one or more MySQL tables.
 *
 * Usage:
 *   php cli_create_bean.php <table_name> [<table_name2> ...]
 *   php cli_create_bean.php --all
 *   php cli_create_bean.php --list
 */

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

// Must be run from CLI
if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "This script must be run from the command line.\n");
    exit(1);
}

include_once(__DIR__ . "/mysqlreflection/mysqlreflection.config.php");

define("DESTINATION_PATH", __DIR__ . "/../models/beans/");

$args = array_slice($argv, 1);

if (empty($args)) {
    fwrite(STDERR, "Usage:\n");
    fwrite(STDERR, "  php cli_create_bean.php <table_name> [<table_name2> ...]\n");
    fwrite(STDERR, "  php cli_create_bean.php --all\n");
    fwrite(STDERR, "  php cli_create_bean.php --list\n");
    exit(1);
}

$reflection = new MVCMySqlSchemaReflection();

// --list: show available tables
if ($args[0] === '--list') {
    $tables = $reflection->getTablesFromSchema();
    if (empty($tables)) {
        echo "No tables found in database: " . DBNAME . "\n";
    } else {
        echo "Tables in database '" . DBNAME . "':\n";
        foreach ($tables as $table) {
            echo "  - $table\n";
        }
    }
    exit(0);
}

// --all: generate beans for every table
if ($args[0] === '--all') {
    $tables = $reflection->getTablesFromSchema();
    if (empty($tables)) {
        fwrite(STDERR, "No tables found in database: " . DBNAME . "\n");
        exit(1);
    }
    echo "Generating beans for all " . count($tables) . " table(s) in '" . DBNAME . "'...\n";
    $reflection->generateClassesFromSelectedTables($tables, DESTINATION_PATH);
    echo "Done. " . count($tables) . " class(es) generated in: " . DESTINATION_PATH . "\n";
    exit(0);
}

// Validate supplied table names against the schema
$availableTables = $reflection->getTablesFromSchema();
$requestedTables = $args;
$invalidTables   = array_diff($requestedTables, $availableTables);

if (!empty($invalidTables)) {
    fwrite(STDERR, "Error: the following table(s) were not found in database '" . DBNAME . "':\n");
    foreach ($invalidTables as $t) {
        fwrite(STDERR, "  - $t\n");
    }
    fwrite(STDERR, "Run with --list to see available tables.\n");
    exit(1);
}

echo "Generating bean(s) for " . count($requestedTables) . " table(s) in '" . DBNAME . "'...\n";
$reflection->generateClassesFromSelectedTables($requestedTables, DESTINATION_PATH);
echo "Done. " . count($requestedTables) . " class(es) generated in: " . DESTINATION_PATH . "\n";
exit(0);
