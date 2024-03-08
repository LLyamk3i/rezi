#!/usr/bin/env sh

read -p "choose your versioning type ('feat' or 'fix'): " choice

version=$(jq '.version' composer.json | tr -d \")

IFS='.' read -ra parts <<< "$version"
major="${parts[0]}"
minor="${parts[1]}"
patch="${parts[2]}"

case "$choice" in
  *"feat"*)
    echo 'MINOR versioning'
    minor=$((minor + 1))
    ;;
  *"fix"*)
    echo 'PATCH versioning'
    patch=$((patch + 1))
    ;;
  *)
    echo 'No verfixsioning action specified'
    ;;
esac

version="$major.$minor.$patch"

sed -i "s/\"version\": \"[^\"]*\"/\"version\": \"$version\"/" composer.json
if [ -e ./package.json ]; then
  sed -i "s/\"version\": \"[^\"]*\"/\"version\": \"$version\"/" package.json
fi

echo "Updated version: $version"
