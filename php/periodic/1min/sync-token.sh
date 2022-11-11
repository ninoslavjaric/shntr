#!/bin/sh
php /var/www/html/cli/sync-balances.php "${HOST}" > /tmp/$(date +%s).txt
