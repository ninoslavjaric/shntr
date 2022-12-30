#!/bin/sh

cd /var/logs/php-fpm || exit 1
el=error.log
touch $el
chown 1000:1000 $el
nel=error.$(date +%s).log
mv $el $nel
gzip $nel;
chown 1000:1000 $nel.gz
touch $el
chown 1000:1000 $el
