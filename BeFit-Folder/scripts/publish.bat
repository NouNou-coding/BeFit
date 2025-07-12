@echo off
:: Step 1: Export current DB to publish_dump.sql
mysqldump -u root befit_db > database\publish_dump.sql

:: Step 2: Replace dump.sql with the new version
copy /Y database\publish_dump.sql database\dump.sql

:: Step 3: Clean up
del database\publish_dump.sql

echo ✅ Published latest "befit_db" to dump.sql!
pause