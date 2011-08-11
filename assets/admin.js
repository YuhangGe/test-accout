var $ = KISSY.all;

//当前编辑的账户
var curAccout=null;
//当前单选的id，这个用来实现可以取消选择任意个人账户
var curRadioId=null;

$.log=function(msg){
	if(console)	
		console.log(msg);
}

function setCookie(name, value, expire, domain, path) {
	value += (domain) ? '; domain=' + domain : '';
	value += (path) ? "; path=" + path : '';
	if(expire) {
		var date = new Date();
		date.setTime(date.getTime() + (expire * 86400000));
		value += "; expires=" + date.toGMTString();
	}
	document.cookie = name + "=" + value;
};

function getCookie(name) {
	var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
	if(arr != null)
		return unescape(arr[2]);
	return null;
}

function getAccoutById(id){
	for(var i=0;i<TEST_ACCOUTS.length;i++){
		if(TEST_ACCOUTS[i].id==id)
			return TEST_ACCOUTS[i];
	}
	return null;
}

KISSY.ready(function() {
	initEvent();
	renderList();
});

function initEvent(){
	$('.edit').on('focus', function() {
		$(this).css({
			'border-color' : '#ff6600'
		});
		this.select();
	});
	$('.edit').on('blur', function() {
		$(this).css({
			'border-color' : 'green'
		})
	})
	$('tr').on('mouseenter mouseleave', function() {
		$(this).toggleClass('row-hover');
	})
	$('#header h1').on('click',function(){
		$('#s-crumbs').html('<span>欢迎</span>');
			$('#edit-content').hide();
			$('#welcome-info').show();
	})	;
}
function expandList(list_id,ele){
	$('#'+list_id).toggle();
	$(ele).toggleClass('btn-expand-2');
}
function renderList(){
	for(var i=0;i<TEST_ACCOUTS.length;i++){
		var acc=TEST_ACCOUTS[i];
		if(acc.type=='person'){
			addPersonList(acc.id,acc.name,acc.describe,acc.selected);
		}else{
			addProjectList(acc.id,acc.name,acc.describe,acc.selected);
		}
	}
}
function addPersonList(id,name,describe,selected){
	$('<li id="per-acc-'+id+'">')
		.html('<a title="'+(describe==null?'':describe)+'" href="javascript:editLabel('+id+',\'个人账户\');">'+name+'<input id="radio-'+id+'" class="radio" type="radio" onclick="checkPerson('+id+');" '+(selected==true?'checked':'')+'/></a>')
		.appendTo($('#person-accouts'));
	if(selected==true)
		curRadioId=id;
}
function addProjectList(id,name,describe,selected){
	$('<li id="pro-acc-'+id+'">')
		.html('<a  title="'+(describe==null?'':describe)+'" href="javascript:editLabel('+id+',\'项目账户\');">'+name+'<input class="check" type="checkbox" onchange="checkProject('+id+',event);" '+(selected==true?'checked':'')+'/></a>')
		.appendTo($('#project-accouts'));
}

function editLabel(id,type){
	curAccout=getAccoutById(id);
	if(curAccout===null){
		console.error("not found label:"+id);
		return;
	}
	
	$('#s-crumbs').html('').append($('<span class="s-tip"></span>').html(type))
		.append($('<span>').html(curAccout.name))
		.append($('<span id="hidden-del"></span>').html("删除").on("dblclick",delLabel));
	
	
	$('#label-describe').html(curAccout.describe==null?'&nbsp':curAccout.describe);
	$('#label-describe-edit').hide();
	$('#edit-add-name').val('');
	$('#edit-add-pwd').val('');
	$('#edit-add-desc').val('');
	
	
	var row_per=$('#row-add');
	$('#table-body').html('').append(row_per);
	for(var i=0;i<curAccout.accouts.length;i++){
		var acc=curAccout.accouts[i];
		insertAccout(acc,row_per);
	}

	$('#edit-content').show();
	$('#welcome-info').hide();
}


function checkPerson(id){
	if(curRadioId==id){
		for(var i=0;i<TEST_ACCOUTS.length;i++){
			if(TEST_ACCOUTS[i].type=="person"){
				TEST_ACCOUTS[i].selected=false;
			}	
		}
		$('#radio-'+id).attr('checked',false);
		curRadioId=null;
	}else{
		for(var i=0;i<TEST_ACCOUTS.length;i++){
			if(TEST_ACCOUTS[i].type=="person"){
				TEST_ACCOUTS[i].selected=(TEST_ACCOUTS[i].id==id);
				$('#radio-'+TEST_ACCOUTS[i].id).attr('checked',TEST_ACCOUTS[i].id==id);
			}	
		}
		curRadioId=id;
	}
	refreshCookie();
}

function insertAccout(acc,before){
	
	$('<tr id="row-'+acc.id+'" class="row">')
		.append($('<td>').html('<div><span id="row-name-'+acc.id+'">'+acc.name+'</span><input id="edit-name-'+acc.id+'" class="edit row-edit" value="'+acc.name+'"/></div>'))
		.append($('<td>').html('<div><span id="row-pwd-'+acc.id+'">'+acc.password+'</span><input id="edit-pwd-'+acc.id+'" class="edit row-edit" value="'+acc.password+'"/></div>'))
		.append($('<td>').html('<div><span id="row-desc-'+acc.id+'">'+(acc.describe==null?'&nbsp':acc.describe)+'</span><textarea id="edit-desc-'+acc.id+'" class="edit row-edit" >'+(acc.describe==null?'':acc.describe)+'</textarea></div>'))
		.append($('<td class="cell-extra">')
			.html('<a id="edit-'+acc.id+'" href="javascript:editRow('+acc.id+');">编辑</a>'))
		.append($('<td class="cell-extra">')
			.html('<a id="del-'+acc.id+'" href="javascript:delRow('+acc.id+');">删除</a>'))
		.insertBefore(before)
		.on('mouseover', function() {
			$(this).addClass('row-hover');
		}).on('mouseleave',function(){
			$(this).removeClass('row-hover');
		});

		$('#row-'+acc.id+" .edit").on('focus', function() {
			$(this).css({
				'border-color' : '#ff6600'
			});
			this.select();
		}).on('blur', function() {
			$(this).css({
					'border-color' : 'green'
			});
		});
}
function addAccout(){
	var name=KISSY.trim($('#edit-add-name').val());
	var pwd=KISSY.trim($('#edit-add-pwd').val());
	var describe=$('#edit-add-desc').val();
	if(name=='' || pwd==''){
		alert("不能为空.");
		return;
	}
	KISSY.io.post("action.php",{'action':'add',"label_id":curAccout.id,'name':name,'password':pwd,'describe':describe},function(rtn){
    		if(rtn.state=="success"){
    			console.log("添加成功");
    			console.log(rtn.data);
    			insertAccout(rtn.data,$('#row-add'));
    			curAccout.accouts.push(rtn.data);
    			if(curAccout.selected==false)
    				$('#radio-'+rtn.data.id).attr('disabled',true);
    			$('#edit-add-name').val('');
				$('#edit-add-pwd').val('');
				$('#edit-add-desc').val('');
    		}else{
    			alert("添加失败，请重试");
    		}
    		
		},"json");
}

function editRow(id){
	if($('#edit-name-'+id).css('display')!='none'){
		var name=KISSY.trim($('#edit-name-'+id).val());
		var password=KISSY.trim($('#edit-pwd-'+id).val());
		var describe=$('#edit-desc-'+id).val();
		if(name==''||password==""){
			alert("不能为空");
			return;
		}
		KISSY.io.post("action.php",{'action':'update',"id":id,'name':name,'password':password,'describe':describe},function(rtn){
    		if(rtn.state=="success"){
    			console.log("修改成功");
    			var d=rtn.data;
    			for(var i=0;i<curAccout.accouts.length;i++){
    				if(curAccout.accouts[i].id==d.id){
    					curAccout.accouts[i]=d;
    					break;
    				}
    			}
    			$('#edit-name-'+d.id).val(d.name).hide();
				$('#edit-pwd-'+d.id).val(d.password).hide();
				$('#edit-desc-'+d.id).val(d.describe).hide();
				$('#row-name-'+d.id).html(d.name);
				$('#row-pwd-'+d.id).html(d.password);
				$('#row-desc-'+d.id).html(d.describe);
				$('#edit-'+id).html("编辑");
				$('#del-'+id).html("删除");
    		}else{
    			alert("添加失败，请重试");
    		}
    		
		},"json");
		
	}else{
		$('#edit-name-'+id).show();
		$('#edit-pwd-'+id).show();
		$('#edit-desc-'+id).show();
		$('#edit-'+id).html("保存");
		$('#del-'+id).html("取消");
	}
}
function delRow(id){
	$.log($('#edit-name-'+id).css('display'));
	if($('#edit-name-'+id).css('display')!='none'){
		$('#edit-name-'+id).hide();
		$('#edit-pwd-'+id).hide();
		$('#edit-desc-'+id).hide();
		$('#edit-'+id).html("编辑");
		$('#del-'+id).html("删除");
	}else{
		if(confirm("确定删除?")==false)
			return;
		KISSY.io.post("action.php",{'action':'del',"id":id},function(rtn){
    		if(rtn.state=="success"){
    			console.log("删除成功");
    			$('#row-'+rtn.data).remove();
    			for(var i=0;i<curAccout.accouts.length;i++){
    				if(curAccout.accouts[i].id==rtn.data){
    					curAccout.accouts.splice(i,1);
    					break;
    				}
    			}
    			disableRadios(true);
    			$('#check-person').attr("checked",false);
    			curAccout.selected=false;
    			refreshCookie();
    		}
		},"json");
	}
}

function checkProject(id){
	var acc=getAccoutById(id);
	if(acc==null){
		alert("error");
		return;
	}
	acc.selected=!acc.selected;
	refreshCookie();
}
function delLabel(){
	
	if(! confirm("确定要删除"+(curAccout.type=="person"?"个人账户":"项目账户")+curAccout.name+" 的所有账户?"))
		return;
	KISSY.io.post("action.php",{'action':'del-lbl',"id":curAccout.id},function(rtn){
    		if(rtn.state=="success"){
    			console.log("删除成功");
    			if(curAccout.type=='person')
    				$("#per-acc-"+curAccout.id).remove();
    			else
    				$("#pro-acc-"+curAccout.id).remove();
    			$('#s-crumbs').html('<span>欢迎</span>');
    			$("#edit-content").hide();
    			$("#welcome-info").show();
    			for(var i=0;i<TEST_ACCOUTS.length;i++){
    				if(TEST_ACCOUTS[i].id==curAccout.id){
    					TEST_ACCOUTS.splice(i,1);
    					curAccout=null;
    				}
    			}
    		}else{
    			alert("删除失败");
    		}
		},"json");
}
function changeLabelDescribe(elem){
	var edit=$('#label-describe-edit');
	if(edit.css('display')!='none'){
		KISSY.io.post("action.php",{'action':'update-lbl',"describe":edit.val(),"id":curAccout.id},function(rtn){
    		if(rtn.state=="success"){
    			console.log("修改成功");
    			$('#label-describe').html(rtn.data.describe);
				curAccout.describe=rtn.data.describe;
				edit.hide();
				$(elem).html('修改');
    		}else{
    			alert("修改失败");
    		}
		},"json");
		
	}else{
		$(elem).html('保存');
		edit.show().val(curAccout.describe).getDOMNode().select();
	}
	
}

function refreshCookie(){
	var c_arr=[];
	for(var i=0;i<TEST_ACCOUTS.length;i++){
		if(TEST_ACCOUTS[i].selected==true)
			c_arr.push(TEST_ACCOUTS[i].id);
	}
	setCookie("test_accouts",c_arr.join(","),10,".taobao.net");
}




function addPersonLabel(){
	$('#mask').css({'width': (document.body.clientWidth)+"px",'height':document.body.scrollHeight+"px",'display':'block'});
	$("#add-lbl-type").val('person');
	$('#add-lbl-describe').val('');
	$('#add-lbl-name').val('');
	$('#add-dialog h3').html("添加个人账户标签");
	$('#add-dialog').show();
}
function addProjectLabel(){
	$('#mask').css({'width': (document.body.clientWidth)+"px",'height':document.body.scrollHeight+"px",'display':'block'});
	$("#add-lbl-type").val('project');
	$('#add-lbl-describe').val('');
	$('#add-lbl-name').val('');
	$('#add-dialog h3').html("添加项目账户标签");
	$('#add-dialog').show();
}
function cancelAddLabel(){
	$('#mask').css('display','none');
	$('#add-dialog').hide();
}

function doAddLabel(){
	var name=KISSY.trim($('#add-lbl-name').val());
	if(name==''){
		alert("不能为空");
		return;
	}
	var describe=$('#add-lbl-describe').val();
	var type=$('#add-lbl-type').val();
	KISSY.io.post("action.php",{'action':'add-lbl',"name":name,"describe":describe,"type":type},function(rtn){
    		if(rtn.state=="success"){
    			console.log("添加成功");
    			var d=rtn.data;
    			$.log(d);
    			if(d.type=='person'){
    				addPersonList(d.id,d.name,d.describe,false);
    				
    			}else{
    				addProjectList(d.id,d.name,d.describe,false);
    			}
    			TEST_ACCOUTS.push(d);
    			cancelAddLabel();
    		}
	},"json");
}
