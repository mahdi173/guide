set :stage, :dev
set :symfony_env, "prod"

set :branch, 'sulu' # your staging branch
set :deploy_to, '/home/ubuntu/htdocs/guidejournal.net/preprod' # path on production server

set :server_host, "51.75.253.76"
set :server_username, "ubuntu"

after 'deploy:updated', 'deploy:migrate' # Comment this if you don't want update the database
# after 'deploy:finished', 'assets:install' # Comment this if you don't want update the database

set :controllers_to_clear, ['app_*']
set :composer_install_flags, '--prefer-dist --no-interaction --optimize-autoloader'


server "#{fetch(:server_host)}", user: "#{fetch(:server_username)}", port: 22, roles: %w{app db web} # edit IP / Port and SSH user of your production server
SSHKit.config.command_map[:composer] = "php #{shared_path.join("composer.phar")}"

namespace :assets do
  task :install do
    on "#{fetch(:server_username)}@#{fetch(:server_host)}" do
        invoke 'symfony:console', 'assets:install', ' public'
        execute "cd #{fetch(:deploy_to)}/current && yarn"
        execute "cd #{fetch(:deploy_to)}/current && yarn run dev"
        invoke 'symfony:console', 'sulu:admin:download-build'
    end
  end
end
