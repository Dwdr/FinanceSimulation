#!/bin/bash
composer dumpautoload

php artisan migrate:fresh
php artisan db:seed


jobs
