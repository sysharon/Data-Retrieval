<?php

function  func_CheckIfFileOpensOk($path){
  if($fp = fopen($path, "r+"))  return true;
  else {
    return false;
  }
}

?>
