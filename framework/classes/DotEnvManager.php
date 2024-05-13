<?php
/**
 * DotEnvManager
 * Create environment variables from .env files can be accessed by using php getenv() function
 *
 * Usage example:
 *
 *      .env file example:
 *
 *      DATABASE=mydb;
 *      DATABASE_USER=root
 *      DATABASE_PASSWORD=root
 *
 *      use framework\classes\DotEnvManager;
 *
 *      $env = new DotEnvManager(__DIR__ . '/.env');
 *      $env->load();
 *      echo getenv('DATABASE_USER');
 *      // prints root
 *      echo getenv('DATABASE')
 *      // prints mydb
 *
 *
 * @package framework/classes
 * @filesource framework/classes/DotEnvManager.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2024 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework\classes;

class DotEnvManager
{
    /**
     * The directory where the .env file can be located.
     *
     * @var string
     */
    protected $path;


    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $path));
        }
        $this->path = $path;
    }

    public function load(): void
    {
        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}