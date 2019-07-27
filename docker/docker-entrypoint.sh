#!/bin/bash
# bugs in macos
set -e
sudo Xvfb :99 -screen 0 1280x1024x24 &

# install composer
if [ "$RUN_COMPOSE" = "1" ] ; then
	sudo composer self-update --no-interaction
	composer install -n
fi;

# dump_routes composer
if [ "$DUMP_ROUTES" = "1" ] ; then
	php bin/console fos:js-routing:dump --format=json --target=web/bundles/js/fos_js_routes.json

fi;

# setup database
if [ "$SETUP_DB" = "1" ] ; then
	php bin/console doctrine:schema:drop --force
	php bin/console doctrine:migrations:migrate -n
	php bin/console hautelook:fixtures:load -n
fi;

# yarn
if [ "$RUN_YARN" = "1" ] ; then
	yarn install
fi;

# install FCK Editor
if [ "$INSTALL_FCK" = "1" ] ; then
	php bin/console ckeditor:install
	php bin/console assets:install web
fi;

exec "$@"
