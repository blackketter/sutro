#!/bin/bash
TZ='Etc/GMT+8'; export TZ
TODAY=$(date +"%Y%m%d")
YESTERDAY=$(date +"%Y%m%d" --date=yesterday)
TWODAYSAGO=$(date +"%Y%m%d" --date="-2 days")

TIME=$(date +"%H%M%S")
VIDEOSPREFIX=/mnt/hd
TODAYPREFIX=${VIDEOSPREFIX}/${TODAY}
mkdir -p ${TODAYPREFIX}

raspivid -t 86400000 -ex night -ifx denoise -h 1080 -w 1920 -n -o ${TODAYPREFIX}/$TODAY-%04d.h264 -v -sg 10000
#raspistill -t 1000 -ex night -ifx denoise -q 100 -h 1080 -w 1920  -n -o ${PHOTOSPREFIX}/${JPG}.jpg
#raspistill -t 1000 -ex night -mm average -ISO 100 -ifx denoise -o ${PHOTOSPREFIX}/${JPG}.jpg
#raspistill -mm matrix -drc high -st -q 100 -h 1080 -w 1920 --brightness 50 -ISO 100 -n -hf -vf -o ${PHOTOSPREFIX}/${JPG}.jpg 
#~/raspistill-dean -t 50000 -mm matrix -drc high -st -q 100 -h 1080 -w 1920  --brightness 50 -ISO 100 -n -hf -vf --timelapse 5000 -v  -o ${PHOTOSPREFIX}/${JPG}%02d.jpg -l ${LATEST}

