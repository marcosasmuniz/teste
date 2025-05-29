#!/bin/bash

# Installation Script for WhatsApp Billing System
# Phase 1: Core System Setup and Prerequisite Checks

# --- Helper Functions ---

# Function to check PHP version
check_php_version() {
    echo "Checking PHP version..."
    if ! command -v php &> /dev/null; then
        echo "Error: PHP CLI is not installed or not in PATH."
        exit 1
    fi

    PHP_VERSION=$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')
    REQUIRED_PHP_VERSION="8.0"

    if (( $(echo "$PHP_VERSION < $REQUIRED_PHP_VERSION" | bc -l) )); then
        echo "Error: PHP version $PHP_VERSION is installed. Version $REQUIRED_PHP_VERSION or higher is required."
        exit 1
    else
        echo "Success: PHP version $PHP_VERSION is installed."
    fi
}

# Function to check required PHP extensions
check_php_extensions() {
    echo "Checking required PHP extensions: $@"
    REQUIRED_EXTENSIONS=("$@")
    MISSING_COUNT=0

    for ext in "${REQUIRED_EXTENSIONS[@]}"; do
        if php -m | grep -qiw "$ext"; then # -i for case-insensitive, -w for whole word
            echo "  - Extension '$ext' is loaded."
        else
            echo "  - Error: Extension '$ext' is NOT loaded."
            MISSING_COUNT=$((MISSING_COUNT + 1))
        fi
    done

    if [ "$MISSING_COUNT" -gt 0 ]; then
        echo "Error: $MISSING_COUNT required PHP extension(s) are missing. Please install them and try again."
        exit 1
    else
        echo "Success: All required PHP extensions are loaded."
    fi
}

# Function to check if Composer is installed
check_composer() {
    echo "Checking Composer..."
    if ! command -v composer &> /dev/null; then
        echo "Error: Composer is not installed or not in PATH."
        echo "Please install Composer: https://getcomposer.org/"
        exit 1
    fi
    COMPOSER_VERSION=$(composer --version)
    echo "Success: Composer is installed ($COMPOSER_VERSION)."
}

# --- Main Script Logic (Phase 1) ---

echo "--- WhatsApp Billing System Installer ---"
echo "--- Phase 1: Core Setup and Prerequisite Checks ---"
echo ""

# 1. Check PHP Version
check_php_version
echo ""

# 2. Check PHP Extensions
# Required extensions: pdo_mysql (database), curl (API calls), json (API calls), mbstring (string manipulation)
check_php_extensions "pdo_mysql" "curl" "json" "mbstring"
echo ""

# 3. Check Composer
check_composer
echo ""

# 4. File Placement Check (Basic)
echo "Ensuring project files are in place..."
if [ ! -f "public/index.php" ] || [ ! -d "app/Controllers" ]; then
    echo "Warning: Some project files seem to be missing."
    echo "Please ensure you are running this script from the root directory of the project (e.g., 'whatsapp_billing_system/')."
    # Optionally, add an exit here if this is critical for this phase
    # exit 1 
else
    echo "Success: Key project files appear to be present (script assumes it's run from project root)."
fi
echo ""

# --- Phase 1.5: Ensure Application Directories ---
echo ""
echo "--- Phase 1.5: Ensure Application Directories ---"
echo ""

echo "Creating 'logs' directory..."
if mkdir -p logs; then
    echo "Success: 'logs' directory created/ensured."
else
    echo "Error: Could not create 'logs' directory. Please check permissions."
    exit 1
fi

echo "Creating 'public/css' directory..."
if mkdir -p public/css; then
    echo "Success: 'public/css' directory created/ensured."
else
    echo "Error: Could not create 'public/css' directory. Please check permissions."
    exit 1
fi

echo "Creating 'public/img' directory..."
if mkdir -p public/img; then
    echo "Success: 'public/img' directory created/ensured."
else
    echo "Error: Could not create 'public/img' directory. Please check permissions."
    exit 1
fi

echo "Creating 'tests' directory..."
if mkdir -p tests; then
    echo "Success: 'tests' directory created/ensured."
else
    echo "Error: Could not create 'tests' directory. Please check permissions."
    exit 1
fi

echo "Creating 'app/Core' directory..."
if mkdir -p app/Core; then
    echo "Success: 'app/Core' directory created/ensured."
else
    echo "Error: Could not create 'app/Core' directory. Please check permissions."
    exit 1
fi

echo "Creating 'app/Http' directory..."
if mkdir -p app/Http; then
    echo "Success: 'app/Http' directory created/ensured."
else
    echo "Error: Could not create 'app/Http' directory. Please check permissions."
    exit 1
fi

echo "Creating 'app/Lib' directory..."
if mkdir -p app/Lib; then
    echo "Success: 'app/Lib' directory created/ensured."
else
    echo "Error: Could not create 'app/Lib' directory. Please check permissions."
    exit 1
fi
echo ""
echo "Success: All specified application directories created/ensured."
echo ""

echo "--- Phase 1 & 1.5 Setup Checks Completed ---"

# --- Phase 2: Application Configuration ---
echo ""
echo "--- Phase 2: Application Configuration ---"
echo ""

# 1. Ensure config directory exists
echo "Ensuring 'config' directory exists..." # This is slightly redundant if moved to Phase 1.5, but harmless.
                                          # Keeping it here as per original Phase 2 logic.
if mkdir -p config; then
    echo "Success: 'config' directory is present."
else
    echo "Error: Could not create 'config' directory. Please check permissions."
    exit 1
fi
echo ""

# 2. Copy config.php.template to config.php
echo "Setting up configuration file..."
CONFIG_FILE="config/config.php"
CONFIG_TEMPLATE="config/config.php.template"

if [ -f "$CONFIG_FILE" ]; then
    echo "Warning: Configuration file '$CONFIG_FILE' already exists."
    echo "Skipping copy from template to avoid overwriting your settings."
else
    if [ -f "$CONFIG_TEMPLATE" ]; then
        if cp "$CONFIG_TEMPLATE" "$CONFIG_FILE"; then
            echo "Success: '$CONFIG_TEMPLATE' copied to '$CONFIG_FILE'."
        else
            echo "Error: Could not copy '$CONFIG_TEMPLATE' to '$CONFIG_FILE'. Please check permissions."
            exit 1
        fi
    else
        echo "Error: Configuration template '$CONFIG_TEMPLATE' not found. Cannot create '$CONFIG_FILE'."
        echo "Please ensure '$CONFIG_TEMPLATE' is present in the 'config' directory."
        exit 1
    fi
fi
echo ""

# 3. User Instruction for Manual Configuration
echo "--- IMPORTANT ACTION REQUIRED ---"
echo "You MUST manually edit the configuration file: $CONFIG_FILE"
echo "Please update it with your specific details for:"
echo "  - Database credentials (DB_HOST, DB_NAME, DB_USER, DB_PASS)"
echo "  - Asaas API Key (ASAAS_API_KEY) and Base URL (if different from default)"
echo "  - Whaticket API Key (WHATICKET_API_KEY) and Base URL"
echo "The application will not function correctly until these settings are updated."
echo "---------------------------------"
echo ""

echo "--- Phase 2 Configuration Setup Completed ---"

# --- Phase 3: Dependencies and Database Setup ---
echo ""
echo "--- Phase 3: Dependencies and Database Setup ---"
echo ""

# 1. Install Composer Dependencies
echo "Installing Composer dependencies..."
if [ ! -f "composer.json" ]; then
    echo "Warning: composer.json not found. Skipping 'composer install'."
    echo "If your project has PHP dependencies, please ensure composer.json is present and run 'composer install' manually."
else
    composer install --no-dev --optimize-autoloader
    if [ $? -eq 0 ]; then
        echo "Success: Composer dependencies installed."
    else
        echo "Error: Composer install failed. Please check the output above for details."
        exit 1
    fi
fi
echo ""

# 2. Database Schema Setup
echo "Attempting to set up database schema..."
echo "This will use the credentials you configured in '$CONFIG_FILE'."

# Check for get_db_creds.php
DB_CREDS_SCRIPT="get_db_creds.php"
if [ ! -f "$DB_CREDS_SCRIPT" ]; then
    echo "Error: Database credentials helper script '$DB_CREDS_SCRIPT' not found."
    echo "Cannot proceed with database setup."
    exit 1
fi

# Get DB credentials
DB_CREDS_OUTPUT=$(php "$DB_CREDS_SCRIPT")
if [ $? -ne 0 ]; then
    echo "Error: Failed to execute '$DB_CREDS_SCRIPT'."
    echo "Output: $DB_CREDS_OUTPUT"
    exit 1
fi

# Check if output indicates an error from the script itself
if echo "$DB_CREDS_OUTPUT" | grep -q "ERROR:"; then
    echo "Error retrieving database credentials from '$DB_CREDS_SCRIPT':"
    echo "$DB_CREDS_OUTPUT"
    exit 1
fi

# Parse credentials (assuming 4 lines: host, name, user, pass)
DB_HOST=$(echo "$DB_CREDS_OUTPUT" | sed -n '1p')
DB_NAME=$(echo "$DB_CREDS_OUTPUT" | sed -n '2p')
DB_USER=$(echo "$DB_CREDS_OUTPUT" | sed -n '3p')
DB_PASS_FROM_CONFIG=$(echo "$DB_CREDS_OUTPUT" | sed -n '4p') # We won't use this directly in the mysql command for prompting

if [ -z "$DB_HOST" ] || [ -z "$DB_NAME" ] || [ -z "$DB_USER" ] || [ -z "$DB_PASS_FROM_CONFIG" ]; then
    echo "Error: Could not parse one or more database credentials from '$DB_CREDS_SCRIPT' output."
    echo "Raw output: $DB_CREDS_OUTPUT"
    exit 1
fi

echo "DB Credentials Parsed: Host=$DB_HOST, Name=$DB_NAME, User=$DB_USER (Password will be prompted)"

# Check for mysql CLI
echo "Checking for MySQL CLI..."
if ! command -v mysql &> /dev/null; then
    echo "Error: MySQL CLI client is not installed or not in PATH."
    echo "Please install MySQL client and ensure it's in your PATH to proceed with database setup."
    exit 1
fi
echo "Success: MySQL CLI client found."

# Execute schema.sql
SCHEMA_FILE="database/schema.sql"
if [ ! -f "$SCHEMA_FILE" ]; then
    echo "Error: Database schema file '$SCHEMA_FILE' not found."
    echo "Cannot proceed with database setup."
    exit 1
fi

echo "Executing database schema from '$SCHEMA_FILE'..."
echo "You will be prompted for the MySQL password for user '$DB_USER'."
# Note: Using -p without a password right after it will prompt.
# The $DB_PASS_FROM_CONFIG is read just to confirm it's set, but not used directly here for security.
mysql -h"$DB_HOST" -u"$DB_USER" -p "$DB_NAME" < "$SCHEMA_FILE"

if [ $? -eq 0 ]; then
    echo "Success: Database schema imported successfully into '$DB_NAME'."
else
    echo "Error: Database schema import failed. Please check the MySQL output above."
    echo "Ensure the database '$DB_NAME' exists and user '$DB_USER' has permissions."
    exit 1
fi
echo ""

echo "--- Phase 3 Dependencies and Database Setup Completed ---"
echo ""
echo "Installation script finished."
echo "To make this script executable (if you haven't already), run: chmod +x install.sh"

exit 0
