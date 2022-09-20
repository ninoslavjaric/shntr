#!/bin/bash

BASEDIR=$(dirname "$0")
CURRENT_TIMESTAMP=$(date +%s)

cat "$BASEDIR/_migration.sql.example" | sed "s/MIGRATION_NAME/$CURRENT_TIMESTAMP/" | tee "$BASEDIR/$CURRENT_TIMESTAMP.sql"
