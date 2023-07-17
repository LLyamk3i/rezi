#!/bin/bash

function get_app_name() {
    echo "$(grep -E "^APP_NAME=" .env | cut -d "=" -f2 | tr ' ' '_' | tr -d '"' | tr '[:upper:]' '[:lower:]').zip";
}