<?php


$dbhost = 'localhost';
$dbuser = 'jose';
$dbpass = 'whiteflag';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
$dbname = 'auditory_system'; // I select the correct database
mysql_select_db($dbname);

$sqltxt = "SELECT recipient, status,error
			from turbosmtp";

$ans = mysql_query($sqltxt, $conn);
$i=0;


while ( $fila = mysql_fetch_array($ans) ){
	$recipients[$i] = $fila[0];
	$status[$i] = $fila[1];
	$errors[$i] = $fila[2];/*converting from mysql to php time*/
	$i++;
}
$count=0;


echo "<table border=\"1\">";
echo "<tr><th> E-Mail </th><th>Status</th><th>Error</th></tr>";
while( $count < $i ){
	if ( $count % 2 == 0){
		echo "<tr id=\"$id[$count]\">";
	}else{
		echo "<tr class=\"alt\"  id=\"$id[$count]\">";
	}
	echo "<td>" . $recipients[$count] . "</td><td>" . $status[$count] . "</td><td>".$errors[$count]
	."</td>";
	echo "<tr>";
	$count++;
}
echo "</table>";



?>