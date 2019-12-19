set :stage, :dev
set :symfony_env, "dev"

set :branch, 'master' # your staging branch
set :deploy_to, '/home/agencemit/htdocs/guidejournal.net/staging' # path on production server

after 'deploy:updated', 'deploy:clean_schema' # Comment this if you don't want update the database

set :controllers_to_clear, ['app_*']
set :composer_install_flags, '--prefer-dist --no-interaction --optimize-autoloader'


server '149.202.46.154', user: 'ubuntu', port: 22, roles: %w{app db web} # edit IP / Port and SSH user of your production server
SSHKit.config.command_map[:composer] = "php #{shared_path.join("composer.phar")}"
