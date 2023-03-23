#!/bin/bash

rm ./storage/logs/*.log
./vendor/bin/pint
./vendor/bin/phpstan analyse
./artisan clear-compiled
./artisan optimize:clear
