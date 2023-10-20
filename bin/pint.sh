#!/bin/bash

./vendor/bin/pint

# remove static on factories
find . \( -path "./trash" -o -path "./vendor" -o -path "./.git" -o -path "./node_modules" \) -prune -o -type f -iwholename "*/database/Factories/*Factory.php" -exec sed -i 's/static //g' {} +
sed -i 's/static //g' ./routes/console.php

find . -type d -empty ! -path "./app/Models*" ! -path "./database/factories*" -exec rmdir {} \;
