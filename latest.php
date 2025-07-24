<!DOCTYPE html>
<html>
<head>
<title>Sutrocam</title>
<link rel="icon" type="image/x-icon" href="/icon/favicon.ico">
<link rel="shortcut icon" type="image/x-icon" href="/icon/favicon.ico">
<link rel="icon" type="image/png" href="/icon/favicon-16x16.png">
<link rel="icon" type="image/png" href="/icon/favicon-32x32.png">
<style type="text/css">
	body { background-color: #222; color:#888; font: 14px/1.3 verdana, arial, helvetica, sans-serif; }
	h1 { font-size:1.4em; }
	h2 { font-size:1.2em; }
	a:link { color:#c33; }
	a:visited { color:#933; }
	p { color:#888; }
    button { color:#888; background-color:#222; }
	/* so linked image won't have border */
	a img { border:none; }
	anim { width: 100%; }
	.links { float:right;text-align:right;width:50%;	}
	.timestamp { }
</style>
</head>

<?php
  date_default_timezone_set('America/Los_Angeles');
  $today = date("Ymd");
  $thedate = $_GET['date'];
  if (!$thedate) {
    $thedate = $today;
  }
?>

<body>

<p>
<h1><a href=".">Sutrocam <?php if ($thedate != $today) { echo $thedate; } ?></a></h1>

<?php
  if ($thedate == $today):
    $root = "medium/";
    $root = $root . $thedate;
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
    } else {
      echo "Can't open root " . $root;
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

  <a href="latest.mp4"><h2>Last 20 Minutes Or So</h2></a>
  <video controls autoplay muted loop width="100%"><source src="latest.mp4" /></video>

  <h2>Latest</h2>

  <div>
      <button onclick="displayCurrent()" id="current" class="active">Latest</button>
  &nbsp;
      <button onclick="firstLong()" id="first">First</button>
      <button onclick="prevLong()" id="prev">Prev</button>
      <button onclick="startLong()" id="longloop">Start</button>
      <button onclick="nextLong()" id="next">Next</button>
      <button onclick="lastLong()" id="last">Last</button>
      <!--<button onclick="window.location.href='latest.mp4';" id="video" class="active">Video</button>-->
  </div>
  <div class="timestamp" id="timestamp"></div>

  <div id="current-image">
    <a href="latest.jpg"><img src="latest.jpg" width="100%"></a>
  </div>

  <div id="image-animation" class="anim"></div>

<?php endif; ?>

<h2>Grid</h2>
<a href="today-grid.jpg"><img src="today-grid.jpg" width="100%"></a>

<a href="today.mp4"><h2>Today</h2></a>
<video controls autoplay muted loop width="100%"><source src="today.mp4" /></video>

<a href="yesterday.mp4"><h2>Yesterday</a> <a class="links" href="yesterday.log">(log)</a></h2>

<video controls autoplay muted loop width="100%"><source src="yesterday.mp4" /></video>

<h2>Yesterday Grid</h2>
<a href="yesterday-grid.jpg"><img src="yesterday-grid.jpg" width="100%"></a>

<h2>Yesterday Average</h2>
<a href="yesterday-mean.jpg"><img src="yesterday-mean.jpg" width="100%"></a>
</body>
</html>

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
            img_list[i].style.width = '100%';
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
    function firstLong() {
            startLong();
            stopLong()
            img_list[iterator].style.display = 'none';
            iterator = 0;
            img_list[iterator].style.display = 'block';
            document.getElementById('timestamp').innerHTML = long_list_dates[iterator];
    }
    function lastLong() {
            startLong();
            stopLong()
            img_list[iterator].style.display = 'none';
            iterator = long_list_dates.length - 1;

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


//	startLong();
  displayLatest();
</script>
