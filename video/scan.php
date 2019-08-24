<?php
$foldername = $_REQUEST['title'];
//$foldername='harshika';
$directory = 'uploads/videos/'.$foldername.'/';
$scanned_directory = array_diff(scandir($directory), array('..', '.'));
$packets = 0; 
foreach ($scanned_directory as $i => $name) {
	
     $name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);
     $var=glob("/opt/lampp/htdocs/video/".$directory.'/tsfiles/'.$name."[0-9]*");

    $packets= $packets+sizeof($var);

 
}
echo $packets;
?>
