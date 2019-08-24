<?php
$output = shell_exec('sudo nohup /bin/bash /opt/lampp/htdocs/video/break1.sh /opt/lampp/htdocs/video/uploads/videos/sss/ > /dev/null &');
echo "<pre> $output </pre>";
?>