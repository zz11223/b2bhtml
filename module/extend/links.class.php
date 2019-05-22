<?php 
defined('IN_DESTOON') or exit('Access Denied');
class dlinks {
	var $itemid;
	var $table;
	var $fields;
	var $errmsg = errmsg;

    function __construct() {
		$this->table = DT_PRE.'links';
		$this->fields = array('username','title','addtime','edittime','linkurl');
    }

    function dlinks() {
		$this->__construct();
    }

	function pass($post) {
		global $L;
		if(!is_array($post)) return false; 
		if(!$post['title']) return $this->_($L['links_pass_site']);
		if(!is_url($post['linkurl'])) return $this->_($L['links_pass_url']);
		return true;
	}

	function set($post) {
		global $MOD, $_username, $_userid;
		if(!$this->itemid) $post['addtime'] = DT_TIME; 
		$post['edittime'] = DT_TIME; 
	    $post['aname'] = 'admin'; 
	    
	    if(isset($post['itemid']) && $post['itemid']==0){
	    	unset($post['itemid']);
	    }
		$post = dhtmlspecialchars($post);

		return array_map("trim", $post);
	}

	function get_one() {
        return DB::get_one("SELECT * FROM {$this->table} WHERE itemid='$this->itemid'");
	}

	function get_list($condition = '1', $order = 'itemid DESC') {
		global $MOD, $TYPE, $pages, $page, $pagesize, $offset, $sum;
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = DB::get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		if($items < 1) return array();
		$lists = array();
		$result = DB::query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = DB::fetch_array($result)) {
			$r['title'] = $r['title'];
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			
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