#!/bin/bash

# rm *.zip
# zip -r open.zip app artisan bin bootstrap composer.json config database .env lang public routes .scribe storage templates vendor modules

# Read the value of APP_NAME from .env file
APP_NAME=$(grep -E "^APP_NAME=" .env | cut -d "=" -f2)

# Replace spaces with underscores
APP_NAME=$(echo "$APP_NAME" | tr ' ' '_')

# Convert to lowercase
APP_NAME=$(echo "$APP_NAME" | tr '[:upper:]' '[:lower:]')

# Set the desired filename
FILENAME="${APP_NAME}.zip"

# Define the name of the .zipignore file
zip_ignore=".zipignore"

zip -r $FILENAME . --exclude @.zipignore

echo 'code zipped'
