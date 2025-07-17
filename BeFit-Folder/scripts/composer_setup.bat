@echo off
:: BeFit AI - One-Click Dependency Installer
:: Safe, clear, and foolproof version
:: Save to: scripts/composer-setup.bat

title BeFit AI Setup

echo ********************************************
echo       BE FIT AI DEPENDENCY INSTALLER
echo ********************************************
echo.
echo This will:
echo 1. Check/install Composer (if needed)
echo 2. Install all PHP dependencies
echo 3. Create vendor folder
echo.
echo NOTE: May require admin rights for Composer
echo.
pause

:: =============================================
:: 1. PHP CHECK (with clear guidance)
:: =============================================
echo.
echo [1/3] CHECKING PHP...

where php >nul 2>&1
if %errorlevel% equ 0 (
    set PHP_CMD=php
    goto check_composer
)

:: Check common PHP locations
set FOUND_PHP=0
for %%P in (
    "C:\xampp\php\php.exe"
    "C:\laragon\bin\php\php.exe"
    "C:\wamp64\bin\php\php.exe"
) do if exist %%P (
    set PHP_CMD=%%P
    set FOUND_PHP=1
)

if %FOUND_PHP% equ 0 (
    echo.
    echo ERROR: PHP NOT FOUND!
    echo.
    echo Required for Composer. Please install:
    echo.
    echo [RECOMMENDED] XAMPP: https://www.apachefriends.org
    echo (Includes PHP + MySQL + Apache)
    echo.
    echo Then RESTART your computer and run this again.
    pause
    exit /b
)

:check_composer
echo Using PHP at: %PHP_CMD%
echo.

:: =============================================
:: 2. COMPOSER INSTALL (with admin fallback)
:: =============================================
echo [2/3] CHECKING COMPOSER...
composer --version >nul 2>&1
if %errorlevel% equ 0 (
    echo Composer already installed ✓
    goto install_deps
)

echo.
echo DOWNLOADING COMPOSER...
powershell -Command "[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12; (New-Object System.Net.WebClient).DownloadFile('https://getcomposer.org/installer', 'composer-setup.php')"

if not exist composer-setup.php (
    echo ERROR: Download failed
    echo Check internet connection and try again
    pause
    exit /b
)

echo.
echo INSTALLING COMPOSER...
%PHP_CMD% composer-setup.php --install-dir=%SystemDrive%\Windows --filename=composer

:: Verify
timeout /t 2 >nul
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo.
    echo COMPOSER INSTALL FAILED
    echo.
    echo SOLUTION: Right-click this file and select
    echo "Run as administrator", then try again
    del composer-setup.php 2>nul
    pause
    exit /b
)

del composer-setup.php 2>nul
echo Composer installed successfully ✓

:: =============================================
:: 3. VENDOR SETUP (with retry logic)
:: =============================================
:install_deps
echo.
echo [3/3] INSTALLING DEPENDENCIES...
echo This may take 2-5 minutes...
echo.

composer install --no-interaction --no-progress
if %errorlevel% neq 0 (
    echo.
    echo WARNING: First attempt failed
    echo Retrying with clearer cache...
    echo.
    composer clear-cache
    composer install --no-interaction --no-progress
)

if exist "..\vendor\autoload.php" (
    echo.
    echo SUCCESS! Setup complete ✓
    echo Vendor folder created at: %cd%\..\vendor
) else (
    echo.
    echo ERROR: Vendor folder not created
    echo Try manual steps:
    echo 1. Open CMD as admin
    echo 2. Run: composer install
)

echo.
echo FINISHED. Press any key to close...
pause >nul