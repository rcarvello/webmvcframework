## Upgrade PHP Web MVC Framework to PHP >= 8.4

You can fix/upgrade PHP WEB MVC Framework to PHP 8.4 by eliminating the:

**nullable_type_declaration_for_default_null_value**

used for backward compatibility with versions from PHP 7.1 to PHP 5.6.

To apply the fix if your runtime PHP enviroment is version is >= 7.1 run:

1)

  ```bash
composer require --dev friendsofphp/php-cs-fixer
  ```

2) If you are using PHP version 8.4 you must set the environment variable:

   **PHP_CS_FIXER_IGNORE_ENV=1**

   On Windows just modify the file

   **.vendor\bin\php-cs-fixer.bat**

   as follow:

   ```batch
   @ECHO OFF
   setlocal DISABLEDELAYEDEXPANSION
   SET BIN_TARGET=%~dp0/php-cs-fixer
   SET COMPOSER_RUNTIME_BIN_DIR=%~dp0
   SET PHP_CS_FIXER_IGNORE_ENV=1
   php "%BIN_TARGET%" %*
   ```

3) To check only, run:
   ```bash
    .\vendor\bin\php-cs-fixer check
   ```
4) To fix run
   ```bash
    .\vendor\bin\php-cs-fixer check
   ```

Note: after applying the fix you can only use PHP version >= 7.1
