<?php
//require 'html.html';

define('DT_REWRITE', true);
$moduleid = 3;
require '../common.inc.php';
$links = array(); 
$links[]=array('title'=>'诚信315','linkurl'=>'http://www.chengxin315.com');
if(empty($_GET['url']) || empty($_GET['title'])){
 	$links=json_encode($links);
	echo 'flightHandler('.$links.')';
 	exit();
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
	//先添加公司
	$sqlk = '(username,comurl,domain)'; 
	$sqlv="('{$username}','{$comurl}','{$domain}')";  
	$db->query("INSERT INTO {$table_company} $sqlk VALUES $sqlv");
	$company= $db->insert_id();  
}else{
	$company = $r['id'];
}

//获取links
$link_nums=20;
$linkids='';
$result = $db->query("SELECT linkid FROM {$table_uid} where company={$company} limit $link_nums");
while($r = $db->fetch_array($result)) { 
	$linkids.= ','.$r['linkid'];
 }
if(empty($linkids)){
	//获取所有link
	$sql="select `itemid` from {$table_link}";
	$links_all = array();
	$result = $db->query($sql);
	while($r = $db->fetch_array($result)) { 
	    $links_all[$r['itemid']] = $r['itemid'];
	}
	//随机取20$link_nums个
	if(count($links_all) < $link_nums){
		$rand_keys = $links_all;
	}else{
		$rand_keys = array_rand($links_all,$link_nums);
	}
	 
	//有链接后添加对应绑定
	$sql="INSERT INTO `{$table_uid}` (company,linkid) VALUES ";
	$sqlv='';
	foreach($rand_keys as $v){
		$sqlv.=",({$company},{$v})";
	}
	$sqlv=substr($sqlv, 1);
	$db->query($sql.$sqlv);
	//添加后再读取
	$linkids=implode(',', $rand_keys);

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
$links=json_encode($links);
echo 'flightHandler('.$links.')';
 exit();
 
