<?php
/**
 * 代金券模型
 
 */
defined('InShopNC') or exit('Access Invalid!');
class voucherModel extends Model {
    const VOUCHER_STATE_UNUSED = 1;
    const VOUCHER_STATE_USED = 2;
    const VOUCHER_STATE_EXPIRE = 3;

    private $voucher_state_array = array(
        self::VOUCHER_STATE_UNUSED => '未使用',
        self::VOUCHER_STATE_USED => '已使用',
        self::VOUCHER_STATE_EXPIRE => '已过期',
    );

	private $applystate_arr;
    private $quotastate_arr;
    private $templatestate_arr;

	public function __construct(){
		parent::__construct();
		//申请记录状态
		$this->applystate_arr = array('new'=>array(1,Language::get('voucher_applystate_new')),'verify'=>array(2,Language::get('voucher_applystate_verify')),'cancel'=>array(3,Language::get('voucher_applystate_cancel')));
		//套餐状态
		$this->quotastate_arr = array('activity'=>array(1,Language::get('voucher_quotastate_activity')),'cancel'=>array(2,Language::get('voucher_quotastate_cancel')),'expire'=>array(3,Language::get('voucher_quotastate_expire')));
		//代金券模板状态
		$this->templatestate_arr = array('usable'=>array(1,'有效'),'disabled'=>array(2,'失效'));

	}

	/**
	 * 获取代金券模板状态
	 */
	public function getTemplateState(){
		return $this->templatestate_arr;
	}
	/**
	 * 领取的代金券状态
	 */
	public function getVoucherState(){
	    return array('unused'=>array(1,Language::get('voucher_voucher_state_unused')),'used'=>array(2,Language::get('voucher_voucher_state_used')),'expire'=>array(3,Language::get('voucher_voucher_state_expire')));
	}

	/**
	 * 返回当前可用的代金券列表,每种类型(模板)的代金券里取出一个代金券码(同一个模板所有码面额和到期时间都一样)
	 * @param array $condition 条件
	 * @param array $goods_total 商品总金额
	 * @return string
	 */
	public function getCurrentAvailableVoucher($condition = array(), $goods_total = 0) {
	   $condition['voucher_end_date'] = array('gt',TIMESTAMP);
	   $condition['voucher_state'] = 1;
	   $voucher_list = $this->table('voucher')->where($condition)->key('voucher_t_id')->select();
	   foreach ($voucher_list as $key => $voucher) {
	       if ($goods_total < $voucher['voucher_limit']) {
	           unset($voucher_list[$key]);
	       } else {
	           $voucher_list[$key]['desc'] = sprintf('面额%s元 有效期至 %s',$voucher['voucher_price'],date('Y-m-d',$voucher['voucher_end_date']));
	       }
	   }
	   return $voucher_list;
	}

	/**
	 * 取得当前有效代金券数量
	 * @param int $member_id
	 */
	public function getCurrentAvailableVoucherCount($member_id) {
	    $info = rcache($member_id, 'm_voucher', 'voucher_count');
	    if (empty($info['voucher_count']) && $info['voucher_count'] !== 0) {
	        $condition['voucher_owner_id'] = $member_id;
	        $condition['voucher_end_date'] = array('gt',TIMESTAMP);
	        $condition['voucher_state'] = 1;
	        $voucher_count = $this->table('voucher')->where($condition)->count();
	        $voucher_count = intval($voucher_count);
			wcache($member_id, array('voucher_count' => $voucher_count), 'm_voucher');
	    } else {
	        $voucher_count = intval($info['voucher_count']);
	    }
	    return $voucher_count;
	}

	/*
	 * 查询当前可用的套餐
	 */
	public function getCurrentQuota($store_id){
		$store_id = intval($store_id);
		if($store_id <= 0){
			return false;
		}
        $param = array();
        $param['quota_storeid'] = $store_id;
        $param['quota_endtime'] = array('gt', TIMESTAMP);
        $info = $this->table('voucher_quota')->where($param)->find();
        return $info;
	}
	/*
	 * 查询新申请的套餐
	 */
	public function getNewApply($store_id){
		$store_id = intval($store_id);
		if($store_id <= 0){
			return false;
		}
		$new_apply = $this->table('voucher_apply')->where(array('apply_storeid'=>$store_id,'apply_state'=>$this->applystate_arr['new'][0]))->find();
		$newapply_flag = false;
        if(!empty($new_apply)){
        	$newapply_flag = true;
        }
        return $newapply_flag;
	}
	/**
	 * 获得代金券列表
	 */
	public function getVoucherList($where, $field = '*', $limit = 0, $page = 0, $order = '', $group = ''){
	    $voucher_list = array();
	    if (is_array($page)){
	        if ($page[1] > 0){
	            $voucher_list = $this->table('voucher')->field($field)->where($where)->page($page[0],$page[1])->order($order)->group($group)->select();
	        } else {
	            $voucher_list = $this->table('voucher')->field($field)->where($where)->page($page[0])->order($order)->group($group)->select();
	        }
	    } else {
	        $voucher_list = $this->table('voucher')->field($field)->where($where)->page($page)->order($order)->group($group)->select();
	    }
	    return $voucher_list;
	}
	
    public function getVoucherUnusedList($where, $field = '*') {
        $where['voucher_state'] = 1;
        return $this->getVoucherList($where, $field);
    }
	/**
	 * 查询可兑换代金券模板详细信息，包括店铺信息
	 */
	public function getCanChangeTemplateInfo($vid,$member_id,$store_id = 0){
	    if ($vid <= 0 || $member_id <= 0 ){
	        return array('state'=>false,'msg'=>'参数错误');
	    }
	    //查询可用代金券模板
	    $where = array();
	    $where['voucher_t_id'] = $vid;
	    $where['voucher_t_state'] = $this->templatestate_arr['usable'][0];
	    $where['voucher_t_end_date'] = array('gt',time());
	    $template_info = $this->table('voucher_template')->field('*')->where($where)->find();
	    if (empty($template_info) || $template_info['voucher_t_total']<=$template_info['voucher_t_giveout']){//代金券不存在或者已兑换完
	        return array('state'=>false,'msg'=>'代金券信息错误');
	    }
	    //验证是否为店铺自己
	    if ($store_id > 0 && $store_id == $template_info['voucher_t_store_id']){
	        return array('state'=>false,'msg'=>'不可以兑换自己店铺的代金券');
	    }
	    //查询代金券对应的店铺信息
	    $store_info = Model('store')->getStoreInfoByID($template_info['voucher_t_store_id']);
	    if (empty($store_info)){
	        return array('state'=>false,'msg'=>'代金券信息错误');
	    }
	    //整理代金券信息
        if (!empty($template_info['voucher_t_customimg'])){
            $template_info['voucher_t_customimg'] = UPLOAD_SITE_URL.DS.ATTACH_VOUCHER.DS.$template_info['voucher_t_store_id'].DS.$template_info['voucher_t_customimg'];
        }else{
            $template_info['voucher_t_customimg'] = UPLOAD_SITE_URL.DS.defaultGoodsImage(240);
        }
        $template_info = array_merge($template_info,$store_info);

	    //查询代金券列表
	    $where = array();
	    $where['voucher_owner_id'] = $member_id;
	    $where['voucher_store_id'] = $template_info['voucher_t_store_id'];
	    $voucher_list= $this->getVoucherList($where);
	    if (!empty($voucher_list)){
	        $voucher_count = 0;//在该店铺兑换的代金券数量
	        $voucherone_count = 0;//该张代金券兑换的数量
	        foreach ($voucher_list as $k=>$v){
	            //如果代金券未用且未过期
	            if ($v['voucher_state'] == 1 && $v['voucher_end_date'] > time()){
	                $voucher_count += 1;
	            }
	            if ($v['voucher_t_id'] == $template_info['voucher_t_id']){
	                $voucherone_count += 1;
	            }
	        }
	        //买家最多只能拥有同一个店铺尚未消费抵用的店铺代金券最大数量的验证
	        if ($voucher_count >= intval(C('promotion_voucher_buyertimes_limit'))){
	            $message = sprintf('您的可用代金券已有%s张,不可再兑换了',C('promotion_voucher_buyertimes_limit'));
	            return array('state'=>false,'msg'=>$message);
	        }
	        //同一张代金券最多能兑换的次数
	        if (!empty($template_info['voucher_t_eachlimit']) && $voucherone_count >= $template_info['voucher_t_eachlimit']){
	            $message = sprintf('该代金券您已兑换%s次，不可再兑换了',$template_info['voucher_t_eachlimit']);
	            return array('state'=>false,'msg'=>$message);
	        }
	    }
	    //验证会员积分是否足够
	    $member_info = Model('member')->getMemberInfoByID($member_id);
	    if (empty($member_info)){
	        return array('state'=>false,'msg'=>'参数错误');
	    }
	    if (intval($member_info['member_points']) < intval($template_info['voucher_t_points'])){
	        return array('state'=>false,'msg'=>'您的积分不足，暂时不能兑换该代金券');
	    }
	    return array('state'=>true,'info'=>$template_info);
	}

	/*
     * 获取代金券编码
     */
    public function get_voucher_code() {
		return mt_rand(10,99)
		      . sprintf('%010d',time() - 946656000)
		      . sprintf('%03d', (float) microtime() * 1000)
		      . sprintf('%03d', (int) $_SESSION['member_id'] % 1000);
    }

    /**
     * 更新代金券信息
     * @param array $data
     * @param array $condition
     */
    public function editVoucher($data,$condition,$member_id = 0 ) {
        $result = $this->table('voucher')->where($condition)->update($data);
        if ($result && $member_id > 0){
            wcache($member_id, array('voucher_count' => null), 'm_voucher');
        }
        return $result;
    }

    /**
     * 返回代金券状态数组
     * @return array
     */
    public function getVoucherStateArray() {
        return $this->voucher_state_array;
    }

    /**
     * 获取买家代金券列表
     *
     * @param int $member_id 用户编号
     * @param int $voucher_state 代金券状态
     * @param int $page 分页数
     */
    public function getMemberVoucherList($member_id, $voucher_state, $page = null) {
        if(empty($member_id)) {
            return false;
        }

        //更新过期代金券状态
        $this->_checkVoucherExpire($member_id);

		$field = 'voucher_id,voucher_code,voucher_title,voucher_desc,voucher_start_date,voucher_end_date,voucher_price,voucher_limit,voucher_state,voucher_order_id,voucher_store_id,store_name,store_id,store_domain,voucher_t_customimg';

        $on = 'voucher.voucher_store_id = store.store_id,voucher.voucher_t_id=voucher_template.voucher_t_id';

		$where = array('voucher_owner_id'=>$member_id);
        $voucher_state  = intval($voucher_state);
        if (intval($voucher_state) > 0 && array_key_exists($voucher_state, $this->voucher_state_array)){
			$where['voucher_state'] = $voucher_state;
		}

		$list = $this->table('voucher,store,voucher_template')->field($field)->join('inner,inner')->on($on)->where($where)->order('voucher_id desc')->page($page)->select();

		if(!empty($list) && is_array($list)){
			foreach ($list as $key=>$val){
                //代金券图片
				if (empty($val['voucher_t_customimg']) || !file_exists(BASE_UPLOAD_PATH.DS.ATTACH_VOUCHER.DS.$val['store_id'].DS.$val['voucher_t_customimg'])){
					$list[$key]['voucher_t_customimg'] = UPLOAD_SITE_URL.DS.defaultGoodsImage(60);
				}else{
					$list[$key]['voucher_t_customimg'] = UPLOAD_SITE_URL.DS.ATTACH_VOUCHER.DS.$val['store_id'].DS.str_ireplace('.', '_small.', $val['voucher_t_customimg']);
				}
                //代金券状态文字
                $list[$key]['voucher_state_text'] = $this->voucher_state_array[$val['voucher_state']];
			}
		}
        return $list;
    }

    /**
     * 更新过期代金券状态
     */
    private function _checkVoucherExpire($member_id) {
        $condition = array();
        $condition['voucher_owner_id'] = $member_id;
        $condition['voucher_state'] = self::VOUCHER_STATE_UNUSED;
        $condition['voucher_end_date'] = array('lt', TIMESTAMP);

        $this->table('voucher')->where($condition)->update(array('voucher_state' => self::VOUCHER_STATE_EXPIRE));
    }
    /**
     * 查询代金券模板列表
     */
    public function getVoucherTemplateList($where, $field = '*', $limit = 0, $page = 0, $order = '', $group = '') {
        $voucher_list = array();
        if (is_array($page)){
            if ($page[1] > 0){
                $voucher_list = $this->table('voucher_template')->field($field)->where($where)->page($page[0],$page[1])->order($order)->group($group)->select();
            } else {
                $voucher_list = $this->table('voucher_template')->field($field)->where($where)->page($page[0])->order($order)->group($group)->select();
            }
        } else {
            $voucher_list = $this->table('voucher_template')->field($field)->where($where)->page($page)->order($order)->group($group)->select();
        }
        
        //查询店铺分类
        $store_class = rkcache('store_class', true);
        if (!empty($voucher_list) && is_array($voucher_list)){
            foreach ($voucher_list as $k=>$v){
                if (!empty($v['voucher_t_customimg'])){
                    $v['voucher_t_customimg'] = UPLOAD_SITE_URL.DS.ATTACH_VOUCHER.DS.$v['voucher_t_store_id'].DS.$v['voucher_t_customimg'];
                }else{
                    $v['voucher_t_customimg'] = UPLOAD_SITE_URL.DS.defaultGoodsImage(240);
                }
                $v['voucher_t_limit'] = intval($v['voucher_t_limit']);
                $v['voucher_t_sc_name'] = $store_class[$v['voucher_t_sc_id']]['sc_name'];
                $voucher_list[$k] = $v;
            }
        }
        return $voucher_list;
    }
    /**
     * 更新代金券模板信息
     * @param array $data
     * @param array $condition
     */
    public function editVoucherTemplate($where,$data) {
        return $this->table('voucher_template')->where($where)->update($data);
    }
    /**
     * 获得代金券面额列表
     */
    public function getVoucherPriceList(){
        return $this->table('voucher_price')->order('voucher_price asc')->select();
    }
    /**
     * 获得推荐的热门代金券列表
     * @param int $num 查询条数
     */
    public function getRecommendTemplate($num){
        //查询店铺分类
        $store_class = rkcache('store_class', true);

        //查询推荐的热门代金券列表
        $where = array();
        $where['voucher_t_recommend'] = '1';
        $where['voucher_t_state'] = $this->templatestate_arr['usable'][0];
        $where['voucher_t_end_date'] = array('gt',time());
        $recommend_voucher = $this->getVoucherTemplateList($where, $field = '*', $num, 0, 'voucher_t_id desc');
        if ($recommend_voucher){
        	foreach ($recommend_voucher as $k=>$v){
        	    $v['voucher_t_sc_name'] = $store_class[$v['voucher_t_sc_id']]['sc_name'];
        	    $recommend_voucher[$k] = $v;
        	}
        }
        return $recommend_voucher;
    }
    /**
     * 积分兑换代金券
     */
    public function exchangeVoucher($template_info, $member_id, $member_name = ''){
        if (intval($member_id) <= 0 || empty($template_info)){
            return array('state'=>false,'msg'=>'参数错误');
        }
        //查询会员信息
        if (!$member_name){
            $member_info = Model('member')->getMemberInfoByID($member_id);
            $member_name = $member_info['member_name'];
        }
        //添加代金券信息
        $insert_arr = array();
        $insert_arr['voucher_code'] = $this->get_voucher_code();
        $insert_arr['voucher_t_id'] = $template_info['voucher_t_id'];
        $insert_arr['voucher_title'] = $template_info['voucher_t_title'];
        $insert_arr['voucher_desc'] = $template_info['voucher_t_desc'];
        $insert_arr['voucher_start_date'] = time();
        $insert_arr['voucher_end_date'] = $template_info['voucher_t_end_date'];
        $insert_arr['voucher_price'] = $template_info['voucher_t_price'];
        $insert_arr['voucher_limit'] = $template_info['voucher_t_limit'];
        $insert_arr['voucher_store_id'] = $template_info['voucher_t_store_id'];
        $insert_arr['voucher_state'] = 1;
        $insert_arr['voucher_active_date'] = time();
        $insert_arr['voucher_owner_id'] = $member_id;
        $insert_arr['voucher_owner_name'] = $member_name;
        //扣除会员积分
        $points_arr['pl_memberid'] = $member_id;
        $points_arr['pl_membername'] = $member_name;
        $points_arr['pl_points'] = -$template_info['voucher_t_points'];
        $points_arr['point_ordersn'] = $insert_arr['voucher_code'];
        $points_arr['pl_desc'] = L('home_voucher').$insert_arr['voucher_code'].L('points_pointorderdesc');
        Model('points')->savePointsLog('app',$points_arr,true);
        $result = $this->table('voucher')->insert($insert_arr);
        if ($result){
            //代金券模板的兑换数增加
            $this->editVoucherTemplate(array('voucher_t_id'=>$template_info['voucher_t_id']), array('voucher_t_giveout'=>array('exp','voucher_t_giveout+1')));
            wcache($member_id, array('voucher_count' => array('exp','voucher_count+1')), 'm_voucher');
            return array('state'=>true,'msg'=>'兑换成功');
        } else {
            return array('state'=>false,'msg'=>'兑换失败');
        }
    }
}
