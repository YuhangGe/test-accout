<?php
	define("DB_HOST",'localhost');
	define("DB_NAME","accout");
	define("DB_USERNAME","root");
	define("DB_PASSWORD","abeajqn");
	$db_connection=mysql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD);
	mysql_query("SET NAMES 'UTF8'"); 
	mysql_select_db(DB_NAME,$db_connection);
?>