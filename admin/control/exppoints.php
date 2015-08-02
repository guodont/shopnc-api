<?php
/**
 * 经验值管理
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class exppointsControl extends SystemControl{
    const EXPORT_SIZE = 5000;
	public function __construct(){
		parent::__construct();		
	}
	/**
	 * 设置经验值获取规则
	 */
	public function expsettingOp(){
	    $model_setting = Model('setting');
		if (chksubmit()){
		    $exp_arr = array();
		    $exp_arr['exp_login'] = intval($_POST['exp_login'])?$_POST['exp_login']:0;
		    $exp_arr['exp_comments'] = intval($_POST['exp_comments'])?$_POST['exp_comments']:0;
		    $exp_arr['exp_orderrate'] = intval($_POST['exp_orderrate'])?$_POST['exp_orderrate']:0;
		    $exp_arr['exp_ordermax'] = intval($_POST['exp_ordermax'])?$_POST['exp_ordermax']:0;
			$result = $model_setting->updateSetting(array('exppoints_rule'=>serialize($exp_arr)));
			if ($result === true){
				$this->log(L('nc_edit,nc_exppoints_manage,nc_exppoints_setting'),1);
				showMessage(L('nc_common_save_succ'));
			}else {
				showMessage(L('nc_common_save_fail'));
			}			
		}
		$list_setting = $model_setting->getListSetting();
		$list_setting['exppoints_rule'] = $list_setting['exppoints_rule']?unserialize($list_setting['exppoints_rule']):array();
	    Tpl::output('list_setting',$list_setting);
		Tpl::showpage('exppoints.setting');
	}
	/**
	 * 积分日志列表
	 */
	public function indexOp(){
		$where = array();
		$search_mname = trim($_GET['mname']);
		$where['exp_membername'] = array('like',"%{$search_mname}%");
		if ($_GET['stage']){
			$where['exp_stage'] = trim($_GET['stage']);
		}
		$stime = $_GET['stime']?strtotime($_GET['stime']):0;
		$etime = $_GET['etime']?strtotime($_GET['etime']):0;
		if ($stime > 0 && $etime>0){
		    $where['exp_addtime'] = array('between',array($stime,$etime));
		}elseif ($stime > 0){
		    $where['exp_addtime'] = array('egt',$stime);
		}elseif ($etime > 0){
		    $where['exp_addtime'] = array('elt',$etime);
		}
		$search_desc = trim($_GET['description']);
		$where['exp_desc'] = array('like',"%$search_desc%");
		
		//查询积分日志列表
		$model = Model('exppoints');
		$list_log = $model->getExppointsLogList($where, '*', 20, 0, 'exp_id desc');
		//信息输出
		Tpl::output('stage_arr',$model->getStage());
		Tpl::output('show_page',$model->showpage(2));
		Tpl::output('list_log',$list_log);
		Tpl::showpage('exppoints.log');
	}
	/**
	 * 积分日志列表导出
	 */
	public function export_step1Op(){
		$where = array();
		$search_mname = trim($_GET['mname']);
		$where['exp_membername'] = array('like',"%{$search_mname}%");
	    if ($_GET['stage']){
			$where['exp_stage'] = trim($_GET['stage']);
		}
		$stime = $_GET['stime']?strtotime($_GET['stime']):0;
		$etime = $_GET['etime']?strtotime($_GET['etime']):0;
		if ($stime > 0 && $etime>0){
		    $where['exp_addtime'] = array('between',array($stime,$etime));
		}elseif ($stime > 0){
		    $where['exp_addtime'] = array('egt',$stime);
		}elseif ($etime > 0){
		    $where['exp_addtime'] = array('elt',$etime);
		}
		$search_desc = trim($_GET['description']);
		$where['exp_desc'] = array('like',"%$search_desc%");
		
		//查询积分日志列表
		$model = Model('exppoints');
		$list_log = $model->getExppointsLogList($where, '*', self::EXPORT_SIZE, 0, 'exp_id desc');
		if (!is_numeric($_GET['curpage'])){
			$count = $model->getExppointsLogCount($where);
			$array = array();
			if ($count > self::EXPORT_SIZE ){	//显示下载链接
				$page = ceil($count/self::EXPORT_SIZE);
				for ($i=1;$i<=$page;$i++){
					$limit1 = ($i-1)*self::EXPORT_SIZE + 1;
					$limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
					$array[$i] = $limit1.' ~ '.$limit2 ;
				}
				Tpl::output('list',$array);				
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$this->createExcel($list_log);
			}
		}else{	//下载
			$this->createExcel($list_log);
		}
	}

	/**
	 * 生成excel
	 *
	 * @param array $data
	 */
	private function createExcel($data = array()){
		import('libraries.excel');
		$excel_obj = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'会员名称');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'经验值');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'添加时间');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'操作阶段');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'描述');
		$stage_arr = Model('exppoints')->getStage();
		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['exp_membername']);
			$tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['exp_points']));
			$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['exp_addtime']));
			$tmp[] = array('data'=>$stage_arr[$v['exp_stage']]);
			$tmp[] = array('data'=>$v['exp_desc']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset('经验值明细',CHARSET));
		$excel_obj->generateXML($excel_obj->charset('经验值明细',CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
}
