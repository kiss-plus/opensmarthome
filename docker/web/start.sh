#!/usr/bin/env bash

source /usr/local/bin/secrets.sh
/var/www/opensmarthome/bin/console cache:clear
/var/www/opensmarthome/bin/console cache:warmup
/usr/local/bin/apache2-foreground -e DEBUG