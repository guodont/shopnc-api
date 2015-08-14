<?php
/**
 * 手机端广告
 *
 * 
 *
 *
 */

defined('InShopNC') or exit('Access Invalid!');

class mb_adModel extends Model{
    public function __construct(){
        parent::__construct('mb_ad');
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
	public function getMbAdList($condition, $page = null, $order = 'link_id asc', $field = '*'){
        $link_list = $this->field($field)->where($condition)->page($page)->order($order)->select();

		//整理图片链接
		if (is_array($link_list)){
			foreach ($link_list as $k => $v){
				if (!empty($v['link_pic'])){
					$link_list[$k]['link_pic_url'] = UPLOAD_SITE_URL.'/'.ATTACH_MOBILE.'/ad'.'/'.$v['link_pic'];
				}
			}
		}

		return $link_list;
	}

	/**
	 * 取单个内容
	 *
	 * @param int $id ID
	 * @return array 数组类型的返回结果
	 */
	public function getMbAdInfoByID($id){
		if (intval($id) > 0){
            $condition = array('link_id' => $id);
            $result = $this->where($condition)->find();
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 取单个内容
	 *
	 * @param int $id ID
	 * @return array 数组类型的返回结果
	 */
	public function getMbAdCount(){
		return Db::getCount('mb_ad');
	}
	/**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function addMbAd($param){
        return $this->insert($param);	
	}
	
	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @param array $condition 条件
	 * @return bool 布尔类型的返回结果
	 */
	public function editMbAd($param, $condition){
        return $this->where($condition)->update($param);
	}
	
	/**
	 * 删除
	 *
	 * @param int $id 记录ID
	 * @return bool 布尔类型的返回结果
	 */
	public function delMbAd($id){
		if (intval($id) > 0){
            //删除图片
			$tmp = $this->getMbAdInfoByID($id);
			if (!empty($tmp['link_pic'])){
				@unlink(BASE_ROOT_PATH.DS.DIR_UPLOAD.DS.ATTACH_MOBILE.'/ad/'.$tmp['link_pic']);
			}

            $condition = array('link_id' => $id);
            return $this->where($condition)->delete();
        } else {
            return false;
        }
	}	
}
