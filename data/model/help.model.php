<?php
/**
 * 帮助模型
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class helpModel extends Model{

    public function __construct() {
        parent::__construct();
    }

	/**
	 * 增加帮助类型
	 *
	 * @param
	 * @return int
	 */
	public function addHelpType($type_array) {
		$type_id = $this->table('help_type')->insert($type_array);
		return $type_id;
	}

	/**
	 * 增加帮助
	 *
	 * @param
	 * @return int
	 */
	public function addHelp($help_array, $upload_ids = array()) {
		$help_id = $this->table('help')->insert($help_array);
		if ($help_id && !empty($upload_ids)) {
		    $this->editHelpPic($help_id, $upload_ids);//更新帮助图片
		}
		return $help_id;
	}

	/**
	 * 删除帮助类型记录
	 *
	 * @param
	 * @return bool
	 */
	public function delHelpType($condition) {
		if (empty($condition)) {
			return false;
		} else {
		    $condition['help_code'] = 'auto';//只有auto的可删除
			$result = $this->table('help_type')->where($condition)->delete();
			return $result;
		}
	}

	/**
	 * 删除帮助记录
	 *
	 * @param
	 * @return bool
	 */
	public function delHelp($condition, $help_ids = array()) {
		if (empty($condition)) {
			return false;
		} else {
			$result = $this->table('help')->where($condition)->delete();
			if ($result && !empty($help_ids)) {
			    $condition = array();
			    $condition['item_id'] = array('in', $help_ids);
			    $this->delHelpPic($condition);//删除帮助中所用的图片
			}
			return $result;
		}
	}

	/**
	 * 删除帮助图片
	 *
	 * @param
	 * @return bool
	 */
	public function delHelpPic($condition) {
		if (empty($condition)) {
			return false;
		} else {
		    $upload_list = $this->getHelpPicList($condition);
		    if (!empty($upload_list) && is_array($upload_list)) {
		        foreach ($upload_list as $key => $value) {
		            @unlink(BASE_UPLOAD_PATH.DS.ATTACH_ARTICLE.DS.$value['file_name']);
		        }
		    }
		    $result = $this->table('upload')->where($condition)->delete();
		    return $result;
		}
	}

	/**
	 * 修改帮助类型记录
	 *
	 * @param
	 * @return bool
	 */
	public function editHelpType($condition, $data) {
		if (empty($condition)) {
			return false;
		}
		if (is_array($data)) {
			$result = $this->table('help_type')->where($condition)->update($data);
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * 修改帮助记录
	 *
	 * @param
	 * @return bool
	 */
	public function editHelp($condition, $data) {
		if (empty($condition)) {
			return false;
		}
		if (is_array($data)) {
			$result = $this->table('help')->where($condition)->update($data);
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * 更新帮助图片
	 *
	 * @param
	 * @return bool
	 */
	public function editHelpPic($help_id, $upload_ids = array()) {
		if ($help_id && !empty($upload_ids)) {
		    $condition = array();
		    $data = array();
		    $condition['upload_id'] = array('in', $upload_ids);
		    $condition['upload_type'] = '2';
		    $condition['item_id'] = '0';
		    $data['item_id'] = $help_id;
		    $result = $this->table('upload')->where($condition)->update($data);
		    return $result;
		} else {
			return false;
		}
	}

	/**
	 * 帮助类型记录
	 *
	 * @param
	 * @return array
	 */
    public function getHelpTypeList($condition = array(), $page = '', $limit = '', $fields = '*') {
		$result = $this->table('help_type')->field($fields)->where($condition)->page($page)->limit($limit)->order('type_sort asc,type_id desc')->select();
		return $result;
    }

	/**
	 * 帮助记录
	 *
	 * @param
	 * @return array
	 */
    public function getHelpList($condition = array(), $page = '', $limit = '', $fields = '*') {
		$result = $this->table('help')->field($fields)->where($condition)->page($page)->limit($limit)->order('help_sort asc,help_id desc')->select();
		return $result;
    }

	/**
	 * 帮助图片记录
	 *
	 * @param
	 * @return array
	 */
    public function getHelpPicList($condition = array()) {
		$condition['upload_type'] = '2';//帮助内容图片
		$result = $this->table('upload')->where($condition)->select();
		return $result;
    }

	/**
	 * 店铺页面帮助类型记录
	 *
	 * @param
	 * @return array
	 */
    public function getStoreHelpTypeList($condition = array(), $page = '', $limit = 0) {
        $condition['page_show'] = '1';//页面类型:1为店铺,2为会员
		$result = $this->table('help_type')->where($condition)->page($page)->limit($limit)->order('type_sort asc,type_id desc')->key('type_id')->select();
		return $result;
    }

	/**
	 * 店铺页面帮助记录
	 *
	 * @param
	 * @return array
	 */
    public function getStoreHelpList($condition = array(), $page = '') {
        $condition['page_show'] = '1';//页面类型:1为店铺,2为会员
		$result = $this->getHelpList($condition, $page);
		return $result;
    }

	/**
	 * 前台商家帮助显示数据
	 *
	 * @param
	 * @return array
	 */
    public function getShowStoreHelpList($condition = array()) {
	    $list = array();
	    $help_list = array();//帮助内容
	    $condition['help_show'] = '1';//是否显示,0为否,1为是
	    $list = $this->getStoreHelpTypeList($condition);//帮助类型
	    if (!empty($list) && is_array($list)) {
	        $type_ids = array_keys($list);//类型编号数组
	        $condition = array();
	        $condition['type_id'] = array('in', $type_ids);
	        $help_list = $this->getStoreHelpList($condition);
	        if (!empty($help_list) && is_array($help_list)) {
	            foreach ($help_list as $key => $value) {
	                $type_id = $value['type_id'];//类型编号
	                $help_id = $value['help_id'];//帮助编号
	                $list[$type_id]['help_list'][$help_id] = $value;
	            }
	        }
	    }
		return $list;
    }
}