<?php 
//$title = $_REQUEST["title"];
$title="bahubal";
$current = dirname(__FILE__);

 $var=glob($current.'/uploads/tsfiles/'.$title.'/*');

 $s=sizeof($var);
 echo $s;

?>
