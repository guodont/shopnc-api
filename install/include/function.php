<?php
/**
 * environmental check
 */
function env_check(&$env_items) {
	$env_items[] = array('name' => '操作系统', 'min' => '无限制', 'good' => 'linux', 'cur'=>PHP_OS, 'status' => 1);

	$env_items[] = array('name' => 'PHP版本', 'min' => '5.3', 'good' => '5.4', 'cur' => PHP_VERSION, 'status'=>(PHP_VERSION < 5.3 ? 0:1));

	$tmp = function_exists('gd_info') ? gd_info() : array();
	preg_match("/[\d.]+/", $tmp['GD Version'],$match);
	unset($tmp);
	$env_items[] = array('name' => 'GD库', 'min' => '2.0', 'good' => '2.0', 'cur' => $match[0], 'status' => ($match[0] < 2 ? 0:1));

	$env_items[] = array('name' => '附件上传', 'min' => '未限制', 'good' => '2M','cur' => ini_get('upload_max_filesize'), 'status' => 1);

	$disk_place = function_exists('disk_free_space') ? floor(disk_free_space(ROOT_PATH) / (1024*1024)) : 0;
	$env_items[] = array('name' => '磁盘空间', 'min' => '100M', 'good' => '>100M','cur' => empty($disk_place) ? '未知' : $disk_place.'M', 'status' => $disk_place < 100 ? 0:1);
}
/**
 * file check
 */
function dirfile_check(&$dirfile_items) {
	foreach($dirfile_items as $key => $item) {
		$item_path = '/'.$item['path'];
		if($item['type'] == 'dir') {
			if(!dir_writeable(ROOT_PATH.$item_path)) {
				if(is_dir(ROOT_PATH.$item_path)) {
					$dirfile_items[$key]['status'] = 0;
					$dirfile_items[$key]['current'] = '+r';
				} else {
					$dirfile_items[$key]['status'] = -1;
					$dirfile_items[$key]['current'] = 'nodir';
				}
			} else {
				$dirfile_items[$key]['status'] = 1;
				$dirfile_items[$key]['current'] = '+r+w';
			}
		} else {
			if(file_exists(ROOT_PATH.$item_path)) {
				if(is_writable(ROOT_PATH.$item_path)) {
					$dirfile_items[$key]['status'] = 1;
					$dirfile_items[$key]['current'] = '+r+w';
				} else {
					$dirfile_items[$key]['status'] = 0;
					$dirfile_items[$key]['current'] = '+r';
				}
			} else {
				if ($fp = @fopen(ROOT_PATH.$item_path,'wb+')){
					$dirfile_items[$key]['status'] = 1;
					$dirfile_items[$key]['current'] = '+r+w';
					@fclose($fp);
					@unlink(ROOT_PATH.$item_path);
				}else {
					$dirfile_items[$key]['status'] = -1;
					$dirfile_items[$key]['current'] = 'nofile';
				}
			}
		}
	}
}
/**
 * dir is writeable
 * @return number
 */
function dir_writeable($dir) {
	$writeable = 0;
	if(!is_dir($dir)) {
		@mkdir($dir, 0755);
	}else {
		@chmod($dir,0755);
	}
	if(is_dir($dir)) {
		if($fp = @fopen("$dir/test.txt", 'w')) {
			@fclose($fp);
			@unlink("$dir/test.txt");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}
/**
 * function is exist
 */
function function_check(&$func_items) {
	$func = array();
	foreach($func_items as $key => $item) {
		$func_items[$key]['status'] = function_exists($item['name']) ? 1 : 0;
	}
}

function show_msg($msg){
	global $html_title,$html_header,$html_footer;
	include 'step_msg.php';
	exit();
}
/**
 * database check
 */
function check_db($db_host, $db_user, $db_pwd, $db_name, $db_prefix, $db_port) {
	if(!function_exists('mysql_connect')) {
		show_msg('undefined function : mysql_connect()');
	}
	if(!@mysql_connect($db_host.":".$db_port, $db_user, $db_pwd)) {
		show_msg('database connect failed');
	} else {
		if($query = mysql_query("SHOW TABLES FROM $db_name")) {
			while($row = mysql_fetch_row($query)) {
				if(preg_match("/^$db_prefix/", $row[0])) {
					return false;
				}
			}
		}
	}
	return true;
}
//make rand
function random($length, $numeric = 0) {
	$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed[mt_rand(0, $max)];
	}
	return $hash;
}
/**
 * drop table 
 */
function droptable($table_name){
	return "DROP TABLE IF EXISTS `". $table_name ."`;";
}

//database class
class db {
	var $querynum = 0;
	var $link;
	var $histories;
	var $time;
	var $tablepre;

	function connect($dbhost, $dbuser, $dbpw, $dbname = '', $dbcharset, $pconnect = 0, $tablepre='', $time = 0) {
		$this->time = $time;
		$this->tablepre = $tablepre;
		if($pconnect) {
			if(!$this->link = mysql_pconnect($dbhost, $dbuser, $dbpw)) {
				$this->halt('Can not connect to MySQL server');
			}
		} else {
			if(!$this->link = mysql_connect($dbhost, $dbuser, $dbpw, 1)) {
				$this->halt('Can not connect to MySQL server');
			}
		}

		if($this->version() > '5.0') {
			if($dbcharset) {
				mysql_query("SET character_set_connection=".$dbcharset.", character_set_results=".$dbcharset.", character_set_client=binary", $this->link);
			}

			if($this->version() > '5.0.1') {
				mysql_query("SET sql_mode=''", $this->link);
			}
		}

		if($dbname) {
			mysql_select_db($dbname, $this->link);
		}

	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}

	function result_first($sql, &$data) {
		$query = $this->query($sql);
		$data = $this->result($query, 0);
	}

	function fetch_first($sql, &$arr) {
		$query = $this->query($sql);
		$arr = $this->fetch_array($query);
	}

	function fetch_all($sql, &$arr) {
		$query = $this->query($sql);
		while($data = $this->fetch_array($query)) {
			$arr[] = $data;
		}
	}

	function query($sql, $type = '', $cachetime = FALSE) {
		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ? 'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->link)) && $type != 'SILENT') {
			$this->halt('MySQL Query Error', $sql);
		}
		$this->querynum++;
		$this->histories[] = $sql;
		return $query;
	}

	function affected_rows() {
		return mysql_affected_rows($this->link);
	}

	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}

	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}

	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		return mysql_get_server_info($this->link);
	}

	function close() {
		return mysql_close($this->link);
	}

	function halt($message = '', $sql = '') {
						echo mysql_error();echo "<br />";
	}
}
