<?php

include 'strings.php';

$dbhost = 'localhost';
$dbuser = $global_dbuser;
$dbpass = $global_dbpass;
$dbname = $global_dbname;
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');

mysql_select_db($dbname);

$query = "select recipient, name
from active 
where recipient not in (
select recipient 
from sendblasterexport )";


$ans = mysql_query($query, $conn);
$i=0;


while ( $fila = mysql_fetch_array($ans) ){
	$recipients[$i] = $fila[0];
	$names[$i] = $fila[1];
	$i++;
}
$count=0;


echo "<table border=\"1\">";
echo "<tr><th> E-Mail </th><th> Nombre </th></tr>";
while( $count < $i ){
	if ( $count % 2 == 0){
		echo "<tr id=\"$id[$count]\">";
	}else{
		echo "<tr class=\"alt\"  id=\"$id[$count]\">";
	}
	echo "<td>" . $recipients[$count] . "</td><td>" .$names[$count]
	."</td>";
	echo "<tr>";
	$count++;
}
echo "</table>";


?>