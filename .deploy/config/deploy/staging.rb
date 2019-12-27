set :stage, :dev
set :symfony_env, "dev"

set :branch, 'master' # your staging branch
set :deploy_to, '/home/ubuntu/htdocs/devis.alliancelogistics.fr/staging' # path on production server

after 'deploy:updated', 'deploy:migrate' # Comment this if you don't want update the database
after 'deploy:finished', 'assets:install' # Comment this if you don't want update the database

set :controllers_to_clear, ['app_*']
set :composer_install_flags, '--prefer-dist --no-interaction --optimize-autoloader'


server '193.70.113.222', user: 'ubuntu', port: 22, roles: %w{app db web} # edit IP / Port and SSH user of your production server
SSHKit.config.command_map[:composer] = "php #{shared_path.join("composer.phar")}"

namespace :assets do
  task :install do
    on "ubuntu@193.70.113.222" do
        invoke 'symfony:console', 'assets:install', ' public'
        execute "cd #{fetch(:deploy_to)}/current && yarn"
        execute "cd #{fetch(:deploy_to)}/current && yarn run encore production"
    end
  end
end
