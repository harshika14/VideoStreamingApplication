<?php
$name=$_REQUEST['q'];
//$name='testingit';
$current = dirname(__FILE__);
$file_pointer = $current.'/uploads/videos/'.$name;
        if (file_exists($file_pointer)) {
            echo "The file $name exists";
        }else {
            echo "File name validated";
        }
        ?>