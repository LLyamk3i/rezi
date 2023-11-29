#!/bin/bash

if [ "$1" == "survey" ]; then
    ./bin/clean/survey.sh
    ./bin/clean/unfinalize.sh
fi

rm ./storage/logs/*.log
./artisan clear-compiled
./artisan optimize:clear
./vendor/bin/pint

# remove static on unstatic closure
./bin/clean/unstatic.sh

# remove empty folders
find . -type d -empty ! -path "./app/Models*" ! -path "./database/factories*" -exec rmdir {} \;

# remove final on inherited class
./bin/clean/unfinalize.sh
