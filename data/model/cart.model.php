<?php
/**
 * 购物车模型
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class cartModel extends Model {

    /**
     * 购物车商品总金额
     */
    private $cart_all_price = 0;

    /**
     * 购物车商品总数
     */
    private $cart_goods_num = 0;

    public function __construct() {
       parent::__construct('cart');
    }

    /**
     * 取属性值魔术方法
     *
     * @param string $name
     */
    public function __get($name) {
        return $this->$name;
    }

	/**
	 * 检查购物车内商品是否存在
	 *
	 * @param
	 */
	public function checkCart($condition = array()) {
	    return $this->where($condition)->find();
	}

	/**
	 * 取得 单条购物车信息
	 * @param unknown $condition
	 * @param string $field
	 */
	public function getCartInfo($condition = array(), $field = '*') {
	   return $this->field($field)->where($condition)->find();
	}

	/**
	 * 将商品添加到购物车中
	 *
	 * @param array	$data	商品数据信息
	 * @param string $save_type 保存类型，可选值 db,cookie
	 * @param int $quantity 购物数量
	 */
	public function addCart($data = array(), $save_type = '', $quantity = null) {
        $method = '_addCart'.ucfirst($save_type);
	    $insert = $this->$method($data,$quantity);
	    //更改购物车总商品数和总金额，传递数组参数只是给DB使用
	    $this->getCartNum($save_type,array('buyer_id'=>$data['buyer_id']));
	    return $insert;
	}

	/**
	 * 添加数据库购物车
	 *
	 * @param unknown_type $goods_info
	 * @param unknown_type $quantity
	 * @return unknown
	 */
	private function _addCartDb($goods_info = array(),$quantity) {
	    //验证购物车商品是否已经存在
	    $condition = array();
	    $condition['goods_id'] = $goods_info['goods_id'];
	    $condition['buyer_id'] = $goods_info['buyer_id'];
	    if (isset($goods_info['bl_id'])) {
	        $condition['bl_id'] = $goods_info['bl_id'];
	    } else {
	        $condition['bl_id'] = 0;
	    }
    	$check_cart	= $this->checkCart($condition);
    	if (!empty($check_cart)) return true;

		$array    = array();
		$array['buyer_id']	= $goods_info['buyer_id'];
		$array['store_id']	= $goods_info['store_id'];
		$array['goods_id']	= $goods_info['goods_id'];
		$array['goods_name'] = $goods_info['goods_name'];
		$array['goods_price'] = $goods_info['goods_price'];
		$array['goods_num']   = $quantity;
		$array['goods_image'] = $goods_info['goods_image'];
		$array['store_name'] = $goods_info['store_name'];
		$array['bl_id'] = isset($goods_info['bl_id']) ? $goods_info['bl_id'] : 0;
		return $this->insert($array);
	}

	/**
	 * 添加到cookie购物车,最多保存5个商品
	 *
	 * @param unknown_type $goods_info
	 * @param unknown_type $quantity
	 * @return unknown
	 */
	private function _addCartCookie($goods_info = array(), $quantity = null) {
    	//去除斜杠
    	$cart_str = get_magic_quotes_gpc() ? stripslashes(cookie('cart')) : cookie('cart');
    	$cart_str = base64_decode(decrypt($cart_str));
    	$cart_array = @unserialize($cart_str);
    	$cart_array = !is_array($cart_array) ? array() : $cart_array;
    	if (count($cart_array) >= 5) return false;

    	if (in_array($goods_info['goods_id'],array_keys($cart_array))) return true;
		$cart_array[$goods_info['goods_id']] = array(
		  'store_id' => $goods_info['store_id'],
		  'goods_id' => $goods_info['goods_id'],
		  'goods_name' => $goods_info['goods_name'],
		  'goods_price' => $goods_info['goods_price'],
		  'goods_image' => $goods_info['goods_image'],
		  'goods_num' => $quantity
		);
		setNcCookie('cart',encrypt(base64_encode(serialize($cart_array))),24*3600);
		return true;
	}

	/**
	 * 更新购物车
	 *
	 * @param	array	$param 商品信息
	 */
	public function editCart($data,$condition) {
		$result	= $this->where($condition)->update($data);
		if ($result) {
		    $this->getCartNum('db',array('buyer_id'=>$condition['buyer_id']));
		}
		return $result;
	}

	/**
	 * 购物车列表
	 *
	 * @param string $type 存储类型 db,cookie
	 * @param unknown_type $condition
	 * @param int $limit
	 */
	public function listCart($type, $condition = array(), $limit = '') {
        if ($type == 'db') {
    		$cart_list = $this->where($condition)->limit($limit)->select();
        } elseif ($type == 'cookie') {
        	//去除斜杠
        	$cart_str = get_magic_quotes_gpc() ? stripslashes(cookie('cart')) : cookie('cart');
        	$cart_str = base64_decode(decrypt($cart_str));
        	$cart_list = @unserialize($cart_str);
        }
        $cart_list = is_array($cart_list) ? $cart_list : array();
        //顺便设置购物车商品数和总金额
		$this->cart_goods_num =  count($cart_list);
	    $cart_all_price = 0;
		if(is_array($cart_list)) {
			foreach ($cart_list as $val) {
				$cart_all_price	+= $val['goods_price'] * $val['goods_num'];
			}
		}
        $this->cart_all_price = ncPriceFormat($cart_all_price);
		return !is_array($cart_list) ? array() : $cart_list;
	}

	/**
	 * 删除购物车商品
	 *
	 * @param string $type 存储类型 db,cookie
	 * @param unknown_type $condition
	 */
	public function delCart($type, $condition = array()) {
	    if ($type == 'db') {
    		$result =  $this->where($condition)->delete();
	    } elseif ($type == 'cookie') {
        	$cart_str = get_magic_quotes_gpc() ? stripslashes(cookie('cart')) : cookie('cart');
        	$cart_str = base64_decode(decrypt($cart_str));
        	$cart_array = @unserialize($cart_str);
            if (key_exists($condition['goods_id'],(array)$cart_array)) {
                unset($cart_array[$condition['goods_id']]);
            }
            setNcCookie('cart',encrypt(base64_encode(serialize($cart_array))),24*3600);
            $result = true;
	    }
	    //重新计算购物车商品数和总金额
		if ($result) {
		    $this->getCartNum($type,array('buyer_id'=>$condition['buyer_id']));
		}
		return $result;
	}

	/**
	 * 清空购物车
	 *
	 * @param string $type 存储类型 db,cookie
	 * @param unknown_type $condition
	 */
	public function clearCart($type, $condition = array()) {
	    if ($type == 'cookie') {
            setNcCookie('cart','',-3600);
	    } else if ($type == 'db') {
	        //数据库暂无浅清空操作
	    }
	}

	/**
	 * 计算购物车总商品数和总金额
	 * @param string $type 购物车信息保存类型 db,cookie
	 * @param array $condition 只有登录后操作购物车表时才会用到该参数
	 */
	public function getCartNum($type, $condition = array()) {
	    if ($type == 'db') {
    	    $cart_all_price = 0;
    		$cart_goods	= $this->listCart('db',$condition);
    		$this->cart_goods_num = count($cart_goods);
    		if(!empty($cart_goods) && is_array($cart_goods)) {
    			foreach ($cart_goods as $val) {
    				$cart_all_price	+= $val['goods_price'] * $val['goods_num'];
    			}
    		}
		  $this->cart_all_price = ncPriceFormat($cart_all_price);
	    } elseif ($type == 'cookie') {
        	$cart_str = get_magic_quotes_gpc() ? stripslashes(cookie('cart')) : cookie('cart');
        	$cart_str = base64_decode(decrypt($cart_str));
        	$cart_array = @unserialize($cart_str);
        	$cart_array = !is_array($cart_array) ? array() : $cart_array;
    		$this->cart_goods_num = count($cart_array);
    		$cart_all_price = 0;
    		foreach ($cart_array as $v){
    			$cart_all_price += floatval($v['goods_price'])*intval($v['goods_num']);
    		}
    		$this->cart_all_price = $cart_all_price;
	    }
	    @setNcCookie('cart_goods_num',$this->cart_goods_num,2*3600);
	    return $this->cart_goods_num;
	}

    /**
     * 登录之后,把登录前购物车内的商品加到购物车表
     *
     */
    public function mergecart($member_info = array(), $store_id = null){
        if (!$member_info['member_id']) return;
        // $save_type = C('cache.type') != 'file' ? 'cache' : 'cookie';
        $save_type = 'cookie';
        $cart_new_list = $this->listCart($save_type);
        if (empty($cart_new_list)) return;

        //取出当前DB购物车已有信息
        $cart_cur_list = $this->listCart('db',array('buyer_id'=>$member_info['member_id']));

        //数据库购物车已经有的商品，不再添加
        if (!empty($cart_cur_list) && is_array($cart_cur_list) && is_array($cart_new_list)) {
            foreach ($cart_new_list as $k=>$v){
                if (!is_numeric($k) || in_array($k,array_keys($cart_cur_list))){
                    unset($cart_new_list[$k]);
                }
            }
        }

        //查询在购物车中,不是店铺自己的商品，未禁售，上架，有库存的商品,并加入DB购物车
        $model_goods = Model('goods');
        $condition = array();
        if (!empty($_SESSION['store_id'])) {
            $condition['store_id'] = array('neq',$store_id);
        }
        $condition['goods_id'] = array('in',array_keys($cart_new_list));
        $goods_list = $model_goods->getGoodsOnlineList($condition);
        if (!empty($goods_list)){
            foreach ($goods_list as $goods_info){
                $goods_info['buyer_id']	= $member_info['member_id'];
                $this->addCart($goods_info,'db',$cart_new_list[$goods_info['goods_id']]['goods_num']);
            }
        }
        //最后清空登录前购物车内容
        $this->clearCart($save_type);
    }
}
