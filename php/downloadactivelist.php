<?php 
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=\"".basename("activelist.csv")."\";" );
header("Content-Transfer-Encoding: binary");
// exit();

include 'strings.php';

	$dbhost = 'localhost';
	$dbuser = $global_dbuser;
	$dbpass = $global_dbpass;
	$dbname = $global_dbname;
	$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
	
	mysql_select_db($dbname);
	$fp = fopen('activelist.csv','w');
	
	//downloads the mail only if if it is suscribed
	$sqltxt = "SELECT recipient,name from active where suscribed = 1";
	$ans = mysql_query($sqltxt, $conn);
	
	$query = mysql_query($sqltxt);
	while ($row = mysql_fetch_array($query)) {
		$nextline = $row[0] . ';' . $row[1] . ';' . "\r\n";
		fwrite($fp,$nextline);
	}
	fclose($fp);

	header("Content-Length: ".filesize("activelist.csv"));
	readfile("activelist.csv");



?>