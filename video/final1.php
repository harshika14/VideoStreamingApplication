    <?php

function sizeinput($input, $len){
        (int)$len;
     (string)$input;
     $n = substr($input, 0,$len);
   $ret = trim($n);
   $out = htmlentities($ret, ENT_QUOTES);
   return $out;
} 



 //Check the file is of correct format.  
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
 // if the form was submitted process request if there is a file for uploading
 if($_POST && array_key_exists("vid_file", $_FILES)){
          //$uploaddir is for videos before conversion
        $convert=$_POST['convert'];
        $uploaddir = dirname(__FILE__).'/uploads/videos/';
         //$live_dir is for videos after converted to flv
    $live_dir = dirname(__FILE__).'/uploads/live/';
         //$live_img is for the first frame thumbs.
    $live_img = dirname(__FILE__).'/uploads/images/';   

        $seed = rand(1,2009) * rand(1,10);     
    $upload = basename($_FILES['vid_file']['name']);
    $uploadfile = $uploaddir .$upload;        
    $vid_title = sizeinput($_POST['vid_title'], 50);
    $vid_desc = sizeinput($_POST['vid_description'], 200);
                           $vid_cat = (int)$_POST['vid_cat'];
    $vid_usr_ip = $_SERVER['REMOTE_ADDR'];
                       $safe_file = checkfile($_FILES['vid_file']);
    //check for the format of the file and uploads only if it is video format
    if($safe_file['safe'] == 1){
                    //Proceed further only if files have been successfully uploaded
                    if (move_uploaded_file($_FILES['vid_file']['tmp_name'], $uploadfile)) {
                       echo "File is valid, and was successfully uploaded.<br/>";
                                 $base = basename($uploadfile, $safe_file['ext']);
          $new_file = $live_dir.$vid_title.'.m3u8';
          $new_image = $base.'jpg';
          $new_image_path = $live_img.$new_image;
          $new_flv = $live_dir.$new_file;
          //make directory for m3u8 files ,if not present
          if($convert == 1)
          {
            if(!is_dir($vid_title))
                   mkdir('uploads/m3u8files/'.$vid_title);
                
                $m3u8path= 'uploads/m3u8files/'.$vid_title.'/'.$vid_title.'.m3u8';
                //make directory for ts files ,if not present
             if(!is_dir($vid_title))
          
      mkdir('uploads/tsfiles/'.$vid_title);
   //to run ffmpeg in background using nohup   
  $status = shell_exec('sudo nohup /bin/bash break3.sh '.$uploadfile.' '.$vid_title.' '.$m3u8path.' > /dev/null &');  
//echo exec('nohup ffmpeg  -i '.$uploadfile.' -loglevel verbose -threads 3 -f hls -hls_time 60 -hls_list_size 99999  -start_number 1 -t 9000 -strict -2 -hls_segment_filename  uploads/tsfiles/'.$vid_title.'/'.$vid_title.'%01d.ts '.$m3u8path.' > /dev/null 2>&1 &');
    //clear the urls file 
    file_put_contents($vid_title.'-url.txt', '');
     echo 'Thank You For Your Video!<br>';
 

//to get the total number of  ts files(packets)
  ob_start();
passthru("ffmpeg -i uploads/videos/".$upload."  2>&1");

 $duration = ob_get_contents();
$full = ob_get_contents();
 ob_end_clean();
 $search = "/duration.*?([0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2})/i";
 
preg_match($search, $full, $matches, PREG_OFFSET_CAPTURE, 3);
$time = $matches[1][0];
$timesec = strtotime($time) - strtotime('TODAY');
$packets = floor($timesec / 60) + 1 ;
echo $packets.'- Total Number of ts files';
//to get progress bar for converting and uploading files
echo " 
<div id='txtHint2' style='display:none'>1</div>
<div id='txtHint3' style='display:none'>0</div>
 <div id='progress-wrap'>
     <div class='progress-message'>Please wait your files are converting</div>  
  <progress  value='1' max='100' class='progress'></progress>
</div>

<div id='progress-wrap1' style='display:none;'>
     <div class='progress-message1'>Please wait ..your files are uploading </div>  
  <progress  value='1' max='100' class='progress1'></progress>
</div>
<a href='".$vid_title."-url.txt' download id='download' hidden>Download</a>

<script>
var i=1;
 var til='".$vid_title."';
var spy;
var spy2;

              function est(val) {
  
    var progress = $('.progress');
        progressMessage = $('.progress-message');  
      if (+val >= ".$packets.") {
      progress.attr('value', '100');
      
      progressMessage.text('Conversion Completed');
      progress.addClass('green');
  } 
  else{ 
    var some= progress.attr('value');
    
    var reader= document.getElementById('txtHint2').innerHTML;
    reader= (reader/".$packets.")*100;
    
   
      progress.attr('value',reader);
      progressMessage.text('Working...');

  }
}  

           function est1(val) {
  
    var progress = $('.progress1');
        progressMessage = $('.progress-message1');  
      
      if (val > '".$packets."') {
      progress.attr('value', '100');
      progressMessage.text('Conversion Completed');
      progress.addClass('green');
  } 
  if(val==0){
      progress.attr('value','1');
    }
  else{
    var some= progress.attr('value');
    
    var reader= document.getElementById('txtHint3').innerHTML;

    reader= (reader/(".$packets."+1))*100;

      progress.attr('value',reader);
      progressMessage.text('Working...');

  } 
    
}  


 var myvar=setInterval(function(){
stoploader1(til);
  i=i+1;
  est(spy);
  if(spy== ".$packets." || spy > ".$packets."){
    my();
  }
  },10000);

  function my(){
  clearInterval(myvar);
  document.getElementById('progress-wrap').style.display='none';
  document.getElementById('progress-wrap1').style.display='block';
  
   var myvar2=setInterval(function(){
stoploader2(til);
  i=i+1;
  est1(spy2);
  if(spy2== ".$packets."+1 || spy2 > ".$packets."){
    my();
  }
  },5000);
   function my(){
  clearInterval(myvar2);
  var txt;
  var r = confirm('Click OK Button to Download the url file');
  if (r == true) {
    document.getElementById('download').click();
    window.open('final.php','_self');
  } else {
    window.open('final.php','_self');
  }

  }


  }






  function stoploader1(til) { 
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('txtHint2').innerHTML = this.responseText;
      
               spy= document.getElementById('txtHint2').innerHTML;
            }
        };
        xmlhttp.open('GET', 'find.php?title=' + til , true);
        xmlhttp.send();
        return spy;
    } 



  function stoploader2(til) { 
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('txtHint3').innerHTML = this.responseText;
               spy2= this.responseText;
            }
        };
        xmlhttp.open('GET', 'testsdk.php?title=' + til , true);
        xmlhttp.send();
        return spy;
    } 


  


</script>
";


 }
 else
 {

  if(!is_dir($vid_title))
      mkdir('uploads/videos/'.$vid_title);
      rename($uploadfile, 'uploads/videos/'.$vid_title.'/'.$upload);
  shell_exec('sudo nohup /bin/bash upload.sh '.$vid_title.' > /dev/null &');
  echo " 


<div id='txtHint3'>0</div>
<div id='progress-wrap1'>
     <div class='progress-message1'>please wait...</div>  
  <progress  value='1' max='100' class='progress1' ></progress>
</div>
<a href='".$vid_title."-url.txt' download id='download' hidden>Download</a>

<script>
  var til='".$vid_title."';
var spy;
var spy2;
var i=1;
           function est1(val) {
  
    var progress = $('.progress1');
        progressMessage = $('.progress-message1');  
      
      if (val ==1) {
      progress.attr('value', '100');
      
      progressMessage.text('Converting Completed');
      progress.addClass('green');
  } 
  if(val==0){
      progress.attr('value','1');
    }
  
    
}  

   var myvar2=setInterval(function(){
stoploader2(til);
  i=i+1;
  est1(spy2);
  if(spy2==1){
    my();
  }
  },20000);
   function my(){
    clearInterval(myvar2);
  var txt;
  var r = confirm('Click ok button to download the url file!');
  if (r == true) {
    document.getElementById('download').click();
    window.open('final.php','_self');
  } else {
    window.open('final.php','_self');
  }
  }
function stoploader2(til) { 

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('txtHint3').innerHTML = this.responseText;
               spy2= this.responseText;  
            }
        };
        xmlhttp.open('GET', 'testsdk.php?title=' + til , true);
        xmlhttp.send();
        return spy;
    } 
</script>
";



 }
             } else {
                    echo "Possible file upload attack!\n";
              print_r($_FILES);
             }
          //if file format does not match any of given video formats
      }else{
    
         echo 'Invalid File Type Please Try Again. You file must be of type 
       .mpg, .wma, .mov, .flv, .mp4, .avi, .qt, .wmv, .rm';
    
    }
 }
?> 



   <script src="jquery.min.js"></script>
   <script type="text/javascript">
     
//to check if file name is repeated or unique
     function showHint(str) {
    if (str.length == 0) {
        document.getElementById("filenameHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("filenameHint").innerHTML = this.responseText;
                if(this.responseText=="The file "+str+" exists")
                {
                    alert("This name already exists use another name");
                    document.getElementById("vid_title").value = "";
                    
                }
            }
        }
        xmlhttp.open("GET", "getHint.php?q="+str, true);
        xmlhttp.send();
    }
}
   </script>

 <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" >
  <p align="left">Please upload Your video.  Thumbnails of your videos are based on the first frame of your video. <br /><h3>Please allow up to a minute for your video to upload. </h3>
   </p>
  <table width="600" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="260" align="left" colspan="3"><div align="center">
      <h3>Upload your Video ! </h3>
    </div></td>
   </tr>
    <tr>
      <td width="260"  align="left"> </td>
      <td width="326" align="left"> </td>
    </tr>
    <tr>
      <td align="left">Title Of Video : </td>
      <td align="left"><input name="vid_title" type="text" id="vid_title"  onblur="showHint(this.value)" required /></td>
   </tr>
   <tr>
     <td align="right"><p id="filenameHint">Hello</p></td>
   </tr>
   <tr>
     <td align="left">File: .mov, .avi, .wma , .mpeg : </td>
     <td align="left"><input name="vid_file" type="file" id="vid_file" /></td>
  </tr>
   <tr>
     <td align="left">Description:</td>
    <td align="left"><textarea name="vid_description" id="vid_description"></textarea></td>
  </tr>
   <tr>
     <td align="left">Category:</td>
    <td align="left"><select name="vid_cat">
       <option value="1" selected="selected">Video</option>
       <option value="2">Cat1</option>
      <option value="3">Cat2</option>
      <option value="4">Cat3</option>
      <option value="5">Cat4</option>
    </select>
     </td>
  </tr>
  <tr>
    <td>
       <input type="radio" name="convert" value="1" checked> Convert<br>
  <input type="radio" name="convert" value="0"> Donot Convert<br>
    </td>
  </tr>
  <tr>

    <td> </td>
     <td><button name="Submit" value="Upload Video">Upload Video</button></td>
  </tr>
 </table>

</form>




<div id="demo"></div>
<div id="txtHint"></div>




