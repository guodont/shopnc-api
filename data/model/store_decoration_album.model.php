<?php
/**
 * 店铺装修相册模型
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class store_decoration_albumModel extends Model {
    public function __construct(){
        parent::__construct('store_decoration_album');
    }

	/**
	 * 列表
     *
	 * @param array $condition 查询条件
	 * @param int $page 分页数
	 * @param string $order 排序
     * @return array
	 */
    public function getStoreDecorationAlbumList($condition, $page = 24, $order = 'upload_time desc') {
        $list = $this->where($condition)->order($order)->page($page)->select();

        //获取图片url并格式化上传时间
        foreach ($list as $key => $value) {
            $list[$key]['image_url'] = getStoreDecorationImageUrl($value['image_name'], $value['store_id']);
            $list[$key]['upload_time_format'] = date('Y-m-d', $value['upload_time']);
        }

        return $list;
    }

    /**
	 * 查询
     *
	 * @param array $condition 查询条件
     * @return array
	 */
    public function getStoreDecorationAlbumInfo($condition) {
        $info = $this->where($condition)->find();
        return $info;
    }

	/*
	 * 添加
     *
	 * @param array $param 信息
	 * @return bool
	 */
    public function addStoreDecorationAlbum($param){
        return $this->insert($param);
    }

	/*
	 * 删除相册图片
     *
	 * @param array $condition 条件
	 * @return bool
	 */
    public function delStoreDecorationAlbum($condition){
        $image_info = $this->getStoreDecorationAlbumInfo($condition);
        if(!empty($image_info)) {
            //删除图片
            $image_file = BASE_UPLOAD_PATH . DS . ATTACH_STORE_DECORATION . DS . $image_info['store_id'] . DS . $image_info['image_name']; 
            if(is_file($image_file)) {
                @unlink($image_file);
            }
            return $this->where($condition)->delete();
        } else {
            return false;
        }
    }
}
