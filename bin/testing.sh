#!/bin/bash

file="phpunit.xml"

case "$1" in
"sqlite")
    echo "Setting test to sqlite"
    sed -i 's/value="mysql"/value="sqlite"/' $file
    sed -i 's/value="test"/value=":memory:"/' $file
    ;;
"mysql")
    echo "Setting test to mysql"
    sed -i 's/value="sqlite"/value="mysql"/' $file
    sed -i 's/value=":memory:"/value="test"/' $file
    ;;
*)
    echo "Invalid argument. Usage: $0 {sqlite|mysql}"
    exit 1
    ;;
esac
