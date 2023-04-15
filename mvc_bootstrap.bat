REM Web MVC Framework Bootstrap file for Windows
REM  
REM Assuming you have many PHP releases extracted into many different sub folders of current .bat file.
REM For example: 
REM
REM c:\php_apps\mvc_bootstrap.php
REM c:\php_apps\php56     folder where are located PHP version 5.3 files
REM c:\php_apps\php74     folder where are located PHP version 7.4 files
REM c:\php_apps\php80     folder where are located PHP version 8.0 files
REM c:\php_apps\php82     folder where are located PHP version 8.2 files
REM
REM Note: On each PHP folder you need to configure php.ini according to framework requirements
@echo off
cls
echo Bootstrapping of PHP WEB MVC Framework
echo.
REM Set php version to use
REM
set PHP_VERSION=56
REM Set path of PHP WEB MVC Framework
REM
set FRAMEWORK_PATH=C:\PHPWEBMVC
start "browser" /B http://localhost:8000
start "php" /B "%~dp0\php%PHP_VERSION%\php" -c "%~dp0\php%PHP_VERSION%\php.ini" -S localhost:8000 "%FRAMEWORK_PATH%\route.php" -t "%FRAMEWORK_PATH%\"  
