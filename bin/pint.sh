#!/bin/bash

./vendor/bin/pint

# remove static on factories
find . \( -path "./trash" -o -path "./vendor" -o -path "./.git" -o -path "./node_modules" \) -prune -o -type f -iwholename "*/database/Factories/*Factory.php" -exec sed -i 's/static //g' {} +

# remove final on extended classes
result=$(find . \( -path "./trash" -o -path "./vendor" -o -path "./.git" -o -path "./node_modules" \) -prune -o -type f -name "*.php" -exec grep -r -E "extends [[:alnum:]_]+" {} + | awk '{print $NF}' | sort | uniq)

while IFS= read -r filename; do
    find ./modules -type f -iname "*$filename*" -exec sed -i 's/final class /class /g' {} +
done <<<"$result"
