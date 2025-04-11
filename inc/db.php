<?php

$dbh_gl = 0;
$dbc_gl = 0;

function db_connect() {
 global $dbh_gl;
 global $dbc_gl;
 if(!$dbh_gl) $dbh_gl = new PDO("dblib:host=10.0.24.230;dbname=inno_report;charset=UTF-8", "sa", "Rkeeper123");
 $dbc_gl++;
 return $dbh_gl;
}

function db_close() {
 global $dbh_gl;
 global $dbc_gl;
 if ($dbc_gl) $dbc_gl--;
 if (($dbc_gl == 0) && $dbh_gl) {
  unset($dbh_gl);
  $dbh_gl = 0;
 }
}

?>
