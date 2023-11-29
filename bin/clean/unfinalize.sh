#!/bin/bash

temp_file="./trash/tmp/unfinalize-classes.txt"

content=$(cat $temp_file)
IFS=$'\n' read -rd '' -a unfinalizes <<<"$content"
for unfinalize in "${unfinalizes[@]}"; do
    sed -i "s/final //g" "$unfinalize"
done
