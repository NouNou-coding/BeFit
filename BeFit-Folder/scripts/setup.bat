@echo off
:: Step 1: Create database (if not exists)
mysql -u root -e "CREATE DATABASE IF NOT EXISTS befit_db"

:: Step 2: Import the latest dump.sql
mysql -u root befit_db < database\dump.sql

echo ✅ Database "befit_db" setup complete! 
pause