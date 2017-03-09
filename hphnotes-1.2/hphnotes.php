<?php

include 'config.php';

// open connection:
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql: '. mysql_error());
mysql_select_db($dbname);

$query = "SELECT * FROM accounts";
$result = mysql_query($query);

if (!mysql_fetch_array($result, MYSQL_ASSOC)) {
	$query = 
		'CREATE TABLE accounts('.
        'id INT NOT NULL AUTO_INCREMENT, '.
        'userid VARCHAR(50) NOT NULL, '.
        'passwordhash CHAR(32) NOT NULL, '.
        'mynotes TEXT NOT NULL, '.
        'PRIMARY KEY(id),'.
		'UNIQUE KEY `IX_accounts_1` (`userid`))';
	$result = mysql_query($query);
}

function deapos($x) {
	return preg_replace("/[^\\w\\d\\.\\-\\=\\@\\/\\!\\|\\:\\,]/", "",$x);
}

$query = "SELECT * FROM accounts where"
	. " userid = '" . deapos($_POST["userid"])
	. "' and passwordhash = '" . deapos($_POST["passwordhash"]) . "'";
	
$result = mysql_query($query);

$row = mysql_fetch_array($result, MYSQL_ASSOC);
$mynotes = $row ? $row["mynotes"] : "";

if ($mynotes != "") {

	if ($_POST["mynotes"]) {
		$query = 
			"UPDATE accounts SET mynotes = '" . deapos($_POST["mynotes"]) . "' WHERE ".
	        " userid = '" . deapos($_POST["userid"]) . "' AND ".
	        " passwordhash = '" . deapos($_POST["passwordhash"]) . "'";
		$result = mysql_query($query);		
	}
	else {
		echo '{"ok":1,"mynotes":"' . $mynotes .'"}';
	}
}
elseif ($_POST["signup"] == 'true') {
	$error = 0;
	$query = 
		"INSERT INTO accounts (userid, passwordhash, mynotes) VALUES (".
        "'" . deapos($_POST["userid"]) . "',".
        "'" . deapos($_POST["passwordhash"]) . "',".
        "'-')";
//    echo($query);
//   exit;
	$result = mysql_query($query) or $error = 1;

	if ($error) echo '{"ok":0,"message":"Error, insert query failed..."}';
    else echo '{"ok":1,"mynotes":"-","errorcode":'.$error.'}';
}
else {
	echo '{"ok":0,"message":"User does not exist or password is bad..."}';
}

mysql_close($conn);

?>