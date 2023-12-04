REM Bootstrap file of Web MVC Framework for Windows
REM
REM Assuming you have many PHP releases extracted into many different sub folders of a root folder.
REM For example:
REM
REM C:\Users\Saro\Desktop\Applicazioni PHP Desktop\phpapp Is the root path of installed PHP distributions
REM and
REM C:\Users\Saro\Desktop\Applicazioni PHP Desktop\phpapp\php56  folder where are located PHP version 5.6 files
REM C:\Users\Saro\Desktop\Applicazioni PHP Desktop\phpapp\php74  folder where are located PHP version 7.4 files
REM C:\Users\Saro\Desktop\Applicazioni PHP Desktop\phpapp\php80  folder where are located PHP version 8.0 files
REM C:\Users\Saro\Desktop\Applicazioni PHP Desktop\phpapp\php82  folder where are located PHP version 8.2 files
REM
REM Note: Each PHP distribution folder starts with "php" + version
REM Note: On each PHP distribution you need to configure php.ini according to framework requirements
@echo off
cls
echo Bootstrapping of PHP WEB MVC Framework
echo.
REM ********************************
REM Set configuration variables here
REM ********************************
REM
REM Set PHP ROOT distributions PATH
set PHP_ROOT_PATH=C:\Users\Saro\Desktop\Applicazioni PHP Desktop\phpapp
REM
REM Set PHP version SUFFIX PATH -- CHANGE THIS FOR SETTING PHP VERSION
set PHP_VERSION=82
REM
REM Set WEB MVC Framework PATH CHANGE THIS FOR SETTING HTTP ROOT FOLDER
REM %~dp0 is the folder of current .bat script
set FRAMEWORK_PATH=%~dp0
REM
REM ********************************
REM End configuration variables
REM ********************************
start http://localhost:8000
"%PHP_ROOT_PATH%\php%PHP_VERSION%\php.exe" -c "%PHP_ROOT_PATH%\php%PHP_VERSION%\php.ini" -S localhost:8000 "%FRAMEWORK_PATH%\route.php" -t "%FRAMEWORK_PATH%\"
