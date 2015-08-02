<?php
/**
 * 核心文件
 *
 * 模型类
 *
 * @package    core* www.abc.com 专业团队 提供售后服务
 */
class Model{

	protected $name = '';
	protected $table_prefix = '';
	protected $init_table = null;
	protected $table_name = '';
	protected $options = array();
	protected $pk = 'id';
	protected $db = null;
	protected $fields = array();
	protected $unoptions = true;	//是否清空参数项，默认清除

	public function __construct($table = null){
		if (!is_null($table)){
			$this->table_name = $table;
			$this->tableInfo($table);
		}
		$this->table_prefix = DBPRE;
		if (!is_object($this->db)){
			$this->db = new ModelDb();
		}
	}

    /**
     * 删除表主键缓存
     */
    public static function dropTablePkArrayCache()
    {
        dkcache('field/_pk');
    }

    /**
     * 生成表结构信息
     *
     * @param string $table
     * @return
     */
    public function tableInfo($table)
    {
        if (empty($table)) return false;
        //只取主键,find(2)等自动匹配主键时使用

        if (C('cache_open')) {
            $this->fields = rkcache('field/_pk', __CLASS__ . '::fetchTablePkArray');
        } else {
            if (file_exists(BASE_DATA_PATH.'/cache/fields/_pk.php')){
                $this->fields = require(BASE_DATA_PATH.'/cache/fields/_pk.php');
            } else {
                $_pk_array = self::fetchTablePkArray();
                F('_pk', $_pk_array, 'cache/fields');
                $this->fields = $_pk_array;
            }
        }

        return $this->fields[$table];
    }

    public static function fetchTablePkArray()
    {
        $full_table = Db::showTables();
        $_pk_array = array();
        $count = strlen(C('tablepre'));
        foreach ($full_table as $v_table) {
            $v = array_values($v_table);
            if (substr($v[0],0,$count) != C('tablepre')) continue;
            $tb = preg_replace('/^'.C('tablepre').'/', '', $v[0]);
            $fields = DB::showColumns($tb);
            foreach ((array)$fields as $k=>$v) {
                if($v['primary']) {
                    $_pk_array[$tb] = $k;break;
                }
            }
        }
        return $_pk_array;
    }

    public function __call($method,$args) {
        if(in_array(strtolower($method),array('table','order','where','on','limit','having','group','lock','master','distinct','index','attr','key'),true)) {
            $this->options[strtolower($method)] =   $args[0];
            if (strtolower($method) == 'table'){
            	if (strpos($args[0],',') !== false){
            		$args[0] = explode(',',$args[0]);
            		$this->table_name = '';
            		foreach ((array)$args[0] as $value) {
            			$this->tableInfo($value);
            		}
            	}else{
            		$this->table_name = $args[0];$this->fields = array();$this->tableInfo($args[0]);
            	}
            }
            return $this;
        }elseif(in_array(strtolower($method),array('page'),true)){
            if ($args[0] == null){
				return $this;
			}elseif(!is_numeric($args[0]) || $args[0] <= 0){
				$args[0] = 10;
			}

			if (is_numeric($args[1]) && $args[1] > 0){
			    //page(2,30)形式，传入了每页显示数据和总记录数
			    if ($args[0] > 0){
			        $this->options[strtolower($method)] =   $args[0];
			        pagecmd('setEachNum',	$args[0]);
			        $this->unoptions = false;
			        pagecmd('setTotalNum',	$args[1]);
			        return $this;
			    }else{
			        $args[0] = 10;
			    }
			}
			$this->options[strtolower($method)] =   $args[0];
			pagecmd('setEachNum',	$args[0]);
			$this->unoptions = false;
			pagecmd('setTotalNum',	$this->get_field('COUNT(*) AS nc_count'));
        	return $this;
        }elseif(in_array(strtolower($method),array('min','max','count','sum','avg'),true)){
            $field =  isset($args[0])?$args[0]:'*';
            return $this->get_field(strtoupper($method).'('.$field.') AS nc_'.$method);
        }elseif(strtolower($method)=='count1'){
            $field =  isset($args[0])?$args[0]:'*';
            $options['field'] = ('count('.$field.') AS nc_count');
            $options =  $this->parse_options($options);
            $options['limit'] = 1;
            $result = $this->db->select($options);
            if(!empty($result)) {
                return reset($result[0]);
            }
        }elseif(strtolower(substr($method,0,6))=='getby_') {
            $field   =   substr($method,6);
            $where[$field] =  $args[0];
            return $this->where($where)->find();
        }elseif(strtolower(substr($method,0,7))=='getfby_') {
            $name   =   substr($method,7);
            $where[$name] =$args[0];
            //getfby_方法只返回第一个字段值
            if (strpos($args[1],',') !== false){
            	$args[1] = substr($args[1],0,strpos($args[1],','));
            }
            return $this->where($where)->get_field($args[1]);
        }else{
            $error = 'Model Error:  Function '.$method.' is not exists!';
            throw_exception($error);
            return;
        }
    }
	/**
	 * 查询
	 *
	 * @param array/int $options
	 * @return null/array
	 */
    public function select($options=array()) {
        if(is_string($options) || is_numeric($options)) {
            // 默认根据主键查询
            $pk   =  $this->get_pk();
            if(strpos($options,',')) {
                $where[$pk] =  array('IN',$options);
            }else{
                $where[$pk]   =  $this->fields[$this->table_name]['_pk_type'] == 'int' ? intval($options) : $options;
            }
            $options =  array();
            $options['where'] =  $where;
        }
        $options =  $this->parse_options($options);
        if ($options['limit'] !== false) {
            if (empty($options['where']) && empty($options['limit'])){
            	//如果无条件，默认检索30条数据
            	$options['limit'] = 30;
            }elseif ($options['where'] !== true && empty($options['limit'])){
            	//如果带WHERE，但无LIMIT，最多只检索1000条记录
            	$options['limit'] = 1000;
            }
        }

        $resultSet = $this->db->select($options);

        if(empty($resultSet)) {
            return array();
        }
        if ($options['key'] != '' && is_array($resultSet)){
        	$tmp = array();
        	foreach ($resultSet as $value) {
        		$tmp[$value[$options['key']]] = $value;
        	}
        	$resultSet = $tmp;
        }
        return $resultSet;
    }

	/**
	 * 取得第N列内容
	 *
	 * @param array/int $options
	 * @return null/array
	 */
    public function getfield($col = 1) {
    	if (intval($col)<=1) $col = 1;
        $options =  $this->parse_options();
        if (empty($options['where']) && empty($options['limit'])){
        	//如果无条件，默认检索30条数据
        	$options['limit'] = 30;
        }elseif ($options['where'] !== true && empty($options['limit'])){
        	//如果带WHERE，但无LIMIT，最多只检索1000条记录
        	$options['limit'] = 1000;
        }

        $resultSet = $this->db->select($options);
        if(false === $resultSet) {
            return false;
        }
        if(empty($resultSet)) {
            return null;
        }
        $return = array();
        $cols = array_keys($resultSet[0]);
        foreach ((array)$resultSet as $k => $v) {
        	$return[$k] = $v[$cols[$col-1]];
        }
        return $return;
    }

    protected function parse_options($options=array()) {
        if(is_array($options)) $options =  array_merge($this->options,$options);
        if(!isset($options['table'])){
        	$options['table'] =$this->getTableName();
        }elseif(false !== strpos(trim($options['table'],', '),',')){
        	foreach(explode(',', trim($options['table'],', ')) as $val){
        		$tmp[] = $this->getTableName($val).' AS `'.$val.'`';
        	}
        	$options['table'] = implode(',',$tmp);
        }else{
        	$options['table'] =$this->getTableName($options['table']);
        }
        if ($this->unoptions === true){
        	$this->options  =   array();
        }else{
        	$this->unoptions = true;
        }
        return $options;
    }

    public function get_field($field,$sepa=null) {
        $options['field']    =  $field;
        $options =  $this->parse_options($options);
        if(strpos($field,',')) { // 多字段
            $resultSet = $this->db->select($options);
            if(!empty($resultSet)) {
                $_field = explode(',', $field);
                $field  = array_keys($resultSet[0]);
                $move   =  $_field[0]==$_field[1]?false:true;
                $key =  array_shift($field);
                $key2 = array_shift($field);
                $cols   =   array();
                $count  =   count($_field);
                foreach ($resultSet as $result){
                    $name   =  $result[$key];
                    if($move) { // 删除键值记录
                        unset($result[$key]);
                    }
                    if(2==$count) {
                        $cols[$name]   =  $result[$key2];
                    }else{
                        $cols[$name]   =  is_null($sepa)?$result:implode($sepa,$result);
                    }
                }
                return $cols;
            }
        }else{
            $options['limit'] = 1;
            $result = $this->db->select($options);
            if(!empty($result)) {
                return reset($result[0]);
            }
        }
        return null;
    }

	/**
	 * 返回一条记录
	 *
	 * @param string/int $options
	 * @return null/array
	 */
    public function find($options=null) {
        if(is_numeric($options) || is_string($options)) {
            $where[$this->get_pk()] = $options;
            $options = array();
            $options['where'] = $where;
        }elseif(!empty($options)) {
        	return false;
        }
        $options['limit'] = 1;
        $options =  $this->parse_options($options);
        $result = $this->db->select($options);
        if(empty($result)) {
            return array();
        }
        return $result[0];
    }
	/**
	 * 删除
	 *
	 * @param array $options
	 * @return bool/int
	 */
    public function delete($options=array()) {
        if(is_numeric($options)  || is_string($options)) {
            // 根据主键删除记录
            $pk   =  $this->get_pk();
            if(strpos($options,',')) {
                $where[$pk]   =  array('IN', $options);
            }else{
                $where[$pk]   =  $this->fields['_pk_type'] == 'int' ? intval($options) : $options;
                $pkValue = $options;
            }
            $options =  array();
            $options['where'] =  $where;
        }
        $options =  $this->parse_options($options);
        $result =   $this->db->delete($options);
        if(false !== $result) {
        	return true;
//            $data = array();
//            if(isset($pkValue)) $data[$pk]   =  $pkValue;
        }
        return $result;
    }
	/**
	 * 更新
	 *
	 * @param array $data
	 * @param array $options
	 * @return boolean
	 */
    public function update($data='',$options=array()) {
        if(empty($data)) return false;
        // 分析表达式
        $options =  $this->parse_options($options);
        if(!isset($options['where'])) {
            // 如果存在主键,自动作为更新条件
            if(isset($data[$this->get_pk()])) {
                $pk   =  $this->get_pk();
                $where[$pk]   =  $data[$pk];
                $options['where']  =  $where;
                $pkValue = $data[$pk];
                unset($data[$pk]);
            }else{
                return false;
            }
        }
        $result = $this->db->update($data,$options);
        if(false !== $result) {
        	return true;
        }
        return $result;
    }

	/**
	 * 插入
	 *
	 * @param array $data
	 * @param bool $replace
	 * @param array $options
	 * @return mixed int/false
	 */
    public function insert($data='', $replace=false, $options=array()) {
        if(empty($data)) return false;
        $options =  $this->parse_options($options);
        $result = $this->db->insert($data,$options,$replace);
        if(false !== $result ) {
            $insertId   =   $this->getLastId();
            if($insertId) {
                return $insertId;
            }
        }
        return $result;
    }

	/**
	 * 批量插入
	 *
	 * @param array $dataList
	 * @param array $options
	 * @param bool $replace
	 * @return boolean
	 */
    public function insertAll($dataList,$options=array(),$replace=false){
        if(empty($dataList)) return false;
        // 分析表达式
        $options =  $this->parse_options($options);
        // 写入数据到数据库
        $result = $this->db->insertAll($dataList,$options,$replace);
        if(false !== $result ) return true;
        return $result;
    }

    /**
	 * 直接SQL查询,返回查询结果
	 *
	 * @param string $sql
	 * @return array
	 */
	public function query($sql){
		return DB::getAll($sql);
	}

	/**
	 * 执行SQL，用于 更新、写入、删除操作
	 *
	 * @param string $sql
	 * @return
	 */
    public function execute($sql){
    	return DB::execute($sql);
    }

    /**
     * 开始事务
     *
     * @param string $host
     */
    public static function beginTransaction($host = 'master'){
    	Db::beginTransaction($host);
    }

    /**
     * 提交事务
     *
     * @param string $host
     */
    public static function commit($host = 'master'){
    	Db::commit($host);
    }

    /**
     * 回滚事务
     *
     * @param string $host
     */
    public static function rollback($host = 'master'){
    	Db::rollback($host);
    }

    /**
     * 清空表
     *
     * @return boolean
     */
    public function clear(){
    	if (!$this->table_name && !$this->options['table']) return false;
    	$options =  $this->parse_options();
    	return $this->db->clear($options);
    }

    /**
     * 取得表名
     *
     * @param string $table
     * @return string
     */
	protected function getTableName($table = null){
		if (is_null($table)){
			$return = '`'.$this->table_prefix.$this->table_name.'`';
		}else{
			$return = '`'.$this->table_prefix.$table.'`';
		}
		return $return;
	}
    /**
     * 取得最后插入的ID
     *
     * @return int
     */
    public function getLastId() {
        return $this->db->getLastId();
    }
    /**
     * 指定查询字段 支持字段排除
     *
     * @param mixed $field
     * @param boolean $except
     * @return Model
     */
    public function field($field,$except=false){
        if(true === $field) {// 获取全部字段
            $fields   =  $this->getFields();
            $field =  $fields?$fields:'*';
        }elseif($except) {// 字段排除
            if(is_string($field)) {
                $field =  explode(',',$field);
            }
            $fields   =  $this->getFields();
            $field =  $fields?array_diff($fields,$field):$field;
        }
        $this->options['field']   =   $field;
        return $this;
    }
    /**
     * 取得数据表字段信息
     *
     * @return mixed
     */
    public function getFields(){
        if($this->fields) {
            $fields   =  $this->fields;
            unset($fields['_autoinc'],$fields['_pk'],$fields['_type']);
            return $fields;
        }
        return false;
    }

    /**
     * 组装join
     *
     * @param string $join
     * @return Model
     */
    public function join($join) {
    	if (false !== strpos($join,',')){
    		foreach (explode(',',$join) as $key=>$val) {
		    	if (in_array(strtolower($val),array('left','inner','right'))){
		    		$this->options['join'][] = strtoupper($val).' JOIN';
		    	}else{
		    		$this->options['join'][] = 'LEFT JOIN';
		    	}
    		}
    	}elseif (in_array(strtolower($join),array('left','inner','right'))){
    		$this->options['join'][] = strtoupper($join).' JOIN';
    	}
        return $this;
    }

	/**
	 * 取得主键
	 *
	 * @return string
	 */
    public function get_pk() {
    	return isset($this->fields[$this->table_name])?$this->fields[$this->table_name]:$this->pk;
    }

   /**
    * 检查非数据字段
    *
    * @param array $data
    * @return array
    */
     protected function chk_field($data) {
        if(!empty($this->fields[$this->table_name])) {
            foreach ($data as $key=>$val){
                if(!in_array($key,$this->fields[$this->table_name],true)){
                    unset($data[$key]);
                }
            }
        }
        return $data;
     }

    public function setInc($field, $step=1) {
        return $this->set_field($field,array('exp',$field.'+'.$step));
    }

    public function setDec($field,$step=1) {
        return $this->set_field($field,array('exp',$field.'-'.$step));
    }

    public function set_field($field,$value='') {
        if(is_array($field)) {
            $data = $field;
        }else{
            $data[$field]   =  $value;
        }
        return $this->update($data);
    }

	/**
	 * 显示分页链接
	 *
	 * @param int $style 分页风格
	 * @return string
	 */
    public function showpage($style = null){
    	return pagecmd('show',$style);
    }

	/**
	 * 获取分页总数
	 *
	 * @return string
	 */
    public function gettotalnum(){
    	return pagecmd('gettotalnum');
    }

	/**
	 * 获取总页数
	 *
	 * @return string
	 */
    public function gettotalpage(){
    	return pagecmd('gettotalpage');
    }
    /**
     * 清空MODEL中的options、table_name属性
     *
     */
    public function cls(){
    	$this->options = array();
    	$this->table_name = '';
    	return $this;
    }

    public function checkActive($host = 'master') {
        $this->db->checkActive($host);
    }

}


/**
 * 完成模型SQL组装
 *
 */
class ModelDb{

    protected $comparison      = array('eq'=>'=','neq'=>'<>','gt'=>'>','egt'=>'>=','lt'=>'<','elt'=>'<=','notlike'=>'NOT LIKE','like'=>'LIKE','in'=>'IN','not in'=>'NOT IN');
    // 查询表达式
    protected $selectSql  =     'SELECT%DISTINCT% %FIELD% FROM %TABLE%%INDEX%%JOIN%%WHERE%%GROUP%%HAVING%%ORDER%%LIMIT% %UNION%';


    public function select($options=array()) {
//     	static $_cache = array();
		$sql = $this->buildSelectSql($options);
        if ($options['cache'] !== false){
            $key =  is_string($cache['cache_key']) ? $cache['cache_key'] : md5($sql);
            if (isset($_cache[$key])){
            	return $_cache[$key];
            }
        }
        $result = DB::getAll($sql,($options['lock'] === true || $options['master'] === true || defined('TRANS_MASTER')) ? 'master' : 'slave');
//         if ($options['cache'] !== false && !isset($_cache[$key])){
//         	$_cache[$key] = $result;
//         }
        return $result;
    }

    public function buildSelectSql($options=array()) {
    	if (is_numeric($options['page'])){
			$page = pagecmd('obj');
			if ($options['limit'] !== 1){
				$options['limit'] = $page->getLimitStart().",".$page->getEachNum();
			}
    	}
        $sql  = $this->parseSql($this->selectSql,$options);
        $sql .= $this->parseLock(isset($options['lock'])?$options['lock']:false);
        return $sql;
    }

    public function parseSql($sql,$options=array()){
        $sql   = str_replace(
            array('%TABLE%','%DISTINCT%','%FIELD%','%JOIN%','%WHERE%','%GROUP%','%HAVING%','%ORDER%','%LIMIT%','%UNION%','%INDEX%'),
            array(
                $this->parseTable($options),
                $this->parseDistinct(isset($options['distinct'])?$options['distinct']:false),
                $this->parseField(isset($options['field'])?$options['field']:'*'),
                $this->parseJoin(isset($options['on'])?$options:array()),
                $this->parseWhere(isset($options['where'])?$options['where']:''),
                $this->parseGroup(isset($options['group'])?$options['group']:''),
                $this->parseHaving(isset($options['having'])?$options['having']:''),
                $this->parseOrder(isset($options['order'])?$options['order']:''),
                $this->parseLimit(isset($options['limit'])?$options['limit']:''),
                $this->parseUnion(isset($options['union'])?$options['union']:''),
                $this->parseIndex(isset($options['index'])?$options['index']:'')
            ),$sql);
        return $sql;
    }

	protected function parseUnion(){
		return '';
	}

	protected function parseLock($lock=false) {
	    if(!$lock) return '';
	    return ' FOR UPDATE ';
	}

	protected function parseIndex($value){
		return empty($value) ? '':' USE INDEX ('.$value.') ';
	}

    protected function parseValue($value) {
        if(is_string($value) || is_numeric($value)) {
            $value = '\''.$this->escapeString($value).'\'';
        }elseif(isset($value[0]) && is_string($value[0]) && strtolower($value[0]) == 'exp'){
            $value   =  $value[1];
        }elseif(is_array($value)) {
            $value   =  array_map(array($this, 'parseValue'),$value);
        }elseif(is_null($value)){
            $value   =  'NULL';
        }
        return $value;
    }

    protected function parseField($fields) {
        if(is_string($fields) && strpos($fields,',')) {
            $fields    = explode(',',$fields);
        }
        if(is_array($fields)) {
            //字段别名定义
            $array   =  array();
            foreach ($fields as $key=>$field){
                if(!is_numeric($key))
                    $array[] =  $this->parseKey($key).' AS '.$this->parseKey($field);
                else
                    $array[] =  $this->parseKey($field);
            }
            $fieldsStr = implode(',', $array);
        }elseif(is_string($fields) && !empty($fields)) {
            $fieldsStr = $this->parseKey($fields);
        }else{
            $fieldsStr = '*';
        }
        return $fieldsStr;
    }

    protected function parseTable($options) {
    	if ($options['on']) return null;
    	$tables = $options['table'];
        if(is_array($tables)) {// 别名定义
            $array   =  array();
            foreach ($tables as $table=>$alias){
                if(!is_numeric($table))
                    $array[] =  $this->parseKey($table).' '.$this->parseKey($alias);
                else
                    $array[] =  $this->parseKey($table);
            }
            $tables  =  $array;
        }elseif(is_string($tables)){
            $tables  =  explode(',',$tables);
            array_walk($tables, array(&$this, 'parseKey'));
//            if (strpos($options['table'],',') === false){
//            	$tables = $options['table'].' AS '.$options['table'];
//            }
//            $tables  =  explode(',',$tables);
        }

        return implode(',',$tables);
    }

    protected function parseWhere($where) {
        $whereStr = '';
        if(is_string($where)) {
            $whereStr = $where;
        }elseif(is_array($where)){
            if(isset($where['_op'])) {
                // 定义逻辑运算规则 例如 OR XOR AND NOT
                $operate    =   ' '.strtoupper($where['_op']).' ';
                unset($where['_op']);
            }else{
                $operate	=   ' AND ';
            }
            foreach ($where as $key=>$val){
//                $whereStr .= '( ';
//                if(!preg_match('/^[A-Z_\|\&\-.a-z0-9]+$/',trim($key))){
//                    $error = 'Model Error: args '.$key.' is wrong!';
//                    throw_exception($error);
//                }
//                $key = trim($key);
//                $whereStr   .= $this->parseWhereItem($this->parseKey($key),$val);
//                $whereStr .= ' )'.$operate;
                $whereStrTemp = '';
                if(0===strpos($key,'_')) {
                    // 解析特殊条件表达式
//                    $whereStr   .= $this->parseThinkWhere($key,$val);
                }else{
                    // 查询字段的安全过滤
                    if(!preg_match('/^[A-Z_\|\&\-.a-z0-9]+$/',trim($key))){
                        throw_exception($error);
                    }
                    // 多条件支持
                    $multi = is_array($val) &&  isset($val['_multi']);
                    $key = trim($key);
                    if(strpos($key,'|')) { // 支持 name|title|nickname 方式定义查询字段
                        $array   =  explode('|',$key);
                        $str   = array();
                        foreach ($array as $m=>$k){
                            $v =  $multi?$val[$m]:$val;
                            $str[]   = '('.$this->parseWhereItem($this->parseKey($k),$v).')';
                        }
                        $whereStrTemp .= implode(' OR ',$str);
                    }elseif(strpos($key,'&')){
                        $array   =  explode('&',$key);
                        $str   = array();
                        foreach ($array as $m=>$k){
                            $v =  $multi?$val[$m]:$val;
                            $str[]   = '('.$this->parseWhereItem($this->parseKey($k),$v).')';
                        }
                        $whereStrTemp .= implode(' AND ',$str);
                    }else{
                        $whereStrTemp   .= $this->parseWhereItem($this->parseKey($key),$val);
                    }
                }
                if(!empty($whereStrTemp)) {
                    $whereStr .= '( '.$whereStrTemp.' )'.$operate;
                }
            }
            $whereStr = substr($whereStr,0,-strlen($operate));
        }
        return empty($whereStr)?'':' WHERE '.$whereStr;
    }

    // where子单元分析
    protected function parseWhereItem($key,$val) {
        $whereStr = '';
        if(is_array($val)) {
            if(is_string($val[0])) {
                if(preg_match('/^(EQ|NEQ|GT|EGT|LT|ELT|NOTLIKE|LIKE)$/i',$val[0])) { // 比较运算
                    $whereStr .= $key.' '.$this->comparison[strtolower($val[0])].' '.$this->parseValue($val[1]);
                }elseif('exp'==strtolower($val[0])){ // 使用表达式
//                    $whereStr .= ' ('.$key.' '.$val[1].') ';
                    $whereStr .= $val[1];
                }elseif(preg_match('/IN/i',$val[0])){ // IN 运算
                    if(isset($val[2]) && 'exp'==$val[2]) {
                        $whereStr .= $key.' '.strtoupper($val[0]).' '.$val[1];
                    }else{
                    	if (empty($val[1])){
                    		$whereStr .= $key.' '.strtoupper($val[0]).'(\'\')';
                    	}elseif(is_string($val[1]) || is_numeric($val[1])) {
                             $val[1] =  explode(',',$val[1]);
                             $zone   =   implode(',',$this->parseValue($val[1]));
                             $whereStr .= $key.' '.strtoupper($val[0]).' ('.$zone.')';
                        }elseif(is_array($val[1])){
 							$zone   =   implode(',',$this->parseValue($val[1]));
                            $whereStr .= $key.' '.strtoupper($val[0]).' ('.$zone.')';
                        }
                    }
                }elseif(preg_match('/BETWEEN/i',$val[0])){
                    $data = is_string($val[1])? explode(',',$val[1]):$val[1];
                    if($data[0] && $data[1]) {
                        $whereStr .=  ' ('.$key.' '.strtoupper($val[0]).' '.$this->parseValue($data[0]).' AND '.$this->parseValue($data[1]).' )';
                    } elseif ($data[0]) {
                        $whereStr .= $key.' '.$this->comparison['gt'].' '.$this->parseValue($data[0]);
                    } elseif ($data[1]) {
                        $whereStr .= $key.' '.$this->comparison['lt'].' '.$this->parseValue($data[1]);
                    }
                }elseif(preg_match('/TIME/i',$val[0])){
                    $data = is_string($val[1])? explode(',',$val[1]):$val[1];
                    if($data[0] && $data[1]) {
                        $whereStr .=  ' ('.$key.' BETWEEN '.$this->parseValue($data[0]).' AND '.$this->parseValue($data[1] + 86400 -1).' )';
                    } elseif ($data[0]) {
                        $whereStr .= $key.' '.$this->comparison['gt'].' '.$this->parseValue($data[0]);
                    } elseif ($data[1]) {
                        $whereStr .= $key.' '.$this->comparison['lt'].' '.$this->parseValue($data[1] + 86400);
                    }
                }else{
                    $error = 'Model Error: args '.$val[0].' is error!';
                    throw_exception($error);
                }
            }else {
                $count = count($val);
                if(in_array(strtoupper(trim($val[$count-1])),array('AND','OR','XOR'))) {
                    $rule = strtoupper(trim($val[$count-1]));
                    $count   =  $count -1;
                }else{
                    $rule = 'AND';
                }
                for($i=0;$i<$count;$i++) {
                	if (is_array($val[$i])){
                		if (is_array($val[$i][1])){
                			$data = implode(',',$val[$i][1]);
                		}else{
                			$data = $val[$i][1];
                		}
                	}else{
                		$data = $val[$i];
                	}
                    if('exp'==strtolower($val[$i][0])) {
                        $whereStr .= '('.$key.' '.$data.') '.$rule.' ';
                    }else{
                        $op = is_array($val[$i])?$this->comparison[strtolower($val[$i][0])]:'=';
                         if(preg_match('/IN/i',$op)){
                         	$whereStr .= '('.$key.' '.$op.' ('.$this->parseValue($data).')) '.$rule.' ';
                         }else{
                         	$whereStr .= '('.$key.' '.$op.' '.$this->parseValue($data).') '.$rule.' ';
                         }

                    }
                }
                $whereStr = substr($whereStr,0,-4);
            }
        }else {
        	$whereStr .= $key.' = '.$this->parseValue($val);
        }
        return $whereStr;
    }

    protected function parseLimit($limit) {
        return !empty($limit)?   ' LIMIT '.$limit.' ':'';
    }

    protected function parseJoin($options = array()) {
        $joinStr = '';
        if (false === strpos($options['table'],',')) return null;
        $table = explode(',',$options['table']);
        $on = explode(',',$options['on']);
        $join = $options['join'];
        $joinStr .= $table[0];
		for($i=0;$i<(count($table)-1);$i++){
        	$joinStr .= ' '.($join[$i]?$join[$i]:'LEFT JOIN').' '.$table[$i+1].' ON '.($on[$i]?$on[$i]:'');
        }
        return $joinStr;
    }

    public function delete($options=array()) {
        $sql   = 'DELETE '.$this->parseAttr($options).' FROM '
            .$this->parseTable($options)
            .$this->parseWhere(isset($options['where'])?$options['where']:'')
            .$this->parseOrder(isset($options['order'])?$options['order']:'')
            .$this->parseLimit(isset($options['limit'])?$options['limit']:'');
            if (stripos($sql,'where') === false && $options['where'] !== true){
            	//防止条件传错，删除所有记录
            	return false;
            }
        return DB::execute($sql);
    }

    public function update($data,$options) {
        $sql   = 'UPDATE '
        	.$this->parseAttr($options)
            .$this->parseTable($options)
            .$this->parseSet($data)
            .$this->parseWhere(isset($options['where'])?$options['where']:'')
            .$this->parseOrder(isset($options['order'])?$options['order']:'')
            .$this->parseLimit(isset($options['limit'])?$options['limit']:'');
            if (stripos($sql,'where') === false && $options['where'] !== true){
            	//防止条件传错，更新所有记录
            	return false;
            }
        return DB::execute($sql);
    }

	public function parseAttr($options){
		if (isset($options['attr'])){
			if (in_array(isset($options['attr']),array('LOW_PRIORITY','QUICK','IGNORE','HIGH_PRIORITY','SQL_CACHE','SQL_NO_CACHE'))){
				return $options['attr'].' ';
			}
		}else{
			return '';
		}
	}

	public function lockAttr($options){
		if (isset($options['attr'])){
			if (in_array($options['attr'],array('FOR UPDATE'))){
				return ' '.$options['attr'].' ';
			}
		}else{
			return '';
		}
	}

    /**
     * 清空表
     *
     * @param array $options
     * @return boolean
     */
	public function clear($options){
		$sql = 'TRUNCATE TABLE '.$this->parseTable($options);
		return DB::execute($sql);
	}
    public function insert($data,$options=array(),$replace=false) {
        $values  =  $fields    = array();
        foreach ($data as $key=>$val){
            $value   =  $this->parseValue($val);
            if(is_scalar($value)) {
                $values[]   =  $value;
                $fields[]     =  $this->parseKey($key);
            }
        }
        $sql   =  ($replace?'REPLACE ':'INSERT ').$this->parseAttr($options).' INTO '.$this->parseTable($options).' ('.implode(',', $fields).') VALUES ('.implode(',', $values).')';
        return DB::execute($sql);
    }

     public function getLastId() {
        return DB::getLastId();
    }

	/**
	 * 批量插入
	 *
	 * @param unknown_type $datas
	 * @param unknown_type $options
	 * @param unknown_type $replace
	 * @return unknown
	 */
    public function insertAll($datas,$options=array(),$replace=false) {
        if(!is_array($datas[0])) return false;
        $fields = array_keys($datas[0]);
        array_walk($fields, array($this, 'parseKey'));
        $values  =  array();
        foreach ($datas as $data){
            $value   =  array();
            foreach ($data as $key=>$val){
                $val   =  $this->parseValue($val);
                if(is_scalar($val)) {
                    $value[]   =  $val;
                }
            }
            $values[]    = '('.implode(',', $value).')';
        }
        $sql   =  ($replace?'REPLACE':'INSERT').' INTO '.$this->parseTable($options).' ('.implode(',', $fields).') VALUES '.implode(',',$values);
        return DB::execute($sql);
    }

    protected function parseOrder($order) {
        if(is_array($order)) {
            $array   =  array();
            foreach ($order as $key=>$val){
                if(is_numeric($key)) {
                    $array[] =  $this->parseKey($val);
                }else{
                    $array[] =  $this->parseKey($key).' '.$val;
                }
            }
            $order   =  implode(',',$array);
        }
        return !empty($order)?  ' ORDER BY '.$order:'';
    }

    protected function parseGroup($group) {
        return !empty($group)? ' GROUP BY '.$group:'';
    }

    protected function parseHaving($having) {
        return  !empty($having)?   ' HAVING '.$having:'';
    }

    protected function parseDistinct($distinct) {
        return !empty($distinct)?   ' DISTINCT '.$distinct.',' :'';
    }

    protected function parseSet($data) {
        foreach ($data as $key=>$val){
            $value   =  $this->parseValue($val);
            if(is_scalar($value))
                $set[]    = $this->parseKey($key).'='.$value;
        }
        return ' SET '.implode(',',$set);
    }

    public function escapeString($str) {
    	$str = addslashes(stripslashes($str));//重新加斜线，防止从数据库直接读取出错
        return $str;
    }

    protected function parseKey(&$key) {
        return $key;
    }

    public function checkActive($host) {
    	Db::ping($host);
    }
}
?>
