<?php

include 'strings.php';

$dbhost = 'localhost';
$dbuser = $global_dbuser;
$dbpass = $global_dbpass;
$dbname = $global_dbname;
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
mysql_select_db($dbname);
date_default_timezone_set('America/Argentina/Buenos_Aires');

//first stores the auditory in the log
$mysqldate = date( 'Y-m-d H:i:s');
$logquery = "insert into log  values('','$mysqldate')";
$ans = mysql_query($logquery, $conn);
if (!$ans){
	echo "<br/>Invalid query:  " . mysql_error();
}

$querysoft = 'insert into soft select recipient, status, error
			from turbosmtp 
			where status like "%FAIL%"
			and (error like "%Recipient%address%rejected:%Access%Denied"
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
			or error like "%Mailbox disabled%")';

$queryhard = 'insert into hard select recipient, status, error
			from turbosmtp 
			where status like "%FAIL%"
			and (error like "%The email account that you tried to reach does not exist%"
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
			or error like "%Relay access denied%")';

$sqlcheck1 = "select recipient from hard";
$sqlcheck2 = "select recipient from soft";

$ans1 = mysql_query($sqlcheck1, $conn);
$hardcount = mysql_num_rows($ans1);

$ans2 = mysql_query($sqlcheck1, $conn);
$softcount = mysql_num_rows($ans2);

if ( $hardcount != 0 || $softcount != 0 ){
	//delete both temporary tables (soft and hard)
	mysql_query("delete from soft where 1", $conn);
	mysql_query("delete from hard where 1", $conn);
	echo "Old data deleted.<br/>";
}

//insert new tuples into tables
$result = mysql_query($querysoft, $conn) or die("error");
echo "Soft Bounces inserted.<br/>";
$result = mysql_query($queryhard, $conn) or die("error");
echo "Hard Bounces inserted.<br/>";


/*
 * . updates the active list bounces
* . unsuscribes the users if the maximun number of bounces has been reached
*/

/*
 *algorithm
*
* . for each mail of the sendblaster table:
*     -> if the mail is present in the active table:
*        -> check if the status is fail
*           -> if fail: check whether is hard or soft
*         		->check the number of bounces plus one of that register is > than 5 (soft) or 3 (hard)
*         			-> yes : unsuscribe the user
*         			-> no: just add one to the count
* 			 -> if success: nothing
*    -> if mail not present: add it to the active table
*/


// using php (ya fue)

$query1 = "select * from turbosmtp";
$query2 = "select * from active where recipient LIKE ";
$querysoft = "select * from";
$ans1 = mysql_query($query1, $conn);

$aux=1;
while ( $row = mysql_fetch_array($ans1) ){
	$ans2 = mysql_query($query2 . "'%$row[1]%'", $conn);
	$isthere = mysql_num_rows($ans2);
	if ($isthere != 0){
		//is there
		$tuple = mysql_fetch_array($ans2);
		if ( $row[3] == "FAIL" ){
			//decides whether is hard or soft
			$ans3 = mysql_query("select * from soft where recipient like '%$row[1]%'",$conn);
			$ans4 = mysql_query("select * from hard where recipient like '%$row[1]%'",$conn);
			$softcount = mysql_num_rows($ans3);
			$hardcount = mysql_num_rows($ans4);
			if ( $softcount != 0 ){
				echo "<br/>" . $row[3] . " soft" . " /softs in active : " . ($tuple[7] );
				$softprev = $tuple[7] +1 ;
				if ( $softprev >= 5 ){
					//need to unsuscribe
					mysql_query("update active set suscribed=0 where recipient like '%$row[1]%'");
				}
				mysql_query("update active set soft=$softprev where recipient like '%$row[1]%'");
				mysql_query("update active set status='SOFT' where recipient like '%$row[1]%'");
			}else if ( $hardcount != 0){
				echo "<br/>" . $row[3] . " hard" . " /hards in active : " . ($tuple[6]);
				$hardprev = $tuple[6] +1 ;
				if ( $hardprev >= 3 ){
					//need to unsuscribe
					mysql_query("update active set suscribed=0 where recipient like '%$row[1]%'");
				}
				mysql_query("update active set hard=$hardprev where recipient like '%$row[1]%'");
				mysql_query("update active set status='HARD' where recipient like '%$row[1]%'");
			}
			
			
				
		}else{//success
			mysql_query("update active set status='SUCCESS' where recipient like '%$row[1]%'");
		}
		// 		echo $aux;
		// 		$aux++;
		// 		echo "<br/>$row[3]";
	}else{//is not there
		//adds it only if is a success
		if ( $row[3] == "SUCCESS"){
			$ans3 = mysql_query("insert into active values('$row[1]','','','','','SUCCESS',0,0,1)", $conn);
			if (!$ans3){
				echo "<br/>Invalid query: $row[1]:  " . mysql_error();
			}else{
				echo '<br/>' . $row[1] . " added.";
			}
		}
	}
}


