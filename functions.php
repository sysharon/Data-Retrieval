<?php
// func_CheckIfFileOpensOk($path);
// func_GetFileAsString($path);
// func_checkInIndexFile($value);
// func_GetWordAppearances($word);
// func_CheckIfExists($term);
// func_InsertNewTerm($term);
// func_UpdateNewTerm($postid);
// function func_ConnectToDb($db)
// function func_DissconnectFromDB($conn)

/*
Global variables!
*/



function  func_CheckIfFileOpensOk($path){
  if($fp = fopen($path, "r+"))  return true;
  else {
    return false;
  }
}


function func_GetFileAsString($path){
  $text = file_get_contents($path);

  if($text != false){
    echo ' read index file<br />';
    $textAfterSplit =preg_split("/[\s,]+/",$text) ;
    for($i=0;$i<count($textAfterSplit);$i++) $textAfterSplit[$i] = strtolower($textAfterSplit[$i]);

    return $textAfterSplit;
  }
  else {
    echo 'Problem Reading Index file';
    return false;
  }
  // $textAfterSplit =preg_split("/[\s,]+/",$searchTerm) ;
}



function func_checkInIndexFile($value){
  if (func_CheckIfFileOpensOk("files/index")){
    if($fp = fopen("files/index","r+")){


      while(($line = fgets($fp)) !==false){
          echo 'line= ',$line,"<br />";
      }
      fclose($fp);
  }
  else{
    echo 'problem opening index file';
  }
}
}

function func_GetWordAppearances($word){
  echo'word= ',$word,'<br />';
  if(func_CheckIfFileOpensOk("files/index")){
    $fp = fopen("files/index", "r");
    while(($line = fgets($fp)) !==false){
      $textAfterSplit =preg_split("/[\s,]+/",$line) ;
        for($i=0;$i<count($textAfterSplit);$i++){
            if($word == $textAfterSplit[$i]) echo 'we have a match! = ',$word, " = ",$textAfterSplit[$i],'<br />';
      }
    }
    fclose($fp);
  }
}

function func_CheckIfExists($term){
  $conn = func_ConnectToDb();
  if($conn == NULL) return NULL;
  $sql ="SELECT postid FROM indextable WHERE term = '$term'";
  $result = $conn->query($sql);
  if (!$result) {
    trigger_error('Invalid query: ' . $conn->error);
  }
  if ($result->num_rows == 0) return -1;
  else {
    $row = $result->fetch_assoc();
    return $row['postid'];
  }

}


/*

*/
function func_InsertNewTerm($term){
  echo 'Im inserting new term! ',$term ,'<br />';
}

/*

*/
function func_UpdateNewTerm($postid){
  echo 'Im updating term! ',$postid,'<br />';

}


function func_ConnectToDb(){
  $username= "root";
  $password="";
  $db="finalproject";
  $servername = "localhost";


  $conn = new mysqli($servername, $username, $password,$db);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}
function func_DissconnectFromDB($conn){
  $conn->close();
}



?>
