<?php


$dbhost = 'localhost';
$dbuser = 'category';
$dbpass = '4975_pirata_MORGAN';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
$dbname = 'category_new'; // I select the correct database
mysql_select_db($dbname);
$last_register = $_GET['last_register'];
$jump = $_GET['jump'];
$func = $_GET['func'];
$company = $_GET['company'];
$type = $_GET['type'];
// echo $last_register;

switch($func){
	case 1: /*first or next*/
		$sqltxt = "SELECT user, mail, DATE, name, campaign, companies.nombre, image_click.id, message
					FROM image_click, newsletters, companies
					WHERE image_click.newsletter = newsletters.newsletter_id
					AND image_click.company = companies.id
					AND companies.id = ".$company." 
					AND image_click.type = ".$type."
					ORDER BY DATE DESC LIMIT " . $last_register .",".($jump);
		break;
	case -1: /*prev*/
		$aux = $last_register-($jump*2);
		$sqltxt = "SELECT user, mail, DATE, name, campaign, companies.nombre,image_click.id, message
					FROM image_click, newsletters, companies
					WHERE image_click.newsletter = newsletters.newsletter_id
					AND image_click.company = companies.id
					AND companies.id = ".$company."
					AND image_click.type = ".$type."
					ORDER BY DATE DESC LIMIT " . $aux .",".($jump);
		break;
}

$ans = mysql_query($sqltxt, $conn);
$i=0;


while ( $fila = mysql_fetch_array($ans) ){
	$names[$i] = $fila[0];
	$mails[$i] = $fila[1];
	$date[$i] = strtotime($fila[2]);/*converting from mysql to php time*/
	$newsletter[$i] = $fila[3];
	$campaign[$i] = $fila[4];
	$companies[$i] = $fila[5];
	$message[$i] = $fila[7];
	$id[$i] = $fila[6];
	$i++;
}
$count=0;


if ( $type == 1){
	echo "<table>";
	echo "<tr><th> Nombre </th><th>E-mail</th><th>Fecha</th><th>Hora</th><th>Newsletter</th><th><p id=\"camp\">Campa&ntilde;a</p></th><th>Compa&ntilde;&iacute;a</th></tr>";
	while( $count < $i ){
		if ( $count % 2 == 0){
			echo "<tr id=\"$id[$count]\">";
		}else{
			echo "<tr class=\"alt\"  id=\"$id[$count]\">";
		}
			echo "<td>" . $names[$count] . "</td><td>" . $mails[$count] . "</td><td>".date("d/m/y",$date[$count]) 
				."</td><td>".date("H:i:s",$date[$count])."</td><td>".$newsletter[$count] ."</td><td>".$campaign[$count] ."</td>"
				."<td>".$companies[$count]."</td><td><a  id=\"deltuple\" href=\"$id[$count]\">borrar</a></td>";
			echo "<tr>";
		$count++;
	}
	echo "</table>";
}else if ( $type = 2 ){
	echo "<table>";
	echo "<tr><th> Nombre </th><th>E-mail</th><th>Fecha</th><th>Hora</th><th>Newsletter</th><th><p id=\"camp\">Campa&ntilde;a</p></th><th>Compa&ntilde;&iacute;a</th><th>Click Link</th></tr>";
	while( $count < $i ){
		if ( $count % 2 == 0){
			echo "<tr id=\"$id[$count]\">";
		}else{
		echo "<tr class=\"alt\"  id=\"$id[$count]\">";
		}
		echo "<td>" . $names[$count] . "</td><td>" . $mails[$count] . "</td><td>".date("d/m/y",$date[$count])
		."</td><td>".date("H:i:s",$date[$count])."</td><td>".$newsletter[$count] ."</td><td>".$campaign[$count] ."</td>"
					."<td>".$companies[$count]."</td><td>".$message[$count] ."</td><td><a  id=\"deltuple\" href=\"$id[$count]\">borrar</a></td>";
				echo "<tr>";
			$count++;
	}
	echo "</table>";
}

//select name from image_click join newsletters on newsletter_id = newsletter

?>