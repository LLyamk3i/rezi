#!/bin/bash

echo $1
source ./bin/functions.sh

rm *.zip
rm -r public/storage

./bin/version/updater.sh
./bin/version/versioning.sh

FILENAME="$(jq '.version' composer.json | tr -d \")-$(get_app_name)"

read -p "choose the amount of compression ('git', 'time' or 'all'): " choice

case "$choice" in

"git")
    git log -1 --name-only --pretty=format:HEAD | zip $FILENAME -@
    ;;
"time")
    composer u --no-dev
    zip -r $FILENAME $(find . -type f -mtime -$2 | grep -Ev -f .zipignore)
    ;;
"all")
    composer u --no-dev
    zip -r $FILENAME . --exclude @.zipignore
    ;;
esac

# Append the contents of .zipkeep to the existing zip archive
zip -g $FILENAME -@ <.zipkeep

echo 'code zipped'
