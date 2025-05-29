# WhatsApp Billing System - Installation Guide

## 1. Introduction

The WhatsApp Billing System (WABS) is a PHP-based application designed to manage customers, invoices, and send billing reminders via WhatsApp, integrating with Asaas for payment processing and Whaticket (or a similar platform) for WhatsApp messaging.

This guide provides step-by-step instructions for installing and configuring the WABS application on your server. The primary tool for initial setup is the `install.sh` script, which automates prerequisite checks, directory creation, configuration file setup, dependency installation, and database schema import.

## 2. Prerequisites

Before you begin, ensure your server environment meets the following requirements:

*   **Operating System**: Linux-based OS (e.g., Ubuntu, CentOS) is recommended.
*   **PHP**: Version 8.0 or higher.
    *   **Required PHP Extensions**:
        *   `pdo_mysql` (for database connectivity)
        *   `curl` (for making API calls)
        *   `json` (for handling JSON data from APIs)
        *   `mbstring` (for string manipulation, often used by libraries)
*   **Database**: MySQL server version 8.0 or higher.
*   **Composer**: Latest stable version for PHP dependency management.
*   **Web Server**: Apache or Nginx with PHP integration (e.g., PHP-FPM).
*   **Shell Access**: Bash or a compatible shell to run scripts.
*   **API Keys**:
    *   **Asaas API Key**: Obtainable from your Asaas account dashboard.
    *   **Whaticket API Key**: Obtainable from your Whaticket instance (or chosen WhatsApp Business API provider).

The `install.sh` script will check for PHP version, extensions, and Composer during its execution.

## 3. Installation Steps

### Step 1: Download/Clone Application Files

Ensure you have the application files on your server. You might have cloned the repository from Git or downloaded a release package.

```bash
# Example if using Git:
# git clone <repository_url> whatsapp_billing_system
# cd whatsapp_billing_system
```

### Step 2: Prepare the Installation Script

Navigate to the root directory of the application and make the `install.sh` script executable.

```bash
cd /path/to/your/whatsapp_billing_system
chmod +x install.sh
```

(Replace `/path/to/your/whatsapp_billing_system` with the actual path to the project directory).

### Step 3: Run the Installation Script

Execute the installation script from the project's root directory:

```bash
./install.sh
```

The script will:
*   Perform prerequisite checks (PHP version, extensions, Composer).
*   Create necessary application directories if they don't exist.
*   Set up the initial configuration file (`config/config.php`) from a template.
*   **Prompt you to manually edit `config/config.php` with your specific credentials.**
*   Attempt to install Composer dependencies (if `composer.json` is present).
*   Attempt to import the database schema (`database/schema.sql`), prompting you for the MySQL database password for the user specified in `config/config.php`.

Follow any instructions or prompts provided by the script.

### Step 4: Manual Configuration

The `install.sh` script copies `config/config.php.template` to `config/config.php` if the latter does not exist. **This is a critical step:**

You **MUST** manually edit the `config/config.php` file to replace placeholder values with your actual:
*   Database connection details (host, database name, user, password).
*   Asaas API Key and Base URL (if different from the default).
*   Whaticket API Key and Base URL.

The application will not function correctly without these settings.

### Step 5: Database Schema (if script failed or for manual check)

If the `install.sh` script was unable to import the database schema, or if you need to do it manually, you can use the following command. First, ensure your `config/config.php` is correctly filled out.

```bash
# 1. Read your DB_HOST, DB_USER, and DB_NAME from config/config.php
# 2. Execute the command (you will be prompted for the password):
# mysql -hYOUR_DB_HOST -uYOUR_DB_USER -pYOUR_DB_NAME < database/schema.sql
```
**Example:** If your `config.php` has `DB_HOST='localhost'`, `DB_USER='wabs_user'`, `DB_NAME='wabs_db'`, the command would be:
```bash
mysql -hlocalhost -uwabs_user -p wabs_db < database/schema.sql
```
**Note**: Be cautious when entering passwords directly on the command line in shared environments. The `-p` option without an immediately following password will prompt securely.

## 4. Web Server Configuration

Your web server must be configured to serve the application from the `public/` directory. URL rewriting should also be enabled to ensure all requests are routed through `public/index.php`.

### Apache Configuration Example

You'll typically create a new virtual host configuration file (e.g., `/etc/apache2/sites-available/wabs.conf`).

```apache
<VirtualHost *:80>
    ServerName yourdomain.com # Replace with your domain or server IP
    DocumentRoot /path/to/your/whatsapp_billing_system/public

    <Directory /path/to/your/whatsapp_billing_system/public>
        AllowOverride All
        Require all granted
        Options FollowSymLinks
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/wabs_error.log
    CustomLog ${APACHE_LOG_DIR}/wabs_access.log combined
</VirtualHost>
```

*   Replace `yourdomain.com` and `/path/to/your/whatsapp_billing_system/public`.
*   Enable the site: `sudo a2ensite wabs.conf` (or your filename).
*   Enable Apache's rewrite module: `sudo a2enmod rewrite`.
*   Restart Apache: `sudo systemctl restart apache2`.

#### `public/.htaccess` for Apache

If you use `AllowOverride All`, create or ensure the following `.htaccess` file is present in the `whatsapp_billing_system/public/` directory:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L,QSA]
</IfModule>
```
This `.htaccess` helps route all non-file/non-directory requests to `index.php`.

### Nginx Configuration Example

Create a new server block configuration file (e.g., `/etc/nginx/sites-available/wabs`).

```nginx
server {
    listen 80;
    server_name yourdomain.com; # Replace with your domain or server IP
    root /path/to/your/whatsapp_billing_system/public;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        # Adjust the socket path according to your PHP-FPM version and setup
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock; # Example for PHP 8.0
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Deny access to .htaccess files, if Apache's .htaccess is present
    location ~ /\.ht {
        deny all;
    }

    # Optional: Logging
    access_log /var/log/nginx/wabs_access.log;
    error_log /var/log/nginx/wabs_error.log;
}
```

*   Replace `yourdomain.com`, `/path/to/your/whatsapp_billing_system/public`, and the `fastcgi_pass` PHP-FPM socket path as needed.
*   Enable the site by creating a symbolic link: `sudo ln -s /etc/nginx/sites-available/wabs /etc/nginx/sites-enabled/`.
*   Test Nginx configuration: `sudo nginx -t`.
*   Restart Nginx: `sudo systemctl restart nginx`.

## 5. File Permissions

The web server needs write access to certain directories. The `logs/` directory is essential for application logging.

```bash
# Navigate to your project root
cd /path/to/your/whatsapp_billing_system

# Set ownership to the web server user (e.g., www-data for Apache/Nginx on Debian/Ubuntu)
# Replace 'www-data:www-data' if your web server user/group is different
sudo chown -R www-data:www-data logs/

# Set permissions for the logs directory
# 775 allows user and group to read/write/execute, and others to read/execute.
# 755 allows only owner to write, group/others to read/execute.
# For logs, web server needs to write.
sudo chmod -R 775 logs/
```
If other directories require write access by the application at runtime (e.g., cache, uploads - not currently part of this project structure), they would need similar permission adjustments. The `config/` directory is currently edited manually, so it doesn't need web server write access.

## 6. Cron Job Setup

The `cron_send_reminders.php` script is designed to be run periodically to automate sending billing reminders.

1.  Open your crontab for editing:
    ```bash
    crontab -e
    ```

2.  Add a line for the cron job. For example, to run the script daily at 2:00 AM:
    ```cron
    0 2 * * * /usr/bin/php /path/to/your/whatsapp_billing_system/cron_send_reminders.php >> /path/to/your/whatsapp_billing_system/logs/cron.log 2>&1
    ```

    **Breakdown:**
    *   `0 2 * * *`: Cron schedule (minute, hour, day of month, month, day of week). This means "at 02:00 on every day-of-month, every month, and every day-of-week".
    *   `/usr/bin/php`: Path to your PHP CLI executable. Verify this path using `which php`.
    *   `/path/to/your/whatsapp_billing_system/cron_send_reminders.php`: Absolute path to the cron script.
    *   `>> /path/to/your/whatsapp_billing_system/logs/cron.log 2>&1`: Redirects both standard output (`stdout`) and standard error (`stderr`) to a log file named `cron.log` within your application's `logs` directory. This is highly recommended for troubleshooting.

3.  **Adjust Paths**: Ensure all paths (PHP CLI, cron script, log file) are correct for your server environment.
4.  **Frequency**: Choose a suitable frequency for reminders (e.g., daily, every few hours) depending on your business needs.

## 7. Final Verification

*   **Web Application**: Open your configured domain (e.g., `http://yourdomain.com`) in a web browser. You should see the home page of the WABS application.
*   **API Endpoints**: Test an API endpoint. If URL rewriting is working, try:
    `http://yourdomain.com/api/customers/test_id`
    If URL rewriting is not yet fully configured or you are using PHP's built-in server (not recommended for production), you might need to include `index.php`:
    `http://yourdomain.com/index.php/api/customers/test_id`
    You should receive a JSON response from the placeholder controller.
*   **Logs**: Check your web server error logs (e.g., `/var/log/apache2/wabs_error.log` or `/var/log/nginx/wabs_error.log`) and application logs (`whatsapp_billing_system/logs/`) if you encounter any issues.

## 8. Troubleshooting (Basic)

*   **500 Internal Server Error**: Often PHP errors. Check web server logs and enable PHP error display if in a development environment (not recommended for production).
*   **404 Not Found**:
    *   For web pages: Check your web server `DocumentRoot` and file paths.
    *   For API routes: Ensure URL rewriting is working correctly or that you are including `index.php` in the path if necessary.
*   **Permission Errors**: If the script reports inability to create directories or files, or the application cannot write logs, check file/directory ownership and permissions.
*   **Database Connection Errors**: Double-check credentials in `config/config.php` and ensure the MySQL server is running and accessible with the provided user/host.
*   **API Key Issues**: If Asaas or Whaticket integrations fail, verify your API keys in `config/config.php` are correct and active.

This guide should help you get the WhatsApp Billing System up and running. For further issues, consult the specific error messages and logs.Okay, I have created the `INSTALL_GUIDE.md` file in the `/app/whatsapp_billing_system/` directory with all the specified sections and content using the `create_file_with_block` tool in the previous turn.

Now, as requested, I will output the content of this `INSTALL_GUIDE.md` file.
