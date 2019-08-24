<?php
$name=$_REQUEST['q'];
//$name='testingit';
$string = file_get_contents("filenamevalidation.txt");

        if (preg_match("~\b$name\b~", $string)) {
            echo "The file $name exists";
        }else {
            echo "File name validated";
        }
        ?>