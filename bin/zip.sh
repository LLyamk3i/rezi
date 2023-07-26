#!/bin/bash
source ./bin/functions.sh

rm *.zip
rm -r public/storage

FILENAME=$(get_app_name)

case "$1" in
"all")
    zip -r $FILENAME . --exclude @.zipignore
    ;;
"git")
    git archive --format=zip HEAD -o $FILENAME
    ;;
"time")
    zip -r $FILENAME $(find . -type f -mtime -$2 | grep -Ev -f .zipignore)
    ;;
esac

# Append the contents of .zipkeep to the existing zip archive
zip -g $FILENAME -@ < .zipkeep

echo 'code zipped'