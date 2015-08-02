<?php
/**
 * 数据库操作 模型
 *
 * session中存放的变量说明：$_SESSION['db_backup']
 * size 文件大小，单位B， 即 传入参数*1024
 * table_name 当前进行备份的表名，即从该表名的位置进行备份，默认为空，即从开头进行备份
 * op 当前表建立动作，create/insert 两种 默认为create
 * limit 条数记录，反映当前insert语句中，处理到的位置，默认为0
 * back_file 备份目录名 格式为YYYYMMDD_序号
 * backup_tables 需要备份的表名列表，为数组格式
 * md5 加密后缀
 * 
 
 */
defined('InShopNC') or exit('Access Invalid!');

class dbModel{
	/**
	 * 备份语句
	 */
	private $back_content = '';
	/**
	 * 步骤
	 */
	private $step = 1;
	/**
	 * 备份数据库
	 *
	 * @param int $step 步骤
	 * @return string 字符类型的返回结果
	 */
	public function backUp($step=1){
		$table_list = $_SESSION['db_backup']['backup_tables'];
		if ($step == 1){
			$this->back_content .= "\r\nSET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\r\n\r\n";
			$_SESSION['db_backup']['table_name'] = $_SESSION['db_backup']['backup_tables'][0];
		}
		$this->step = $step;
		if (!empty($_SESSION['db_backup']['table_name'])){
			$key = array_search($_SESSION['db_backup']['table_name'],$table_list);
			if ($key > 0){
				for ($i=0; $i<$key; $i++){
					unset($table_list[$i]);
				}
			}
		}
		/**
		 * 创建表sql
		 */
		if ($_SESSION['db_backup']['op'] == 'create'){
			foreach ($table_list as $k => $v){
				/**
				 * 写入session
				 */
				$_SESSION['db_backup']['table_name'] = $v;
				$result = $this->getCreateContent($v);
				/**
				 * 跳出
				 */
				if ($result === false){
					return true;
				}
				/**
				 * 判断是否最后结束
				 */
				if (empty($table_list[$k+1])){
					/**
					 * 写入文件
					 */
					$this->writeBackFile();
					/**
					 * 写入session op
					 */
					$_SESSION['db_backup']['op'] = 'insert';
					$_SESSION['db_backup']['table_name'] = $_SESSION['db_backup']['backup_tables'][0];
					return true;
				}
			}
		}
		/**
		 * 表信息sql
		 */
		if ($_SESSION['db_backup']['op'] == 'insert'){
			foreach ($table_list as $k => $v){
				/**
				 * 写入session
				 */
				$_SESSION['db_backup']['table_name'] = $v;
				while (true) {
					$result = $this->getInsertContent($v);
					if ($result === 'succ'){
						break;
					}
					/**
					 * 跳出
					 */
					if ($result === false){
						return true;
					}
				}
				/**
				 * 判断是否最后结束
				 */
				if (empty($table_list[$k+1]) && $_SESSION['db_backup']['limit'] == 0){
					/**
					 * 写入文件
					 */
					$this->writeBackFile();
					return true;
				}
			}
		}
		return true;
	}
	
	/**
	 * 表名列表
	 *
	 * @param string $type all/self 取表列表范围，all为整个数据库全部表，self为产品自己的表
	 * @return array $rs_row 返回数组形式的查询结果
	 */
    public function getTableList($type = 'self'){
        $table_list = array();
        $tmp = Db::showTables();
        $count = strlen(DBPRE);
        $table = "Tables_in_" . DBNAME;
        if ($type == 'all') {
            if (is_array($tmp)) {
                foreach ($tmp as $k => $v) {
                    $table_list[] = $v[$table];                 
                }
            }
        }
        if ($type == 'self') {
            if (is_array($tmp)) {
                foreach ($tmp as $k => $v) {
                    $table_list[] = $v[$table];                    
                }
            }
        }
        return $table_list;
    }
	
	
	/**
	 * create表语句内容
	 *
	 * @param 
	 * @return string 字符串类型的返回结果
	 */
	private function getCreateContent($table){
		/**
		 * 构造语句
		 */
		$tmp_create = "DROP TABLE IF EXISTS `". $table ."`;\r\n";
		$tmp_create .= Db::showCreateTable(substr($table,strlen(DBPRE),strlen($table)-1));
		$tmp_create .= ";\r\n\r\n";
		/**
		 * 判断长度
		 */
		if (strlen($this->back_content.$tmp_create) >= $_SESSION['db_backup']['size']){
			/**
			 * 写入文件，跳出
			 */
			$this->writeBackFile();
			/**
			 * 停止备份
			 */
			return false;
		}else {
			/**
			 * 增加备份语句
			 */
			$this->back_content .= $tmp_create;
			/**
			 * 继续备份
			 */
			return true;
		}
	}
	
	/**
	 * 转换特殊符号
	 *
	 * @param 
	 * @return string 字符串类型的返回结果
	 */
	private function sqlAddslashes($a_string = '', $is_like = false, $crlf = false, $php_code = false){
    if ($is_like) {
        $a_string = str_replace('\\', '\\\\\\\\', $a_string);
    } else {
        $a_string = str_replace('\\', '\\\\', $a_string);
    }

    if ($crlf) {
        $a_string = str_replace("\n", '\n', $a_string);
        $a_string = str_replace("\r", '\r', $a_string);
        $a_string = str_replace("\t", '\t', $a_string);
    }

    if ($php_code) {
        $a_string = str_replace('\'', '\\\'', $a_string);
    } else {
        $a_string = str_replace('\'', '\'\'', $a_string);
    }

    return $a_string;
	}
	/**
	 * insert表语句内容
	 *
	 * @param 
	 * @return string 字符串类型的返回结果
	 */
	private function getInsertContent($table){
		/**
		 * 开始条数
		 */
		$limit = $_SESSION['db_backup']['limit']?$_SESSION['db_backup']['limit']:0;
		/**
		 * 当前语句大小
		 */
		$now_size = strlen($this->back_content);
		/**
		 * 取信息
		 */
		$param = array();
		$param['table'] = substr($table,strlen(DBPRE),strlen($table)-1);
		$param['limit'] = $limit.',300';
		$param['cache'] = false;
		$list = Db::select($param);

		/**
		 * 没有信息
		 */
		if (empty($list)){
			/**
			 * limit数据归0
			 */
			$_SESSION['db_backup']['limit'] = 0;
			/**
			 * 继续back循环
			 */
			return 'succ';
		}
		/**
		 * 字段信息
		 */
		$columns_array = Db::showColumns(substr($table,strlen(DBPRE),strlen($table)-1));
		/**
		 * 生成sql语句
		 */
		$result = '';
		foreach ($list as $k => $v){
			$tmp_sql = '';
			$tmp_columns = '';
			$tmp_value = '';
			/**
			 * 字段信息
			 */
			foreach ($columns_array as $k_col => $v_col){
				/**
				 * 字段
				 */
				$tmp_columns .= "`". $k_col ."`,";
				/**
				 * 值
				 */
				if ($v_col['null'] == 'YES'){
					if (empty($v[$k_col])){
						$tmp_value .= "NULL,";
					}else {
						$tmp_value .= "'". $this->sqlAddslashes($v[$k_col]) ."',";
					}
				}else {
					$tmp_value .= "'". $this->sqlAddslashes($v[$k_col]) ."',";
				}
			}
			/**
			 * 构造语句
			 */
			$tmp_sql .= "INSERT INTO `".$table."` ";
			$tmp_sql .= "(";
			$tmp_sql .= trim($tmp_columns,',');
			$tmp_sql .= ") VALUES(";
			$tmp_sql .= trim($tmp_value,',');
			$tmp_sql .= ")";
			$tmp_sql .= ";\r\n";
			/**
			 * 判断字符串大小限制
			 */
			if (strlen($this->back_content.$tmp_sql) >= $_SESSION['db_backup']['size']){
				/**
				 * 备份文件
				 */
				$this->writeBackFile();
				/**
				 * 超过限制，跳出讯号
				 */
				return false;
			}else {
				/**
				 * 增加session中的limit计数
				 */
				$_SESSION['db_backup']['limit']++;
				$this->back_content .= $tmp_sql;
			}
		}
		
		/**
		 * 结束该表的读取，limit归0
		 */
		if (count($list) < 10){
			$_SESSION['db_backup']['limit'] = 0;
			$this->back_content .= "\r\n";
			return 'succ';
		}
		/**
		 * 继续back循环
		 */
		return true;
	}
	
	/**
	 * 获取目录
	 * 
	 * @param 
	 * @return 
	 */
	public function getBackDir(){
		/**
		 * 按照日期进行生成
		 */
		$dir_list = readDirList(BASE_ROOT_PATH.DS.'sql_back');
		$tmp = date('Ymd');
		$check_array = array();
		if (is_array($dir_list)){
			foreach ($dir_list as $k => $v){
				if (substr($v,0,strlen($tmp)) == $tmp){
					$check_array[] = substr($v,strlen($tmp)+1,strlen($v));
				}
			}
		}
		$return = $tmp.'_'.($check_array[count($check_array)-1]+1);
		return $return;
	}
	
	/**
	 * 写入文件
	 *
	 * @param int $id 记录ID
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function writeBackFile(){
		Language::read('model_lang_index');
		$lang	= Language::getLangContent();
		$step = $this->step;
		try {
			if (!is_dir(BASE_ROOT_PATH.DS.'sql_back'.DS.$_SESSION['db_backup']['back_file'])){
				if (!$this->mkdirs(BASE_ROOT_PATH.DS.'sql_back'.DS.$_SESSION['db_backup']['back_file'],0755)){
					$error = $lang['db_backup_mkdir_fail'];
					throw new Exception($error);
				}else {
					$fp = @fopen(BASE_ROOT_PATH.DS.'sql_back'.DS.$_SESSION['db_backup']['back_file'].DS.'index.html','w+');
					@fclose($fp);
				}
			}
			$file_name = BASE_ROOT_PATH.DS.'sql_back'.DS.$_SESSION['db_backup']['back_file'].DS.$_SESSION['db_backup']['back_file'].'_'.$step.'_'.$_SESSION['db_backup']['md5'].'.sql';
			$fp = @fopen($file_name,'w+');
			if (@fwrite($fp,$this->back_content) === false){
				$error = $lang['db_backup_vi_file_fail'];
				throw new Exception($error);
			}
			@fclose($fp);
		}catch (Exception $e){
			showMessage($e->getMessage(),'','exception');
		}
		return true;
	}
	/**
	 * 建立多级目录
	 *
	 * @param string $dir 目录
	 * @return true 
	 */
	public function mkdirs($dir){
        if (!is_dir($dir)) {
            if (!$this->mkdirs(dirname($dir))) {
                return false;
            }
            if (!mkdir($dir, 0777)) {
                return false;
            }
        }
        return true;
    }
	/**
	 * 数据库备份导入
	 *
	 * @param string $path 目录
	 * @param int $step 步骤，也是第几个文件
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function import($path,$step=1){
		$dir = BASE_ROOT_PATH.DS.'sql_back'.DS.$path;
		$file_list = array();
		readFileList($dir,$file_list);
		/**
		 * 过滤文件
		 */

		if (!empty($file_list) && is_array($file_list)){
			foreach ($file_list as $key=>$file_name){
				if (strtolower(substr($file_name,-4)) == '.sql'){
					$tmp_list[] = $file_name;
				}
			}
			$file_list = $tmp_list;
		}
		foreach($file_list as $k=>$v){
			$varr = explode('_',$v);
			$file_list[$k] = $varr['0'].'_'.$varr['1'].'_'.$varr['2'].'_'.$varr['3'].'_'.($k+1).'_'.$varr['5'];
		}

		$file_name = $file_list[$step-1];
		//此处使用is_file来判断该sql文件是否存在，不使用file_exists
		if (is_file($file_name)){
			$handle = @fopen($file_name, "r");
			$tmp_sql = '';
			if ($handle) {
			    while (!feof($handle)) {
			        $buffer = fgets($handle);
			        if (trim($buffer) != ''){
			        	$tmp_sql .= $buffer;
				        if (substr(rtrim($buffer),-1) == ';'){
				        	if (preg_match('/^(CREATE|ALTER|DROP)\s+(VIEW|TABLE|DATABASE|SCHEMA)\s+/i', ltrim($tmp_sql))){
				        		//标准的SQL语句，将被执行
				        	}else if (preg_match('/^(INSERT)\s+(INTO)\s+/i', ltrim($tmp_sql)) && substr(rtrim($buffer),-2) == ');'){
				        		//标准的SQL语句，将被执行
				        	}else if (preg_match('/^(SET)\s+SQL_MODE=/i', ltrim($tmp_sql))){
				        		//SET SQL_MODE 设置，将被执行
				        	}else{
				        		//不能组成标准的SQL语句，继续向下一行取内容，直到组成合法的SQL为止
				        		continue;
				        	}
				        	if (!empty($tmp_sql)){
								/**
								 * 销毁当前用户Session信息
								 */
								if (strpos($tmp_sql,cookie('sess_id')) !== false){
									unset($tmp_sql);
									continue;
								}
				        		Db::query($tmp_sql,'slave');
				        		unset($tmp_sql);
				        	}
				        }
			        }
			    }
			    @fclose($handle);
			}
			/**
			 * 判断是否还有下个文件
			 */
			if (empty($file_list[$step])){
				return 'succ';
			}else {
				return 'continue';
			}
		}else {
			return false;
		}
	}
}