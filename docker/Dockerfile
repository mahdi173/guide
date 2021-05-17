# Juste like the ci
FROM php:7.3-apache

#Install System Packages
RUN apt update && apt install -y libxml2-dev libzip-dev unzip zlib1g-dev libicu-dev libsqlite3-dev sqlite3 libpng-dev

#Install PHP Extensions
RUN docker-php-ext-install pdo_sqlite pdo_mysql zip pcntl intl gd dom

RUN pecl install apcu
RUN docker-php-ext-enable apcu

#Install wkhtmltopdf Package for pdf generation
#RUN sudo apt install wkhtmltopdf

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs

# Add node to sudoers ( without password )
#USER root
#RUN echo 'node ALL=NOPASSWD: ALL' >> /etc/sudoers.d/50-node \
#&& echo 'Defaults    env_keep += "DEBIAN_FRONTEND"' >> /etc/sudoers.d/env_keep

RUN a2enmod proxy_fcgi ssl rewrite proxy proxy_balancer proxy_http
RUN docker-php-ext-install xml
RUN docker-php-ext-enable xml

USER www-data

EXPOSE 80
EXPOSE 8000

CMD ["apache2-foreground" ]