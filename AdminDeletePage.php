<?php 
if(!isset($_SESSION)) session_start();
if(!$_SESSION["admin"]) header("location: index.php");
require_once("functions.php");
include("htmlPages/header.html");
?>
<div class="content">
	<div class="wrappers">
<?php 
if(isset($_POST['docum'])){
	$doc = $_POST['docum'];
	// print "docNum = $doc <br>";
	
	DeleteFile($doc);

}
else{
 ?>
  <div class="AdminOptions2">

 <form method="POST">
 <input type="number" name="docum" placeholder="Please Select Document Number:">
 <button type="submit">Delete This Document!</button>
 </form>

</div>




<?php } ?>
</div>
</div>

 <?php include("htmlPages/footer.html"); ?>