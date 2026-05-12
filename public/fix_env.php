<?php
/**
 * Fix .env file on the server
 * DELETE THIS FILE AFTER USE!
 */

$envPath = dirname(__DIR__) . '/.env';

$envContent = 'APP_NAME="Edu Ular Tangga"
APP_ENV=production
APP_KEY=base64:TNAaX0ZTlSE3noxsSDDmpCRtDUvlLZx4bwAwT5SLE8g=
APP_DEBUG=false
APP_URL=https://yaladders.online

APP_LOCALE=id
APP_FALLBACK_LOCALE=id
APP_FAKER_LOCALE=id_ID

APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u324142816_yaladders
DB_USERNAME=u324142816_yaladders
DB_PASSWORD=Yaladders123#

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
';

// Write the .env file
file_put_contents($envPath, $envContent);

echo "<h2>✅ .env file has been fixed!</h2>";
echo "<p>File written to: " . $envPath . "</p>";
echo "<pre>" . htmlspecialchars($envContent) . "</pre>";

// Clear config cache
echo "<h3>Clearing config cache...</h3>";
$bootstrapCache = dirname(__DIR__) . '/bootstrap/cache/config.php';
if (file_exists($bootstrapCache)) {
    unlink($bootstrapCache);
    echo "<p>✅ Config cache cleared</p>";
} else {
    echo "<p>No config cache to clear</p>";
}

echo "<hr>";
echo "<p style='color:red; font-weight:bold;'>⚠️ DELETE THIS FILE (fix_env.php) IMMEDIATELY AFTER USE!</p>";
echo "<p><a href='/'>→ Go to homepage</a></p>";
