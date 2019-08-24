<?php
$current = dirname(__FILE__);
 $var=glob($current.'/uploads/videos/harshu/*');
 print_r($var);
 $m3u8files=sizeof($var);
 echo $m3u8files;
 ?>