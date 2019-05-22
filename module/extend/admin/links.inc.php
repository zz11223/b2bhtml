<?php
defined('DT_ADMIN') or exit('Access Denied');
$TYPE = get_type('links', 1);
require DT_ROOT.'/module/'.$module.'/links.class.php';
$do = new dlinks();
 //添加编辑
if(!empty($_POST)){
	 
	if(isset($_POST['actionp'])){
		if($do->pass($_POST)) {
			if(empty($_POST['itemid'])){ 
				$id=$do->add($_POST);
			 	echo  json_encode(['code'=>$id,'msg'=>'添加成功']);
			}else{
				$do->itemid = $_POST['itemid'];
				$do->edit($_POST);
			 	echo  json_encode(['code'=>1,'msg'=>'添加成功']);
			}
			 
		} else {
			echo  json_encode(['code'=>0,'msg'=>'输入错误dd']);
		}
		 exit;
		 
	}
}

$menus = array (
   
    array('推荐链接列表', '?moduleid='.$moduleid.'&file='.$file),
     
);


$this_forward = '?moduleid='.$moduleid.'&file='.$file;
if(in_array($action, array('', 'check'))) {
	$sfields = array('按条件', '网站名称', '网站地址');
	$dfields = array('title','title','linkurl','introduce');
	$sorder  = array('结果排序方式', '更新时间降序', '更新时间升序');
	$dorder  = array('itemid DESC', 'edittime DESC', 'eidttime ASC');
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	 
	$dtype  = array('0', '1', '2');
	$level = isset($level) ? intval($level) : 0;
	$typeid = isset($typeid) ? intval($typeid) : 0;
	$type = isset($type) ? intval($type) : 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
		$fields_select = dselect($sfields, 'fields', '', $fields);
	 
	$order_select  = dselect($sorder, 'order', '', $order);
	 
	$condition = '';
	 
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	 
	 
}
 

 
switch($action) {
	  
	default:
		$menuid = 1;

		$lists = $do->get_list('itemid >0 '.$condition, $dorder[$order]);
		include tpl('links', $module);
	break;
}
?>