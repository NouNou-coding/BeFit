@echo off
:: Batch file for automatic Composer installation and dependency setup
:: Requires admin privileges for Composer installation

echo ********************************************
echo  BeFit AI - Automatic Dependency Installer
echo ********************************************
echo.
echo This script will:
echo 1. Install Composer (if missing)
echo 2. Install all PHP dependencies
echo 3. Verify the vendor folder
echo.
echo Note: Composer installation requires admin rights.
echo.
pause

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
powershell -Command "(New-Object System.Net.WebClient).DownloadFile('https://getcomposer.org/installer', 'composer-setup.php')" >nul 2>&1

if not exist composer-setup.php (
    echo ERROR: Failed to download Composer
    echo Please install manually from: https://getcomposer.org/download
    pause
    exit /b
)

echo Installing Composer (this requires admin rights)...
echo Please accept UAC prompt if it appears...
powershell -Command "Start-Process php -ArgumentList 'composer-setup.php' -Verb RunAs -Wait" >nul 2>&1
del composer-setup.php >nul 2>&1
del composer-setup.php.pubkey >nul 2>&1

:: Move composer to system path
if exist composer.phar (
    echo Moving Composer to system location...
    mkdir "%SystemDrive%\ProgramData\ComposerSetup" >nul 2>&1
    copy composer.phar "%SystemDrive%\ProgramData\ComposerSetup\composer.bat" >nul 2>&1
    setx /M PATH "%PATH%;%SystemDrive%\ProgramData\ComposerSetup" >nul 2>&1
    del composer.phar >nul 2>&1
)

:: Verify installation
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Composer installation failed
    echo Please install manually from: https://getcomposer.org/download
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