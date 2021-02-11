<!DOCTYPE html>
<html>
<head>
<title>Sutrocam 2021</title>
<style type="text/css">
	body { background-color: black; color:#888; font: 14px/1.3 verdana, arial, helvetica, sans-serif; }
	h1 { font-size:1.3em; }
	h2 { font-size:1.2em; }
	a:link { color:#c33; }
	a:visited { color:#933; }
	p { color:#888; }
    button { color:#888; background-color:#222; }
	/* so linked image won't have border */
	a img { border:none; }
	anim { width: 100px; }
</style>
</head>

<?php
	$root = "medium/";
	$root = $root . date('Ymd');
  $filter = "/(\.gif|\.jpg|\.jpeg|\.png)$/";
  $imagecount = 120;

	if ( $root_dir = @opendir($root) ) {
			while ( false !== ($img_file = readdir($root_dir)) ) {
						if ( preg_match($filter, $img_file) ) {
							$images[] = $root . "/" . $img_file;
							$dates[] = $img_file;
					}
			}
			closedir($root_dir);
	}
	sort($images);
	sort($dates);
	$images = array_slice($images, -$imagecount);
    $dates = array_slice($dates, -$imagecount);
	function printImages() {
		global $images;
		foreach ($images as $image) {
			echo "'" . $image . "',\n";
		}
	}
	function printDates() {
		global $dates;
		foreach ($dates as $date) {
			echo "'" . $date . "',\n";
		}
	}
?>

<body>
<div class="menu">
<div style="float:left;text-align:left;width:50%">
    <button onclick="displayCurrent()" id="current" class="active">Latest</button>
    <button onclick="startLong()" id="longloop">Stop</button>
    <button onclick="prevLong()" id="prev">Prev</button>
    <button onclick="nextLong()" id="next">Next</button>
</div>

<div style="float:right;text-align:right;width:50%">
	<a href=".">index</a>
</div>
</div>
<p></p>
<div class="body">
<div>&nbsp;</div>
<div id="timestamp"></div>
	    <div id="current-image">
			<a href="http://sutrocam.local/lapse/latest.html"><img src="http://sutrocam.local/lapse/latest.jpg" width="100%"></a>
    </div>
    <div id="image-animation" class="anim">
    </div>
</div>

<script>

    var current_date = "8:21 AM, July 30 2020";
    var long_list = [
			<?php printImages(); ?>
    ];
    var long_list_dates = [
    			<?php printDates(); ?>
    ];
    var iterator = 0;
    var img_list = [];

    var container = document.getElementById('image-animation');

    var running_animation;

    function startLong() {
        if (document.getElementById('longloop').className === "active") {
            stopLong();
        } else if (document.getElementById('longloop').className === "paused") {
            document.getElementById('longloop').className = "active";
            startAnimation(long_list, long_list_dates);
            document.getElementById('longloop').innerHTML = "Stop";
        } else {
            displayCurrent();
            document.getElementById('longloop').className = "active";
            document.getElementById('current').className = "";
            document.getElementById('longloop').innerHTML = "Stop";

            setupAnimation(long_list, long_list_dates);
            startAnimation(long_list, long_list_dates);
        }
    }

    function setupAnimation(file_list, date_list) {
        img_list = [];
        document.getElementById('current-image').style.display = 'none';

        for (var i = 0; i < file_list.length; i++) {
            img_list.push(document.createElement('img'));
            img_list[i].src = file_list[i];
            if (i != 0) {
                img_list[i].style.display = 'none';
            }
            container.append(img_list[i]);
        }

        document.getElementById('timestamp').innerHTML = date_list[0];
    }

    function startAnimation(file_list, date_list) {
        function iterate() {
            img_list[iterator].style.display = 'none';
            iterator++;

            if (iterator >= file_list.length) {
                iterator = 0;
            }

            img_list[iterator].style.display = 'block';
            document.getElementById('timestamp').innerHTML = date_list[iterator];
        }

        running_animation = setInterval(iterate, 100);
    }

    function stopLong() {
            clearInterval(running_animation);
            document.getElementById('longloop').className = "paused";
            document.getElementById('longloop').innerHTML = "Start";
    }
    function prevLong() {
            startLong();
            stopLong()
            img_list[iterator].style.display = 'none';
            iterator--;

            if (iterator < 0) {
                iterator = long_list_dates.length - 1;
            }

            img_list[iterator].style.display = 'block';
            document.getElementById('timestamp').innerHTML = long_list_dates[iterator];
    }
    function nextLong() {
            startLong();
            stopLong()
            img_list[iterator].style.display = 'none';
            iterator++;

            if (iterator >= long_list_dates.length) {
                iterator = 0;
            }

            img_list[iterator].style.display = 'block';
            document.getElementById('timestamp').innerHTML = long_list_dates[iterator];
			
    }

    function displayCurrent() {
        stopLong();
        iterator = 0;
        document.getElementById('timestamp').innerHTML = "";// current_date;
        document.getElementById('current-image').style.display = 'block';
        document.getElementById('longloop').className = "";
        document.getElementById('current').className = "active";
        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }
    }
	startLong();

</script>
<p>Yesterday: <a href="yesterday.log">(log)</a>
<video controls autoplay muted loop width="100%"><source src="yesterday.mp4" /></video>
<p>Grid:
<a href="yesterday-grid.jpg"><img src="yesterday-grid.jpg" width="100%"></a>
<p>Average:
<a href="yesterday-mean.jpg"><img src="yesterday-mean.jpg" width="100%"></a>
</body>
</html>
