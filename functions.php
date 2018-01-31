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

function func_CheckIfExists($conn,$term){

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
TODO: add this argument suitable for the rest of the application !
*/
function func_InsertNewTerm($conn,$term,$docnum){
  echo 'Im inserting new term! ',$term ,'<br />';
  $query = "INSERT INTO indextable (term , hit) VALUES ('$term','0')";
  $result = $conn->query($query);
  if(!$result) return NULL;
  $postid = func_CheckIfExists($conn,$term);
  func_UpdateNewTerm($conn,$postid,$docnum);
}

/*

*/
function func_UpdateNewTerm($conn,$postid,$docnum){
  echo 'Im updating term! ',$postid,'<br />';

  $sql = "UPDATE indextable set hit = hit + 1 WHERE postid = '$postid'";
  $result = $conn->query($sql);

  $sql = "INSERT INTO postfiletable (postid, docname) VALUES ('$postid','$docnum')";
  $resul=$conn->query($sql);



}


function func_ConnectToDb(){
  $username= "root";
  $password="";
  $db="finalproject";
  $servername = "localhost";

  $conn = new mysqli($servername, $username, $password,$db);
  if ($conn->connect_error)     die("Connection failed: " . $conn->connect_error);
  return $conn;
}





function func_DissconnectFromDB($conn){
  $conn->close();
}
function func_ArrangeTableByAsc($conn){
  $sql =  "ALTER TABLE indextable ORDER term BY ASC";
  $sql2 = "ALTER TABLE postfiletable ORDER postid BY  ASC";

  $conn->query($sql);
  if(!$conn)  {
    echo 'doesnt work ORDER BY<br />';
    return NULL;
  }
  $conn->query($sql2);
      echo 'doesnt work ORDER BY<br />';

}

function func_FindTermInDocNum($conn,$text,&$arry){
  $sql = "SELECT docname FROM postfiletable NATURAL JOIN indextable WHERE term = '$text'";
  $result = $conn->query($sql);
  if (!$result)
    return NULL;
    while($row = $result->fetch_assoc())
      $arry[intval($row["docname"])]++;
}

function func_PrintDocsWithHighestHits(&$arry){
  $max=0;

  foreach(array_keys($arry) as &$value)
    if($arry[$value] > $max)
      $max = $arry[$value];
  foreach(array_keys($arry) as &$value){

    if($value == $max){

    }
  }



}

function func_CheckIfIncludedInStopList($term){
  $stopList= array("a","all","and","any","at","be","do","for","her",
"how","if","is","many","not","see","the","their","when","why");
foreach($stopList as $value)
  if($term == $value)
    return true;


  return false;

}








?>
