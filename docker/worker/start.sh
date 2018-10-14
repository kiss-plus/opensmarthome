#!/usr/bin/env bash

source /usr/local/bin/secrets.sh
$PROJECT_DIR/bin/console cache:clear
$PROJECT_DIR/bin/console cache:warmup
$PROJECT_DIR/bin/console rabbitmq:consumer actuators