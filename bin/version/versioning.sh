#!/bin/bash

find . -type f -name ".v[0-9].[0-9].[0-9]*" -delete
version=$(jq '.version' composer.json | tr -d \")
echo "project: $(jq '.name' composer.json | tr -d \")\nversion: v$version" > ".v$version-$(date +%s)"

echo  'versioning finished'