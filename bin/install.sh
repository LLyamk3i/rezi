#!/bin/bash

cp .env.example .env
composer i
./artisan  key:generate