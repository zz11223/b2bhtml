<?php
//require 'html.html';

define('DT_REWRITE', true);
$moduleid = 3;
require '../common.inc.php';
$links = array(); 
$links[]=array('title'=>'诚信315','linkurl'=>'http://www.chengxin315.com');
//return $links; 
if(empty($_GET['url']) || empty($_GET['title'])){
 	 
 	exit(json_encode($links));
}
//接受数据检测
$comurl=$_GET['url'];
$username=trim($_GET['title']);
$domain=$_GET['url'];
$len1=strpos($domain,'//'); 
if($len1>0){
    $domain=substr($domain,$len1+2);
} 
$len2=strrpos($domain,'/');
if($len2>0){
    $domain=substr($domain,0,$len2);
} 
$table_company='';
$table_company = $DT_PRE.'links_company';
$table_link = $DT_PRE.'links';
$table_uid = $DT_PRE.'links_uid';
$r = $db->get_one("SELECT id FROM {$table_company} WHERE domain='{$domain}' limit 1");
if(empty($r['id'])){
	exit(json_encode($links)); 
}else{
	$company = $r['id'];
}

//获取links
$link_nums=10;
$linkids='';
$result = $db->query("SELECT linkid FROM {$table_uid} where company={$company} limit $link_nums");
while($r = $db->fetch_array($result)) { 
	$linkids.= ','.$r['linkid'];
 }
if(empty($linkids)){
	exit(json_encode($links));  
}else{ 
	$linkids=substr($linkids,1);
}
 //获取links 
$result = $db->query("SELECT link.title,link.linkurl,com.comurl FROM {$table_link} as link join {$table_company} as com on link.company=com.id WHERE link.itemid in({$linkids}) LIMIT $link_nums");
while($r = $db->fetch_array($result)) {
	 
	$links[] = array(
		'title'=>$r['title'],
		'linkurl'=>empty($r['linkurl'])?$r['comurl']:$r['linkurl']
		);
 }
exit(json_encode($links)); 
 
