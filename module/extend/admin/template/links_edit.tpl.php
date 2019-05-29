<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<table cellspacing="0" class="tb">
 
<td class="tl"><span class="f_red">*</span>所属公司</td>
<td><input name="post[username]" type="text" id="username" size="40" value=""/> <span id="dtitle" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 网站地址</td>
<td><input name="post[linkurl]" type="text" id="linkurl" size="40" placeholder="http://" /> 
	<span id="dlinkurl" class="f_red">请填入带http的完整网址</span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 添加反链个数</td>
<td><input name="post[num]" type="number" id="num" size="40" value="0"/> 
	<span id="num" class="f_red">0为不添加，填入正整数会为它插入反链</span></td>
</tr>
 

</table>
<div class="sbt"><input type="submit" name="submit" value="添加" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="取 消" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>');"/></div>
</form>
<?php load('clear.js'); ?>
<script type="text/javascript">
function check() {
	var l;
	var f;
	 
	f = 'username';
	l = Dd(f).value.length;
	if(l < 2) {
		Dmsg('请输入公司名称', f);
		return false;
	}
	f = 'linkurl';
	l = Dd(f).value.length;
	if(l < 12) {
		Dmsg('请输入网站地址', f);
		return false;
	}
}
</script>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>