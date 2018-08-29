#!/usr/bin/env bash

DB_NAME=$(cat /run/secrets/db_name)
DB_USER=$(cat /run/secrets/db_user)
DB_PASS=$(cat /run/secrets/db_password)
DB_HOST=$(cat /run/secrets/db_host)
DB_PORT=$(cat /run/secrets/db_port)

export DATABASE_URL=mysql://${DB_USER}:${DB_PASS}@${DB_HOST}:${DB_PORT}/${DB_NAME}
