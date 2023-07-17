#!/bin/bash
source ./bin/functions.sh

rm *.zip
rm -r public/storage

FILENAME=$(get_app_name)

echo $FILENAME

# # Define the name of the .zipignore file
zip_ignore=".zipignore"

zip -r $FILENAME . --exclude @.zipignore

echo 'code zipped'
