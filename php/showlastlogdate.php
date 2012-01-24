<?php

$dbhost = 'localhost';
$dbuser = 'jose';
$dbpass = 'whiteflag';
// $dbuser = 'category';
// $dbpass = '4975_pirata_MORGAN';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
$dbname = 'auditory_system';
// $dbname = 'category_auditory_system';
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
$i=0;


while ( $fila = mysql_fetch_array($ans2) ){
	$date[$i] = $fila[0];
	$i++;
}

echo date("H:i:s",$date[0]);



?>