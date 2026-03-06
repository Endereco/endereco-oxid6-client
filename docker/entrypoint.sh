#!/bin/bash
set -e

CONFIG="/var/www/html/source/config.inc.php"

# Wait for MySQL
echo "Waiting for MySQL at ${MYSQL_HOST:-db}:3306 ..."
until nc -z "${MYSQL_HOST:-db}" 3306; do
    sleep 1
done
echo "MySQL is ready."

# Configure config.inc.php on first start (placeholders still present)
if grep -q '<dbHost>' "$CONFIG" 2>/dev/null; then
    echo "Configuring config.inc.php ..."
    sed -i "s|<dbHost>|${MYSQL_HOST:-db}|g"           "$CONFIG"
    sed -i "s|<dbName>|${MYSQL_DATABASE:-db}|g"        "$CONFIG"
    sed -i "s|<dbUser>|${MYSQL_USER:-user}|g"          "$CONFIG"
    sed -i "s|<dbPwd>|${MYSQL_PASSWORD:-pwd}|g"        "$CONFIG"
    sed -i "s|<sShopURL>|${SHOP_URL:-http://localhost/}|g" "$CONFIG"
    sed -i "s|<sShopDir>|/var/www/html/source/|g"      "$CONFIG"
    sed -i "s|<sCompileDir>|/var/www/html/source/tmp/|g" "$CONFIG"
fi

# Auto-setup: import OXID schema + data and create default admin if DB is empty
SETUP_SQL_DIR="/var/www/html/vendor/oxid-esales/oxideshop-ce/source/Setup/Sql"
MYSQL_CMD="mysql -h ${MYSQL_HOST:-db} -u ${MYSQL_USER:-user} -p${MYSQL_PASSWORD:-pwd} ${MYSQL_DATABASE:-db} --skip-ssl --default-character-set=utf8"

if ! $MYSQL_CMD -e "SHOW TABLES LIKE 'oxconfig';" 2>/dev/null | grep -q oxconfig; then
    echo "Running OXID auto-setup ..."

    for SQL_FILE in database_schema.sql initial_data.sql initial_license.sql; do
        if [ -f "$SETUP_SQL_DIR/$SQL_FILE" ]; then
            echo "Importing $SQL_FILE ..."
            { echo "SET NAMES utf8;"; cat "$SETUP_SQL_DIR/$SQL_FILE"; } | $MYSQL_CMD
        fi
    done

    # Create default admin user via PHP PDO to safely handle the bcrypt hash
    php -r "
        \$pdo = new PDO(
            'mysql:host=${MYSQL_HOST:-db};dbname=${MYSQL_DATABASE:-db};charset=utf8',
            '${MYSQL_USER:-user}', '${MYSQL_PASSWORD:-pwd}'
        );
        \$pass = password_hash('admin', PASSWORD_BCRYPT);
        \$pdo->prepare('INSERT IGNORE INTO oxuser
            (OXID, OXACTIVE, OXRIGHTS, OXUSERNAME, OXPASSWORD, OXPASSSALT,
             OXFNAME, OXLNAME, OXSHOPID)
            VALUES (?, 1, ?, ?, ?, ?, ?, ?, ?)')
            ->execute(['oxdefaultadmin', 'malladmin', 'admin@example.com',
                       \$pass, '', 'Admin', 'Admin', 1]);
        \$pdo->prepare('INSERT IGNORE INTO oxobject2group
            (OXID, OXSHOPID, OXOBJECTID, OXGROUPSID)
            VALUES (MD5(?), ?, ?, ?)')
            ->execute(['oxdefaultadmin-oxidadmin', 1,
                       'oxdefaultadmin', 'oxidadmin']);
        echo 'Admin user created.' . PHP_EOL;
    "

    # Register and activate the Endereco module
    cd /var/www/html
    if [[ "${ENDERECO_USE_MIGRATIONS:-}" == "true" ]]; then
        echo "Migration mode: adding bEnderecoUseMigrations to config.inc.php ..."
        echo "\$this->bEnderecoUseMigrations = true;" >> "$CONFIG"
    fi
    vendor/bin/oe-console oe:module:install-configuration source/modules/endereco/endereco-oxid6-client
    vendor/bin/oe-console oe:module:activate endereco-oxid6-client
    if [[ "${ENDERECO_USE_MIGRATIONS:-}" == "true" ]]; then
        echo "Running Endereco migrations ..."
        vendor/bin/oe-eshop-db_migrate migrations:migrate
    fi
    rm -rf /var/www/html/source/tmp/*

    # Import demo data if available
    DEMODATA_SQL="/var/www/html/vendor/oxid-esales/oxideshop-demodata-ce/src/demodata.sql"
    if [ -f "$DEMODATA_SQL" ]; then
        echo "Importing demodata.sql ..."
        { echo "SET NAMES utf8;"; cat "$DEMODATA_SQL"; } | $MYSQL_CMD --force
        echo "Copying demo images ..."
        vendor/bin/oe-eshop-demodata_install
    fi

    # Generate multilanguage DB views required by OXID 6
    vendor/bin/oe-eshop-db_views_generate

    # Post-install: remove Setup directory and lock config.inc.php (health-check requirements)
    rm -rf /var/www/html/source/Setup
    chmod 444 "$CONFIG"

    echo "Auto-setup complete."
fi

# Regenerate Composer autoloader now that the module volume is mounted
echo "Regenerating autoloader ..."
cd /var/www/html && composer dump-autoload --no-dev --optimize --quiet

# Ensure writable directories are owned by www-data
chown -R www-data:www-data \
    /var/www/html/source/tmp \
    /var/www/html/source/log \
    /var/www/html/source/export \
    /var/www/html/var 2>/dev/null || true

exec "$@"
