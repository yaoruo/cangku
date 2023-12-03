

var sever_ip ="43.138.132.154";  //换服务器这里要改成服务器的ip


function writetop_cmds() {  //这里改旁边按键指令
	
	var msg = '<table style="float:right"  width="100%" border="0" cellspacing="0" cellpadding="1">'
	msg += '<tr align="center" valign="middle"><button class="buttom_bt2" id="time" onclick="javascript:cmdsa(this)" style="background:url(./css/images/pet.png);background-size:100% 100%;"></button></tr>';
	msg += '<tr align="center" valign="middle"><button class="buttom_bt2" id="set sign5" onclick="javascript:cmdsa(this)" style="background:url(./css/images/title.png);background-size:100% 100%;"></button></tr>';
	msg += '<tr align="center" valign="middle"><button class="buttom_bt2" id="time" onclick="javascript:cmdsa(this)" style="background:url(./css/images/huodong.png);background-size:100% 100%;"></button></tr>';
	msg += '<tr align="center" valign="middle"><button class="buttom_bt2"  onclick="javascript:config()" style="background:url(./css/images/setbt.png);background-size:100% 100%;"></button></tr>';
	msg += '<tr align="center" valign="middle"><button class="buttom_bt2"  onclick="javascript:close_r()" style="background:url(./css/images/more.png);background-size:100% 100%;"></button></tr>';
	msg += '</table>';
	$('#leftcmds').html(msg);	
	
}



function writehere_cmds() { //这里改上面按键指令
	
	
	var msg = '<table style="float:right"  width="55%" border="0" cellspacing="0" cellpadding="1"><tr>';
	msg += '<td align="center" valign="middle"><button class="buttom_bt2"  id="time" onclick="javascript:cmdsa(this)" style="background:url(./css/images/sign5.png);background-size:100% 100%;"></button></td>';
	msg += '<td align="center" valign="middle"><button class="buttom_bt2"  id="set sign5" onclick="javascript:cmdsa(this)" style="background:url(./css/images/hongbao.png);background-size:100% 100%;"></button></td>';
	msg += '<td align="center" valign="middle"><button class="buttom_bt2"  id="dig" onclick="javascript:cmdsa(this)" style="background:url(./css/images/banghui.png);background-size:100% 100%;"></button></td>';
	msg += '<td align="center" valign="middle"><button class="buttom_bt2"  id="set env" onclick="javascript:cmdsa(this)" style="background:url(./css/images/time.png);background-size:100% 100%;"></button></td>';
	msg += '<td align="center" valign="middle"><button class="buttom_bt2"  id="help anews" onclick="javascript:more_here()" style="background:url(./css/images/more.png);background-size:100% 100%;"></button></td>';
	msg += '</tr></table>'		
	
	hereob.html(msg);
	
	
	
	
}



function config()
{
	var long_value, chat_value;
	hudongob.html('');
	hudongob.dialog({
		title:"系统设置",
		modal:true,
		width:scrw*11/12,
		position:["center",200],
		buttons: {
		}
	});
	hudongob.append('<input type="button" style="margin:3px;width:30%;height:35px;font-size:12px" fonts="12px"  value="字体小" onclick="sys_fontsize(this)" />');
	hudongob.append('<input type="button" style="margin:3px;width:30%;height:35px;font-size:13px" fonts="13px"  value="字体中" onclick="sys_fontsize(this)" />');
	hudongob.append('<input type="button" style="margin:3px;width:30%;height:35px;font-size:14px" fonts="14px"  value="字体大" onclick="sys_fontsize(this)" />');
	hudongob.append('<input type="button" style="margin:3px;width:30%;height:35px;color:rgba(37,187,47,0.9)" fonts="rgba(37,187,47,0.9)"  value="绿色" onclick="sys_fontclor(this)" />');
	hudongob.append('<input type="button" style="margin:3px;width:30%;height:35px;color:rgba(195,81,175,0.9)" fonts="rgba(256,256,256,0.9)"  value="白色" onclick="sys_fontclor(this)" />');
	hudongob.append('<input type="button" style="margin:3px;width:30%;height:35px;color:rgba(0,0,0,0.9)" fonts="rgba(0,0,0,0.9)"  value="黑色" onclick="sys_fontclor(this)" />');
	hudongob.append('<input type="button" style="margin:3px;width:30%;height:35px;font-size:13px" sound="0"  value="声音开" onclick="sys_sound(this)" />');
	hudongob.append('<input type="button" style="margin:3px;width:30%;height:35px;font-size:14px" sound="1"  value="声音关" onclick="sys_sound(this)" />');
	hudongob.css('max-height',scrh1/2);
	if(hudongob.height()>(scrh1-400-longob.height()-hpsob.height()-tbarob.height()))
	{
		hudongob.height(scrh1-400-longob.height()-hpsob.height()-tbarob.height());
	}
};