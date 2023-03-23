#!/bin/sh

rm open.zip
zip -r open.zip app artisan bin bootstrap composer.json config database .env lang public routes .scribe storage templates vendor modules