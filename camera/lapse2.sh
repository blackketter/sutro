#!/bin/bash
TZ='America/Los_Angeles'; export TZ
TODAY=$(date +"%Y%m%d")
YESTERDAY=$(date +"%Y%m%d" --date=yesterday)
TWODAYSAGO=$(date +"%Y%m%d" --date="-2 days")

TIME=$(date +"%H%M%S")

mkdir -p stills/${TODAY}

echo ""
echo "Taking lapse at ${TODAY} ${TIME}..."

libcamera-still --ev 1  --metering average --autofocus-mode manual --lens-position .001 --awb daylight --width 1920 --height 1080 --roi .2,.2,.6,.6  --immediate -o lapse/lapse00.jpg
rm latest.jpg 
ln -s lapse/lapse00.jpg latest.jpg
sleep 8.3
libcamera-still --ev 1  --metering average  --autofocus-mode manual --lens-position .001  --awb daylight --width 1920 --height 1080 --roi .2,.2,.6,.6  --immediate -o lapse/lapse01.jpg
rm latest.jpg 
ln -s lapse/lapse01.jpg latest.jpg
sleep 8.3
libcamera-still --ev 1  --metering average  --autofocus-mode manual --lens-position .001  --awb daylight --width 1920 --height 1080 --roi .2,.2,.6,.6  --immediate -o lapse/lapse02.jpg
rm latest.jpg 
ln -s lapse/lapse02.jpg latest.jpg
sleep 8.3
libcamera-still --ev 1  --metering average  --autofocus-mode manual --lens-position .001  --awb daylight --width 1920 --height 1080 --roi .2,.2,.6,.6  --immediate -o lapse/lapse03.jpg
rm latest.jpg 
ln -s lapse/lapse03.jpg latest.jpg
sleep 8.3
libcamera-still --ev 1  --metering average  --autofocus-mode manual --lens-position .001  --awb daylight --width 1920 --height 1080 --roi .2,.2,.6,.6  --immediate -o lapse/lapse04.jpg
rm latest.jpg 
ln -s lapse/lapse04.jpg latest.jpg
sleep 8.3
libcamera-still --ev 1 --metering average  --autofocus-mode manual --lens-position .001  --awb daylight --width 1920 --height 1080 --roi .2,.2,.6,.6  --immediate -o lapse/lapse05.jpg

for i in lapse/lapse*.jpg; do
    # Process $i
    D=`date -r ${i} +%Y%m%d%H%M%S`
#   echo "Moving ${i} to ${D}.jpg"
    mv ${i} stills/${TODAY}/${D}.jpg
done

rm latest.jpg

ln -s stills/${TODAY}/${D}.jpg latest.jpg

#rm -rf stills/${TWODAYSAGO}

