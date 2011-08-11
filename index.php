<?php
include "function.php";

$coo_accouts = array();

if(!empty($_COOKIE['test_accouts']) && preg_match('/^\d+(,\d+)*$/', $_COOKIE['test_accouts'])) {
	$coo_accouts = explode(',', $_COOKIE['test_accouts']);
}

require "db.php";


$all_result=getAllAccouts();


$output=array();
foreach($all_result as $r){
	$r['selected']=in_array($r['id'],$coo_accouts);
	$output[]=$r;
}

mysql_close($db_connection);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>测试账户管理</title>
		<!-- rest、grid、box三个css使用的是kissy的设计模式-->
		<link rel="stylesheet" href="assets/reset-min.css" type="text/css" />
		<link rel="stylesheet" href="assets/grid-min.css" type="text/css" />
		<link rel="stylesheet" href="assets/box-min.css" type="text/css" />
		<!--当前页面需要的css-->
		<link rel="stylesheet" href="assets/style.css" type="text/css" />
		<!-- 渲染所有账户信息到js中 ，页面完全在前端使用js控制-->
		<script type="text/javascript">
			var TEST_ACCOUTS=<?php echo json_encode($output);?>;
		</script>
		<!-- Kissy -->
		<script type="text/javascript" src="http://a.tbcdn.cn/s/kissy/1.2.0/kissy.js"></script>
		
		<script type="text/javascript" src="assets/admin.js"></script>
		
	</head>
	<body>
		<div id="header">
			<h1> 测试账户管理页面 </h1>
		</div>
		<div class="col-main">
			<div class="col-left">
				<h2 class="sub-title">个人账户<a class="btn-add" href="javascript:addPersonLabel();">添加</a><i onclick="expandList('list-person',this);"  class="btn-expand"></i></h2>
				<div id="list-person" class="list">
					<ul id="person-accouts">
			<!--			<li id="per-acc-1">
							<a href="javascript:editPerson(1);">YunQian</a><b></b>
			</li> -->

					</ul>
				</div>
				<h2 class="sub-title">项目账户<a class="btn-add" href="javascript:addProjectLabel();">添加</a><i onclick="expandList('list-project',this);" class="btn-expand"></i></h2>
				<div id="list-project" class="list">
					<ul id="project-accouts">
		<!--				<li id="pro-acc-1">
							<a href="#">Demo
							<input onchange="checkProject(1);" class="check" type="checkbox" checked="true"/>
							</a> </li>-->
					
					</ul>
				</div>
			</div>
			<div class="col-right">
				<div id="s-crumbs">
					<span>欢迎</span>
				<!--	<span class="s-tip">项目账户：</span>
					<span>Daisy</span> -->
				</div>
				<div id="welcome-info">
					<p>你可以直接通过左边的操作面板，添加账户标签，为每个标签设置多个账户，以及激活账户。</p>
					<p>当前阶段，激活的账户数据没有与个人账户绑定，全部存储于Cookies中，当清空cookies后需要重新设置。</p>
					<p>当前所有信息由大家公开编辑，请不要随意删改由他人创建的账户信息。</p>
				</div>
				<div id="edit-content">
					<div class="info">
						<p style="font-weight: bold;">
							标签简介：<a  href="javascript:;" onclick="javascript:changeLabelDescribe(this);" state="edit">修改</a>
						</p>
						<p style="text-indent: 2em;position: relative;">
							<span id="label-describe" >这是云谦的个人测试账户组.这是云谦的个人测试账户组.这是云谦的个人测试账户组.这是云谦的个人测试账户组.这是云谦的个人测试账户组.这是云谦的个人测试账户组</span>
							<textarea class="edit row-edit" id="label-describe-edit" ></textarea>
						</p>
					</div>
					<div class="grid grid-zebra">
						<p style="font-size: 13px;font-weight: bold;margin-bottom: 10px;">
							账户列表：
						</p>
						<table id="table-person" class="table">
							<colgroup>
								<col width="15%">
								<col width="15%">
								<col >
								<col width="5%">
								<col width="5%">
							</colgroup>
							<thead>
								<tr class="row">
									<th>账户</th>
									<th>密码</th>
									<th>说明</th>
									<th class="cell-extra" colspan="2">操作</th>
									
								</tr>
							</thead>
							<tbody id="table-body">
		<!--				<tr id="row-1" class="row">
									<td id="col-1">
									<div> Alice
										<input class="edit row-edit" style="display: block;" />
									</div>
									</td>
									<td>Alice</td>
									<td>MyLove</td>
									<td class="cell-extra"><a href="#">编辑</a></td>
									<td class="cell-extra"><a href="#">删除</a></td>
									<td class="cell-extra">
									<input type="radio" class="radio"/>
									</td>
				</tr> -->
								<tr id="row-add" class="row">
									<td>
									<div>Alice
										<input id="edit-add-name" class="edit row-edit" style="display: block;" />
									</div>
									</td>
									<td>
									<div>Daisy
										<input id="edit-add-pwd" class="edit row-edit" style="display: block;" />
									</div>
									</td>
									<td>
									<div>Yini
										<input id="edit-add-desc" class="edit row-edit" style="display: block;" />
									</div>
									</td>
									<td class="cell-extra" colspan="2"><a href="javascript:addAccout();">添加账户</a></td>
								</tr>
							</tbody>
					</table>
					
				</div>
			</div>
			
			<div id="mask"></div>
			
			<div id="add-dialog" class="box">
				<s class="box-tp"><b></b></s>
				<div class="box-hd">
					<h3>添加标签</h3>
					<div class="box-act">
						<a href="javascript:cancelAddLabel();">X</a>
					</div>
				</div>
				<div class="box-bd">
					<p>标签名称：</p><input id="add-lbl-name" class="edit" type="text" />
					<p>标签说明:</p><textarea id="add-lbl-describe" class="edit" rows="2" ></textarea>
					<input type="hidden" id="add-lbl-type" value='person' />
					<div style="margin-top: 5px;height: 20px;">
						<input onclick="cancelAddLabel();" class="btn" type="button" value="取消" /><input onclick="doAddLabel();" class="btn" type="button" value="提交" />
					</div>
				</div>
				<s class="box-bt"><b></b></s>
			</div>
			
			
		</div>
		</div>
		<div class="footer">
			&copy; Copyright 2010~2011, Taobao UED Team.
		</div>
	</body>
</html>