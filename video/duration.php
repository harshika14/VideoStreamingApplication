<?php
ob_start();
passthru("ffmpeg -i uploads/videos/19.launching_application_using_eks.mp4  2>&1");

$duration = ob_get_contents();
$full = ob_get_contents();

 ob_end_clean();
 $search = "/duration.*?([0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}\.[0-9]{1,2})/i";
preg_match($search, $full, $matches, PREG_OFFSET_CAPTURE, 3);
$time = $matches[1][0];
print_r($time);
//echo $timesec = strtotime($time) - strtotime('TODAY');
//echo $packets = ($timesec / 60) + 1 ;
//echo $packets.'iam packet';
?>