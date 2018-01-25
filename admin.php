<?php
if(!isset($_SESSION))
   {
       session_start();
   }
  include ("htmlPages/header.html");

if(!isset($_SESSION["admin"])){
  if((isset($_POST["username"])) && (isset($_POST["password"])) &&
   ($_POST["username"] == "admin") && ($_POST["password"] == "pass")){
     $_SESSION["admin"] = true;
   }
   else{
     include("htmlPages/login.html");
   }
}
 if((isset($_SESSION["admin"])) && ($_SESSION["admin"])){
   include("showAdminOptions.php");
  // include("pagesToAdd.php");

}




 ?>



 <?php include ("htmlPages/footer.html") ; ?>
