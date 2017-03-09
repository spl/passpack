<?php
include 'config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!--
		(c) 2008 Francesco Sullo, Passpack Srl (www.passpack.com)
		This sample is distributed under a MIT license
		-->
		<script type="text/javascript" src="lib/passpack.js"></script>
		<script type="text/javascript" src="lib/jquery.js"></script>
		<script type="text/javascript" src="lib/history.js"></script>
		<script type="text/javascript" src="lib/q.js"></script>
		<script type="text/javascript">
dbIsOk = true;
/*<?php

$dbIsOk = 1;
$conn = mysql_connect($dbhost, $dbuser, $dbpass) || $dbIsOk = 0;
if (!$dbIsOk or !mysql_select_db($dbname)) echo("*/dbIsOk = false;/*");
//mysql_close($conn);

?>*/		
		</script>
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
		<link id="cssbase" rel="stylesheet" type="text/css" href="css/yellow.css"/>
		<title>HPH Notes (a Host-Proof Hosting Sample Application using Passpack library)
		</title>
	</head>
	<body>
		<a id="sullof" target="_blank" href="http://sullof.com"><img src="pic/sullof.png" style="float:right;border:0" /></a>
		<div id="container">
			<div id="header"><b>HPH Notes</b> - a Host-Proof Hosting Sample Application using <a target="_blank" href="http://code.google.com/p/passpack/">Passpack HPH</a></div>
			<div id="intro">Host-Proof Hosting (HPH) let's you store information on someone else's server, and that someone else can't read what you've stored! This is a sample application using HPH. Login to write yourself a secret note. You can see it whenever you'd like, but no one else can. Neat huh?</div>
			<div id="wrapper"></div>
			<div id="footer" class="mini"><a id="minilogo" target="_blank" href="http://www.passpack.com"></a>
			(c) 2008 <a target="_blank" href="http://sullof.com">Francesco Sullo</a> 
			-  Distributed under <a target="_blank" href="http://www.opensource.org/licenses/mit-license.php">MIT license</a>
			- Source code available at <a target="_blank" href="http://code.google.com/p/passpack/">Google Code.</a> 
			- Change CSS style to <a href="#" id="changestyle">xxx</a>
			</div>
		</div>
		<script type="text/javascript" src="main.js"></script>
	</body>
</html>