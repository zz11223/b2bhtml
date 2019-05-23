<?php 
defined('IN_DESTOON') or exit('Access Denied');
$content_table = content_table(4, $userid, is_file(DT_CACHE.'/4.part'), $DT_PRE.'company_data');
$r = $db->get_one("SELECT content FROM {$content_table} WHERE userid=$userid");
$COM['content'] = $r['content'];
$intro_length = isset($HOME['intro_length']) && $HOME['intro_length'] ? intval($HOME['intro_length']) : 400; 
$COM['intro'] = nl2br(dsubstr(trim(strip_tags($r['content'])), $intro_length, '...'));
$COM['thumb'] = $COM['thumb'] ? $COM['thumb'] : DT_SKIN.'image/company.jpg';
if($COMGROUP['main_d']) {
	$_main_show = array();
	foreach($HMAIN as $k=>$v) {
		$_main_show[$k] = strpos(','.$COMGROUP['main_d'].',', ','.$k.',') !== false ? 1 : 0;
	}
	$_main_show = implode(',', $_main_show);
} else {
	$_main_show = '1,1,1,0,0,0,0';
}
$_main_order = '0,10,20,30,40,50,60,70';
$_main_num = '10,1,10,5,3,4,4,10';
$_main_file= implode(',' , $IFILE);
$_main_name = implode(',' , $HMAIN);

$main_show = explode(',', isset($HOME['main_show']) ? $HOME['main_show'] : $_main_show);
$main_order = explode(',', isset($HOME['main_order']) ? $HOME['main_order'] : $_main_order);
$main_num = explode(',', isset($HOME['main_num']) ? $HOME['main_num'] : $_main_num);
$main_file = explode(',', isset($HOME['main_file']) ? $HOME['main_file'] : $_main_file);
$main_name = explode(',', isset($HOME['main_name']) ? $HOME['main_name'] : $_main_name);
$_HMAIN = array();
asort($main_order);
foreach($main_order as $k=>$v) {
	if($main_show[$k] && in_array($main_file[$k], $IFILE)) {
		$_HMAIN[$k] = $HMAIN[$k];
	}
	if($main_num[$k] < 1 || $main_num[$k] > 50) $main_num[$k] = 10;
}
$HMAIN = $_HMAIN;
$seo_title = isset($HOME['seo_title']) && $HOME['seo_title'] ? $HOME['seo_title'] : '';
$head_title = '';
if($DT_PC) {
	//
} else {
	$background = (isset($HOME['background']) && $HOME['background']) ? $HOME['background'] : '';
	$logo = (isset($HOME['logo']) && $HOME['logo']) ? $HOME['logo'] : ($COM['thumb'] ? $COM['thumb'] : 'static/img/home-logo.png');
	$M = array();
	foreach($MENU as $v) {
		if(in_array($v['file'], array('introduce', 'news', 'credit', 'contact'))) continue;
		$M[] = $v;
	}
	$head_name = $L['com_home'];
}
/*添加新闻*/
//先获取主站新闻23488,获取最新焦点资讯
$table_news = $DT_PRE.'article_21'; 
$condition = "catid=23488 AND status=3";
 
//itemid,addtime,title,introduce
$news_one = $db->get_one("SELECT itemid,addtime,title,introduce FROM {$table_news} WHERE $condition ORDER BY addtime DESC LIMIT 1");
$news_one['linkurl'] = userurl($username, 'file=news&itemid='.$news_one['itemid'].'&zztype=article'.$city_url, $domain);
$news_one['introduce']=dsubstr($news_one['introduce'], 100,'...'); 
//获取公司新闻
$table_news = $DT_PRE.'news';
$table_data_news = $DT_PRE.'news_data';
$condition = "username='$username' AND status=3";
$news_list = array();
//id,edittime,title
$result = $db->query("SELECT itemid,addtime,title FROM {$table_news} WHERE $condition ORDER BY level desc,addtime DESC LIMIT 4");
$newids='';
//标记第几个，在第三个后添加主站新闻
$i=0;
while($r = $db->fetch_array($result)) {  
	$newids.=','.$r['itemid'];
	$r['linkurl'] = userurl($username, 'file=news&itemid='.$r['itemid'].$city_url, $domain);
	$i++;
	if($i==4){
		$news_list[$news_one['itemid']] = $news_one; 
	}
	$news_list[$r['itemid']] = $r;
}
if(count($news_list)<4){
	$news_list[$news_one['itemid']] = $news_one; 
}
$db->free_result($result);
if($newids!=''){
	$newids=substr($newids, 1);
	$condition="itemid in ($newids)";
	$result = $db->query("SELECT itemid,content FROM {$table_data_news} WHERE $condition ");
	while($r = $db->fetch_array($result)) {   
		 
		//处理HTML标签和替换空格
		$r['content']=trim(strip_tags($r['content']));
		$qian=array(" ","　","\t","\n","\r","\r\n","&nbsp;");
        $hou=array("","","","","","","");
        $r['content']=str_replace($qian,$hou,$r['content']); 
 
		$news_list[$r['itemid']]['introduce'] =dsubstr($r['content'], 100,'...'); 
		
	}
	$db->free_result($result);
}
 

  
include template('index', $template);
if(isset($update) && $db->cache_ids && ($username == $_username || $_groupid == 1 || $domain)) {
	foreach($db->cache_ids as $v) {
		$dc->rm($v);
	}
	dheader($COM['linkurl']);
}
?>