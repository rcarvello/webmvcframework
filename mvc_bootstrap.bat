REM Bootstrap file of Web MVC Framework for Windows
REM
REM Assuming you have many PHP releases extracted into many different sub folders of current .bat file.
REM For example:
REM
REM c:\php_apps\mvc_bootstrap.php
REM c:\php_apps\php56     folder where are located PHP version 5.3 files
REM c:\php_apps\php74     folder where are located PHP version 5.3 files
REM c:\php_apps\php80     folder where are located PHP version 5.3 files
REM c:\php_apps\php82     folder where are located PHP version 5.3 files
REM
REM Note: On each PHP folder you need to configure php.ini according to framework requirements
@echo off
cls
echo Bootstrapping of PHP WEB MVC Framework
echo.
REM ********************************
REM Set configuration variables here
REM ********************************
REM
REM Set PHP distributions PATH (for example C:\php_apps or %~dp0 for current .bat folder)
set PHP_ROOT_PATH=%~dp0
REM
REM Set PHP version SUFFIX PATH
set PHP_VERSION=56
REM
REM Set WEB MVC Framework PATH
set FRAMEWORK_PATH=D:\gitmvc
REM
REM ********************************
REM End configuration variables
REM ********************************
start "php" /B "%PHP_ROOT_PATH%\php%PHP_VERSION%\php.exe" -c "%PHP_ROOT_PATH%\php%PHP_VERSION%\php.ini" -S localhost:8000 "%FRAMEWORK_PATH%\route.php" -t "%FRAMEWORK_PATH%\"
start "browser" /B http://localhost:8000
