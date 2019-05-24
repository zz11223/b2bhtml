<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';

$domain='cc.cc';
$comurl='cc.cc',
$username='cc';
echo 'flightHandler('.json_encode($domain.$username).')';
 exit();
$table_company='';
$table_company = $DT_PRE.'links_company';
$table_link = $DT_PRE.'links';
$table_uid = $DT_PRE.'links_uid';
$r = $db->get_one("SELECT id AS num FROM {$table_company} WHERE domain='{$domain}'");
if(empty($r['id'])){
	//先添加公司
	$sqlk = '(username,comurl,domain)'; 
	$sqlv="('{$username}','{$comurl}','{$domain}')";  
	$db->query("INSERT INTO {$table_company} $sqlk VALUES $sqlv");
	$company= $db->insert_id(); 
}else{
	$company = $r['id'];
}
$list=array('$company'=>$company);
$list=json_encode($list);
echo 'flightHandler('.$sqlv.')';
 exit();
		//获取links
		$link_nums=20;
		$linkids='';
		$result = $db->query("SELECT linkid FROM {$table_uid} limit $link_nums");
		while($r = $db->fetch_array($result)) { 
			$linkids.= ','.$r['linkid'];
		 }
		if(empty($linkids)){
			//获取所有link
			$sql="select `itemid` from `{$this->table}`";
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
			foreach($rand_keys as $v){
				$sql.=",({$company},{$v})";
			}
			$sql=substr($sql, 1);
			$db->query($sql);
			//添加后再读取
			$linkids=implode(',', $rand_keys);
	 
		}else{ 
			$linkids=substr($linkids,1);
		}
		 //获取ids
		$lists = array(); 
		$result = $db->query("SELECT * FROM {$this->table} LIMIT $link_nums");
			$result = $db->query("SELECT title,linkurl,comurl FROM {$this->table} as link join {$table_company} as com on link.company=com.id WHERE link.itemid in({$linkids}) LIMIT $link_nums");
		while($r = $db->fetch_array($result)) {
			 
			$lists[] = array(
				'title'=>$r['title'],
				'linkurl'=>empty($r['linkurl'])?$r['comurl']:$r['linkurl']
				);
		 }
$list=json_encode($list);
echo 'flightHandler('.$list.')';
 exit();
 