<?php
// -----------------
// Useful functions
// -----------------
function getOSFamily()
{
    if (defined('PHP_OS_FAMILY')) {
        return PHP_OS_FAMILY; // PHP >= 7.2
    }

    $os = strtolower(PHP_OS);
    if (strpos($os, 'win') === 0) {
        return 'Windows';
    }
    if (strpos($os, 'darwin') === 0) {
        return 'Darwin'; // macOS
    }
    if (strpos($os, 'linux') === 0) {
        return 'Linux';
    }
    return 'Unknown';
}


function setup_php()
{
    echo "Checking PHP installation...\n";

    // 1. Checking PHP installation
    $phpVersion = shell_exec("php -v 2>&1");
    if (strpos($phpVersion, "PHP") === false) {
        echo "\033[0;31m PHP is not installed or not in PATH.\033[0m\n";
        return false;
    }
    echo "\033[0;32m PHP detected:\033[0m\n$phpVersion\n";

    // 2. Get current php.ini
    $phpInfo = shell_exec("php -i");
    $iniPath = null;
    foreach (explode("\n", $phpInfo) as $line) {
        if (stripos($line, "Loaded Configuration File") !== false) {
            $parts = explode("=>", $line);
            if (count($parts) == 2) {
                $iniPath = trim($parts[1]);
            }
            break;
        }
    }

    if (!$iniPath || $iniPath === "(None)") {
        echo "\033[0;33m No php.ini loaded.\033[0m\n";
        $iniPath = "";
    } else {
        echo "Using php.ini: $iniPath\n";
    }

    // 3. Looking for PHP executable
    $osFamily = getOSFamily();
    if (stripos($osFamily, 'Windows') !== false) {
        $output = shell_exec("where php");
    } else {
        $output = shell_exec("which php");
    }

    $phpBin = $output ? trim($output) : PHP_BINARY;

    // 4. User input with default values
    echo "\n--- PHP Configuration ---\n";
    echo "PHP binary path [{$phpBin}]: ";
    $phpBinInput = trim(fgets(STDIN));
    $phpBinFinal = $phpBinInput !== "" ? $phpBinInput : $phpBin;

    echo "php.ini path [{$iniPath}]: ";
    $iniPathInput = trim(fgets(STDIN));
    $iniPathFinal = $iniPathInput !== "" ? $iniPathInput : $iniPath;

    // 5. Load the config.json
    $configFile = __DIR__ . "/config.json";
    if (!file_exists($configFile)) {
        echo "\033[0;31m config.json not found!\033[0m\n";
        return false;
    }

    $config = json_decode(file_get_contents($configFile), true);
    if (!$config) {
        echo "\033[0;31m Invalid config.json format!\033[0m\n";
        return false;
    }

    // 6. Update and save config.json
    $config['PHP_BIN'] = $phpBinFinal;
    $config['PHP_INI_PATH'] = $iniPathFinal;

    file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    echo "\n";
    echo "\033[0;32m config.json updated successfully!\033[0m\n";
    return true;
}

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

// --------------
// Initialization
// --------------

$templateFile = __DIR__ . '/config/application.config.template.php';
$configFile = __DIR__ . '/config/application.config.php';
$sqlFile = __DIR__ . "/sql/mrp.sql";

if (!file_exists($templateFile)) {
    echo "\033[0;31m Template file not found: application.config.template.php\033[0m\n";
    exit(1);
}

if (!copy($templateFile, $configFile)) {
    echo "\033[0;31m Failed to initialize application.config.php from template.\033[0m\n";
    exit(1);
}

echo "\033[0;36m File application.config.php reinitialized from template.\033[0m\n\n";



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
    echo "\033[0;31m NPM was not found. Install Node.js and do it again.\033[0m\n";
    exit(1);
}

echo "PHP: $phpVersion\n";
echo "NPM: $npmVersion\n";

if (!setup_php()) {
    echo "\033[0;31m Setup aborted due to PHP configuration error.\033[0m\n";
    exit(1);
}

// -------------------------
// 2. Configuration
// -------------------------

// get the project name (current folder)
$projectName = basename(getcwd());

$placeholders = [
    "DB_HOST" => "localhost",
    "DB_USER" => "root",
    "DB_PASSWORD" => "root",
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


echo "Testing MySQL connection...\n";

try {
    // Connessione senza specificare DB
    $db = $params['DB_HOST'] === 'localhost' ? '127.0.0.1' : $params['DB_HOST'];
    $mysqli = @new mysqli($db, $params["DB_USER"], $params["DB_PASSWORD"]);

    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }

    echo "\033[0;32m Successfully connected to MySQL server.\033[0m\n";
    $mysqli->close();

} catch (Exception $e) {
    echo "\033[0;31m MySQL connection error: {$e->getMessage()}\033[0m\n";
    exit(1);
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

    // Create DB if not exists
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

// PHP > 8.4 Fix
if (PHP_VERSION_ID >= 80400) {
    echo "\033[0;36m PHP >= 8.4 detected, installing php-cs-fixer...\033[0m\n";

    passthru("composer require --dev friendsofphp/php-cs-fixer");

    if (stripos(PHP_OS, 'WIN') === 0) {
        passthru(".\\vendor\\bin\\php-cs-fixer fix");
    } else {
        passthru("./vendor/bin/php-cs-fixer fix");
    }

    echo "\033[0;32m Code style fixed with php-cs-fixer.\033[0m\n";
} else {
    echo "\033[0;33m PHP version < 8.4 → skipping php-cs-fixer.\033[0m\n";
}

