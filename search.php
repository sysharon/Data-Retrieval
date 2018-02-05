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
    $operator = "AND";

    $textAfterSplit =preg_split("/[\s,]+/",$searchTerm) ;
    $fileArray=scandir("Permanent");
    $arry = array();
    $arry2 = array();
    for($i=2;$i<count($fileArray);$i++)  {

      $arry[strval($fileArray[$i])] = 0;// **********************
      $arry2[strval($fileArray[$i])] = 0;
    }


$conn = func_ConnectToDb();
  $numberOfWords = count($textAfterSplit);
  // print_r($textAfterSplit);
    for($i =0;$i<count($textAfterSplit);$i++){
      $str = strtolower($textAfterSplit[$i]);
      // echo 'str[1] = ',$str[0],'<Br />';
      // if($str[0] == '(' ) func_SearchBrackets($textAfterSplit,$i) ;
       if(func_CheckIfIncludedInStopList($textAfterSplit[$i])) continue;
       if($str[0] == '"') handleParentheses($textAfterSplit,$i,$arry,$conn);
       else if($str[0] == '(') handleBrackets($textAfterSplit,$i,$arry,$conn);
       else if(strcmp($str,"or") ==0) $operator = "OR"; //handleOR($textAfterSplit,$i,$arry,$arry2,$conn);
       else if(strcmp($str,"not")==0) $operator = "NOT";//handleNOT($textAfterSplit,$i,$arry,$conn);
       else{
        func_FindTermInDocNum($conn,$textAfterSplit[$i],$arry2);  //array2 has value for appeareacne in docs

        if($i != 0){
        if($operator == "OR")
          calculateOR($arry,$arry2,$fileArray);
        else if($operator == "NOT")
          calculateNOT($arry,$arry2,$fileArray);
        else if($operator == "AND")calculateAND($arry,$arry2,$fileArray);
}
      if($i==0){
        for($j=2;$j<count($fileArray);$j++){
            if($arry2[strval($fileArray[$j])] == 1)
            $arry[strval($fileArray[$j])] = 1;
            $arry2[strval($fileArray[$j])] = 0;
      }
      }
      $operator = "AND";
    }


  }

    if(!func_PrintDocsWithHighestHits($arry,$textAfterSplit))
      header('location: index.php');
func_DissconnectFromDB($conn);


  }
  // echo "searchTerm = " ,$searchTerm;
?>
