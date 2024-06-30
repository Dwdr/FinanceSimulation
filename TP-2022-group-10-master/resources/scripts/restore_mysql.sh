#!/bin/sh

SQL_FILE=$1

DB_HOST=$(cat .env | grep "DB_HOST=*" | awk -F= '{print $2}')
DB_DATABASE=$(cat .env | grep "DB_DATABASE=*" | awk -F= '{print $2}')
DB_USERNAME=$(cat .env | grep "DB_USERNAME=*" | awk -F= '{print $2}')
DB_PASSWORD=$(cat .env | grep "DB_PASSWORD=*" | awk -F= '{print $2}')

mysql -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE < $SQL_FILE

echo success
