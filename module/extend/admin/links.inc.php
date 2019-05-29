<?php
defined('DT_ADMIN') or exit('Access Denied');
//$TYPE = get_type('links', 1);

require DT_ROOT.'/module/'.$module.'/links.class.php';
 
$do = new dlinks();
 error_reporting(E_ALL);

 //添加编辑
if(!empty($_POST) && isset($_POST['actionp'])){
	$actionp=trim($_POST['actionp']);
	switch($actionp){
		case 'add':
			if($do->pass($_POST)) {
				if(empty($_POST['itemid'])){ 
					$id=$do->add($_POST);
				 	echo  json_encode(array('code'=>$id,'msg'=>'添加成功'));
				}else{
					$do->itemid = $_POST['itemid'];
					$do->edit($_POST);
				 	echo  json_encode(array('code'=>1,'msg'=>'添加成功'));
				}
				 
			} else {
				echo  json_encode(array('code'=>0,'msg'=>'输入错误dd'));
			}
			break;
		case 'get_companys':
			$list=$do->get_companys();
			echo  json_encode($list); 
			break;
		case 'get_links1':
			$list=$do->get_links1(intval($_POST['id']));
			echo  json_encode($list); 
			break;
		case 'get_links2':
			$list=$do->get_links2(intval($_POST['id']));
			echo  json_encode($list); 
			break;
	}
	exit;
	 
}

$menus = array (
    array('添加公司', '?moduleid='.$moduleid.'&file='.$file.'&action=add'),
    array('推荐链接列表', '?moduleid='.$moduleid.'&file='.$file),
    
   
);

$this_forward = '?moduleid='.$moduleid.'&file='.$file;
if(in_array($action, array('', 'check'))) {
	$sfields = array('网站名称', '网站地址', '关键词', '关键词地址');
	$dfields = array('com.username','com.comurl','link.title','link.linkurl');
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
	 case 'add':
		if($submit) {
			$post['title']=$post['username'];
			if(!($do->pass($post))) {
				msg($do->errmsg);
			}

 			$company=$do->add_company($post);
 			$post['num']=intval($post['num']);
 			if($post['num']>0){
 				$do->uid_add2($company,$post['num']); 
 			}
 			
			dmsg('添加成功', '?moduleid='.$moduleid.'&file='.$file.'&action='.$action.'&typeid='.$post['typeid']);
			 
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			$linkurl = 'http://';
			$status = 3;
			$addtime = timetodate($DT_TIME);
			$typeid = 0;
			$menuid = 0;
			include tpl('links_edit', $module);
		}
	break; 
	 
	default:
		if(isset($_GET['filedo'])){
			 switch($_GET['filedo']){
			 	case 'company_save':
			 		 $do->edit_company($_GET);
			 		 break;
			 	case 'company_uid':
			 		 $do->uid_add1($_GET['id'],2);
			 		 break;	
			 	
			 }
			
		}

		$menuid = 1;

		$lists = $do->get_list('itemid >0 '.$condition, $dorder[$order]);

		include tpl('links', $module);
	break;
}
?>