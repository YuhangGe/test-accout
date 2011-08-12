<?php
require "function.php";

$call_back = null;
if(!empty($_REQUEST['callback']))
	$callback = $_REQUEST['callback'];

$output = array();
if(!empty($_COOKIE['test_accouts']) && preg_match('/^\d+(,\d+)*$/', $_COOKIE['test_accouts'])) {
	$coo_accouts = explode(',', $_COOKIE['test_accouts']);
	require "db.php";
	foreach($coo_accouts as $id) {
		$accout = getAccout($id);
		foreach($accout as $ea)
			$output[] = $ea;
	}
}

if($callback == null)
	echo 'var TEST_ACCOUTS=' . json_encode($output) . ";";
else
	echo $callback . '(' . json_encode($output) . ');';

mysql_close($db_connection);
?>