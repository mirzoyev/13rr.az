<?php
include_once '../inc/predoc.php';
include_once '../inc/header.php';
include_once 'inc/personal.php';

$directory = $_SERVER["DOCUMENT_ROOT"];
$paths = array_diff(scandir($directory), array('..', '.'));

foreach($paths as $path){
 if(!is_dir($path)){
  $type = explode('.', $path);
  $type = array_reverse($type);
  if($type[0] == 'css') {
   echo "<a href=\"personal_style_change.php?s=$type[1]\">$type[1]</a><br>";
  }
 }
}

include_once '../inc/footer.php';
?>
