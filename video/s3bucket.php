<?php
$title=$_REQUEST['title'];
shell_exec('sudo ansible-playbook multiadd.yml --extra-vars "pathoftsfiles=/opt/lampp/htdocs/video/uploads/tsfiles/$2 pathofm3u8files=/opt/lampp/htdocs/video/uploads/m3u8files/$2 folder=$2 path2=$2/');
echo "Your video has been Successfully Uploaded to the S3Bucket";
?>