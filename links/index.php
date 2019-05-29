<?php
//require 'html.html';

define('DT_REWRITE', true);
$moduleid = 3;
require '../common.inc.php';
$links = array(); 
$links[]=array('title'=>'诚信315','linkurl'=>'http://www.chengxin315.com'); 
if(empty($_GET['domain'])){ 
 	exit(json_encode($links));
}
//接受数据检测 
$domain=trim($_GET['domain']);
//去除www.
$len1=stripos($domain,'www.');
if($len1===0){
	$domain=substr($domain,4);
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
	//获取所有链接 
	$sql="SELECT link.itemid FROM {$table_link} as link join {$table_company} as com on com.is_link2=1 and link.company!={$company} and link.company=com.id";
	$links_all = array();
	$result = $db->query($sql);
	while($r = $db->fetch_array($result)) { 
	    $links_all[$r['itemid']] = $r['itemid'];
	}
 
	if(empty($links_all)){
		exit(json_encode($links)); 
	}
	$links_all_str=implode(',', $links_all);
	//先获取连接次数 
	$sql="select linkid,count(itemid) as num from {$table_uid} group by linkid order by num asc"; 
	
	//保存有次数的链接
	$links_use = array();
	$result = $db->query($sql);
	while($r = $db->fetch_array($result)) { 
	    $links_use[] = $r['linkid'];
	}
	//比较数组获取没有链接过的链接
	$links_nouse=array_diff($links_all, $links_use);
 
	//最后结果
	$links_res=array();
	//先获取未引入链接的公司
	if(!empty($links_nouse)){
		//查询数据库获取，排除相同公司 
		$links_nouse_str=implode(',', $links_nouse);
		$sql="select itemid from {$table_link} where itemid in({$links_nouse_str}) and company!={$company} group by company";
		$result = $db->query($sql);
		while($r = $db->fetch_array($result)) { 
		    $links_res[$r['itemid']] = $r['itemid'];
		}
	}
	 
	//检查数量如果足够就可以，不够还要再添加link_nums
	$len=$link_nums-count($links_res);
	if($len>0 && !empty($links_use)){
		//增加5倍数量，确保不会有重复
		$len_for=$len*5;
		$len_array=count($links_use);
		$len_for=($len_for>$len_array)?$len_array:$len_for;
		$ids='';
		for($i=0;$i<$len_for;$i++){
			$ids.=','.$links_use[$i];
		}
		$ids=substr($ids,1);
		//要获取的条数
		$len=($len_for>$len)?$len:$len_for;
		$sql="select itemid from {$table_link} where itemid in({$ids}) and company!={$company} group by company limit {$len}";
		 
		$result = $db->query($sql);
		while($r = $db->fetch_array($result)) { 
		    $links_res[$r['itemid']] = $r['itemid'];
		}
	} 
	 
	//有链接后添加
	$sql="INSERT INTO `{$table_uid}` (company,linkid) VALUES ";
	$sqlv='';
	foreach($links_res as $v){
		$sqlv.=",({$company},{$v})";
	}
	$sqlv=substr($sqlv, 1); 
	$db->query($sql.$sqlv); 
	$linkids=implode(',', $links_res);
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
 
