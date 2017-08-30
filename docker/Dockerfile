FROM ubuntu:16.04

# set mysql password
RUN echo "mysql-server mysql-server/root_password password toor" | debconf-set-selections
RUN echo "mysql-server mysql-server/root_password_again password toor" | debconf-set-selections

# install
RUN apt-get -y update && apt-get -y install mysql-client mysql-server apache2 php php-cli php-curl libapache2-mod-php php-mcrypt php-mysql curl
RUN cd /tmp && curl -s https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# configure mysql
RUN sed -i 's/^bind/#bind/' /etc/mysql/mysql.conf.d/mysqld.cnf
RUN service mysql start && mysql -u root -p'toor' -e "update mysql.user set Host='%';flush privileges;"

# configure apache
RUN sed -i 's/^short_open_tag = Off/short_open_tag = On/' /etc/php/7.0/apache2/php.ini
RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# expose ports
EXPOSE 3306
EXPOSE 80

# start it...
CMD service apache2 start && service mysql start && composer --working-dir=/var/www/secure/lib install && tail -f /var/log/apache2/error.log
