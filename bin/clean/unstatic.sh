#!/bin/bash

# Define the directories where you want to search and replace
directories=( "database/factories" "modules" "tests" "routes" )

# Define the text you want to search for and remove
needle="static "

# Use the find command to locate the files with the text
# Then, use grep to search for the text, and sed to remove it
for dir in "${directories[@]}"; do
    find "$dir" -type f \( -ipath '*/database/Factories/*Factory.php' -o -name *.test.php -o -name console.php \) -exec grep -l "$needle" {} \; | while read -r file; do
        sed -i "s/$needle//g" "$file"
    done
done
