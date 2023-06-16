#!/bin/bash

rm ./storage/logs/*.log
./bin/pint.sh
./vendor/bin/phpstan analyse
./artisan clear-compiled
./artisan optimize:clear
