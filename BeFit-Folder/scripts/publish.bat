@echo off
:: Check if database folder exists
if not exist "database\" (
    echo ❌ Error: 'database' folder missing! Creating it...
    mkdir database
)

:: Export DB (with error handling)
echo Exporting befit_db...
mysqldump -u root befit_db > database\publish_dump.sql 2>nul
if errorlevel 1 (
    echo ❌ mysqldump failed! Possible reasons:
    echo 1. MySQL not in PATH
    echo 2. Wrong credentials (edit publish.bat to add password)
    pause
    exit /b
)

:: Verify export
if not exist "database\publish_dump.sql" (
    echo ❌ Failed to create publish_dump.sql
    pause
    exit /b
)

:: Update dump.sql
copy /Y database\publish_dump.sql database\dump.sql >nul
del database\publish_dump.sql

echo ✅ Success! Published latest befit_db to dump.sql
pause