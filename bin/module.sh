#!/bin/bash

# Check if two arguments are provided
if [ $# -ne 2 ]; then
  echo "Usage: $0 [model name] [module name]"
  exit 1
fi

# Define a function to find files in a folder
file_path() {
  folder="$1"
  name="$2"

  if [ ! -d "$folder" ]; then
    echo ""
    return
  fi

  find "$folder" -type f -iname "*$name*"
}

# Get input arguments
model=$1
module=$2

# Define an array of file types and corresponding destination folders
file_types=(
    "Notifications"
    "Models"
    "Rules"
    "Seeders"
    "Factories"
    "Migrations"
    "Http/Resources"
    "Http/Requests"
    "Http/Controllers"
    "Policies"
)

# Loop through the file types and move files
for type in "${file_types[@]}"; do
  source_file=$(file_path "app/$type" "$model")
  if [ -n "$source_file" ]; then
    destination_folder="modules/${module}/Infrastructure/${type}/"
    mkdir -p "$destination_folder"
    phpactor class:move "$source_file" "$destination_folder"
    echo "moved $source_file";
  fi
done

# Move migration files
migration_file=$(file_path "database/migrations" "$model")
if [ -n "$migration_file" ]; then
  mv "$migration_file" "modules/${module}/Infrastructure/Database/Migrations/"
    echo "moved $migration_file";
fi

# Confirm completion
echo "Files moved successfully for model: $model to module: $module"
