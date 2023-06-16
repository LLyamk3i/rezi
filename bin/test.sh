#!/bin/bash

clear
rm storage/logs/*.log

composer exec pest -- --filter "'$1'"
