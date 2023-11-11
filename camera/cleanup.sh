#!/bin/bash
TZ='America/Los_Angeles'; export TZ
DAYSAGO=$(date +"%Y%m%d" --date="-14 days")

rm -rf ../stills/${DAYSAGO}

