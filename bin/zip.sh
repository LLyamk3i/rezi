#!/bin/bash

echo $1
source ./bin/functions.sh

rm *.zip
rm -r public/storage

# composer u --no-dev

./bin/version/versioning.sh

FILENAME="$(jq '.version' composer.json | tr -d \")-$(get_app_name)"

case "$1" in

"git")
    git archive --format=zip HEAD -o $FILENAME
    ;;
"time")
    zip -r $FILENAME $(find . -type f -mtime -$2 | grep -Ev -f .zipignore)
    ;;
*)
    zip -r $FILENAME . --exclude @.zipignore
    ;;
esac

# Append the contents of .zipkeep to the existing zip archive
zip -g $FILENAME -@ <.zipkeep

echo 'code zipped'
