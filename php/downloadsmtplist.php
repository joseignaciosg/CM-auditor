<?php 

include 'strings.php';

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=\"".basename("smtplist.csv")."\";" );
header("Content-Transfer-Encoding: binary");
// exit();

	$dbhost = 'localhost';
	$dbuser = $global_dbuser;
	$dbpass = $global_dbpass;
	$dbname = $global_dbname;
	$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
	mysql_select_db($dbname);
	$fp = fopen('smtplist.csv','w');
	
	$sqltxt = "SELECT recipient, status,error from turbosmtp";
	$ans = mysql_query($sqltxt, $conn);
	
	$query = mysql_query($sqltxt);
	while ($row = mysql_fetch_array($query)) {
		$nextline = $row[0] . ';' . $row[1] . ';' . $row[2] . ';' . "\r\n";
		fwrite($fp,$nextline);
	}
	fclose($fp);

	header("Content-Length: ".filesize("smtplist.csv"));
	readfile("smtplist.csv");



?>