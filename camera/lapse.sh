#!/bin/bash
TZ='America/Los_Angeles'; export TZ
TODAY=$(date +"%Y%m%d")
YESTERDAY=$(date +"%Y%m%d" --date=yesterday)
TWODAYSAGO=$(date +"%Y%m%d" --date="-2 days")

TIME=$(date +"%H%M%S")
PHOTOSPREFIX=/var/www/html/lapse

cd ${PHOTOSPREFIX}

mkdir -p ${TODAY}

echo "Taking lapse at ${TODAY} ${TIME}..."


raspistill -t 5000 -ex night -mm spot -ifx denoise -q 15 -h 1080 -w 1920 -o lapse00.jpg
sleep 3.5
raspistill -t 5000 -ex night -mm spot -ifx denoise -q 15 -h 1080 -w 1920 -o lapse01.jpg
sleep 3.5
raspistill -t 5000 -ex night -mm spot -ifx denoise -q 15 -h 1080 -w 1920 -o lapse02.jpg
sleep 3.5
raspistill -t 5000 -ex night -mm spot -ifx denoise -q 15 -h 1080 -w 1920 -o lapse03.jpg
sleep 3.5
raspistill -t 5000 -ex night -mm spot -ifx denoise -q 15 -h 1080 -w 1920 -o lapse04.jpg
sleep 3.5
raspistill -t 5000 -ex night -mm spot -ifx denoise -q 15 -h 1080 -w 1920 -o lapse05.jpg

for i in lapse*.jpg; do
    # Process $i
    D=`date -r ${i} +%Y%m%d%H%M%S`
#   echo "Moving ${i} to ${D}.jpg"
    mv ${i} ${TODAY}/${D}.jpg
done

rm latest.jpg
ln -s ${TODAY}/${D}.jpg latest.jpg

rm -rf $PHOTOSPREFIX/${TWODAYSAGO}

