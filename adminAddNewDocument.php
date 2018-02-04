<?php
if(!isset($_SESSION)) session_start();




if(!$_SESSION["admin"]) header("location: index.php");
require_once("functions.php");
 include("htmlPages/header.html");
?>

<div class="wrappers">


<?php


  /*
  Check if there is a Incoming files.. if not showing the form to input the documents
  include javascript to add dynamic files with the 'name="file0"' 'name="file1"' .....
  */
 if(!isset($_POST["numberOfFiles"])) {
   include("htmlPages/addNewDocumentForm.html");
  }



/*
ELSE means there were post request with the files!
*/
 else{

   $numberOfFiles = $_POST['numberOfFiles'];
 // echo 'number of files: ',$numberOfFiles,"<br /><Br />";
 $conn = func_ConnectToDb();

for($i=0;$i<$numberOfFiles;$i++){
 if($fp = fopen($_FILES["file$i"]['tmp_name'],"r+")) {
   $fileArray=scandir("Permanent");
$max = 0;
   for($k=0;$k<count($fileArray);$k++){
     $value = intval($fileArray[$k]);
     if($value > $max) $max=$value;
   }

   if(ksort($fileArray)){
      if(($fileArray == NULL) || ($fileArray[0] == '.') || ($fileArray[1] == "..") ||
       (count($fileArray) == 0) || (count($fileArray) <=2))
      {
        $fileNum = 1;
      }

      else{
      $fileNum = $fileArray[count($fileArray)-1]+1;

    }
    $max++;

    }
   else{
       echo 'cant sort the array<Br />';
     }

     echo 'max= ',$max,'<br />';
     $fileNum = $max;
     if(!copy($_FILES["file$i"]['tmp_name'],"Permanent/$max")) echo 'cant copy file! = ',$_FILES["file$i"]['tmp_name'],'<br />';

   $str= func_GetFileAsString($_FILES["file$i"]['tmp_name']);
   /*
   This for loop gets all the content in the file without
   carring for , ; ' ' " "
   */
   for($j=0;$j<count($str);$j++){
     if($str[$j]== '') continue;
     echo '$str[$j]= ',$str[$j],'<br />';
     // if(func_CheckIfIncludedInStopList($str[$j])) continue;
     $postid = func_CheckIfExists($conn,$str[$j],$fileNum);
     if($postid == -1)   func_InsertNewTerm($conn,$str[$j],$fileNum);
     else  func_UpdateNewTerm($conn,$postid,$fileNum);

 }
 }
}
func_DissconnectFromDB($conn);


}



  ?>





</div>
  <?php include("htmlPages/footer.html"); ?>
