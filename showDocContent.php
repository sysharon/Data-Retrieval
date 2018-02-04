<?php
if(!isset($_SESSION)) session_start();
if(!isset($_GET["docNum"])) header('Location:index.php');
$docNum = $_GET["docNum"];
include("htmlPages/header.html");

$fp = fopen("Permanent/".$docNum,"r");
if(!$fp)  header('Location:index.php');

echo '
<script>
    var arr = [];
    var line =[];
    var searchTerm =[];
    </script>';
$searchTerm = array();


for($i=0;$i<$_GET["number"];$i++){
  $searchTerm[$i] = $_GET["term$i"];
  echo '<script>searchTerm.push("',$searchTerm[$i],'")</script>';
}

while($str=fgets($fp)){
  // echo '<script>line.push("',$str,'");</script>';
  $textAfterSplit =preg_split("/[\s,]+/",$str) ;

echo '<script>line.push("';
for($k=0;$k<count($textAfterSplit);$k++)
echo $textAfterSplit[$k],' ';
echo '")</script>';

}
fclose($fp);
// $fp = fopen("Permanent/".$docNum,"r");


echo '<div id="showContent"></div>';
// while($str=fgets($fp))

  // echo $str ;

// fclose($fp);




include("htmlPages/footer.html");


?>

<script>
$(document).ready(function() {
  var i=0;
  var strr= $("#showContent").text();
  console.log(strr[5]);
  // for(var i=0;i<splitIt.length;i++)console.log(splitIt[i]);


//line contains every line as a string
//splitIt contain every word of the line
//searchTerm conation the searched word
  var splitIt;
  var isItHint = false;
  line.forEach(function(element){
     splitIt = element.split(" ");  //was splitit
     splitIt.forEach(function(element2){
       for (var i=0;i<searchTerm.length;i++){
        if(element2.toLowerCase() == searchTerm[i].toLowerCase()) {$("#showContent").append("<span class='showHint'>"+searchTerm[i]+"</span>");
      isItHint = true;
      }
      }
if(!isItHint) $("#showContent").append(element2+" ");
else {
  isItHint = false;
  $("#showContent").append(" ");
}

     });
$("#showContent").append("<br />");
  });




});

// window.onload = function() {
//   alert(document.getElementById("justAdiv").value);
//   document.getElementById("justAdiv").innerHTML = "hello world";
// };
</script>
