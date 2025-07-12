@echo off
:: Set correct paths - adjust if your structure differs
set "MYSQL_USER=root"
set "MYSQL_PASSWORD="  # Add your password here if needed
set "DB_NAME=befit_db"
set "DUMP_PATH=..\database\dump.sql"

:: Check MySQL is running
tasklist | find /i "mysqld.exe" >nul
if %errorlevel% neq 0 (
    echo ❌ MySQL not running! Start it via XAMPP first.
    pause
    exit /b
)

:: Export with error handling
echo Exporting %DB_NAME%...
if defined MYSQL_PASSWORD (
    mysqldump -u %MYSQL_USER% -p%MYSQL_PASSWORD% %DB_NAME% > "%DUMP_PATH%"
) else (
    mysqldump -u %MYSQL_USER% %DB_NAME% > "%DUMP_PATH%"
)

if errorlevel 1 (
    echo ❌ Export failed! Possible causes:
    echo 1. Wrong credentials (edit MYSQL_USER/MYSQL_PASSWORD)
    echo 2. Database '%DB_NAME%' doesn't exist
    echo 3. Check path: %DUMP_PATH%
    pause
    exit /b
)

echo ✅ Success! Database exported to:
echo %CD%\%DUMP_PATH%
pause