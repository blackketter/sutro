#!/bin/bash
TZ='America/Los_Angeles'; export TZ
DAYSAGO=$(date +"%Y%m%d" --date="-8 days")

rm -rf stills/${DAYSAGO}

