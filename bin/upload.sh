#!/bin/bash

source ./bin/functions.sh

FTP_HOST="ftp.atelier-pret-et-finance.com"
FTP_USERNAME="llyam@atelier-pret-et-finance.com"
FTP_PASSWORD="H.8_@4A?TvPT"
FILENAME=$(get_app_name)

if [ -f "$FILENAME" ]; then
    # Get the file creation time
    created_time=$(stat -c "%Y" "$FILENAME")
    current_time=$(date +"%s")

    # Calculate the time difference in seconds
    time_diff=$((current_time - created_time))
    one_hour_ago=$((60 * 60))

    if [ "$time_diff" -ge "$one_hour_ago" ]; then
        ./bin/zip.sh
    fi
else
    ./bin/zip.sh
fi

ftp -n $FTP_HOST <<END_SCRIPT
quote USER $FTP_USERNAME
quote PASS $FTP_PASSWORD
binary

put $FILENAME

quit
END_SCRIPT

exit 0
