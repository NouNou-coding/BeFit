@echo off
:: Batch file for automatic Composer installation and dependency setup
:: Version 2.1 - Fixed admin rights handling

echo ********************************************
echo  BeFit AI - Automatic Dependency Installer
echo ********************************************
echo.
echo This script will:
echo 1. Install Composer (if missing)
echo 2. Install all PHP dependencies
echo 3. Verify the vendor folder
echo.
pause

:: Check for admin rights first
set IS_ADMIN=0
net session >nul 2>&1
if %errorlevel% equ 0 (set IS_ADMIN=1)

:: Check if composer is available
echo.
echo [STEP 1/3] Checking Composer...
composer --version >nul 2>&1

if %errorlevel% equ 0 (
    echo Composer is already installed ✓
    goto :install_deps
)

:: Install Composer automatically
echo.
echo Composer not found. Installing now...
echo Downloading Composer Setup...
powershell -Command "[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12; (New-Object System.Net.WebClient).DownloadFile('https://getcomposer.org/installer', 'composer-setup.php')"

if not exist composer-setup.php (
    echo ERROR: Failed to download Composer
    echo Please check your internet connection
    pause
    exit /b
)

:: Set PHP path explicitly for XAMPP
set PHP_PATH=C:\xampp\php\php.exe
if not exist "%PHP_PATH%" (
    echo ERROR: PHP not found at %PHP_PATH%
    echo Please ensure XAMPP is installed correctly
    pause
    exit /b
)

:: Install based on admin rights
if %IS_ADMIN% equ 1 (
    echo Installing Composer with admin rights...
    "%PHP_PATH%" composer-setup.php --install-dir=%SystemDrive%\Windows --filename=composer
) else (
    echo.
    echo WARNING: Admin rights required for Composer installation
    echo Please right-click this script and select "Run as administrator"
    pause
    del composer-setup.php
    exit /b
)

:: Cleanup
del composer-setup.php >nul 2>&1
del composer-setup.php.pubkey >nul 2>&1

:: Verify installation
timeout /t 2 >nul
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo.
    echo ERROR: Composer installation failed
    echo Please try:
    echo 1. Right-click and "Run as administrator"
    echo 2. Install manually from: https://getcomposer.org/download
    pause
    exit /b
)

echo Composer installed successfully ✓

:install_deps
echo.
echo [STEP 2/3] Installing dependencies...
echo This may take several minutes...
echo.
composer install --no-interaction --no-progress

if %errorlevel% neq 0 (
    echo ERROR: Dependency installation failed!
    echo Possible solutions:
    echo 1. Check internet connection
    echo 2. Run 'composer install' manually
    echo 3. Contact support
    pause
    exit /b
)

:: Verify vendor folder
echo.
echo [STEP 3/3] Verifying installation...
if exist "..\vendor\autoload.php" (
    echo SUCCESS! Vendor folder created ✓
    echo You can now run the application.
) else (
    echo WARNING: Vendor folder not created!
    echo Try running 'composer install' manually.
)

echo.
echo Installation complete!
pause