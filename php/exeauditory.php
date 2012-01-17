<?php


$dbhost = 'localhost';
$dbuser = 'jose';
$dbpass = 'whiteflag';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
$dbname = 'auditory_system'; // I select the correct database
mysql_select_db($dbname);

$querysoft = 'insert into soft select recipient, status, error
			from turbosmtp 
			where status like "%FAIL%"
			and error like "%Recipient%address%rejected:%Access%Denied"
			or error like "%Server%access%forbidden%by%your%IP%"
			or error like "%no mailbox by that name is currently available%"
			or error like "%Mailbox size limit exceeded%"
			or error like "%mailbox unavailable%"
			or error like "%Mailbox quota exceeded%"
			or error like "%spam%"
			or error like "%Administrative prohibition%"
			or error like  "%Denied by policy%"
			or error like "%Account is not active%"
			or error like "%connection died%"
			or error like "%Service Unavailable%"
			or error like "%Mail could not be processed%"
			or error like "%Mailbox disabled%"';

$queryhard = 'insert into hard select recipient, status, error
			from turbosmtp 
			where status like "%FAIL%"
			and error like "%The email account that you tried to reach does not exist%"
			or error like "%Recipient address rejected: User unknown%"
			or error like "%Unable to relay for%"
			or error like "%relay not permitted%"
			or error like "%Invalid recipient%"
			or error like "%No such user%"
			or error like "%mail server permanently rejected message%"
			or error like "%permanently%"
			or error like "%user unknown%"
			or error like "%address rejected%"
			or error like "%no such user%"
			or error like "%not exists"
			or error like "%unknown%"
			or error like "%No such recipient%"
			or error like "%no such recipient%"
			or error like "%No such address%"
			or error like "%no such address%"
			or error like "%recipient rejected%"
			or error like "%doesn%t have a % account%"
			or error like "%I couldn% find any host by that name%"
			or error like "%No relaying allowed%"
			or error like "%This account has been disabled or discontinued%"
			or error like "%Unrouteable address%"
			or error like "%Unable to relay%"
			or error like "%no such address here%"
			or error like "%was not found%"
			or error like "%invalid mailbox%"
			or error like "%does not exist%"
			or error like "%Relay access denied%"';

$sqlcheck1 = "select recipient from hard";
$sqlcheck2 = "select recipient from soft";

$ans1 = mysql_query($sqlcheck1, $conn);
$hardcount = mysql_num_rows($ans1);

$ans2 = mysql_query($sqlcheck1, $conn);
$softcount = mysql_num_rows($ans2);

if ( $hardcount != 0 || $softcount != 0 ){
	//delete both temporary tables (soft and hard)
	mysql_query("delect from soft where 1", $conn);
	mysql_query("delect from hard where 1", $conn);
	echo "Old data deleted.<br/>";
}

//insert new tuples into tables
$result = mysql_query($querysoft, $conn) or die("error");
echo "Soft Bounces inserted.<br/>";
$result = mysql_query($queryhard, $conn) or die("error"); 
echo "Hard Bounces inserted.<br/>";

