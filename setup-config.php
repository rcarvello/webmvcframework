<?php
// -----------------
// Useful functions
// -----------------
function commandExists($cmd)
{
    $checkCmd = (strncasecmp(PHP_OS, 'WIN', 3) === 0)
        ? "where $cmd"
        : "command -v $cmd";
    exec($checkCmd, $output, $returnVar);
    return $returnVar === 0;
}

function getVersion($cmd)
{
    exec("$cmd --version 2>&1", $output, $returnVar);
    return $returnVar === 0 ? $output[0] : false;
}

// -------------------------
// 1. Checking dependencies
// -------------------------

echo "Checking dependencies...\n";

$phpVersion = getVersion("php");
$npmVersion = getVersion("npm");

if (!$phpVersion) {
    echo "PHP was not found. Install PHP and do it again.\n";
    exit(1);
}
if (!$npmVersion) {
    echo "NPM was not found. Install Node.js and do it again.\n";
    exit(1);
}

echo "PHP: $phpVersion\n";
echo "NPM: $npmVersion\n";

// -------------------------
// 2. Configuration
// -------------------------

$configFile = __DIR__ . "/config/application.config.php";
$sqlFile = __DIR__ . "/sql/mrp.sql";

// get the project name (current folder)
$projectName = basename(getcwd());

$placeholders = [
    "DB_HOST" => "localhost",
    "DB_USER" => "root",
    "DB_PASSWORD" => "",
    "DB_NAME" => strtolower($projectName), // default: project name (current directory)
    "DB_PORT" => "3306"
];

if (!file_exists($configFile)) {
    echo "Configuration file not found: $configFile\n";
    exit(1);
}

$content = file_get_contents($configFile);

$params = [];
foreach ($placeholders as $key => $default) {
    echo "$key [$default]: ";
    $input = trim(fgets(STDIN));
    $value = $input !== "" ? $input : $default;
    $params[$key] = $value;

    // Replacing placeholder
    $content = str_replace("{" . $key . "}", $value, $content);
}

// Updating config file
file_put_contents($configFile, $content);
echo "application.config.php was successfully updated.\n";

// -------------------------
// 3. Database setup
// -------------------------

if (!file_exists($sqlFile)) {
    echo "SQL file not found: $sqlFile\n";
    exit(1);
}

echo "DB Setup...\n";

try {
    $dsn = "mysql:host=" . $params["DB_HOST"] . ";charset=utf8mb4";
    $pdo = new PDO($dsn, $params["DB_USER"], $params["DB_PASSWORD"], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => true
    ]);

    // crea DB se non esiste
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . $params["DB_NAME"] . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `" . $params["DB_NAME"] . "`");

    // Load the SQL script
    $sql = file_get_contents($sqlFile);
    $pdo->exec($sql);

    echo "Database '{$params["DB_NAME"]}' successfully created.\n";

} catch (PDOException $e) {
    echo "PDO Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "Setup process is successfully completed!\n";
