#!/bin/bash
TZ='America/Los_Angeles'; export TZ
DAYSAGO=$(date +"%Y%m%d" --date="-7 days")

rm -rf ../stills/${DAYSAGO}

mv lapse.log lapse.prev.log
