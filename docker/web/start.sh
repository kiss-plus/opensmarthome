#!/usr/bin/env bash

source /usr/local/bin/secrets.sh
$PROJECT_DIR/bin/console cache:clear
$PROJECT_DIR/bin/console cache:warmup
/usr/local/bin/apache2-foreground -e DEBUG