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