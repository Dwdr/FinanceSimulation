#!/bin/bash
composer dumpautoload
php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan view:clear
php artisan view:cache
php artisan route:clear
php artisan route:cache
php artisan optimize:clear

php artisan migrate:fresh
php artisan db:seed

echo "* * * * * cd $(pwd) && php artisan schedule:run >> /dev/null 2>&1
* * * * * cd $(pwd) && php artisan queue:work --stop-when-empty >> /dev/null 2>&1" > crontab_task.txt

crontab crontab_task.txt
