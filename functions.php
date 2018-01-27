<?php

function  func_CheckIfFileOpensOk($path){
  if($fp = fopen($path, "r+"))  return true;
  else {
    return false;
  }
}


function func_GetIndexAsString(){
  $text = file_get_contents("files/index");

  if($text != false){
    echo ' read index file<br />';
    return $text;
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


?>
