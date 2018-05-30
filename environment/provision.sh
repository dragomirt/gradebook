#!/usr/bin/env bash

echo "Installing LAMP Stack and setting it up..."
echo "Installing Apache..."
apt-get update >/dev/null 2>&1
apt-get install -y apache2 >/dev/null 2>&1
echo "Installing PHP and GIT..."
apt-get install python-software-properties software-properties-common -y >/dev/null 2>&1
add-apt-repository ppa:ondrej/php -y >/dev/null 2>&1
apt-get update >/dev/null 2>&1
apt-get install php7.1 php7.1-fpm php7.1-mysql php7.1-zip php7.1-mcrypt php7.1-mbstring php git -y >/dev/null 2>&1
phpenmod mcrypt
phpenmod mbstring
echo "Installing MySQL..."
debconf-set-selections <<< 'mysql-server mysql-server/root_password password toor' >/dev/null 2>&1
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password toor' >/dev/null 2>&1
apt-get install mariadb-server -y >/dev/null 2>&1
echo "Installing phpmyadmin..."
debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/admin-pass password toor' >/dev/null 2>&1
debconf-set-selections <<< 'phpmyadmin phpmyadmin/setup-password password toor' >/dev/null 2>&1
debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/app-pass password toor' >/dev/null 2>&1
debconf-set-selections <<< 'phpmyadmin phpmyadmin/app-password-confirm password toor' >/dev/null 2>&1
debconf-set-selections <<< 'phpmyadmin phpmyadmin/password-confirm password toor' >/dev/null 2>&1
debconf-set-selections <<< 'phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2' >/dev/null 2>&1
debconf-set-selections <<< 'phpmyadmin phpmyadmin/dbconfig-install boolean true' >/dev/null 2>&1
debconf-set-selections <<< 'phpmyadmin phpmyadmin/dbconfig-install boolean true' >/dev/null 2>&1
apt-get install phpmyadmin -y >/dev/null 2>&1
echo "Setting up the path to the local server..."
rm -rf /var/www/html
ln -fs /vagrant /var/www/html
echo "Importing the database..."
mysql -uroot -ptoor -e "CREATE DATABASE ioncrean_catalogdb" >/dev/null 2>&1
mysql -uroot -ptoor ioncrean_catalogdb < /vagrant/db_structure/ioncrean_catalogdb.sql >/dev/null 2>&1
echo "The box has been successfully provisioned!"