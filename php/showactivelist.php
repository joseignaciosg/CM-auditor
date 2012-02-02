<?php
include 'strings.php';


$dbhost = 'localhost';
$dbuser = $global_dbuser;
$dbpass = $global_dbpass;
$dbname = $global_dbname;
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
mysql_select_db($dbname);

$sqltxt = "SELECT recipient ,name, status,hard, soft, suscribed
			from active";

$ans = mysql_query($sqltxt, $conn);
$i=0;


while ( $fila = mysql_fetch_array($ans) ){
	$recipients[$i] = $fila[0];
	$names[$i] = $fila[1];
	$status[$i] = $fila[2];
	$hards[$i] = $fila[3];
	$softs[$i] = $fila[4];
	$suscribed[$i] = $fila[5];
	$i++;
}

$count=0;


echo "<table border=\"1\">";
echo "<tr><th></th><th> E-Mail </th><th>Nombre</th><th>Status</th><th>Hard</th><th>Soft</th><th>Suscribed</th></tr>";
while( $count < $i ){
	if ( $count % 2 == 0){
		echo "<tr id=\"$id[$count]\">";
	}else{
		echo "<tr class=\"alt\"  id=\"$id[$count]\">";
	}
	echo "<td>$count - </td><td>" . $recipients[$count] . "</td><td>" .  $names[$count] . "</td><td>" . $status[$count] . "</td><td>". $hards[$count] .
	"</td><td>" . $softs[$count] . "</td><td>" . $suscribed[$count]  ."</td>";
	echo "<tr>";
	$count++;
}
echo "</table>";


?>