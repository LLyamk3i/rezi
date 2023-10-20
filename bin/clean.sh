#!/bin/bash

temp_file="/tmp/unfinalize-classes.txt"

if [ "$1" == "survey" ]; then
    ./bin/check/survey.sh
fi

rm ./storage/logs/*.log
./artisan clear-compiled
./artisan optimize:clear
./bin/pint.sh

content=$(cat $temp_file)
IFS=$'\n' read -rd '' -a unfinalizes <<<"$content"
for unfinalize in "${unfinalizes[@]}"; do
    sed -i "s/final //g" "$unfinalize"
done
