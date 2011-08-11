<?php

/**
 * 得到某个标签和其下账户信息
 */
function getAccout($id) {
	$rtn = array();
	$result = mysql_query("SELECT id,name,type,`describe` FROM labels WHERE id='$id';");
	if(!$result)
		return $rtn;
	while(($id_list = mysql_fetch_row($result))) {
		$rtn[] = array('id' => $id_list[0], 
			'name' => $id_list[1], 
			'type' => ($id_list[2] == 0 ? 'person' : 'project'),
			'describe' => (empty($id_list[3]) ? null : $id_list[3]), 
			'accouts' => getLabelAccouts($id_list[0]));
	}
	return $rtn;
}

/**
 * 得到某个标签下的所有账户
 */
function getLabelAccouts($label_id) {
	$rtn = array();
	$r_list = mysql_query("SELECT id,name,password,`describe` FROM accouts WHERE label_id='$label_id';");
	if(!$r_list)
		return $rtn;
	while(($acc_list = mysql_fetch_row($r_list))) {
		$rtn[] = array('id' => $acc_list[0], 'name' => $acc_list[1], 'password' => $acc_list[2], 'describe' => (empty($acc_list[3]) ? null : $acc_list[3]), );
	}
	return $rtn;
}

function getAllAccouts() {
	$rtn = array();
	$query = "SELECT id,name,type,`describe` FROM labels;";
	$result = mysql_query($query);
	if(!$result)
		return $rtn;
	while(($id_list = mysql_fetch_row($result))) {
		$rtn[] = array(
			'id' => $id_list[0], 
			'name' => $id_list[1], 
			'type' => ($id_list[2] == 0 ? 'person' : 'project'), 
			'describe' => (empty($id_list[3]) ? null : $id_list[3]), 
			'accouts' => getLabelAccouts($id_list[0]));
	}
	return $rtn;
}


function insertLabel($name,$type,$describe){
	$query="INSERT INTO labels (name,type,`describe`) VALUES('$name','$type','$describe');";
	$result=mysql_query($query);
	if(!$result || ($rtn= mysql_insert_id())==0)
		return null;
	return $rtn;
}

function updateLabel($id,$name,$type,$describe){
	$query="UPDATE labels SET ";
	if($name)
		$query.="name='$name' ";
	if($type=="person")
		$query.=" type='0' ";
	elseif($type=="project")
		$query.=" type='1' ";
	if($describe)
		$query.=" `describe`='$describe' ";
	$query.=" WHERE id='$id';";
	$result=mysql_query($query);
	if(!$result)
		return false;
	return true;
}

function insertAccout($name,$password,$describe,$label_id){
	$query="INSERT INTO accouts (name,password,`describe`,label_id) VALUES('$name','$password','$describe','$label_id');";
	$result=mysql_query($query);
	if(!$result || ($rtn= mysql_insert_id())==0)
		return null;
	return $rtn;
}

function updateAccout($name,$password,$describe,$id){
	$query="UPDATE accouts SET name='$name',password='$password',`describe`='$describe' WHERE id='$id';";
	$result=mysql_query($query);
	if(!$result)
		return false;
	return true;
}
function deleteAccout($id){
	$query="DELETE FROM accouts WHERE id='$id';";
	$result=mysql_query($query);
	if(!$result || mysql_affected_rows()==0)
		return false;
	else return true;
}

function deleteLabel($id){
	$query="DELETE FROM accouts WHERE label_id='$id'";
	$r1=mysql_query($query);
	$query="DELETE FROM labels WHERE id='$id'";
	$r2=mysql_query($query);
	if(!$r2 || mysql_affected_rows()==0)
		return false;
	else return true;
}
?>