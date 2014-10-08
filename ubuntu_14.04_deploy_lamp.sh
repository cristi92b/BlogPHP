#!/bin/bash
echo "WARNING: backup all files in /var/www before running this script."
while true; do
    read -p "Do you wish to continue? (yes/no)" yn
    case $yn in
        [Yy]* ) break;;
        [Nn]* ) exit;;
        * ) echo "Please answer yes or no.";;
    esac
done
sudo apt-get update
sudo apt-get install expect

VAR=$(expect -c '
spawn apt-get -y install mysql-server
expect "New password for the MySQL \"root\" user:"
send "admin\r"
expect "Repeat password for the MySQL \"root\" user:"
send "admin\r"
expect eof
')

echo "$VAR"

sudo apt-get -y install mysql-client apache2 libapache2-mod-php5 php5 php5-cli php5-json php5-mysql php5-readline pkg-php-tools php-pear debpear git

cd /var/www
rm *
rm -r *
git clone --recursive https://github.com/cristi92b/BlogPHP.git .
sudo /etc/init.d/mysql start
mysql -u root -padmin <<EOF
CREATE DATABASE PHPDB;
EOF
mysql -D PHPDB -u root -padmin <<EOF
CREATE TABLE IF NOT EXISTS post( id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255) NOT NULL, createdTime TIMESTAMP NOT NULL DEFAULT 0, updateTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, content MEDIUMTEXT )ENGINE=INNODB;
EOF
mysql -D PHPDB -u root -padmin <<EOF
CREATE TABLE IF NOT EXISTS comment( id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50) NOT NULL, createdTime TIMESTAMP NOT NULL DEFAULT 0, updateTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, post_id INT UNSIGNED NOT NULL, content TEXT, FOREIGN KEY (post_id) REFERENCES post(id) ON DELETE CASCADE )ENGINE=INNODB;
EOF
mysql -D PHPDB -u root -padmin <<EOF
CREATE TABLE IF NOT EXISTS users( id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50) NOT NULL, role VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL );
EOF

echo "Please configure Apcahe2:"
echo "1. Edit virtual hosts and add /var/www/public_html/ as document root in /etc/apache2/sites-available/"
echo "2. Allow access override in /etc/apache2/apache2.conf for /var/www"


