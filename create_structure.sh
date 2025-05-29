#!/bin/bash
set -e # Exit immediately if a command exits with a non-zero status.

# Create main application directories
mkdir -p app/Controllers
mkdir -p app/Models
mkdir -p app/Services
mkdir -p app/Core
mkdir -p app/Http
mkdir -p app/Lib

# Create config directory
mkdir -p config

# Create database directory and subdirectories
mkdir -p database/migrations
mkdir -p database/seeds
touch database/schema.sql

# Create public directory and subdirectories/files
mkdir -p public/css
mkdir -p public/js
mkdir -p public/img
touch public/index.php

# Create templates/views directory and subdirectories
mkdir -p templates/layouts
mkdir -p templates/pages

# Create vendor directory (for Composer)
mkdir -p vendor

# Create logs directory
mkdir -p logs

# Create tests directory
mkdir -p tests

# Create project root files
touch README.md
touch composer.json

echo "Directory structure created successfully."
ls -R .
