# Juste like the ci
FROM circleci/php:7.1-apache-node-browsers

#Install System Packages
RUN sudo apt install unzip zlib1g-dev libicu-dev libsqlite3-dev sqlite3 libpng-dev 

#Install PHP Extensions
RUN sudo -E docker-php-ext-install pdo_sqlite pdo_mysql zip pcntl intl gd

#Install wkhtmltopdf Package for pdf generation
# RUN sudo apt install wkhtmltopdf

RUN yes "" | sudo pecl install apcu && sudo -E docker-php-ext-enable apcu
RUN sudo -E docker-php-ext-install opcache

# Add node to sudoers ( without password )
USER root
RUN echo 'node ALL=NOPASSWD: ALL' >> /etc/sudoers.d/50-node \
&& echo 'Defaults    env_keep += "DEBIAN_FRONTEND"' >> /etc/sudoers.d/env_keep

USER circleci

EXPOSE 80
EXPOSE 8000

CMD ["sudo" , "apache2-foreground" ]
