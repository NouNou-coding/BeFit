@echo off
:: BeFit AI - Guaranteed Dependency Installer
:: Save to: scripts/composer-setup.bat

title BeFit AI Setup

echo ********************************************
echo       BE FIT AI DEPENDENCY INSTALLER
echo ********************************************
echo.
echo This will:
echo 1. Verify PHP installation
echo 2. Setup Composer (if needed)
echo 3. Install all dependencies
echo.
pause

:: =============================================
:: 1. UNFAILING PHP DETECTION
:: =============================================
echo.
echo [1/3] LOCATING PHP...

:: Method 1: Check PATH first
where php >nul 2>&1
if %errorlevel% equ 0 (
    set PHP_CMD=php
    goto found_php
)

:: Method 2: Check XAMPP default locations
for %%P in (
    "%ProgramFiles%\XAMPP\php\php.exe"
    "%SystemDrive%\xampp\php\php.exe"
    "C:\xampp\php\php.exe"
) do if exist %%P (
    set PHP_CMD=%%P
    set "PHP_DIR=%%~dpP"
    goto found_php
)

:: Method 3: Registry lookup for XAMPP
for /f "tokens=2*" %%A in (
    'reg query "HKLM\SOFTWARE\XAMPP" /v "Install_Dir" 2^>nul'
) do if exist "%%B\php\php.exe" (
    set PHP_CMD="%%B\php\php.exe"
    set "PHP_DIR=%%B\php\"
    goto found_php
)

echo.
echo ERROR: PHP NOT DETECTED IN XAMPP!
echo.
echo Even though XAMPP is installed, we couldn't find PHP.
echo.
echo QUICK FIX:
echo 1. Open XAMPP Control Panel
echo 2. Click 'Shell' button
echo 3. Run this script from that window
echo.
pause
exit /b

:found_php
echo Detected PHP at: %PHP_CMD%
echo.

:: =============================================
:: 2. BULLETPROOF COMPOSER SETUP
:: =============================================
echo [2/3] SETTING UP COMPOSER...

:: Check if composer exists in PATH
where composer >nul 2>&1
if %errorlevel% equ 0 (
    echo Composer already installed ✓
    goto install_deps
)

:: Download Composer
echo Downloading Composer installer...
powershell -NoProfile -Command "[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12; (New-Object System.Net.WebClient).DownloadFile('https://getcomposer.org/installer', 'composer-setup.php')"

if not exist composer-setup.php (
    echo ERROR: Download failed
    echo Check your internet connection
    pause
    exit /b
)

:: Install Composer
echo Installing Composer...
%PHP_CMD% composer-setup.php --install-dir=%SystemDrive%\Windows --filename=composer

:: Verify
timeout /t 3 >nul
where composer >nul 2>&1
if %errorlevel% neq 0 (
    echo.
    echo COMPOSER INSTALL FAILED
    echo.
    echo SOLUTION:
    echo 1. Close this window
    echo 2. Right-click this file
    echo 3. Select "Run as administrator"
    del composer-setup.php 2>nul
    pause
    exit /b
)

del composer-setup.php 2>nul
echo Composer installed successfully ✓

:: =============================================
:: 3. DEPENDENCY INSTALLATION
:: =============================================
:install_deps
echo.
echo [3/3] INSTALLING DEPENDENCIES...
echo This may take 2-5 minutes...
echo.

:: Set PATH temporarily to include PHP for CLI
set "PATH=%PHP_DIR%;%PATH%"

composer install --no-interaction --no-progress
if %errorlevel% neq 0 (
    echo.
    echo WARNING: First attempt failed
    echo Retrying with cleared cache...
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
    echo ERROR: Final setup failed
    echo MANUAL SOLUTION:
    echo 1. Open XAMPP Control Panel
    echo 2. Click 'Shell' button
    echo 3. Run: composer install
)

echo.
echo FINISHED. Press any key to close...
pause >nul