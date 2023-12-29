#!/bin/bash

directories=("database/factories" "modules" "tests" "routes")
patterns='-ipath '*/database/Factories/*' -o -name *.test.php -o -name console.php'
needles=(
    "closure: static function (): void {"
    "state(state: static"
    ", callback: static function"
    "conditionOrMessage: static fn (): bool"
)

for dir in "${directories[@]}"; do
    for needle in "${needles[@]}"; do
        find "$dir" -type f \( $patterns \) -exec grep -l "$needle" {} \; | while read -r file; do
            sed -i "s/$needle/${needle/' static'/}/g" "$file"
        done
    done
done
