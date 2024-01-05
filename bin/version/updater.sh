#!/usr/bin/env sh

message="$(tail -n 1 ~/.zsh_history)"
version=$(jq '.version' composer.json | tr -d \")

IFS='.' read -ra parts <<< "$version"
major="${parts[0]}"
minor="${parts[1]}"
patch="${parts[2]}"

case "$message" in
  *"feat:"*)
    echo 'MINOR versioning'
    minor=$((minor + 1))
    ;;
  *"fix:"*)
    echo 'PATCH versioning'
    patch=$((patch + 1))
    ;;
  *)
    echo 'No versioning action specified'
    ;;
esac

version="$major.$minor.$patch"

sed -i "s/\"version\": \"[^\"]*\"/\"version\": \"$version\"/" composer.json
if [ -e ./package.json ]; then
  sed -i "s/\"version\": \"[^\"]*\"/\"version\": \"$version\"/" package.json
fi


git add composer.json package.json
git commit --amend --no-edit -n

echo "Updated version: $version"
