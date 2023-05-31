#!/bin/bash

composer u
composer bump
[ -f ./package.json ] && pnpm up