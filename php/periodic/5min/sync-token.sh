#!/bin/sh
php /var/www/html/cli/sync-balances.php "${HOST}" > /tmp/balances$(date +%s).txt
