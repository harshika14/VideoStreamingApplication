<?php 
session_start();
if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
       {
           header("Location:index.php");  
       }
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
    $extfile = substr($input,-4); 
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
$flag = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['foldername'])&& !empty($_POST['foldername']))
		$foldername=$_POST['foldername'];
    $convert=$_POST['convert'];
    if(!is_dir($foldername))
    	mkdir('uploads/videos/'.$foldername);
    foreach ($_FILES['files']['name'] as $i => $name) {
     if(preg_match('/\s/',$name)){ 
      $name=preg_replace("/[[:blank:]]+/"," ",$name);
     $name=str_replace(" ","_",$name);
     } 
     $name=strtolower($name);
        if (strlen($_FILES['files']['name'][$i]) > 1) {
            if (move_uploaded_file($_FILES['files']['tmp_name'][$i], 'uploads/videos/'.$foldername.'/'.$name)) {
                $count++;
     
                
              
                

     //echo "Video Uploaded ".$withoutExt.'<br>';
     //echo 'to'.$name.'<br>';
    $is_good = checkfile($name);
    if($is_good['safe']==1){
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
if ($convert==1) {
$packets = floor($timesec / 60) + $packets + 1;
}
else
$packets = 0;
}
else
{
  if(!is_dir($foldername)){
    if ($convert==1) {
      mkdir('uploads/videos/'.$foldername.'/otherFiles');
  
  copy('uploads/videos/'.$foldername.'/'.$name, 'uploads/videos/'.$foldername.'/otherFiles/'.$name);
  $flag = 2;
    }
}
}

}
       
        }
    }
    $path = 'uploads/videos/'.$foldername.'/';
    $current = dirname(__FILE__);
 $var=glob($current.'/uploads/videos/'.$foldername.'/*');
 $m3u8files=sizeof($var);
 $packets2=$packets+$m3u8files;
 if($convert == 1){
shell_exec('sudo nohup /bin/bash break1.sh '.$foldername.' > /dev/null &');
echo $packets."- Number of total ts files<br>"; 
 if ($flag == 2) {
   $packets2 = $packets2 - 1;
 }
 echo $packets2."- Number of Files to be Uploaded"; 
 }
 else
{
  shell_exec('sudo nohup /bin/bash upload.sh '.$foldername.' > /dev/null &');
}
 
 

if($convert == 1)
{
echo " 
<div id='txtHint2' hidden>1</div>
<div id='txtHint3' hidden>0</div>
 <div id='progress-wrap'>
     <div class='progress-message'>please wait..</div>  
  <progress  value='1' max='100' class='progress' style='height:24px;width:20%;'></progress>
</div>


<div id='progress-wrap1' style='display:none;'>
     <div class='progress-message1'>please wait..</div>  
  <progress  value='1' max='100' class='progress1' ></progress>
</div>
<a href='".$foldername."-url.txt' download id='download' hidden>Download</a>

<script>
var i=1;
 var til='".$foldername."';
var spy;
var spy2;

              function est(val) {
  
    var progress = $('.progress');
        progressMessage = $('.progress-message');  
      if (val >= ".$packets.") { 
      
      progress.attr('value', '100');
      
      progressMessage.text('Nothing can stop you now.');
      progress.addClass('green');
  } 
  else{ 
    var some= progress.attr('value');
    
    var reader= document.getElementById('txtHint2').innerHTML;
    reader= (reader/".$packets.")*100;
    
   
      progress.attr('value',reader);
      progressMessage.text('please wait,your files are converting');

  }
}  

           function est1(val) {
  
    var progress = $('.progress1');
        progressMessage = $('.progress-message1');  
      
      if (val > '".$packets2."') {
      progress.attr('value', '100');
      
      progressMessage.text('Converting Completed');
      progress.addClass('green');
  } 
  if(val==0){
      progress.attr('value','1');
    }
  else{
    var some= progress.attr('value');
    
    var reader= document.getElementById('txtHint3').innerHTML;

    reader= (reader/(".$packets2."))*100;

      progress.attr('value',reader);
      progressMessage.text('please wait... Files are getting uploaded');

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
  if(spy2== ".$packets2." || spy2 > ".$packets2."){
    my();
  }
  },5000);
   function my(){
    clearInterval(myvar2);
  var txt;
  var r = confirm('Click ok button to download the url file!');
  if (r == true) {
    document.getElementById('download').click();
    window.open('multi2.php','_self');
  } else {
    window.open('multi2.php','_self');
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
        xmlhttp.open('GET', 'scan.php?title=' + til , true);
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
//if do not want to convert
else{
  echo " 


<div id='txtHint3'>0</div>
<div id='progress-wrap1'>
     <div class='progress-message1'>please wait...</div>  
  <progress  value='1' max='100' class='progress1' ></progress>
</div>
<a href='".$foldername."-url.txt' download id='download' hidden>Download</a>

<script>
  var til='".$foldername."';
var spy;
var spy2;
var i=1;
           function est1(val) {
  
    var progress = $('.progress1');
        progressMessage = $('.progress-message1');  
      
      if (val > '".$m3u8files."') {
      progress.attr('value', '100');
      
      progressMessage.text('Converting Completed');
      progress.addClass('green');
  } 
  if(val==0){
      progress.attr('value','1');
    }
  else{
    var some= progress.attr('value');
    
    var reader= document.getElementById('txtHint3').innerHTML;

    reader= (reader/(".$m3u8files."))*100;

      progress.attr('value',reader);
      progressMessage.text('please wait... Files are getting uploaded');

  } 
    
}  





   var myvar2=setInterval(function(){
stoploader2(til);
  i=i+1;
  est1(spy2);
  if(spy2== ".$m3u8files." || spy2 > ".$m3u8files."){
    my();
  }
  },5000);
   function my(){
    clearInterval(myvar2);
  var txt;
  var r = confirm('Click ok button to download the url file!');
  if (r == true) {
    document.getElementById('download').click();
    window.open('multi2.php','_self');
  } else {
    window.open('multi2.php','_self');
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


} 
?> 
<script type="text/javascript" src="jquery.min.js"></script>
 <script type="text/javascript">
     

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
                    document.getElementById("foldername").value = "";
                }
            }
        }
        xmlhttp.open("GET", "getHint.php?q="+str, true);
        xmlhttp.send();
    }
}
   </script>
   <style type="text/css">
     #container{
      
      width:50%;
      height:50%;
      align-content: center;

      margin-left:30%;
      margin-right: 40%;
       
     } 
 body{
    background:url('tech2.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-blend-mode:screen;
    font-family:sans-serif;
    font-size: 70%;
    font-weight: normal;

  }
     #form{
      text-align: center;
    height:380px;
    background-color: rgba(0,0,0,0.9);
    color: white;
    margin-right: 20%;
    margin-left: 10%;
    margin-top: 5%;
    width: 40%; 
    float: right;
    padding:2%;
   font-weight: bold;
   font-size:150%;
    } 
    
    
    
    button{
      padding:1.5%;
      border-radius: 8px;
      border: 2px solid #1c5c6f;
      background-color: #1c5c6d;}
      button:hover{
  background-color: #6ccfd8;
  opacity:0.8;
   
}   
.button{
      padding:1.5%;
      border-radius: 8px;
      border: 2px solid #1c5c6f;
      background-color: #1c5c6d;}
      .button:hover{
  background-color: #6ccfd8;
  opacity:0.8;
  }


   </style>
   <div id="form">
<form method="post" enctype="multipart/form-data">
  <p>Write name of your folder</p>
  <input type="text" name="foldername" id="foldername" onblur="showHint(this.value)" required><br><br>
    <input type="file" name="files[]" id="files" multiple="" directory="" webkitdirectory="" mozdirectory=""><br>
    
    <p id="filenameHint"></p>
    
    <input type="radio" name="convert" value="1" checked> Convert<br>
  <input type="radio" name="convert" value="0"> Donot Convert<br><br>
  <input class="button" type="submit" value="Upload" />
  </form>
  <button onclick="window.open('logout.php','_self')">Logout</button>
      
<div>