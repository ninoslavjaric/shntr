#!/bin/sh
gzip /tmp/*.txt
php /var/www/html/cli/process_token_transactions.php "${HOST}" > /tmp/process_token_transactions$(date +%s).txt
