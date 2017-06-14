#!/bin/bash
useradd -r -d /var/www/vhosts/#hostname# -c "#hostname#" #username# >/tmp/setup.log
echo '#username#:#password#' | chpasswd >/tmp/setup.log
wget https://ftp.drupal.org/files/projects/drupal-8.3.0.tar.gz >/tmp/setup.log
tar xvzf drupal-8.3.0.tar.gz >/tmp/setup.log
mv drupal-8.3.0/ /var/www/vhosts/#hostname# >/tmp/setup.log
cp /var/www/vhosts/#hostname#/sites/default/default.settings.php /var/www/vhosts/#hostname#/sites/default/settings.php >/tmp/setup.log
mkdir /var/www/vhosts/#hostname#/sites/default/files -p >/tmp/setup.log
mkdir /var/www/vhosts/#hostname#/logs
chown #username#.#username# /var/www/vhosts/#hostname#/ -R >/tmp/setup.log
chmod g+w /var/www/vhosts/#hostname#/sites/default/files/ >/tmp/setup.log
chmod g+w /var/www/vhosts/#hostname#/sites/default/settings.php >/tmp/setup.log
chmod a-w /var/www/vhosts/#hostname# >/tmp/setup.log
chmod u+w /var/www/vhosts/#hostname# >/tmp/setup.log