<?php
/**
 * 手机端首页
 *
 * 
 *
 *
 */

defined('InShopNC') or exit('Access Invalid!');

class mb_homeModel extends Model{
    public function __construct() {
        parent::__construct('mb_home');
    }

	/**
	 * 列表
	 *
	 * @param array $condition 查询条件
	 * @param int $page 分页数
	 * @param string $order 排序
	 * @param string $field 字段
     * @return array
	 */
	public function getMbHomeList($condition, $page = null, $order = 'h_type asc', $field = '*') {
        $h_list = $this->field($field)->where($condition)->page($page)->order($order)->select();

		//整理图片链接
		if (is_array($h_list)){
			foreach ($h_list as $k => $v){
				if (!empty($v['h_img'])){
					$h_list[$k]['h_img_url'] = UPLOAD_SITE_URL.'/'.ATTACH_MOBILE.'/home'.'/'.$v['h_img'];
				}
			}
		}

		return $h_list;
	}

	/**
	 * 取单个内容
	 *
	 * @param int $id ID
	 * @return array 数组类型的返回结果
	 */
	public function getMbHomeInfoByID($id){
		if (intval($id) > 0){
            $condition = array('h_id' => $id);
            $result = $this->where($condition)->find();
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @param array $condition 条件
	 * @return bool 布尔类型的返回结果
	 */
	public function editMbHome($param, $condition){
        return $this->where($condition)->update($param);
	}	
}
