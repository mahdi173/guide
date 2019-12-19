# config valid only for current version of Capistrano
# lock '3.5.0'

set :application, 'guidejournal.net'
set :repo_url, 'git@github.com:multiinfo/guidejournal.git'

set :bin_path, "bin"
set :config_path, "config"
set :var_path, "var"
set :web_path, "public"

# The next settings are lazily evaluated from the above values, so take care
# when modifying them
set :log_path, "var/log"
set :cache_path, "var/cache"

set :symfony_console_path, "bin/console"
set :symfony_console_flags, "--no-debug"

# asset management
set :assets_install_path, "public"
set :assets_install_flags,  '--symlink'

# Share files/directories between releases
set :linked_dirs, ["public/media", "public/uploads", "var/log", "vendor", "node_modules"]

# To use a .env file:
set :linked_files, [".env.local"]

# Set correct permissions between releases, this is turned off by default
set :file_permissions_paths, ["var", "public/media", "public/uploads"]
set :file_permissions_users, ["www-data"]
set :permission_method, false

# Role filtering
set :symfony_roles, :all
set :symfony_deploy_roles, :all

# Add extra environment variables:
set :default_env, {
 'APP_ENV' => 'prod'
}

set :keep_releases, 5

before "deploy:updated", "deploy:set_permissions:acl"

after 'deploy:starting', 'composer:install_executable'
after 'deploy:starting', 'deploy:grant_access'
after 'deploy:updated', 'deploy:grant_access'
after 'deploy:finished', 'assets:install'
after 'deploy:finished', 'server:restart'

namespace :deploy do
  task :migrate do
    # invoke 'symfony:console', 'doctrine:schema:drop', '--force'
    invoke 'symfony:console', 'doctrine:schema:update', '--force'
    # invoke 'symfony:console', 'd:fixtures:load', '--no-interaction' # Comment this if you have no fixtures
    # invoke 'symfony:console', 'doctrine:schema:update', '--force'
  end
  task :clean_schema do
    invoke 'symfony:console', 'doctrine:schema:drop', '--force'
    invoke 'symfony:console', 'doctrine:schema:update', '--force'
    invoke 'symfony:console', 'doctrine:fixtures:load', '--no-interaction' # Comment this if you have no fixtures
  end
  task :grant_access do
    on "ubuntu@149.202.46.154" do
        execute "cd #{fetch(:deploy_to)}/ && sudo chown ubuntu:www-data shared/ -R"
        execute "cd #{fetch(:deploy_to)}/ && sudo chmod 0775 shared/ -R"
        execute "cd #{fetch(:deploy_to)}/ && sudo chown ubuntu:www-data releases/ -R"
        execute "cd #{fetch(:deploy_to)}/ && sudo chmod 0775 releases/ -R"
    end
  end
end

namespace :debug do
  task :cmd do
    on "ubuntu@149.202.46.154" do
        invoke 'symfony:console', 'ckeditor:install'
        invoke 'symfony:console', 'assets:install', ' public'
    end
  end
end

namespace :assets do
  task :install do
    on "ubuntu@149.202.46.154" do
        invoke 'symfony:console', 'assets:install', ' public'
        execute "cd #{fetch(:deploy_to)}/current && yarn"
        execute "cd #{fetch(:deploy_to)}/current && yarn run build"
    end
  end
end

namespace :server do
  task :restart do
    on "ubuntu@149.202.46.154" do
        execute "sudo service apache2 restart"
    end
  end
end
