@echo off
:: Get the parent directory path (where database folder lives)
set "PARENT_DIR=%~dp0.."

:: Check if database folder exists in parent directory
if not exist "%PARENT_DIR%\database\" (
    echo ❌ Error: 'database' folder missing in project root!
    echo Expected at: %PARENT_DIR%\database
    pause
    exit /b
)

:: Export DB with full path
echo Exporting befit_db...
mysqldump -u root befit_db > "%PARENT_DIR%\database\publish_dump.sql" 2>nul

if errorlevel 1 (
    echo ❌ mysqldump failed! Check:
    echo 1. Is MySQL running in XAMPP?
    echo 2. Try adding password: edit -u root to -u root -pYOUR_PASSWORD
    echo 3. Ensure 'befit_db' exists
    pause
    exit /b
)

:: Verify export
if not exist "%PARENT_DIR%\database\publish_dump.sql" (
    echo ❌ Failed to create publish_dump.sql
    dir "%PARENT_DIR%\database\"
    pause
    exit /b
)

:: Update dump.sql
copy /Y "%PARENT_DIR%\database\publish_dump.sql" "%PARENT_DIR%\database\dump.sql"
del "%PARENT_DIR%\database\publish_dump.sql"

echo ✅ Success! Published latest befit_db to:
echo %PARENT_DIR%\database\dump.sql
pause