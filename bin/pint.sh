#!/bin/bash

./vendor/bin/pint
sed -i 's/final //' modules/Residence/Domain/ValueObjects/Distance.php
find . \( -path "./trash" -o -path "./vendor" -o -path "./.git" -o -path "./node_modules" \) -prune -o -type f -iwholename "*/database/Factories/*Factory.php" -exec sed -i 's/static //g' {} +
