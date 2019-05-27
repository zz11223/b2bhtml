<?php 
defined('IN_DESTOON') or exit('Access Denied');
class dlinks {
	var $itemid;
	var $table;
	var $table_company;
	var $table_uid;
	var $links_num;
	var $fields;
	var $errmsg = errmsg;

    function __construct() {
    	$this->links_num = 10;
		$this->table = DT_PRE.'links';
		$this->table_company = DT_PRE.'links_company';
		$this->table_uid = DT_PRE.'links_uid';
		$this->fields = array('company','title','addtime','edittime','linkurl');
    }

    function dlinks() {
		$this->__construct();
    }

	function pass($post) {
		global $L;
		if(!is_array($post)) return false; 
		if(!$post['title']) return $this->_($L['links_pass_site']);

		if(!empty($post['linkurl']) && !is_url($post['linkurl'])) return $this->_($L['links_pass_url']);
		return true;
	}

	function set($post) {
		global $MOD, $_username, $_userid;
		if(!$this->itemid) $post['addtime'] = DT_TIME; 
		$post['edittime'] = DT_TIME;  
	    if(isset($post['itemid']) && $post['itemid']==0){
	    	unset($post['itemid']);
	    }
		$post = dhtmlspecialchars($post);
		return array_map("trim", $post);
	}

	function get_one() {
        return DB::get_one("SELECT * FROM {$this->table} WHERE itemid='$this->itemid'");
	}
	function get_companys() {
		$lists = array();
		$result = DB::query("SELECT * FROM {$this->table_company} ORDER BY id desc");
		while($r = DB::fetch_array($result)) {
			 
			$lists[] = array(
				'comurl'=>$r['comurl'],
				'username'=>$r['username'],
				'id'=>$r['id'], 
				);
		}
		return $lists;
	}
	function edit_company($data) {
		$table_company = $this->table_company;
		if(empty($data['id'])){
			return 0;
		}
		$id=intval($data['id']); 
		$username=trim($data['username']);
		$comurl=trim($data['comurl']);
		$domain=$comurl;
		$len1=strpos($domain,'//'); 
		if($len1>0){
			$domain=substr($domain,$len1+2);
		} 
		$len2=strrpos($domain,'/');
		if($len2>0){
			$domain=substr($domain,0,$len2);
		} 
		 $sql="update `{$table_company}` set `username`='{$username}',`comurl`='{$comurl}',`domain`='{$domain}' where `id`={$id}";
		 
		$result = DB::query($sql); 
		return 1;
	}
	function get_list($condition = '1', $order = 'itemid DESC') {
		global $MOD, $TYPE, $pages, $page, $pagesize, $offset, $sum;
		 
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = DB::get_one("SELECT COUNT(itemid) AS num FROM {$this->table} as link join {$this->table_company} as com on link.company=com.id WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		if($items < 1) return array();
		$lists = array();
		/*$result = DB::query("SELECT * FROM {$this->table} as link join {$this->table_company} as com on link.company=com.id WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");*/
		$result = DB::query("SELECT * FROM {$this->table} as link join {$this->table_company} as com on link.company=com.id WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = DB::fetch_array($result)) {
			$r['title'] = $r['title'];
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			 
			$lists[] = $r;
		}
		return $lists;
	}
 	function get_links1($company) {
		 
		$lists = array();
		//先获取关联id
		$result = DB::query("SELECT linkid FROM {$this->table_uid} WHERE company={$company}");
		$ids='';
		while($r = DB::fetch_array($result)) {
			$ids.=','.$r['linkid'];
		}
		if($ids==''){
			return array();
		}
		$ids=substr($ids,1);
		 //获取链接详情
		$result = DB::query("SELECT link.title,link.linkurl,com.username,com.comurl FROM {$this->table} as link join {$this->table_company} as com on link.company=com.id WHERE link.itemid in($ids)");
		 
		while($r = DB::fetch_array($result)) { 
			$r['linkurl'] = empty($r['linkurl'])?$r['comurl']:$r['linkurl'];
			$lists[] = $r;
		}
		return $lists;
	}
	function get_links2($company) {
		 
		$lists = array();
		//先获取所有linkid
		$result = DB::query("SELECT itemid FROM {$this->table} WHERE company={$company}");
		$link_ids='';
		while($r = DB::fetch_array($result)) {
			$link_ids.=','.$r['itemid'];
		}
		if($link_ids==''){
			return array();
		}

		$link_ids=substr($link_ids,1);
		//先获取链接的公司
		$result = DB::query("SELECT company FROM {$this->table_uid} WHERE linkid in({$link_ids})");
		$com_ids='';
		while($r = DB::fetch_array($result)) {
			$com_ids.=','.$r['company'];
		}
		if($com_ids==''){
			return array();
		}

		$com_ids=substr($com_ids,1);
		 //获取链接详情
		$result = DB::query("SELECT username,comurl FROM {$this->table_company}  WHERE id in($com_ids)");
		 
		while($r = DB::fetch_array($result)) {  
			$lists[] = $r;
		}
		return $lists;
	}
	function add($post) {
		global $DT, $MOD, $module;
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
        
		DB::query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		$this->itemid = DB::insert_id();
	
		return $this->itemid;
	}
	function add_company($post) {
		global $DT, $MOD, $module;

		//先添加公司
		$sqlk = '(username,comurl,domain)';
		$comurl=$post['linkurl'];
		$domain=$post['linkurl'];
		$len1=strpos($domain,'//'); 
		if($len1>0){
		    $domain=substr($domain,$len1+2);
		} 
		$len2=strrpos($domain,'/');
		if($len2>0){
		    $domain=substr($domain,0,$len2);
		} 
		
		$sqlv="('{$post['username']}','{$comurl}','{$domain}')"; 
		 
		DB::query("INSERT INTO {$this->table_company} $sqlk VALUES $sqlv");
		$company= DB::insert_id();
	 
		//再找关键字
		$meta_array = get_meta_tags($post['linkurl']);
		$keywords=trim($meta_array['keywords']); 
		if(empty($keywords)){
			$key_arr=array($post['username']);
		}else{
			$encode = mb_detect_encoding($keywords, array('UTF-8','GB2312','GBK'));
			if($encode != "UTF-8")
			{ 
			    $keywords=@iconv($encode,'UTF-8',$keywords);
			} 
		 	$key_arr=explode(',', $keywords);
		}
		
	 	$post = $this->set($post);
	 	$sqlk = '(title,company,addtime,edittime)';
	  	$sqlv='';
		foreach($key_arr as $v){  
			$sqlv.=",('{$v}','{$company}','{$post['addtime']}','{$post['edittime']}')";  
		} 
		$sqlv=substr($sqlv, 1);
        DB::query("INSERT INTO {$this->table} {$sqlk} VALUES {$sqlv}"); 
        
		return $company;
	}
	//添加对其他公司的链接
	function uid_add1($company,$type=1) {
		 
		$table_uid=$this->table_uid;
		$links_num=$this->links_num;
		$table_link=$this->table;
		//先检测是否删除
		if($type==2){
			  DB::query("delete from {$table_uid} where company={$company}"); 
		}
		//获取所有链接
		$sql="select itemid,company from {$table_link} where company!={$company}";
		$links_all = array();
		$result = DB::query($sql);
		while($r = DB::fetch_array($result)) { 
		    $links_all[$r['company']] = $r['itemid'];
		}
		//随机取$link_nums个，得到linkids
		$linkids=array();
		if(count($links_all) <= $links_num){ 
			$linkids=$links_all;
		}else{
			$rand_coms = array_rand($links_all,$links_num); 
			foreach ($rand_coms as $value) {
				$linkids[]=$links_all[$value];
			} 
		}
		 
		//有链接后添加对应绑定
		$sql="INSERT INTO `{$table_uid}` (company,linkid) VALUES ";
		$sqlv='';
		foreach($linkids as $v){
			$sqlv.=",({$company},{$v})";
		}
		$sqlv=substr($sqlv, 1); 
		DB::query($sql.$sqlv); 
		return 1;
	}
	//添加其他公司的反链
	function uid_add2($company,$type=1) {
		 
		$table_uid=$this->table_uid;
		$links_num=$this->links_num;
		$table_link=$this->table;
		$table_company=$this->table_company;
		//先获取所有linkid
		$result = DB::query("SELECT itemid FROM {$table_link} WHERE company={$company}");
		$link_ids0='';
		$link_ids=array();
		while($r = DB::fetch_array($result)) {
			$link_ids0.=','.$r['itemid'];
			$link_ids[$r['itemid']]=$r['itemid'];
		}
		if($link_ids0==''){
			return 1;
		} 
		$link_ids0=substr($link_ids0,1);
		//先检测是否删除
		if($type==2){
			DB::query("delete from {$table_uid} where linkid in({$link_ids0})");
		}
		 //添加的个数links_num

		//获取所有公司
		$sql="select id from {$table_company} where id!={$company}";
		$com_all = array();
		$result = DB::query($sql);
		while($r = DB::fetch_array($result)) { 
		    $com_all[$r['id']] = $r['id'];
		}
		//随机取$link_nums个
		$comids=array();
		if(count($com_all) <= $links_num){ 
			$comids=$com_all;
		}else{
			$comids = array_rand($com_all,$links_num); 
		}
		 
		//有链接后添加对应绑定
		$sql="INSERT INTO `{$table_uid}` (company,linkid) VALUES ";
		$sqlv='';
		foreach($comids as $v){
			$link=array_rand($link_ids,1); 
			$sqlv.=",({$v},{$link})";
		}
		$sqlv=substr($sqlv, 1); 
		DB::query($sql.$sqlv); 
		return 1;
	}
	function edit($post) {
		global $DT, $MOD, $module;
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    DB::query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		
		return true;
	}
   
 

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>