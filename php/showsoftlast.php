<?php

include 'strings.php';

$dbhost = 'localhost';
$dbuser = $global_dbuser;
$dbpass = $global_dbpass;
$dbname = $global_dbname;
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
mysql_select_db($dbname);

$sqltxt = "SELECT recipient, status,error
			from soft";

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