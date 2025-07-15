#!/bin/bash

# Create database (if it doesn't exist)
mysql -u root -e "CREATE DATABASE IF NOT EXISTS befit"

# Import the SQL dump
mysql -u root befit < database/dump.sql

echo "✅ Database 'befit' imported successfully!"