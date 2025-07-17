@echo off
:: Batch file for automatic Composer and dependency setup
:: Final fixed version - handles all cases correctly

echo ********************************************
echo  BeFit AI - Automatic Dependency Installer
echo ********************************************
echo.
echo This script will:
echo 1. Setup Composer (if missing)
echo 2. Install PHP dependencies
echo 3. Create vendor folder
echo.
pause

:: Check admin rights
set IS_ADMIN=0
net session >nul 2>&1 && set IS_ADMIN=1

:: Check Composer
echo.
echo [STEP 1/3] Checking Composer...
composer --version >nul 2>&1
if %errorlevel% equ 0 (
    echo Composer is already installed ✓
    goto :install_deps
)

:: Install Composer
echo.
echo Composer not found. Installing now...
echo Downloading Composer Setup...
powershell -Command "[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12; (New-Object System.Net.WebClient).DownloadFile('https://getcomposer.org/installer', 'composer-setup.php')"

if not exist composer-setup.php (
    echo ERROR: Download failed
    echo Check internet connection and try again
    pause
    exit /b
)

:: Set PHP path (XAMPP default)
set PHP_PATH=C:\xampp\php\php.exe
if not exist "%PHP_PATH%" (
    echo ERROR: PHP not found at %PHP_PATH%
    echo Install XAMPP or update PHP path in script
    pause
    exit /b
)

:: Run installation
echo Installing Composer...
"%PHP_PATH%" composer-setup.php --install-dir=%SystemDrive%\Windows --filename=composer

:: Verify installation
timeout /t 3 >nul
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    if %IS_ADMIN% equ 0 (
        echo.
        echo ADMIN REQUIRED: Right-click and "Run as administrator"
    ) else (
        echo.
        echo INSTALL FAILED: Try manual install from:
        echo https://getcomposer.org/download
    )
    pause
    exit /b
)

:: Cleanup
del composer-setup.php >nul 2>&1
del composer-setup.php.pubkey >nul 2>&1

echo Composer installed successfully ✓

:install_deps
echo.
echo [STEP 2/3] Installing dependencies...
echo This may take several minutes...
echo.
composer install --no-interaction --no-progress
if %errorlevel% neq 0 (
    echo.
    echo ERROR: Dependency installation failed!
    echo Try these solutions:
    echo 1. Check internet connection
    echo 2. Delete vendor folder and retry
    echo 3. Run 'composer install' manually
    pause
    exit /b
)

echo.
echo [STEP 3/3] Verifying vendor folder...
if exist "vendor\autoload.php" (
    echo SUCCESS! Vendor folder created ✓
    echo Your setup is complete.
) else (
    echo WARNING: Vendor folder missing!
    echo Try running 'composer install' manually
)

echo.
echo PROCESS COMPLETE
pause