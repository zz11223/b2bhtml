<?php 
defined('IN_DESTOON') or exit('Access Denied');
class dlinks {
	var $itemid;
	var $table;
	var $table_company;
	var $table_uid;
	var $fields;
	var $errmsg = errmsg;

    function __construct() {
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

	function get_links($domain,$comurl,$username) {
		$r = DB::get_one("SELECT id AS num FROM {$this->table_company} WHERE domain='{$domain}'");
		if(empty($r['id'])){
			//先添加公司
			$sqlk = '(username,comurl,domain)'; 
			$sqlv="('{$username}','{$comurl}','{$domain}')";  
			DB::query("INSERT INTO {$this->table_company} $sqlk VALUES $sqlv");
			$company= DB::insert_id(); 
		}else{
			$company = $r['id'];
		}
		//获取links
		$link_nums=20;
		$linkids='';
		$result = DB::query("SELECT linkid FROM {$this->table_uid} limit $link_nums");
		while($r = DB::fetch_array($result)) { 
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
			$sql="INSERT INTO `{$this->table_uid}` (company,linkid) VALUES ";
			foreach($rand_keys as $v){
				$sql.=",({$company},{$v})";
			}
			$sql=substr($sql, 1);
			DB::query($sql);
			//添加后再读取
			$linkids=implode(',', $rand_keys);
	 
		}else{ 
			$linkids=substr($linkids,1);
		}
		 //获取ids
		$lists = array(); 
		$result = DB::query("SELECT * FROM {$this->table} LIMIT $link_nums");
			$result = DB::query("SELECT title,linkurl,comurl FROM {$this->table} as link join {$this->table_company} as com on link.company=com.id WHERE link.itemid in({$linkids}) LIMIT $link_nums");
		while($r = DB::fetch_array($result)) {
			 
			$lists[] = array(
				'title'=>$r['title'],
				'linkurl'=>empty($r['linkurl'])?$r['comurl']:$r['linkurl']
				);
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
	function add_all($post) {
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
		$keywords=$meta_array['keywords']; 
		$encode = mb_detect_encoding($keywords, array('UTF-8','GB2312','GBK'));
		if($encode != "UTF-8")
		{ 
		    $keywords=@iconv($encode,'UTF-8',$keywords);
		} 
	 	$key_arr=explode(',', $keywords);
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