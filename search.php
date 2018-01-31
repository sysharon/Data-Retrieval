<?php

if(!isset($_SESSION)) session_start();
require_once("functions.php");
  include("htmlPages/header.html");

  $searchTerm = $_POST["search"];
  if(!$searchTerm)    {
  echo '
      <a style="position:relative; top:50%;left:40%;text-align:left;border-left:3px solid;"href="index.php">   Please fill the Search Line</a>
      ';
        header('Location: index.php');
    }

  else {
    echo 'text= ',$searchTerm,'<Br />';
    $textAfterSplit =preg_split("/[\s,]+/",$searchTerm) ;
    $fileArray=scandir("Permanent");
    $arry = array();

    for($i=2;$i<count($fileArray);$i++)  {
      // echo 'file= ',$fileArray[$i],'<br />';
      // $array.push($fileArray[$i],0);
      $arry[strval($fileArray[$i])] = 0;// **********************
      // echo 'strval($fileArray[$i]= ',strval($fileArray[$i]),'<br />';
      // $arry["2"] = 4;
      // print_r($arry);
    }
    // print_r($arry);

    // var_dump($textAfterSplit);
    // $keywords = preg_split("/[\s,]+/", "hyper[text],adas+ language, programming");
// print_r($keywords);
// print_r($arry);
$conn = func_ConnectToDb();

    for($i =0;$i<count($textAfterSplit);$i++){
      echo $textAfterSplit[$i],"<br />" ;//Omri- use this variable to search in an index file which you will write (add random words and numbers) and return in which files the words appear
      func_FindTermInDocNum($conn,$textAfterSplit[$i],$arry);
    }
print_r($arry);
func_DissconnectFromDB($conn);




  }
  // echo "searchTerm = " ,$searchTerm;
