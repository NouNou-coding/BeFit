@echo off
setlocal

:: Default possible path (adjust if needed)
set "MYSQL_PATH=C:\xampp\mysql\bin\mysql.exe"

:: Check if mysql.exe exists in default path
if not exist "%MYSQL_PATH%" (
    echo.
    echo 🔍 Could not find mysql.exe in the default path:
    echo     %MYSQL_PATH%
    echo.
    set /p MYSQL_PATH=👉 Enter full path to mysql.exe (e.g. C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe): 
)

:: Validate mysql.exe exists
if not exist "%MYSQL_PATH%" (
    echo ❌ mysql.exe not found at: %MYSQL_PATH%
    pause
    exit /b
)

:: Create database
"%MYSQL_PATH%" -u root -e "CREATE DATABASE IF NOT EXISTS befit_db"

:: Import tables
echo.
echo 🔄 Checking if dump.sql exists...
dir ..\database\dump.sql
if not exist "..\database\dump.sql" (
    echo ❌ dump.sql not found in ..\database\
    pause
    exit /b
)

:: Importing dump
"%MYSQL_PATH%" -u root befit_db < ..\database\dump.sql

echo.
echo ✅ Database setup complete!
pause
