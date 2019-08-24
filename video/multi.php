<?php 

function sizeinput($input, $len){
        (int)$len;
     (string)$input;
     $n = substr($input, 0,$len);
   $ret = trim($n);
   $out = htmlentities($ret, ENT_QUOTES);
   return $out;
} 

function checkfile($input){
    $ext = array('mpg', 'wma', 'mov', 'flv', 'mp4', 'avi', 'qt', 'wmv', 'rm');
    $extfile = substr($input['name'],-4); 
    $extfile = explode('.',$extfile);
    $good = array();
    $extfile = $extfile[1];
    if(in_array($extfile, $ext)){
          $good['safe'] = true;
     $good['ext'] = $extfile;
    }else{
          $good['safe'] = false;
   }
     return $good;
 }



$count = 0;
$notvalid = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['foldername'])&& !empty($_POST['foldername']))
		$foldername=$_POST['foldername'];
    if(!is_dir($foldername))
    	mkdir('uploads/videos/'.$foldername);
      echo $_FILES['files']['name'];
    foreach ($_FILES['files']['name'] as $i => $name) {
      echo $_FILES['files']['name'];

            $safe_file = checkfile($i);
            if($safe_file['safe'] == 0)
            {
              $notvalid=$notvalid+1;
              echo 'Invalid File Type Please Try Again. You file must be of type 
       .mpg, .wma, .mov, .flv, .mp4, .avi, .qt, .wmv, .rm';
            }


    }
    if ($notvalid==0) {
    foreach ($_FILES['files']['name'] as $i => $name) {
        if (strlen($_FILES['files']['name'][$i]) > 1) {
            if (move_uploaded_file($_FILES['files']['tmp_name'][$i], 'uploads/videos/'.$foldername.'/'.$name)) {
                $count++;
                echo $name."<br>";
              
                

     //echo "Video Uploaded ".$withoutExt.'<br>';
     //echo 'to'.$name.'<br>';
     ob_start();
passthru("ffmpeg -i uploads/videos/".$foldername.'/'.$name."  2>&1");
$duration = ob_get_contents();
$full = ob_get_contents();
ob_end_clean();
$search = "/duration.*?([0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2})/i";
//print_r($duration);
preg_match($search, $full, $matches, PREG_OFFSET_CAPTURE, 3);
$time = $matches[1][0];
$timesec = strtotime($time) - strtotime('TODAY');
$packets = floor($timesec / 60) + $packets + 1;



       }
        }
    }
  }
    $path = '/opt/lampp/htdocs/video/uploads/videos/'.$foldername.'/';
  shell_exec('sudo nohup /bin/bash /opt/lampp/htdocs/video/break1.sh '.$foldername.' > /dev/null &');
 echo $packets."hey i am packet";
echo "<div id='txtHint2'>1</div>
 <div class='progress-wrap'>
     <div class='progress-message'>Ваша форма заполнена на <span class='output'>___</span> %</div>  
  <progress  value='1' max='100' class='progress'></progress>
</div> 
<style>
.green{
  background-color:green;
} 
</style>

<script>
var i=1;
 var til='".$foldername."';
var spy;

              function est(val) {
  
    var progress = $('.progress');
        progressMessage = $('.progress-message');  
      if (val == ".$packets.") {
      progress.attr('value', '100');
      progressMessage.text('Nothing can stop you now.');
      progress.addClass('green');
  } 
  else{ 
    var some= progress.attr('value');
    
    var reader= document.getElementById('txtHint2').innerHTML;
    reader= (reader/".$packets.")*100;
   
   
      progress.attr('value',reader);
      progressMessage.text('Complete the form');

  }
} 


 var myvar=setInterval(function(){
stoploader1(til);

 console.log(i+'insidesleeper'+spy);
  i=i+1;
  est(spy);
  if(spy== ".$packets." || spy > ".$packets."){ 
     var progress = $('.progress');
        progressMessage = $('.progress-message'); 
      progress.attr('value', '100');
      progressMessage.text('Nothing can stop you now.');
      progress.addClass('green');
    my();
  }
  },30000);

  function my(){
    console.log('stopped');
  clearInterval(myvar); 
  }





  function stoploader1(til) { 

    console.log('jai ho');
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('txtHint2').innerHTML = this.responseText;
            
                console.log('kamyab');
                console.log('kuch');
               spy= document.getElementById('txtHint2').innerHTML;
            console.log(spy);
            console.log('success');
              
            }
        };
        xmlhttp.open('GET', 'scan.php?title=' + til , true);
        xmlhttp.send();
       
    } 





</script>
";
} 
?>
<script type="text/javascript" src="jquery.min.js"></script>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="files[]" id="files" multiple="" directory="" webkitdirectory="" mozdirectory="">
    <input type="text" name="foldername" id="foldername">
    <input class="button" type="submit" value="Upload" />
</form>