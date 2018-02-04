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
// include("showDocContent.php");


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
    $textAfterSplit =preg_split("/[\s,(,),.,<,>':\"]+/",$text) ;
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
      $textAfterSplit =preg_split("/[\s,(,),.,<,>':\"]+/",$line) ;
        for($i=0;$i<count($textAfterSplit);$i++){
            if($word == $textAfterSplit[$i]) echo 'we have a match! = ',$word, " = ",$textAfterSplit[$i],'<br />';
      }
    }
    fclose($fp);
  }
}

function func_CheckIfExists($conn,$term,$fileNum){
  if($conn == NULL) return NULL;
  $sql ="SELECT postid FROM indextable WHERE term = '$term'";
  $result = $conn->query($sql);
  if (!$result) {
    trigger_error('Invalid query: ' . $conn->error);
  }
  if ($result->num_rows == 0) return -1;
  else {
    $row = $result->fetch_assoc();
    return $row['postid'];  //this it the post id
  }

}


function func_InsertNewTerm($conn,$term,$docnum){
  $query = "INSERT INTO indextable (term , hit) VALUES ('$term','0')";
  $result = $conn->query($query);
  if(!$result) return NULL;
  $postid = func_CheckIfExists($conn,$term,$docnum);
  func_UpdateNewTerm($conn,$postid,$docnum);
}

/*

*/
function func_UpdateNewTerm($conn,$postid,$docnum){
  if(func_CheckIfExistsInSameDoc($conn,$postid,$docnum)){
    $sql = "UPDATE postfiletable set freq = freq + 1 WHERE docname = '$docnum' AND postid = '$postid'";
    echo $postid,'updating postifile table+1<Br />';
  }
  else{   //not exist in our file
    $sql = "UPDATE indextable set hit = hit + 1 WHERE postid = '$postid'";
    $result = $conn->query("INSERT INTO postfiletable (postid, docname, freq) VALUES ('$postid','$docnum','1')");
    if(!$result)  return NULL;
  }

  $result = $conn->query($sql);
if(!$result)  return NULL;


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

function func_PrintDocsWithHighestHits(&$arry,&$textAfterSplit){
  $max=0;

  echo '<div class="results">';

  foreach(array_keys($arry) as &$value)
    if($arry[$value] > $max)
      $max = $arry[$value];
    // echo 'max= ',$max,'<br />';
    if($max == 0) return false;
  foreach(array_keys($arry) as &$value){
    if(($arry[$value] == $max) && ($max > 0)) {
      printDocPreview($value,$textAfterSplit);
    }
  }

  echo '</div>';
  return true;
  
}
function printDocPreview($docNum,&$arry){
  $fp = fopen('Permanent/'.strval($docNum),"r");
  if(!$fp)  return null;
  $query = '&number='.count($arry);
  for($i=0;$i<count($arry);$i++)  $query .= "&term$i=$arry[$i]";
  echo '<a href="showDocContent.php?docNum=',$docNum,$query,'"><div class="preview">';
  for($i=0;$i<4;$i++){
    echo '
      <div class="line',$i,'">
      ',fgets($fp),'
      </div>
    ';
  }
  echo'</div>';
  fclose($fp);

}

function func_CheckIfIncludedInStopList($term){
  $stopList= array("a","all","and","any","at","be","do","for","her",
"how","if","is","many","not","see","the","their","when","why");
foreach($stopList as $value)
  if($term == $value)
    return true;


  return false;

}

function func_CheckIfExistsInSameDoc($conn, $postid,$docnum){
  $sql ="SELECT * from postfiletable WHERE postid = '$postid' AND docname = '$docnum'";
  echo 'postiid= ',$postid,' docNum=  ',$docnum,'<br />';
  $result = $conn->query($sql);
  if(!$result) return NULL;
  else return $result->num_rows;

}







?>
