<?php
if(!isset($_SESSION)) session_start();




if(!$_SESSION["admin"]) header("location: index.php");
require_once("functions.php");
 include("htmlPages/header.html");
?>

<div class="wrappers">


<?php

// $fh = fopen($_FILES['file']['tmp_name'], 'r');
  // if(!isset($_FILES["file"])) echo 'isset!';



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
 echo 'number of files: ',$numberOfFiles,"<br /><Br />";

for($i=0;$i<$numberOfFiles;$i++){

 if($fp = fopen($_FILES["file$i"]['tmp_name'],"r+")) {

   $str= func_GetFileAsString($_FILES["file$i"]['tmp_name']);

   /*
   This for loop gets all the content in the file without
   carring for , ; ' ' " "
   */
   for($j=0;$j<count($str)-1;$j++){
     echo 'our string is: ',$str[$j],'<br />';

     $postid = func_CheckIfExists($str[$j]);
     if($postid == -1)   func_InsertNewTerm($str[$j]);
     else  func_UpdateNewTerm($postid);

 }
 }
}





  // func_GetWordAppearances("line");



}


// }

  ?>





</div>
  <?php include("htmlPages/footer.html"); ?>

  <!-- <script>
  var counter = 0;
  $(document).ready(function(){


$("#filesNumbersInput").change(function(){
  for(var i=0;i<$("#filesNumbersInput2").val();i++){
    $("#files").append('<input id="firstFile" type="file" name="file'+i+'"/><br />');

  }
  $("#files").append('<input name="file'+i+'" type="submit" value="GO!"  >');

  $("#filesNumbersInput").css("display","none");

  console.log("number = "+$("#filesNumbersInput").val() );
})
  });

  </script> -->
