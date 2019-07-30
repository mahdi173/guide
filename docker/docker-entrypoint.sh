#!/bin/bash
# bugs in macos
set -e
sudo Xvfb :99 -screen 0 1280x1024x24 &

if [ -f "composer.phar" ]; then
    php composer.phar install -n
fi

# yarn
yarn install

php bin/console d:s:u -f

exec "$@"
