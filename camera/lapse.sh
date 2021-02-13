#!/bin/bash
TZ='America/Los_Angeles'; export TZ
TODAY=$(date +"%Y%m%d")
YESTERDAY=$(date +"%Y%m%d" --date=yesterday)
TWODAYSAGO=$(date +"%Y%m%d" --date="-2 days")

TIME=$(date +"%H%M%S")

mkdir -p stills/${TODAY}

echo "Taking lapse at ${TODAY} ${TIME}..."

raspistill -t 5000 -ex auto  -mm average -ifx denoise -q 15 -h 1080 -w 1920 -o lapse/lapse00.jpg
sleep 3.5
raspistill -t 5000 -ex auto  -mm average -ifx denoise -q 15 -h 1080 -w 1920 -o lapse/lapse01.jpg
sleep 3.5
raspistill -t 5000 -ex auto  -mm average -ifx denoise -q 15 -h 1080 -w 1920 -o lapse/lapse02.jpg
sleep 3.5
raspistill -t 5000 -ex auto  -mm average -ifx denoise -q 15 -h 1080 -w 1920 -o lapse/lapse03.jpg
sleep 3.5
raspistill -t 5000 -ex auto  -mm average -ifx denoise -q 15 -h 1080 -w 1920 -o lapse/lapse04.jpg
sleep 3.5
raspistill -t 5000 -ex auto  -mm average -ifx denoise -q 15 -h 1080 -w 1920 -o lapse/lapse05.jpg

for i in lapse/lapse*.jpg; do
    # Process $i
    D=`date -r ${i} +%Y%m%d%H%M%S`
#   echo "Moving ${i} to ${D}.jpg"
    mv ${i} stills/${TODAY}/${D}.jpg
done

rm latest.jpg

ln -s stills/${TODAY}/${D}.jpg latest.jpg

rm -rf stills/${TWODAYSAGO}

