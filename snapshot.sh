#!/bin/bash
TZ='America/Los_Angeles'; export TZ
TODAY=$(date +"%Y%m%d")
YESTERDAY=$(date +"%Y%m%d" --date=yesterday)
TWODAYSAGO=$(date +"%Y%m%d" --date="-2 days")

TIME=$(date +"%H%M%S")
PHOTOSPREFIX=/var/www/lapse

mkdir -p ${PHOTOSPREFIX}/${TODAY}

JPG=${TODAY}/${TODAY}${TIME}
LATEST=${PHOTOSPREFIX}/latest.jpg

raspistill -mm matrix -drc high -st -q 100 -h 1080 -w 1920 --brightness 50 -ISO 100 -n -hf -vf -v -o ${PHOTOSPREFIX}/${JPG}.jpg 
#~/raspistill-dean -t 50000 -mm matrix -drc high -st -q 100 -h 1080 -w 1920  --brightness 50 -ISO 100 -n -hf -vf --timelapse 5000 -v  -o ${PHOTOSPREFIX}/${JPG}%02d.jpg -l ${LATEST}
rm $LATEST
ln -s ${PHOTOSPREFIX}/${JPG}.jpg $LATEST
rm -f $PHOTOSPREFIX/${YESTERDAY}/${YESTERDAY}${TIME}*.jpg
rmdir --ignore-fail-on-non-empty $PHOTOSPREFIX/${YESTERDAY}
rm -rf $PHOTOSPREFIX/${TWODAYSAGO}

