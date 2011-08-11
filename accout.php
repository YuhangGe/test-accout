<?php
require "function.php";

if(empty($_COOKIE['test_accouts'])){
	echo 'var TEST_ACCOUTS=[];';
	exit();
}
if(!preg_match('/^\d+(,\d+)*$/',$_COOKIE['test_accouts'])){
	echo 'var TEST_ACCOUTS=[];';
	exit();
}

$call_back=null;
if(!empty($_REQUEST['callback']))
	$callback=$_REQUEST['callback'];


$coo_accouts=explode(',', $_COOKIE['test_accouts']);



require "db.php";

$output=array();

foreach($coo_accouts as $id){
	$accout=getAccout($id);
	foreach($accout as $ea)
		$output[]=$ea;
}

if($callback==null)
	echo 'var TEST_ACCOUTS='.json_encode($output).";";
else
	echo $callback.'('.json_encode($output).');';

mysql_close($db_connection);
?>