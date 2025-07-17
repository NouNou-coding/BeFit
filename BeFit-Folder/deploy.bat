@echo off
cd /d %~dp0
rmdir /s /q vendor\composer
composer dump-autoload