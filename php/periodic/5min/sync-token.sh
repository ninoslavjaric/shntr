#!/bin/sh
gzip /tmp/*.txt
php /var/www/html/cli/sync-balances.php "${HOST}" > /tmp/$(date +%s).txt
