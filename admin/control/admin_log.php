<?php
/**
 * 系统操作日志
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class admin_logControl extends SystemControl{
	const EXPORT_SIZE = 5000;

	public function __construct(){
		parent::__construct();
		Language::read('admin_log');
	}

	/**
	 * 日志列表
	 *
	 */
	public function listOp(){
		$model = Model('admin_log');
		$condition = array();
		if (!empty($_GET['admin_name'])){
			$condition['admin_name'] = $_GET['admin_name'];
		}
		if(!empty($_GET['time_from'])){
			$time1	= strtotime($_GET['time_from']);
		}
		if(!empty($_GET['time_to'])){
			$time2	= strtotime($_GET['time_to']);
			if($time2 !== false) $time2 = $time2 + 86400;
		}
		if ($time1 && $time2){
			$condition['createtime'] = array('between',array($time1,$time2));
		}elseif($time1){
			$condition['createtime'] = array('egt',$time1);
		}elseif($time2){
			$condition['createtime'] = array('elt',$time2);
		}
		$list = $model->where($condition)->order('id desc')->page(20)->select();

//		$admin = Model()->table('admin,gadmin')->field('admin_id,admin_name,gid,gname')->join('left')->on('admin.admin_gid=gadmin.gid')->select();

		Tpl::output('list',$list);
		Tpl::output('page',$model->showpage());
		Tpl::showpage('admin_log.index');
	}

	/**
	 * 删除日志
	 *
	 */
	public function list_delOp(){
		$condition = array();
		if (is_numeric($_GET['delago'])){
			$condition['createtime'] = array('lt',TIMESTAMP-intval($_GET['delago']));
		}elseif($_GET['delago'] == 'all'){
			$condition = true;
		}elseif(is_array($_POST['del_id'])){
			$condition['id'] = array('in',$_POST['del_id']);
		}
		if (!Model('admin_log')->where($condition)->delete()){
			$this->log(L('nc_del,nc_admin_log'),0);
			showMessage(L('nc_common_del_fail'),'','html','error');
		}else{
		    $this->log(L('nc_del,nc_admin_log'),1);
			showMessage(L('nc_common_del_succ'),'','html','error');
		}
	}

	/**
	 * 导出第一步
	 */
	public function export_step1Op(){
		$model = Model('admin_log');
		$condition = array();
		if (!empty($_GET['admin_name'])){
			$condition['admin_name'] = $_GET['admin_name'];
		}
		if(!empty($_GET['time_from'])){
			$time1	= strtotime($_GET['time_from']);
		}
		if(!empty($_GET['time_to'])){
			$time2	= strtotime($_GET['time_to']);
			if($time2 !== false) $time2 = $time2 + 86400;
		}
		if ($time1 && $time2){
			$condition['createtime'] = array('between',array($time1,$time2));
		}elseif($time1){
			$condition['createtime'] = array('egt',$time1);
		}elseif($time2){
			$condition['createtime'] = array('elt',$time2);
		}
		if (!is_numeric($_GET['curpage'])){
			$count = $model->where($condition)->count();
			$array = array();
			if ($count > self::EXPORT_SIZE ){	//显示下载链接
				$page = ceil($count/self::EXPORT_SIZE);
				for ($i=1;$i<=$page;$i++){
					$limit1 = ($i-1)*self::EXPORT_SIZE + 1;
					$limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
					$array[$i] = $limit1.' ~ '.$limit2 ;
				}
				Tpl::output('list',$array);
				Tpl::output('murl','index.php?act=admin_log&op=list');
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$data = $model->where($condition)->order('id desc')->limit(self::EXPORT_SIZE)->select();
				$this->createExcel($data);
			}
		}else{	//下载
			$limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
			$limit2 = self::EXPORT_SIZE;
			$data = $model->where($condition)->order('id desc')->limit("{$limit1},{$limit2}")->select();
			$this->createExcel($data);
		}
	}

	/**
	 * 生成excel
	 *
	 * @param array $data
	 */
	private function createExcel($data = array()){
		Language::read('export');
		import('libraries.excel');
		$excel_obj = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('admin_log_man'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('admin_log_do'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('admin_log_dotime'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'IP');
		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['admin_name']);
			$tmp[] = array('data'=>$v['content']);
			$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['createtime']));
			$tmp[] = array('data'=>$v['ip']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('nc_admin_log'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('nc_admin_log'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
}
