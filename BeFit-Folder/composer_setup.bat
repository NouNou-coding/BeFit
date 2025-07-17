@echo off
cls
echo ======================================
echo   BeFit Project - Composer Setup
echo ======================================

:: Check if composer is available
where composer >nul 2>&1
IF %ERRORLEVEL% NEQ 0 (
    echo.
    echo [ERROR] Composer is not installed or not added to PATH.
    echo Download it from: https://getcomposer.org/download/
    pause
    exit /b
)

:: Run composer install
echo.
echo Installing dependencies with Composer...
composer install

IF %ERRORLEVEL% EQU 0 (
    echo.
    echo [SUCCESS] All Composer dependencies installed successfully!
) ELSE (
    echo.
    echo [ERROR] composer install encountered an issue.
)

pause
