<?php
 require 'aws-autoloader.php';
 $folder = $_REQUEST['title'];
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
error_reporting(0);
$bucket = 'test-7999837399';
$txt = "";
// Instantiate the client.
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1',
    'credentials' => [
        'key'    => 'AKIAQBKJQKSSDUJVMJ7B',
        'secret' => 'ZjE1zGczwjE+Dsj9EQCB773EYLbEb0kc+1HVRCIj',
    ],

]);
file_put_contents($folder.'-url.txt', '');

// Use the high-level iterators (returns ALL of your objects).
try {
    
    $results = $s3->getPaginator('ListObjects', [
        'Bucket' => $bucket,
        'Prefix' => $folder."/"
    ]);

    foreach ($results as $result) {
        foreach ($result['Contents'] as $object) {
            $txt = $txt."https://s3.amazonaws.com/ansible-harshika/".$object['Key'] . PHP_EOL;
            $myfile = fopen($folder."-url.txt", "w") or die("Unable to open file!");
            fwrite($myfile, $txt);
            fclose($myfile);
        }
    }

} catch (S3Exception $e) {
    echo "0";
}

// Use the plain API (returns ONLY up to 1000 of your objects).
/*try {
    $objects = $s3->listObjects([
        'Bucket' => $bucket
    ]);
    foreach ($objects['Contents']  as $object) {
        echo $object['Key'] . PHP_EOL;
    }
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}*/
$file=$folder."-url.txt";
$linecount = 0;
$handle = fopen($file, "r");
while(!feof($handle)){
  $line = fgets($handle);
  $linecount++;
}

fclose($handle);
$linecount = $linecount - 1;

echo $linecount;    



?>