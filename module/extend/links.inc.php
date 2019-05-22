<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$MOD['link_enable'] or dheader(DT_PATH);
require DT_ROOT.'/include/post.func.php';
$ext = 'links';
$url = $EXT[$ext.'_url'];
$mob = $EXT[$ext.'_mob'];
$TYPE = get_type($ext, 1);
$_TP = sort_type($TYPE);
require DT_ROOT.'/module/'.$module.'/'.$ext.'.class.php';
$do = new dlinks();
$typeid = isset($typeid) ? intval($typeid) : 0;
if($action == 'reg') {
	$MOD['link_reg'] or message($L['link_reg_close']);
	if($submit) {
	 
		$post = dhtmlspecialchars($post);
		if($do->pass($post)) {
			$r = $db->get_one("SELECT itemid FROM {$DT_PRE}links WHERE linkurl='$post[linkurl]' AND username=''");
			if($r) message($L['link_url_repeat']);
			 
			$do->add($post);
			 
		} else {
			message($do->errmsg);
		}
	} else {
		$type_select = type_select($TYPE, 1, 'post[typeid]', $L['link_choose_type'], 0, 'id="typeid"');
		$head_title = $L['link_reg'].$DT['seo_delimiter'].$L['link_title'];
	}
} else {
	$head_title = 'dfsf';
	 
}
$template = $ext;
if($DT_PC) {
	$destoon_task = rand_task();
	if($EXT['mobile_enable']) $head_mobile = str_replace($url, $mob, $DT_URL);
} else {
	$foot = '';
	if($action == 'reg') {
		$back_links = $mob;
	} else {
		$back_links = ($kw || $page > 1 || $typeid) ? $mob : DT_MOB.'more.php';
	}
}
include template($template, $module);
?>