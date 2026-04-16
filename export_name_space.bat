@echo off
setlocal EnableExtensions EnableDelayedExpansion

if "%~1"=="" goto :usage

set "NS=%~1"
set "NS=%NS:/=\%"
set "CLEAN_MODE=0"

if /I "%~2"=="--clean" set "CLEAN_MODE=1"
if /I "%~2"=="/clean" set "CLEAN_MODE=1"

:trim_leading
if "!NS:~0,1!"=="\" (
	set "NS=!NS:~1!"
	goto :trim_leading
)

:trim_trailing
if "!NS:~-1!"=="\" (
	set "NS=!NS:~0,-1!"
	goto :trim_trailing
)

if not defined NS goto :usage

set "ROOT=%~dp0"
if "%ROOT:~-1%"=="\" set "ROOT=%ROOT:~0,-1%"
set "EXPORT_ROOT=%ROOT%\exports"
set "HAS_ERROR=0"

if not exist "%EXPORT_ROOT%" mkdir "%EXPORT_ROOT%"

echo.
echo Export namespace: %NS%
echo Destination root: %EXPORT_ROOT%
if "%CLEAN_MODE%"=="1" echo Clean mode: enabled
echo.

if "%CLEAN_MODE%"=="1" (
	call :clean_tree "controllers\%NS%"
	call :clean_tree "models\%NS%"
	call :clean_tree "views\%NS%"
	call :clean_tree "templates\%NS%"
	call :clean_tree "locales\en\%NS%"
	call :clean_tree "locales\it-it\%NS%"
	call :clean_tree "locales\en\controllers\%NS%"
	call :clean_tree "locales\it-it\controllers\%NS%"
	call :clean_tree "classes\%NS%"
	call :clean_tree "js\%NS%"
	call :clean_tree "css\%NS%"
	call :clean_tree "imgs\%NS%"
	call :clean_tree "sql\%NS%"
	echo.
)

call :copy_tree "controllers\%NS%"
call :copy_tree "models\%NS%"
call :copy_tree "views\%NS%"
call :copy_tree "templates\%NS%"
call :copy_tree "locales\en\%NS%"
call :copy_tree "locales\it-it\%NS%"
call :copy_tree "locales\en\controllers\%NS%"
call :copy_tree "locales\it-it\controllers\%NS%"
call :copy_tree "classes\%NS%"
call :copy_tree "js\%NS%"
call :copy_tree "css\%NS%"
call :copy_tree "imgs\%NS%"
call :copy_tree "sql\%NS%"

echo.
if "%HAS_ERROR%"=="1" (
	echo Export completed with errors.
	exit /b 1
) else (
	echo Export completed.
	exit /b 0
)

:copy_tree
set "REL=%~1"
set "SRC=%ROOT%\%REL%"
set "DST=%EXPORT_ROOT%\%REL%"

if not exist "%SRC%" (
	echo [skip] %REL% not found
	goto :eof
)

if not exist "%DST%" mkdir "%DST%"

robocopy "%SRC%" "%DST%" /E /NJH /NJS /NFL /NDL /NC /NS /NP >nul
set "RC=!ERRORLEVEL!"

if !RC! GEQ 8 (
	echo [error] %REL% copy failed ^(robocopy exit !RC!^)
	set "HAS_ERROR=1"
) else (
	echo [ok] %REL%
)

goto :eof

:clean_tree
set "REL=%~1"
set "DST=%EXPORT_ROOT%\%REL%"

if exist "%DST%" (
	rmdir /s /q "%DST%"
	if exist "%DST%" (
		echo [error] unable to clean %REL%
		set "HAS_ERROR=1"
	) else (
		echo [clean] %REL%
	)
) else (
	echo [clean-skip] %REL% not present
)

goto :eof

:usage
echo Usage:
echo   %~nx0 NAME_SPACE [--clean^|/clean]
echo.
echo Examples:
echo   %~nx0 ai
echo   %~nx0 "examples\db"
echo   %~nx0 ai --clean
echo.
exit /b 1
