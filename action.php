<?php
	if(empty($_REQUEST['action'])){
		echo "{}";
		exit();
	}
	$act=$_REQUEST['action'];
	
	require "db.php";
	include "function.php";
	
	if($act=='del'){
		if(deleteAccout($_REQUEST['id'])==true)
			$output=array("state"=>"success","data"=>$_REQUEST['id']);
		else
			$output=array("state"=>"failure");
	}elseif($act=="update-lbl"){
		if(updateLabel($_REQUEST['id'],$_REQUEST['name'],$_REQUEST['type'],$_REQUEST['describe'])){
			$output=array("state"=>"success","data"=>array(
				'id'=>$_REQUEST['id'],
				'name'=>$_REQUEST['name'],
				'type'=>$_REQUEST['type'],
				'describe'=>$_REQUEST['describe']
			));
		}else
			$output=array("state"=>"failure");
	}
	elseif($act=='update'){
		if(updateAccout($_REQUEST['name'],$_REQUEST['password'],$_REQUEST['describe'],$_REQUEST['id']))
			$output=array("state"=>"success","data"=>array(
				'id'=>$_REQUEST['id'],
				'name'=>$_REQUEST['name'],
				'password'=>$_REQUEST['password'],
				'describe'=>$_REQUEST['describe']
			));
		else
			$output=array("state"=>"failure");
	}
	elseif($act=='del-lbl'){
		if(deleteLabel($_REQUEST['id'])==true)
			$output=array("state"=>"success","data"=>$_REQUEST['id']);
		else
			$output=array("state"=>"failure");
	}
	elseif($act=='add'){
		$new_id=insertAccout($_REQUEST['name'],$_REQUEST['password'],$_REQUEST['describe'],$_REQUEST['label_id']);
		if($new_id==null){
			$output=array("state"=>"failure");
		}else{
			$output=array("state"=>"success","data"=>array(
				'id'=>$new_id,
				'label_id'=>$_REQUEST['label_id'],
				'name'=>$_REQUEST['name'],
				'password'=>$_REQUEST['password'],
				'describe'=>$_REQUEST['describe']
			));
		}
	}elseif($act=="add-lbl"){
		
		$new_id=insertLabel($_REQUEST['name'],$_REQUEST['type']=='project'?1:0,$_REQUEST['describe']);
		if($new_id==null){
			$output=array("state"=>"failure");
		}else{
			$output=array("state"=>"success","data"=>array(
				'id'=>$new_id,
				'name'=>$_REQUEST['name'],
				'describe'=>$_REQUEST['describe'],
				'type'=>$_REQUEST['type'],
				'accouts'=>array(),
				'selected'=>false,
				'selecteID'=>0
			));
		}
		
	}
	
	
	echo json_encode($output);
	mysql_close($db_connection);
?>