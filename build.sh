#!/bin/bash

# Vercel's PHP runtime path
PHP_PATH="/vercel/path0/.vercel/php/bin/php"

# Check if PHP exists
if [ -f "$PHP_PATH" ]; then
    echo "Using PHP at: $PHP_PATH"
    $PHP_PATH -v
    
    # Download Composer
    $PHP_PATH -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    $PHP_PATH composer-setup.php
    $PHP_PATH -r "unlink('composer-setup.php');"
    
    # Install dependencies
    $PHP_PATH composer.phar install --no-dev --optimize-autoloader
    
    # Dump autoload
    $PHP_PATH composer.phar dump-autoload --optimize
else
    echo "PHP not found at expected path. Using system PHP..."
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php
    php composer.phar install --no-dev --optimize-autoloader
    php composer.phar dump-autoload --optimize
fi

echo "Build completed!"