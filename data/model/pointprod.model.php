<?php
/**
 * 积分礼品管理
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class pointprodModel extends Model {
	public function __construct(){
		parent::__construct();
	}
	/**
	 * 获取兑换商品的展示状态
	 */
	public function getPgoodsShowState(){
	    $pgoodsshowstate_arr = array('unshow'=>array(0,'下架'),'show'=>array(1,'上架'));
	    return $pgoodsshowstate_arr;
	}
	
	/**
	 * 获取兑换商品的开启状态
	 */
	public function getPgoodsOpenState(){
	    $pgoodsopenstate_arr = array('open'=>array(0,'开启'),'close'=>array(1,'禁售'));
	    return $pgoodsopenstate_arr;
	}
	
	/**
	 * 获取兑换商品的推荐状态
	 */
	public function getPgoodsRecommendState(){
	    $pgoodsrecommendstate_arr = array('uncommend'=>array(0,'未推荐'),'commend'=>array(1,'已推荐'));
	    return $pgoodsrecommendstate_arr;
	}
	
	/**
	 * 礼品保存
	 *
	 * @param	array $param 商品资料
	 */
	public function addPointGoods($param) {
		if(empty($param)) {
			return false;
		}
		$insert_id = $this->table('points_goods')->insert($param);
		if ($insert_id) {
		    return $insert_id;
		} else {
		    return false;
		}
	}
	/**
	 * 礼品信息列表
	 *
	 * @param array $condition 条件数组
	 * @param array $page   分页
	 * @param array $field   查询字段
	 * @param array $page   分页  
	 */
	public function getPointProdList($where = '', $field='*',$order='',$limit='',$page=''){
		if (empty($order)){
			$order = 'pgoods_sort asc';
		}
		$list = $this->table('points_goods')->field($field)->where($where)->order($order)->limit($limit)->page($page)->select();
		if (is_array($list) && count($list)>0){
			foreach ($list as $k=>$v){
			    $v['pgoods_image_old'] = $v['pgoods_image'];
			    $v['pgoods_image_small'] = pointprodThumb($v['pgoods_image'], 'small');
				$v['pgoods_image'] = pointprodThumb($v['pgoods_image'], 'mid');
				
				$v['ex_state'] = $this->getPointProdExstate($v);
				//处理限制的会员等级
				if (isset($v['pgoods_limitmgrade'])){
				    $limitgrade = intval($v['pgoods_limitmgrade']);
				    if ($limitgrade > 0){
				        $membergrade_arr = Model('member')->getMemberGradeArr();
				        $v['pgoods_limitgradename'] = $membergrade_arr[$limitgrade]['level_name'];
				    }
				}
				//获得浏览次数
				if (isset($v['pgoods_view'])){
				    $v['pgoods_view'] = $this->getPointProdViewNum($v['pgoods_id'],$v['pgoods_view']);
				}
				$list[$k] = $v;
			}
		}
		return $list;
	}
	
	/**
	 * 查询出售中的兑换礼品列表
	 */
	public function getOnlinePointProdList($where = '', $field='*',$order='',$limit='',$page=''){
	    $pgoodsshowstate_arr = $this->getPgoodsShowState();
	    $pgoodsopenstate_arr = $this->getPgoodsOpenState();
	    $where['pgoods_show'] = $pgoodsshowstate_arr['show'][0];
	    $where['pgoods_state'] = $pgoodsopenstate_arr['open'][0];
	    $list = $this->getPointProdList($where, $field, $order, $limit, $page);
	    return $list;
	}
	
	/**
	 * 礼品信息单条
	 *
	 * @param array $condition 条件数组
	 * @param array $field   查询字段
	 */
	public function getPointProdInfo($where = '',$field='*'){
		$prodinfo = $this->table('points_goods')->where($where)->find();
		if (!empty($prodinfo)){
		    $prodinfo['pgoods_image_old'] = $prodinfo['pgoods_image'];
		    $prodinfo['pgoods_image_max'] = pointprodThumb($prodinfo['pgoods_image']);
		    $prodinfo['pgoods_image_small'] = pointprodThumb($prodinfo['pgoods_image'], 'small');
			$prodinfo['pgoods_image'] = pointprodThumb($prodinfo['pgoods_image'], 'mid');
			
			$prodinfo['ex_state'] = $this->getPointProdExstate($prodinfo);
			//处理兑换时间限制
			if ($prodinfo['pgoods_islimittime'] == 1 && $prodinfo['ex_state'] == 'going'){
			    $timediff = intval($prodinfo['pgoods_endtime'])-time();
			    $prodinfo['timediff']['diff_day']  = intval($timediff/86400);
			    $prodinfo['timediff']['diff_hour'] = intval($timediff%86400/3600);
			    $prodinfo['timediff']['diff_mins'] = intval($timediff%86400%3600/60);
			    $prodinfo['timediff']['diff_secs'] = intval($timediff%86400%3600%60);
			}
			//处理限制的会员等级
			if (isset($prodinfo['pgoods_limitmgrade'])){
			    $limitgrade = intval($prodinfo['pgoods_limitmgrade']);
			    if ($limitgrade > 0){
			        $membergrade_arr = Model('member')->getMemberGradeArr();
			        $prodinfo['pgoods_limitgradename'] = $membergrade_arr[$limitgrade]['level_name'];
			    }
			}
			//获得浏览次数
			if (isset($prodinfo['pgoods_view'])){
			    $prodinfo['pgoods_view'] = $this->getPointProdViewNum($prodinfo['pgoods_id'],$prodinfo['pgoods_view']);
			}			
		}
		return $prodinfo;
	}
	
	/**
	 * 查询出售中的兑换礼品
	 */
	public function getOnlinePointProdInfo($where = array(),$field='*'){
	    $pgoodsshowstate_arr = $this->getPgoodsShowState();
	    $pgoodsopenstate_arr = $this->getPgoodsOpenState();
	    $where['pgoods_show'] = $pgoodsshowstate_arr['show'][0];
	    $where['pgoods_state'] = $pgoodsopenstate_arr['open'][0];
	    $prodinfo = $this->getPointProdInfo($where,$field);
	    return $prodinfo;
	}
	/**
	 * 获得兑换礼品的浏览次数
	 * @param int $pgoods_id 兑换礼品ID 
	 */
	public function getPointProdViewNum($prod_id,$pgoods_view = ''){
	    $prod_id = intval($prod_id);
	    if ($prod_id <= 0){
	        return 0;
	    }
	    $is_data = true;//是否从数据库读取
	    if (C('cache_open')){//如果开启缓存，则读取缓存的浏览次数
	        $prod_info = rcache($prod_id, 'pointprod', 'pgoods_view,view_updatetime');
	        if ($prod_info){
	            $is_data = false;
	        }
	    }
	    if ($is_data){//从数据库读取
	        if ($pgoods_view === ''){//如果已经获得浏览次数则直接返回,否则查询数据库中的浏览次数
	           $prod_info = $this->table('points_goods')->field('pgoods_view')->where(array('pgoods_id'=>$prod_id))->find();
	           $pgoods_view = intval($prod_info['pgoods_view']);
	        }
	    } else {
	        $pgoods_view = intval($prod_info['pgoods_view']);
	    }
	    return $pgoods_view;
	}
	
	/**
	 * 获得礼品兑换状态
	 * @param array $condition 礼品数组
	 * return array $field   查询字段
	 */
	public function getPointProdExstate($prodinfo){
		$datetime = time();
		$ex_state = 'end';//兑换按钮的可用状态
		if ($prodinfo['pgoods_islimittime'] == 1){
			//即将开始
			if ($prodinfo['pgoods_starttime']>$datetime && $prodinfo['pgoods_storage']>0){
				$ex_state = 'willbe';
			}
			//时间进行中
			if ($prodinfo['pgoods_starttime'] <= $datetime && $datetime < $prodinfo['pgoods_endtime'] && $prodinfo['pgoods_storage']>0){
				$ex_state = 'going';
			}
		}else {
			if ($prodinfo['pgoods_storage']>0){
				$ex_state = 'going';
			}
		}
		return $ex_state;
	}
	
	/**
	 * 删除礼品信息
	 * @param	mixed $pg_id 删除申请记录编号
	 */
	public function delPointProdById($pg_id){
		if(empty($pg_id)) {
			return false;
		}
		$where = array();
		if (is_array($pg_id)){
			foreach ($pg_id as $k=>$v){
			    $pg_id[$k] = intval($v);
			}
			$where['pgoods_id'] = array('in',$pg_id);
		} else {
		    $pg_id = intval($pg_id);
		    $where['pgoods_id'] = $pg_id;
		}
		$result = $this->table('points_goods')->where($where)->delete();
		//删除积分礼品下的图片信息
		if ($result){
			//删除积分礼品下的图片信息
			$upload_model = Model('upload');
			if (is_array($pg_id) && count($pg_id)>0){
				$pg_idStr = implode(',',$pg_id);
				$upload_list = $upload_model->getUploadList(array('upload_type_in' =>'5,6','item_id_in'=>$pg_idStr));
			}else {
				$upload_list = $upload_model->getUploadList(array('upload_type_in' =>'5,6','item_id'=>$pg_id));
			}			
			if (is_array($upload_list) && count($upload_list)>0){
				$upload_idarr = array();
				foreach ($upload_list as $v){
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_POINTPROD.DS.$v['file_name']);
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_POINTPROD.DS.$v['file_thumb']);
					$upload_idarr[] = $v['upload_id'];
				}
				//删除图片
				$upload_model->dropUploadById($upload_idarr);
			}
		}
		return $result;
	}
	/**
	 * 编辑积分礼品信息
	 */
	public function editPointProd($update_arr, $where){
	    if (empty($update_arr)) {
	        return true;
	    }
	    $result	= $this->table('points_goods')->where($where)->update($update_arr);
	    return $result;
	}
	/**
     * 获得推荐的热门兑换商品列表
     * @param int $num 查询条数
     */
    public function getRecommendPointProd($num){
        $where = array();
        $where['pgoods_show'] = 1;
        $where['pgoods_state'] = 0;
        $where['pgoods_commend'] = 1;
        $recommend_pointsprod = $this->getPointProdList($where,'*','pgoods_sort asc,pgoods_id desc',$num);
        if ($recommend_pointsprod && is_array($recommend_pointsprod)){
        	foreach ($recommend_pointsprod as $k=>$v){
        	    //处理限制的会员等级
        	    $limitgrade = intval($v['pgoods_limitmgrade']);
        	    if ($limitgrade > 0){
        	        $membergrade_arr = Model('member')->getMemberGradeArr();
        	        $v['pgoods_limitgradename'] = $membergrade_arr[$limitgrade]['level_name'];
        	        $recommend_pointsprod[$k] = $v;
        	    }
        	}
        }
        return $recommend_pointsprod;
    }
    /**
     * 更新礼品浏览次数
     */
    public function editPointProdViewnum($prod_id){
        if (intval($prod_id) <= 0){
            return array('state'=>false,'msg'=>'参数错误');
        }
        $viewnum = 0;//最新浏览次数
        $cache_arr = array();
        $tmptime = time();
        if (!C('cache_open')){//直接更新数据库浏览次数
            $this->editPointProd(array('pgoods_view'=>array('exp','pgoods_view+1')), array('pgoods_id'=>$prod_id));
        } else {//通过缓存记录浏览次数
            $prod_info = rcache($prod_id, 'pointprod', 'pgoods_view,view_updatetime');
            if (empty($prod_info)){//如果兑换礼品的浏览次数缓存不存在，则查询兑换礼品数据库信息，建立缓存
                //查询兑换礼品信息
                $prod_info = $this->getPointProdInfo(array('pgoods_id'=>$prod_id),'pgoods_view');
                $viewnum = intval($prod_info['pgoods_view']) + 1;
                wcache($prod_id, array('pgoods_view'=>$viewnum,'view_updatetime'=>$tmptime), 'pointprod');
            } else {
                $viewnum = intval($prod_info['pgoods_view']) + 1;
                if (($prod_info['view_updatetime']+3600) < $tmptime){//如果缓存时间超出1小时，则将更新进入数据库，时间初始为当前时间
                    $this->editPointProd(array('pgoods_view'=>$viewnum), array('pgoods_id'=>$prod_id));
                    wcache($prod_id, array('pgoods_view'=>$viewnum,'view_updatetime'=>$tmptime), 'pointprod');
                } else {//如果缓存时间未超出1小时，则更新浏览次数
                    wcache($prod_id, array('pgoods_view'=>$viewnum), 'pointprod');
                }
            }
        }
        return array('state'=>true);
    }
}