<?php
/**
 * 积分礼品购物车
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class pointcartModel extends Model {
	/**
	 * 礼品购物车保存
	 *
	 * @param	array $param 资料
	 */
	public function addPointCart($param) {
		if(empty($param)) {
			return false;
		}
		$result = $this->table('points_cart')->insert($param);
		if($result) {
		    //清除相关缓存
		    wcache($param['pmember_id'], array('pointcart_count' => null), 'm_pointcart');
			return $result;
		} else {
			return false;
		}
	}
	/**
	 * 兑换礼品购物车列表
	 */
	public function getPointCartList($where, $field = '*', $page = 0, $limit = 0, $order = '', $group = ''){
	    if (is_array($page)){
	        if ($page[1] > 0){
	            $cartgoods_list = $this->table('points_cart')->field($field)->where($where)->page($page[0],$page[1])->limit($limit)->group($group)->order($order)->select();
	        } else {
	            $cartgoods_list = $this->table('points_cart')->field($field)->where($where)->page($page[0])->limit($limit)->group($group)->order($order)->select();
	        }
	    } else {
	        $cartgoods_list = $this->table('points_cart')->field($field)->where($where)->page($page)->limit($limit)->group($group)->order($order)->select();
	    }
	    if ($cartgoods_list){
	        foreach ($cartgoods_list as $k=>$v){
	            $v['pgoods_image_old'] = $v['pgoods_image'];
	            $v['pgoods_image_max'] = pointprodThumb($v['pgoods_image']);
	            $v['pgoods_image_small'] = pointprodThumb($v['pgoods_image'], 'small');
	            $v['pgoods_image'] = pointprodThumb($v['pgoods_image'], 'mid');
	            $cartgoods_list[$k] = $v;
	        }
	    }
	    return $cartgoods_list;
	}
	
	/**
	 * 查询兑换礼品购物车列表并计算总积分
	 */
	public function getPCartListAndAmount($where, $field = '*', $page = 0, $limit = 0, $order = '', $group = ''){
	    $cartgoods_list = $this->getPointCartList($where);
	    //兑换礼品总积分
	    $cartgoods_pointall = 0;
	    if(!empty($cartgoods_list) && is_array($cartgoods_list)) {
	        foreach ($cartgoods_list as $k=>$v) {
	            $v['pgoods_pointone'] = intval($v['pgoods_points']) * intval($v['pgoods_choosenum']);
	            $cartgoods_list[$k] = $v;
	            $cartgoods_pointall = $cartgoods_pointall + $v['pgoods_pointone'];
	        }
	    }
	    return array('state'=>true,'data'=>array('cartgoods_list'=>$cartgoods_list,'cartgoods_pointall'=>$cartgoods_pointall));
	}
	
	/**
	 * 礼品购物车信息单条
	 *
	 * @param array $condition 条件数组
	 * @param array $field   查询字段
	 */
	public function getPointCartInfo($where, $field = '*', $order = '', $group = ''){
	    return $this->table('points_cart')->field($field)->where($where)->group($group)->order($order)->find();
	}
	
	/**
	 * 礼品购物车礼品数量
	 *
	 * @param array $member_id 会员ID
	 */
	public function countPointCart($member_id) {
	    $info = rcache($member_id, 'm_pointcart', 'pointcart_count');
	    if (empty($info['pointcart_count']) && $info['pointcart_count'] !== 0) {
	        $pointcart_count = $this->table('points_cart')->where(array('pmember_id'=>$member_id))->count();
	        $pointcart_count = intval($pointcart_count);
	        wcache($member_id, array('pointcart_count' => $pointcart_count), 'm_pointcart');
	    } else {
	        $pointcart_count = intval($info['pointcart_count']);
	    }
	    return $pointcart_count;
	}
	/**
	 * 删除礼品购物车信息按照购物车编号
	 * @param	mixed $pc_id 删除记录编号
	 */
	public function delPointCartById($pc_id,$member_id = 0){
	    if(empty($pc_id)) {
	        return false;
	    }
	    $where = array();
	    if (is_array($pc_id)){
	        $where['pcart_id'] = array('in',$pc_id);
	    }else {
	        $where['pcart_id'] = $pc_id;
	    }
	    $result = $this->table('points_cart')->where($where)->delete();
	    //清除相关缓存
	    if ($result && $member_id > 0){
	        wcache($member_id, array('pointcart_count' => null), 'm_pointcart');
	    }
		return $result;
	}
	/**
	 * 删除特定条件礼品购物车信息
	 * @param	mixed $pc_id 删除记录编号
	 */
	public function delPointCart($where, $member_id = 0){
		$result = $this->table('points_cart')->where($where)->delete();
		//清除相关缓存
		if ($result && $member_id > 0){
		    wcache($member_id, array('pointcart_count' => null), 'm_pointcart');
		}
		return $result;
	}
	/**
	 * 积分礼品购物车信息修改
	 *
	 * @param	array $param 修改信息数组
	 * @param	array $where 条件数组 
	 */
	public function editPointCart($where, $param) {
	    if(empty($param)) {
	        return false;
	    }
	    $result = $this->table('points_cart')->where($where)->update($param);
	    return $result;
	}
	
	/**
	 * 验证是否能兑换
	 */
	public function checkExchange($pgoods_id, $quantity, $member_id){
	    $pgoods_id	= intval($pgoods_id);
	    $quantity	= intval($quantity);
	    if($pgoods_id <= 0 || $quantity <= 0) {
	        return array('state'=>false, 'error'=>'ParameterError', 'msg'=>'参数错误');
	    }
	    $model_pointprod = Model('pointprod');
	    //获取兑换商品的展示状态
	    $pgoodsshowstate_arr = $model_pointprod->getPgoodsShowState();
	    //获取兑换商品的开启状态
	    $pgoodsopenstate_arr = $model_pointprod->getPgoodsOpenState();
	    //验证积分礼品是否存在
	    $prod_info	= $model_pointprod->getPointProdInfo(array('pgoods_id'=>$pgoods_id,'pgoods_show'=>$pgoodsshowstate_arr['show'][0],'pgoods_state'=>$pgoodsopenstate_arr['open'][0]));
	    if (!$prod_info){
	        return array('state'=>false, 'error'=>'ParameterError', 'msg'=>'兑换礼品信息不存在');
	    }
	    
	    //验证积分礼品兑换状态
	    $ex_state = $model_pointprod->getPointProdExstate($prod_info);
	    switch ($ex_state){
	    	case 'willbe':
	    	    return array('state'=>false, 'error'=>'StateError', 'msg'=>'该兑换礼品的兑换活动即将开始');
	    	    break;
	    	case 'end':
	    	    return array('state'=>false, 'error'=>'StateError', 'msg'=>'该兑换礼品的兑换活动已经结束');
	    	    break;
	    }
	    
	    //查询会员信息
	    $model_member = Model('member');
	    $member_info = $model_member->getMemberInfoByID($member_id,'member_points,member_exppoints');
	    
	    //验证是否满足会员级别
	    $member_info['member_grade'] = $model_member->getOneMemberGrade($member_info['member_exppoints']);
	    if ($prod_info['pgoods_limitmgrade'] > 0 && $member_info['member_grade']['level'] < $prod_info['pgoods_limitmgrade']){
	        return array('state'=>false, 'error'=>'MemberGradeError', 'msg'=>'您还未达到兑换所需的会员级别，不能进行兑换');
	    }
	    
	    //验证兑换数量是否合法
	    $data = $this->checkPointProdExnum($prod_info,$quantity,$member_id);
	    if (!$data['state']){
	        return array('state'=>false, 'error'=>'StateError', 'msg'=>$data['msg']);
	    }
	    $prod_info['quantity'] = $quantity;
	    //计算消耗积分总数
	    $prod_info['pointsamount'] = intval($prod_info['pgoods_points'])*intval($quantity);
	    
	    //验证积分数是否足够
	    $data = $this->checkPointEnough($prod_info['pointsamount'], $member_id, $member_info);
	    if (!$data['state']){
	        return array('state'=>false, 'error'=>'PointsShortof', 'msg'=>$data['msg']);
	    }
	    return array('state'=>true, 'data'=>array('prod_info'=>$prod_info));
	}
	
	/**
	 * 验证礼品兑换数量是否合法
	 * @param array $prodinfo 礼品数组
	 * @param array $quantity 兑换数量
	 * @param array $member_id 会员编号
	 * return array 兑换数量是否合法及其错误数组
	 */
	public function checkPointProdExnum($prodinfo,$quantity,$member_id){
	    $data = $this->getPointProdExnum($prodinfo, $quantity, $member_id);
	    if (!$data['state']){
	        return array('state'=>false,'msg'=>$data['msg']);
	    }
	    //如果兑换数量大于可兑换数量则提示错误
	    if ($data['data']['quantity'] < $quantity){
	        return array('state'=>false,'msg'=>"兑换礼品数量不能大于{$data['data']['quantity']}");
	    }
	    return array('state'=>true);
	}
	
	/**
	 * 获得礼品可兑换数量
	 * @param array $prodinfo 礼品数组
	 * @param array $quantity 兑换数量
	 * @param array $member_id 会员编号
	 * return array 兑换数量及其错误数组
	 */
	public function getPointProdExnum($prodinfo,$quantity,$member_id){
	    if ($quantity <= 0){
	        return array('state'=>false,'msg'=>'兑换数量错误');
	    }
	    if ($prodinfo['pgoods_storage'] <= 0){
	        return array('state'=>false,'msg'=>'该礼品已兑换完');
	    }
	    if ($prodinfo['pgoods_storage'] < $quantity){
	        //如果兑换数量大于库存，则兑换数量为库存数量
	        $quantity = $prodinfo['pgoods_storage'];
	    }
	    if ($prodinfo['pgoods_islimit'] == 1 && $prodinfo['pgoods_limitnum'] < $quantity ){
	        //如果兑换数量大于限兑数量，则兑换数量为限兑数量
	        $quantity = $prodinfo['pgoods_limitnum'];
	    }
	    //查询已兑换数量，并获得剩余可兑换数量
	    if ($prodinfo['pgoods_islimit'] == 1){
	        $model_pointorder = Model('pointorder');
	        //获取兑换订单状态
	        $pointorderstate_arr = $model_pointorder->getPointOrderStateBySign();
	        $where = array();
	        $where['point_goodsid'] = $prodinfo['pgoods_id'];
	        $where['point_buyerid'] = $member_id;
	        $where['point_orderstate'] = array('neq',$pointorderstate_arr['canceled'][0]);//未取消
	        $pordergoodsinfo = $model_pointorder->getPointOrderAndGoodsInfo($where, "SUM(point_goodsnum) as exnum", '', 'point_goodsid');
	        if ($pordergoodsinfo){
	            $ablenum = $prodinfo['pgoods_limitnum'] - intval($pordergoodsinfo['exnum']);
	            if ($ablenum <= 0){
	                return array('state'=>false,'msg'=>'您已达到该礼品的最大兑换数，不能再兑换，请兑换其他礼品');
	            }
	            if ($ablenum < $quantity){
	                $quantity = $ablenum;
	            }
	        }
	    }
	    return array('state'=>true,'data'=>array('quantity'=>$quantity));
	}
	/**
	 * 获得某会员购物车礼品总积分
	 */
	public function getPointCartAmount($member_id){
	    if ($member_id <= 0){
	    	return array('state'=>false,'msg'=>'参数错误');
	    }
	    $info = $this->getPointCartInfo(array('pmember_id'=>$member_id),'SUM(pgoods_points*pgoods_choosenum) as amount','','pmember_id');
	    $amount = intval($info['amount']);
	    return $amount;
	}
	/**
	 * 获得符合条件的购物车商品列表同时计算运费、总积分数等信息，用于下单过程
	 */
	public function getCartGoodsList($member_id){
	    $return_array = array();
	    //获取礼品购物车内信息
	    $cartgoodslist_tmp = $this->getPointCartList(array('pmember_id'=>$member_id));
	    if(!$cartgoodslist_tmp) {
	        return array('state'=>false,'msg'=>'购物车信息错误');
	    }
	    $cartgoodslist = array();
	    foreach ($cartgoodslist_tmp as $v) {
	        $cartgoodslist[$v['pgoods_id']] = $v;
	    }
	    //购物车礼品ID数组
	    $cartgoodsid_arr = array_keys($cartgoodslist);
	    
	    //查询积分礼品信息
	    $model_pointprod = Model('pointprod');
	    $pointprod_list = $model_pointprod->getOnlinePointProdList(array('pgoods_id'=>array('in',$cartgoodsid_arr)));
	    if (!$pointprod_list){
	        return array('state'=>false,'msg'=>'购物车信息错误');
	    }
	    unset($cartgoodsid_arr);
	    unset($cartgoodslist_tmp);
	    
	    $cart_delid_arr = array();//应删除的购物车信息
	    $pgoods_pointall = 0;//积分总数
	    
	    //查询会员信息
	    $model_member = Model('member');
	    $member_info = $model_member->getMemberInfoByID($_SESSION['member_id']);
	    $member_info['member_grade'] = $model_member->getOneMemberGrade($member_info['member_exppoints']);

	    //处理购物车礼品信息
	    foreach ($pointprod_list as $k=>$v){
	        //验证是否满足会员级别
	        if ($v['pgoods_limitmgrade'] > 0 && $member_info['member_grade']['level'] < $v['pgoods_limitmgrade']){
	            $cart_delid_arr[] = $cartgoodslist[$v['pgoods_id']]['pcart_id'];
	            unset($pointprod_list[$k]);
	            break;
	        }
	        	        
	        //验证积分礼品兑换状态
	        $ex_state = $model_pointprod->getPointProdExstate($v);
	        switch ($ex_state){
	        	case 'going':
	        	    //验证兑换数量是否合法
	        	    $data = $this->getPointProdExnum($v, $cartgoodslist[$v['pgoods_id']]['pgoods_choosenum'], $member_id);
	        	    if (!$data['state']){
	        	        //删除积分礼品兑换信息
	        	        $cart_delid_arr[] = $cartgoodslist[$v['pgoods_id']]['pcart_id'];
	        	        unset($pointprod_list[$k]);
	        	    } else {
	        	        $quantity = $data['data']['quantity'];
	        	        $pointprod_list[$k]['quantity'] = $quantity;
	        	        
	        	        //计算单件礼品积分数
	        	        $pointprod_list[$k]['onepoints'] = $quantity*intval($v['pgoods_points']);

	        	        //计算所有礼品积分数
	        	        $pgoods_pointall = $pgoods_pointall + $pointprod_list[$k]['onepoints'];
	        	        
	        	    }
	        	    break;
	        	default:
	        	    //删除积分礼品兑换信息
	        	    $cart_delid_arr[] = $cartgoodslist[$v['pgoods_id']]['pcart_id'];
	        	    unset($pointprod_list[$k]);
	        	    break;
	        }
	    }
	    
	    //删除不符合条件的礼品购物车信息
	    if (is_array($cart_delid_arr) && count($cart_delid_arr)>0){
	        $this->delPointCartById($cart_delid_arr, $member_id);
	    }
	    if (!$pointprod_list) {
	        return array('state'=>false,'msg'=>'购物车信息错误');
	    }
	    return array('state'=>true,'data'=>array('pointprod_list'=>$pointprod_list,'pgoods_pointall'=>$pgoods_pointall));
	}
	/**
	 * 验证积分是否足够
	 * @param $points int 所需积分
	 * @param $member_id int 会员ID
	 * @param $member_info array 会员详细信息，不必须
	 * @return 积分是否足够 
	 */
	public function checkPointEnough($points, $member_id, $member_info = array()){
	    $points = intval($points);
	    if ($member_id <= 0){
	        return array('state'=>false,'msg'=>'会员信息错误');
	    }
	    if (!$member_info){
	        $member_info = Model('member')->getMemberInfoByID($member_id, 'member_points');
	    }
	    if (intval($member_info['member_points']) < $points){
	        return array('state'=>false,'msg'=>'积分不足，暂时不能兑换');
	    }
	    return array('state'=>true);
	}
}