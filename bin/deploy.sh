#!/bin/bash

./bin/clean
composer u
./artisan scribe:generate
composer u --no-dev
./bin/zip
