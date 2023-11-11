#!/bin/bash
TZ='America/Los_Angeles'; export TZ
TODAY=$(date +"%Y%m%d")
YESTERDAY=$(date +"%Y%m%d" --date=yesterday)
TWODAYSAGO=$(date +"%Y%m%d" --date="-2 days")

TIME=$(date +"%H%M%S")

LATEST=latest.jpg
STILLS=stills/${TODAY}
mkdir -p $STILLS 

echo ""
echo "Taking lapse at ${TODAY} ${TIME}..."

for i in {0..5}
do
	START=$(date +%s)	
	
	IMAGE=lapse/lapse0${i}.jpg
	date
	echo "Taking $IMAGE"	
	./stillcmd $IMAGE
	ln -f -s $IMAGE $LATEST
	
	END=$(date +%s)
	DIFF=$(( $END - $START))
	if [ $i -eq 5 ]; then
		DIFF=100
	fi
	
	if [ $DIFF -lt 10 ]; then
		sleep $(( 10 - $DIFF ))
	fi
done

for i in lapse/lapse*.jpg; do
    # Process $i
    D=`date -r ${i} +%Y%m%d%H%M%S`
    echo "Moving ${i} to ${D}.jpg"
    mv ${i} ${STILLS}/${D}.jpg
done

ln -f -s ${STILLS}/${D}.jpg $LATEST


