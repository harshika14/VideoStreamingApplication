<?php 
$title = $_REQUEST["title"];
//$title="umraojaan";
$current = dirname(__FILE__);

 $var=glob($current.'/uploads/tsfiles/'.$title.'/'.$title."[0-9]*");
foreach($var as $file){ 
	$i=1;

 
} 
echo sizeof($var);

?>
