<?php
/**
 * 页面模块
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class web_configModel extends Model{
	/**
	 * 读取模块内容记录
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getCodeRow($code_id,$web_id){
		$param = array();
		$param['code_id']	= $code_id;
		$param['web_id']	= $web_id;
		$result	= $this->table('web_code')->where($param)->find();
		return $result;
	}

	/**
	 * 读取模块内容记录列表
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getCodeList($condition = array()){
		$result = $this->table('web_code')->where($condition)->order('web_id')->select();
		return $result;
	}

	/**
	 * 更新模块内容信息
	 *
	 * @param
	 * @return bool 布尔类型的返回结果
	 */
	public function updateCode($condition,$data){
		$code_id = $condition['code_id'];
		if (intval($code_id) < 1){
			return false;
		}
		if (is_array($data)){
			$result = $this->table('web_code')->where($condition)->update($data);
			return $result;
		} else {
			return false;
		}
	}
	/**
	 * 读取记录列表
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getWebList($condition = array('web_page' => 'index'),$page = ''){
		$result = $this->table('web')->where($condition)->order('web_sort')->page($page)->select();
		return $result;
	}

	/**
	 * 更新模块信息
	 *
	 * @param
	 * @return bool 布尔类型的返回结果
	 */
	public function updateWeb($condition,$data){
		$web_id = $condition['web_id'];
		if (intval($web_id) < 1){
			return false;
		}
		if (is_array($data)){
			$result = $this->table('web')->where($condition)->update($data);
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * 更新模块html信息
	 *
	 */
	public function updateWebHtml($web_id = 1,$style_name = 'orange'){
		$web_html = '';
		$code_list = $this->getCodeList(array('web_id'=>"$web_id"));
		if(!empty($code_list) && is_array($code_list)) {
			Language::read('web_config,home_index_index');
			$lang = Language::getLangContent();
			$output = array();
			$output['style_name'] = $style_name;
			foreach ($code_list as $key => $val) {
				$var_name = $val['var_name'];
				$code_info = $val['code_info'];
				$code_type = $val['code_type'];
				$val['code_info'] = $this->get_array($code_info,$code_type);
				$output['code_'.$var_name] = $val;
			}
    		switch ($web_id) {
        	    case 101:
        	        $style_file = BASE_DATA_PATH.DS.'resource'.DS.'web_config'.DS.'focus.php';
        	    	break;
        	    case 121:
        	    	$style_file = BASE_DATA_PATH.DS.'resource'.DS.'web_config'.DS.'sale_goods.php';
        	    	break;
        	    default:
        	    	$style_file = BASE_DATA_PATH.DS.'resource'.DS.'web_config'.DS.'default.php';
        	    	break;
    		}
			if (file_exists($style_file)) {
				ob_start();
                include $style_file;
                $web_html = ob_get_contents();
                ob_end_clean();
			}
			$web_array = array();
			$web_array['web_html'] = addslashes($web_html);
			$web_array['update_time'] = time();
			$this->updateWeb(array('web_id'=>$web_id),$web_array);
		}
		return $web_html;
	}
	/**
	 * 模块html信息
	 *
	 */
	public function getWebHtml($web_page = 'index',$update_all = 0){
		$web_array = array();
		$web_list = $this->getWebList(array('web_show'=>1,'web_page'=> array('like',$web_page.'%')));
		if(!empty($web_list) && is_array($web_list)) {
			foreach($web_list as $k => $v){
			    $key = $v['web_page'];
				if ($update_all == 1 || empty($v['web_html'])) {//强制更新或内容为空时查询数据库
					$web_array[$key] .= $this->updateWebHtml($v['web_id'],$v['style_name']);
				} else {
					$web_array[$key] .= $v['web_html'];
				}
			}
		}
		return $web_array;
	}

	/**
	 * 读取广告位记录列表
	 *
	 */
	public function getAdvList($type = 'screen'){
		$condition = array();
		$condition['screen'] = array(
			'ap_class' => '0',//图片
			'is_use' => '1',//启用
			'ap_width' => '1920',//宽度
			'ap_height' => '481'//高度
			);
		$condition['focus'] = array(
			'ap_class' => '0',//图片
			'is_use' => '1',//启用
			'ap_width' => '259',//宽度
			'ap_height' => '180'//高度
			);

		$result = $this->table('adv_position')->where($condition[$type])->order('ap_id desc')->select();
		return $result;
	}

	/**
	 * 主题样式名称
	 *
	 */
	public function getStyleList($style_id = 'index'){
		$style_data = array(
			'red' => Language::get('web_config_style_red'),
			'pink' => Language::get('web_config_style_pink'),
			'orange' => Language::get('web_config_style_orange'),
			'green' => Language::get('web_config_style_green'),
			'blue' => Language::get('web_config_style_blue'),
			'purple' => Language::get('web_config_style_purple'),
			'brown' => Language::get('web_config_style_brown'),
			'default' => Language::get('web_config_style_default')
			);
		$result['index']	= $style_data;
		return $result[$style_id];
	}

	/**
	 * 转换字符串
	 */
	public function get_array($code_info,$code_type){
		$data = '';
		switch ($code_type) {
    	    case "array":
    	    	if(is_string($code_info)) $code_info = unserialize($code_info);
    	    	if(!is_array($code_info)) $code_info = array();
    	    	$data = $code_info;
    	      break;
    	    case "html":
    	    	if(!is_string($code_info)) $code_info = '';
    	    	$data = $code_info;
    	    	break;
    	    default:
    	    	$data = '';
    	    	break;
		}
		return $data;
	}

	/**
	 * 转换数组
	 */
	public function get_str($code_info,$code_type){
		$str = '';
		switch ($code_type) {
    	    case "array":
    	    	if(!is_array($code_info)) $code_info = array();
    	    	$code_info = $this->stripslashes_deep($code_info);
    	    	$str = serialize($code_info);
    	    	$str = addslashes($str);
    	      break;
    	    case "html":
    	    	if(!is_string($code_info)) $code_info = '';
    	    	$str = $code_info;
    	    	break;
    	    default:
    	    	$str = '';
    	    	break;
		}
		return $str;
	}
	/**
	 * 递归去斜线
	 */
	public function stripslashes_deep($value){
		$value = is_array($value) ? array_map(array($this,'stripslashes_deep'), $value) : stripslashes($value);
		return $value;
	}

	/**
	 * 商品列表，价格以促销价显示
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getGoodsList($condition = array(),$order = 'goods_id desc',$page = ''){
	    $list = array();
	    $model_goods = Model('goods');
	    $field = 'goods_id,goods_commonid,goods_name,goods_image,goods_price,goods_marketprice';
	    $goods_list = $model_goods->getGoodsListByColorDistinct($condition,$field,$order,$page);
	    if (!empty($goods_list) && is_array($goods_list)) {
	        $goods_commonlist = array();//商品公共ID关联商品ID数组
	        foreach ($goods_list as $key => $value) {
	            $goods_id = $value['goods_id'];
	            $goods_commonid = $value['goods_commonid'];
	            $goods_commonlist[$goods_commonid][] = $goods_id;
	            $value['goods_type'] = 1;
	            $list[$goods_id] = $value;
	        }
	        $goods_ids = array_keys($list);//商品ID数组
	        if (C('promotion_allow')) {//限时折扣
	            $xianshi_list = Model('p_xianshi_goods')->getXianshiGoodsListByGoodsString(implode(',', $goods_ids));
    	        if (!empty($xianshi_list) && is_array($xianshi_list)) {
    	            foreach ($xianshi_list as $key => $value) {
    	                $goods_id = $value['goods_id'];
    	                $goods_price = $value['xianshi_price'];
    	                $list[$goods_id]['goods_price'] = $goods_price;
    	                $list[$goods_id]['goods_type'] = 3;
    	            }
    	        }
	        }
	        $common_ids = array_keys($goods_commonlist);//商品公共ID数组
	        if (C('groupbuy_allow')) {//最终以抢购价为准
	            $groupbuy_list = Model('groupbuy')->getGroupbuyListByGoodsCommonIDString(implode(',', $common_ids));
    	        if (!empty($groupbuy_list) && is_array($groupbuy_list)) {
    	            foreach ($groupbuy_list as $key => $value) {
    	                $goods_commonid = $value['goods_commonid'];
    	                $goods_price = $value['groupbuy_price'];
    	                foreach ($goods_commonlist[$goods_commonid] as $k => $v) {
    	                    $goods_id = $v;
    	                    $list[$goods_id]['goods_price'] = $goods_price;
    	                    $list[$goods_id]['goods_type'] = 2;
    	                }
    	            }
    	        }
	        }
	    }
	    return $list;
	}

	/**
	 * 更新商品价格信息
	 *
	 */
	public function updateWebGoods($condition = array('web_show' => '1')){
		$web_style_array = array();
		$web_list = $this->getWebList($condition);//板块列表
		if(!empty($web_list) && is_array($web_list)) {
			foreach($web_list as $k => $v){
			    $web_id = $v['web_id'];
				$web_style_array[$web_id] = $v['style_name'];
			}
			$goods_ids = array();//商品ID数组
	        $condition = array();
	        $condition['web_id'] = array('in', array_keys($web_style_array));
	        $condition['var_name'] = array('in', array('recommend_list','sale_list'));
			$code_list = $this->getCodeList($condition);//有商品内容记录列表
			if(!empty($code_list) && is_array($code_list)) {
			    $update_list = array();
    			foreach ($code_list as $key => $val) {
    				$code_id = $val['code_id'];
    				$code_info = $val['code_info'];
    				$code_type = $val['code_type'];
    				$val['code_info'] = $this->get_array($code_info,$code_type);//输出变量数组
        	        $recommend_list = $val['code_info'];
        	        if (!empty($recommend_list) && is_array($recommend_list)) {
        	            foreach ($recommend_list as $k => $v) {
        	                if (!empty($v['goods_list']) && is_array($v['goods_list'])) {//商品列表
        	                    $goods_id_array = array_keys($v['goods_list']);//商品ID
        	                    $goods_ids = array_merge($goods_ids, $goods_id_array);
        	                    $update_list[$code_id] = $val;
        	                }
        	            }
        	        }
    			}
    			if (!empty($goods_ids) && is_array($goods_ids)) {
    			    $condition = array();
    			    $condition['goods_id'] = array('in', $goods_ids);
    			    $goods_list = $this->getGoodsList($condition);//最新商品
    			}
    			foreach ($update_list as $key => $val) {
    				$update = 0;//商品价格是否有变化
        	        foreach ($val['code_info'] as $k => $v) {
        	            if (!empty($v['goods_list']) && is_array($v['goods_list'])) {
            	            foreach ($v['goods_list'] as $k3 => $v3) {//单个商品
            	                $goods_id = $v3['goods_id'];
            	                $goods_price = $v3['goods_price'];
            	                if (!empty($goods_list[$goods_id]) && ($goods_list[$goods_id]['goods_price'] != $goods_price)) {
            	                    $val['code_info'][$k]['goods_list'][$goods_id]['goods_price'] = $goods_list[$goods_id]['goods_price'];
            	                    $update++;
            	                }
            	            }
        	            }
        	        }
        	        if ($update > 0) {//更新对应内容
        				$code_id = $val['code_id'];
        				$web_id = $val['web_id'];
        	            $code_type = $val['code_type'];
        	            $code_info = $this->get_str($val['code_info'],$code_type);
        	            $this->updateCode(array('code_id'=> $code_id),array('code_info'=> $code_info));
        	            $this->updateWebHtml($web_id,$web_style_array[$web_id]);
        	        }
    			}
			}
		}
	}

}
