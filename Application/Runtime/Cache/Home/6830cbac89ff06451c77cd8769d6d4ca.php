<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>臻云单点登录控制页面</title>
<link rel="stylesheet" type="text/css" href="/Public/css/css_top.css"/>
<link rel="stylesheet" type="text/css" href="/Public/css/model.css"/>
<script src="/Public/js/jquery-1.8.0.min.js" type="text/javascript" ></script>
<script src="/Public/js/jquery-ui/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript" ></script>
<link rel="stylesheet" type="text/css" href="/Public/js/jquery-ui/jquery-ui-themes-1.11.1/themes/start/jquery-ui.css"/>
<script type="text/javascript" type="text/javascript" src="/Public/js/date.js"></script>
<script language='javascript'>
/**
 * 当前时间详细显示
 */
function time(){
     var mydate  = new Date();
     var week    = new Array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
     var year    = mydate.getFullYear(); 
     var month   = mydate.getMonth()+1;
     var day     = mydate.getDate();
     var hours   = mydate.getHours();
     var minutes = mydate.getMinutes();
     var seconds = mydate.getSeconds();
     var myweek  = week[mydate.getDay()];
     month       = month < 10 ? '0' + month : month;
     day         = day < 10 ? '0' + day : day;
     hours       = hours < 10 ? '0' + hours : hours;
     minutes     = minutes < 10 ? '0' + minutes : minutes;
     seconds     = seconds < 10 ? '0' + seconds : seconds;
     year        = navigator.userAgent.indexOf("Firefox")>0 ? year+1900:year;
     var str     = '';
     str         = year+'年'+month+'月'+day+'日'+'('+showCal()+')'+' '+myweek+' '+hours+":"+minutes+":"+seconds;
     document.getElementById('time').innerHTML = str;
   	 setTimeout("time()",1000);
}
</script>
</head>
<body onload="time()">
<div class="topnav">
	<div class="sitenav">
		<div class="welcome">
 			<span id='time'></span>
		</div>
		<div class="welcome">
			您好：<span class="username"><?php echo ($_USER_["username"]); ?></span>，欢迎使用本系统
		</div>
		<div class="sitelink">
			<a href="javascript::void(0)">设为桌面图标</a> | 
			<a href="javascript::void(0)" >帮助</a> | 
			<a style="padding:2px 12px;" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover" href="/Login/logout">注销登录</a>
			<a style="padding:2px 12px;" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover" href="javascript:void(0)" onclick="changePwd()">修改密码</a>
		</div>
	</div>
	<div class="leftnav">
		<ul>
			<li class="navleft"></li>
			<li id='d0'><a href="<?php echo U('Index/index');?>" target="_self">站点列表</a></li>
			<li id='d1'><a href="<?php echo U('User/index');?>" target="_self">用户列表</a></li>
			<li class="navright"></li>
		</ul>
	</div>
</div>

<!-- 修改密码 -->
<div id="dlg_changePasswd" style="display: none;" title="修改密码">
    <div class="validateTips" id="alertTips" style="display:none;"></div>
    <form name="passwForm" id="passwForm" method="post" action="" target="_blank">
        <div class="bill">
        	<div style="width: 100%;margin-top:10px;" class="bill-item">
                <div style="width: 26%;" class="bill-item-left">新密码：</div>
                <div style="width: 70%;" class="bill-item-right">
                   <input type="password" name="passwd" style="width:180px;"/>
                </div>
            </div>
            <div style="width: 100%;margin-top:10px;" class="bill-item">
                <div style="width: 26%;" class="bill-item-left">确认密码：</div>
                <div style="width: 70%;" class="bill-item-right">
                   <input type="password" name="surePasswd" style="width:180px;"/>
                </div>
            </div>
        </div>    
    </form>
</div>
<!-- 确定 -->
<div id="dialog-confirm" style="display: none;">
	<p style="text-align:center;font-size: 14px;color: red;font-weight: bold;">
	确定要删除吗？
	</p>
</div>
<script language='javascript'>
function changePwd(){
	$('#dlg_changePasswd').dialog({	   
	    autoOpen: true,
		modal: true,
        show:'slide',
        hide:'slide',
        title: '修改用户密码',
		resizable: false,
		height:275,	
		width: 550,
		buttons:{
	    	'关闭': function() {
	    		$('#dlg_changePasswd').dialog('close');
			 },
			'确定': function() {
				$.ajax({
					type: 'post',
					url: '<?php echo U("Login/changePwd");?>',
					data: $('#passwForm').serializeArray(),
					async: true,
					dataType: 'json', //xml, json, script or html
					success: function(data) {
						if (data.status == 1) {
							$('#dlg_changePasswd').dialog('close');
							//修改密码重新登录系统
							location.href = './Login/';
						} else {
							message('alertTips', data.info);
						}
					}
				});
			}
		}	 
	});
}
function message(panel,t) {  
	$("#"+panel).show().append(t).addClass('ui-state-highlight');
	setTimeout(function() {
		$("#"+panel).removeClass('ui-state-highlight').text('').hide();
	}, 3000);
}
/**
 * 弹框提示信息
 */
function dlgMsg(tip){ 
	var style='color:red;font-family:宋体, Verdana, Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;text-align:center;padding:0 15px;line-height:20px;margin:15px 10px;';
	$('<div title="温馨提示"><p style="'+style+'">'+tip+'</p></div>').dialog({
		modal: true,
		show: 'slide',
		hide: 'slide',
		buttons: {
			'确定': function(){ $( this ).dialog( "close" ); }
		}
	});
}
</script>
<div class="toolbar cf" style="margin:18px 70px;">
	<div class="tool_date cf">
		<div class="title cf">
			<div class="more form" id="ver_keys">			
				<form action="<?php echo U('User/index');?>" method="post" class="fl">
					用户名: 
					<input type="text" name="username" value="<?php echo ($param["username"]); ?>" style="width:95px;"/>&nbsp;&nbsp;
					电话: 
					<input type="text" name="mobile" value="<?php echo ($param["mobile"]); ?>" style="width:95px;"/>&nbsp;&nbsp;
                   	邮箱: 
					<input type="text" name="web_site" value="<?php echo ($param["email"]); ?>" style="width:95px;"/>&nbsp;&nbsp;
					<input type="submit"  class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover" value="搜索">
					&nbsp;&nbsp;
					<input type="button"  class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover" value="新建" onclick="ModifySsoUser('')">
				</form>
			</div>
		</div>
	</div>
</div>
<!-- -->
<div style="margin:10px 35px;">
	<div class="column cf datashow">
		<table  width="70%" cellpadding="5" cellspacing="3" class="contab">
			<thead>
				<tr>
					<th>用户ID</th>
					<th>用户名</th>
					<th>电话</th>
					<th>邮箱</th>
					<th>组别</th>
					<th>状态</th>
					<th>创建时间</th>	
					<th>修改时间</th>	
					<th>操作</th>	
				</tr>
			</thead>		
			<tbody class="dataTab">
				<?php if(is_array($user_list)): foreach($user_list as $key=>$vo): ?><tr>
						<td><?php echo ($vo["id"]); ?></td>
						<td><?php echo ($vo["username"]); ?></td>
						<td><?php echo ($vo["mobile"]); ?></td>
						<td><?php echo ($vo["email"]); ?></td>
						<td><?php if($vo["u_grp"] == 1): ?>管理员<?php else: ?>普通用户<?php endif; ?></td>
						<td><?php if($vo["status"] == 1): ?>正常<?php else: ?>禁用<?php endif; ?></td>
						<td><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></td>
						<td><?php echo (date("Y-m-d H:i:s",$vo["update_time"])); ?></td>
						<td>
							<input type="button"  class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover" value="编辑" onclick="ModifySsoUser(<?php echo ($vo["id"]); ?>)">
						</td>
					</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
	</div>
	<div class="page"><?php echo ($pageLink); ?></div>	
</div>
<!-- 编辑站点 -->
<div id="sso_user_dlg" style="display: none;" title="编辑sso用户信息">
    <div class="validateTips" id="ssouTips" style="display:none;"></div>
    <form name="ssouForm" id="ssouForm" method="post" action="" target="_blank">
    	<input type="hidden" name="id" id="id" value="" />
        <div class="bill">
        	<div style="width: 100%;margin-top:10px;" class="bill-item">
                <div style="width: 26%;" class="bill-item-left">用户名：</div>
                <div style="width: 70%;" class="bill-item-right">
                   <input type="text" id="username" name="username" style="width:220px;"/>
                </div>
            </div>
            <div style="width: 100%;margin-top:10px;" class="bill-item">
                <div style="width: 26%;" class="bill-item-left">电话：</div>
                <div style="width: 70%;" class="bill-item-right">
                   <input type="text" id="mobile" name="mobile" style="width:220px;"/>
                </div>
            </div>
            <div style="width: 100%;margin-top:10px;" class="bill-item">
                <div style="width: 26%;" class="bill-item-left">邮箱：</div>
                <div style="width: 70%;" class="bill-item-right">
                   <input type="text" id="email" name="email" style="width:220px;"/>
                </div>
            </div>
            <div style="width: 100%;margin-top:10px;" class="bill-item">
                <div style="width: 26%;" class="bill-item-left">密码：</div>
                <div style="width: 70%;" class="bill-item-right">
                   <input type="password" name="passwd" style="width:220px;"/>
                </div>
            </div>
        	<div style="width: 100%;margin-top:10px;" class="bill-item">
                <div style="width: 26%;" class="bill-item-left">状态：</div>
                <div style="width: 70%;" class="bill-item-right">
                   <select name="u_grp" id="u_grp">
                   		<option value="1">正常</option>
	                	<option value="0">禁用</option>
                	</select>
                </div>
            </div>
            <div style="width: 100%;margin-top:10px;" class="bill-item">
                <div style="width: 26%;" class="bill-item-left">所属组别：</div>
                <div style="width: 70%;" class="bill-item-right">
                   <select name="status" id="status">
                   		<option value="0">普通用户</option>
                   		<option value="1">管理员</option>
                	</select>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
<script language='javascript'>
function ModifySsoUser(id){
	if( !isNaN(id) )  { //修改
		$.ajax({
			type: 'post',
			url: '<?php echo U("User/getOne");?>',
			data: {'id':id},
			async: true,
			dataType: 'json', 
			success: function(data) {
				if (data.status == 1) {
					$.each(data.user_info, function(i, v){
						if(i== 'status' || i=='u_grp') { //编辑框赋值
							$("#"+i).find("option[value="+v+"]").attr("selected", true);
						}else{
							$("#"+i).val(v);
						}
					});
				} 
			}
		});
	}
	$('#sso_user_dlg').dialog({	   
	    autoOpen: true,
		modal: true,
        show:'slide',
        hide:'slide',
        title: '编辑sso用户信息',
		resizable: false,
		height:475,	
		width: 550,
		buttons:{
	    	'关闭': function() {
	    		$('#sso_user_dlg').dialog('close');
			 },
			'确定': function() {
				$.ajax({
					type: 'post',
					url: '<?php echo U("User/createSsoUser");?>',
					data: $('#ssouForm').serializeArray(),
					async: true,
					dataType: 'json', //xml, json, script or html
					success: function(data) {
						if (data.status == 1) {
							$('#sso_user_dlg').dialog('close');
							//修改密码重新登录系统
							location.href = '<?php echo U("User/index");?>';
						} else {
							message('ssouTips', data.info);
						}
					}
				});
			}
		}	 
	});
}
</script>