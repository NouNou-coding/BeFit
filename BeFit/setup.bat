@echo off
mysql -u root -e "CREATE DATABASE IF NOT EXISTS befit"
mysql -u root befit < database\dump.sql
echo ✅ Database imported!