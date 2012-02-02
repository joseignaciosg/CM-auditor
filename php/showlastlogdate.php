<?php

include 'strings.php';

$dbhost = 'localhost';
$dbuser = $global_dbuser;
$dbpass = $global_dbpass;
$dbname = $global_dbname;
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
mysql_select_db($dbname);

$sqltxt = "select  max(id) from log";
$ans = mysql_query($sqltxt, $conn);
if (!$ans){
	echo "<br/>Invalid query:  " . mysql_error();
}
$row = mysql_fetch_array($ans);

$sqltxt2 = "select fecha from log where id = $row[0]";
$ans2 = mysql_query($sqltxt2, $conn);
if (!$ans){
	echo "<br/>Invalid query:  " . mysql_error();
}


$fila = mysql_fetch_array($ans2);
$date[0] = strtotime($fila[0]);
echo "Dia: " . date("d/m/y",$date[0]); 
echo "<br>Fecha: " . date("H:i:s",$date[0]);



?>