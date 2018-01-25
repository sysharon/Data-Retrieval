<?php
if(!isset($_SESSION))
   {
       session_start();
   }
  if(!$_SESSION['admin'])
    header("location: index.php");
// echo readfile("files/index");
if($fp = fopen("files/index","r+")){
  while(($line = fgets($fp)) !==false){
      echo 'line= ',$line,"<br />";
  }
  fclose($fp);
}
else {
  echo 'Unable to open the file fiels/index';
}

// $fpp = fopen("files/newFile", "w");
// fwrite($fpp,"hello worlds world");
// fclose($fpp);
 ?>
