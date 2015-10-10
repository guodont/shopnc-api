<?php
/**


^^^^^^^^^^^^^^^^^^^^^^^^^^^^

 */
defined('InShopNC') or exit('Access Invalid!');
class flea_class_indexControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('setting,flea_class');
		if($GLOBALS['setting_config']['flea_isuse']!='1'){
			showMessage(Language::get('flea_isuse_off_tips'),'index.php?act=dashboard&op=welcome');
		}
	}
	/**
	 * 设置
	 */
	public function flea_class_indexOp(){
		/**
		 * 加载语言包
		 */
		$lang	= Language::getLangContent();
		/**
		 * 实例化商品分类模型
		 */
		$model_class		= Model('flea_class');
		$goods_class		= $model_class->getTreeClassList(1);
		Tpl::output('goods_class',$goods_class);
		/**
		 * 获取设置信息
		 */
		$fc_index = $model_class->getFleaIndexClass(array());
		if(is_array($fc_index)&&!empty($fc_index)){
			foreach ($fc_index as $value){
				Tpl::output($value['fc_index_code'],$value);
			}
		}
		
		if($_POST['form_submit']=='ok'){
			$a = $model_class->setFleaIndexClass(array('fc_index_code'=>'shuma','fc_index_id1'=>$_POST['shuma_cid1'],'fc_index_id2'=>$_POST['shuma_cid2'],'fc_index_id3'=>$_POST['shuma_cid3'],'fc_index_id4'=>$_POST['shuma_cid4']));
			$b = $model_class->setFleaIndexClass(array('fc_index_code'=>'zhuangban','fc_index_id1'=>$_POST['zhuangban_cid1'],'fc_index_id2'=>$_POST['zhuangban_cid2'],'fc_index_id3'=>$_POST['zhuangban_cid3'],'fc_index_id4'=>$_POST['zhuangban_cid4']));
			$c = $model_class->setFleaIndexClass(array('fc_index_code'=>'jujia','fc_index_id1'=>$_POST['jujia_cid1'],'fc_index_id2'=>$_POST['jujia_cid2'],'fc_index_id3'=>$_POST['jujia_cid3'],'fc_index_id4'=>$_POST['jujia_cid4']));
			$d = $model_class->setFleaIndexClass(array('fc_index_code'=>'xingqu','fc_index_id1'=>$_POST['xingqu_cid1'],'fc_index_id2'=>$_POST['xingqu_cid2'],'fc_index_id3'=>$_POST['xingqu_cid3'],'fc_index_id4'=>$_POST['xingqu_cid4']));
			$e = $model_class->setFleaIndexClass(array('fc_index_code'=>'muying','fc_index_id1'=>$_POST['muying_cid1'],'fc_index_id2'=>$_POST['muying_cid2'],'fc_index_id3'=>$_POST['muying_cid3'],'fc_index_id4'=>$_POST['muying_cid4']));
			if($a && $b && $c && $d && e){
				$a = $model_class->setFleaIndexClass(array('fc_index_code'=>'shuma','fc_index_name1'=>$_POST['shuma_cname1'],'fc_index_name2'=>$_POST['shuma_cname2'],'fc_index_name3'=>$_POST['shuma_cname3'],'fc_index_name4'=>$_POST['shuma_cname4']));
				$b = $model_class->setFleaIndexClass(array('fc_index_code'=>'zhuangban','fc_index_name1'=>$_POST['zhuangban_cname1'],'fc_index_name2'=>$_POST['zhuangban_cname2'],'fc_index_name3'=>$_POST['zhuangban_cname3'],'fc_index_name4'=>$_POST['zhuangban_cname4']));
				$c = $model_class->setFleaIndexClass(array('fc_index_code'=>'jujia','fc_index_name1'=>$_POST['jujia_cname1'],'fc_index_name2'=>$_POST['jujia_cname2'],'fc_index_name3'=>$_POST['jujia_cname3'],'fc_index_name4'=>$_POST['jujia_cname4']));
				$d = $model_class->setFleaIndexClass(array('fc_index_code'=>'xingqu','fc_index_name1'=>$_POST['xingqu_cname1'],'fc_index_name2'=>$_POST['xingqu_cname2'],'fc_index_name3'=>$_POST['xingqu_cname3'],'fc_index_name4'=>$_POST['xingqu_cname4']));
				$e = $model_class->setFleaIndexClass(array('fc_index_code'=>'muying','fc_index_name1'=>$_POST['muying_cname1'],'fc_index_name2'=>$_POST['muying_cname2'],'fc_index_name3'=>$_POST['muying_cname3'],'fc_index_name4'=>$_POST['muying_cname4']));
				if($a && $b && $c && $d && e){
					showMessage(Language::get('flea_class_setting_ok'));
				}
			}else{
				showMessage(Language::get('flea_class_setting_error'));
			}
		}
		Tpl::showpage('flea_class_index');
	}
}