#!/bin/bash

./bin/zip.sh

FTP_HOST="ftp.bmcisonline.com"
FTP_USERNAME="weed@bmcisonline.com"
FTP_PASSWORD="rx099%X-2=wy"

ftp -n $FTP_HOST <<END_SCRIPT
quote USER $FTP_USERNAME
quote PASS $FTP_PASSWORD
binary

put $(php -r "echo (require __DIR__ .  '/config.php')['name'];").zip

quit
END_SCRIPT

exit 0