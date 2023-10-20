#!/bin/bash

temp_file="/tmp/unfinalize-classes.txt"
output=$(./bin/check.sh 2>&1)

# Check the exit status of the command (0 indicates success)
if [ $? ] >0; then
    unprocessed=$(echo "$output" | grep "cannot extend final class")
    if [ -n "$unprocessed" ]; then

        # Split the input into lines
        IFS=$'\n' read -rd '' -a lines <<<"$unprocessed"

        # Initialize an array to store unique file names
        files=()

        # Process each line and extract file information
        for line in "${lines[@]}"; do
            # Check if the line contains "PHP Fatal error" and skip it
            if [[ $line == *"PHP Fatal error"* ]]; then
                continue
            fi

            # Check if the line contains "cannot extend final class"
            if [[ $line != *"cannot extend final class"* ]]; then
                continue
            fi

            # Extract the file name
            file=${line##*cannot extend final class} # Remove text before "cannot extend final class"
            file=${file#* }                          # Remove leading spaces
            file=$(echo "$file" | tr -d '[:space:]') # Remove all whitespace
            file=$(echo "$file" | tr '\\' '/')       # Replace backslashes with forward slashes
            file="$file.php"                         # Add ".php" extension

            # Add the cleaned file name to the array
            files+=("$file")
        done

        # Remove duplicates and empty entries
        files=($(echo "${files[@]}" | tr ' ' '\n' | sort -u | tr '\n' ' '))

        # Print the unique file names
        echo "Unique files:"
        for file in "${files[@]}"; do
            file=$(echo "${file,}")
            echo "$file"
            if [ ! -f "$temp_file" ]; then
                echo "$file" >"$temp_file"
            else
                grep -q "$file" "$temp_file" || echo "$file" >>"$temp_file"
            fi
        done

    fi
fi
