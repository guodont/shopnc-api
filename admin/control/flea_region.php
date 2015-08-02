<?php
/**


^^^^^^^^^^^^^^^^^^^^^^^^^^^^

 */
defined('InShopNC') or exit('Access Invalid!');
class flea_regionControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('region,flea_index');
		if ($GLOBALS['setting_config']['flea_isuse'] != 1 ){
			showMessage(Language::get('flea_index_unable'),'index.php?act=dashboard&op=welcome');
			// showMessage(Language::get('admin_ztc_unavailable'),'index.php?act=dashboard&op=welcome');
		}
	}
	/**
	 * 地区列表
	 *
	 * @param 
	 * @return 
	 */
	public function flea_regionOp(){
		require_once(BASE_DATA_PATH.DS.'cache'.DS.'flea_cache.php');
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$model_area = Model('flea_area');
		/**
		 * 增加 修改 地区信息
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 是否生成缓存的标识
			 */
			$new_cache = true;
			/**
			 * 新增地区
			 */
			if (is_array($_POST['new_area_name'])){
				foreach ($_POST['new_area_name'] as $k => $v){
					if (!empty($v)){
						$insert_array = array();
						$insert_array['flea_area_name'] = $v;
						$insert_array['flea_area_parent_id'] = $_POST['flea_area_parent_id'];
						$insert_array['flea_area_sort'] = intval($_POST['new_area_sort'][$k]);
						$insert_array['flea_area_deep'] = $_POST['child_area_deep'];
						$model_area->add($insert_array);
						$new_cache = true;
					}
				}
			}
			/**
			 * 修改地区
			 */
			if (is_array($_POST['area_name'])){
				foreach ($_POST['area_name'] as $k => $v){
					if (!empty($v)){
						$insert_array = array();
						$insert_array['flea_area_id'] = $k;
						$insert_array['flea_area_name'] = $v;
						$insert_array['flea_area_sort'] = intval($_POST['area_sort'][$k]);
						$model_area->update($insert_array);
						$new_cache = true;
					}
				}
			}
			/**
			 * 删除地区
			 */
			if (!empty($_POST['hidden_del_id'])){
				$_POST['hidden_del_id'] = trim($_POST['hidden_del_id'],'|');
				$del_id = explode('|',$_POST['hidden_del_id']);
				$model_area->del($del_id,$_POST['child_area_deep']);
				$new_cache = true;
			}

			/**
			 * 更新缓存
			 */
			if ($new_cache === true){
				flea_Cache::getCache('flea_area',array('deep'=>$_POST['child_area_deep'],'new'=>'1'));
				
			}

			showMessage($lang['region_index_modify_succ']);
		}
		/**
		 * 导航地区内容
		 */
		/**
		 * 一级
		 */
		
		$province_list = flea_Cache::getCache('flea_area',array('deep'=>'1'));
		$child_area_deep = 1;
		/**
		 * 二级
		 */
		if(!empty($_GET['province'])){
			$cache_data = flea_Cache::getCache('flea_area',array('deep'=>'2'));
			if (is_array($cache_data)){
				$city_list = array();
				foreach ($cache_data as $k => $v){
					if ($v['flea_area_parent_id'] == intval($_GET['province'])){
						$city_list[] = $v;
					}
				}
			}
			unset($cache_data);
			$child_area_deep = 2;
			/**
			 * 三级
			 */
			if(!empty($_GET['city'])){
				$cache_data = flea_Cache::getCache('flea_area',array('deep'=>'3'));
				if (is_array($cache_data)){
					$district_list = array();
					foreach ($cache_data as $k => $v){
						if ($v['flea_area_parent_id'] == intval($_GET['city'])){
							$district_list[] = $v;
						}
					}
				}
				unset($cache_data);
				$child_area_deep = 3;
				/**
				 * 四级
				 */
				if(!empty($_GET['district'])){
					$child_area_deep = 4;
				}
			}
		}
		/**
		 * 地区列表
		 */
		
		$condition['flea_area_parent_id'] = $_GET['flea_area_parent_id']?$_GET['flea_area_parent_id']:'0';
		$area_list = $model_area->getListArea($condition,'flea_area_sort asc');
		Tpl::output('province',$_GET['province']?$_GET['province']:'');
		Tpl::output('city',$_GET['city']);
		Tpl::output('district',$_GET['district']);

		Tpl::output('province_list',$province_list);
		Tpl::output('city_list',$city_list);
		Tpl::output('district_list',$district_list);
		Tpl::output('flea_area_parent_id',$_GET['flea_area_parent_id']?$_GET['flea_area_parent_id']:'0');
		Tpl::output('area_list',$area_list);
		Tpl::output('child_area_deep',$child_area_deep);
		Tpl::showpage('flea_region.index');
	}

	/**
	 * 导入地区
	 *
	 * @param 
	 * @return 
	 */
	public function flea_region_importOp(){
		require_once(BASE_DATA_PATH.DS.'cache'.DS.'flea_cache.php');
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$model_area = Model('flea_area');
		/**
		 * 导入
		 */
		if ($_POST['form_submit'] == 'ok'){
			if (!empty($_FILES['csv'])){
				$fp = @fopen($_FILES['csv']['tmp_name'],'rb');
				/**
				 * 父ID
				 */
				$area_parent_id_1 = 0;

				while (!feof($fp)) {
					$data = fgets($fp, 4096);
					switch (strtoupper($_POST['charset'])){
						case 'UTF-8':
							if (strtoupper(CHARSET) !== 'UTF-8'){
								$data = iconv('UTF-8',strtoupper(CHARSET),$data);
							}
							break;
						case 'GBK':
							if (strtoupper(CHARSET) !== 'GBK'){
								$data = iconv('GBK',strtoupper(CHARSET),$data);
							}
							break;
					}
					if (!empty($data)){
						$data	= str_replace('"','',$data);
						/**
						 * 逗号去除
						 */
						$tmp_array = array();
						$tmp_array = explode(',',$data);
						/**
						 * 第一位是序号，后面的是内容，最后一位名称
						 */
						$tmp_deep = 'flea_area_parent_id_'.(count($tmp_array)-1);
						$insert_array = array();
						$insert_array['flea_area_sort'] = $tmp_array[0];
						$insert_array['flea_area_parent_id'] = $$tmp_deep;
						$insert_array['flea_area_name'] = $tmp_array[count($tmp_array)-1];
						$insert_array['flea_area_deep'] = count($tmp_array)-1;
						$area_id = $model_area->add($insert_array);
						/**
						 * 赋值这个深度父ID
						 */
						$tmp = 'flea_area_parent_id_'.count($tmp_array);
						$$tmp = $area_id;
					}
				}
				/**
				 * 重新生成缓存
				 */
				for ($i=1;$i<=4;$i++){
					$tmp = 'flea_area_parent_id_'.$i;
					if (intval($$tmp) >= 0){
						flea_Cache::getCache('flea_area',array('deep'=>intval($i),'new'=>'1'));
					}
				}
				showMessage($lang['region_import_succ'],'index.php?act=flea_region&op=flea_region');
			}else {
				showMessage($lang['region_import_csv_null']);
			}
		}
		Tpl::showpage('flea_region.import');
	}
	/**
	 * 导入默认地区
	 *
	 * @param 
	 * @return 
	 */
	public function flea_import_default_areaOp() {
		$lang	= Language::getLangContent();
		
		$file = BASE_DATA_PATH.'/resource/examples/flea_area.sql';
		if (!is_file($file)){
			showMessage($lang['region_import_csv_null']);
		}

		$handle = @fopen($file, "r");
		$tmp_sql = '';
		if ($handle) {
			
			Db::query("TRUNCATE TABLE `".DBPRE."flea_area`");
		    while (!feof($handle)) {
			
		        $buffer = fgets($handle);
		        if (trim($buffer) != ''){
		        	$tmp_sql .= $buffer;
			        if (substr(rtrim($buffer),-1) == ';'){
			        	if (preg_match('/^(INSERT)\s+(INTO)\s+/i', ltrim($tmp_sql)) && substr(rtrim($buffer),-2) == ');'){
			        		//标准的SQL语句，将被执行
			        	}else{
			        		//不能组成标准的SQL语句，继续向下一行取内容，直到组成合法的SQL为止
			        		continue;
			        	}
			        	if (!empty($tmp_sql)){
									if (strtoupper(CHARSET) == 'GBK'){
										$tmp_sql = iconv('UTF-8',strtoupper(CHARSET),$tmp_sql);
									}
			        		$tmp_sql = str_replace("`33hao_flea_area`","`".DBPRE."flea_area`",$tmp_sql);
			        		Db::query($tmp_sql);
			        		unset($tmp_sql);
			        	}
			        }
		        }
		    }
	    	@fclose($handle);
			/**
			 * 重新生成缓存
			 */
			require_once(BASE_DATA_PATH.DS.'cache'.DS.'flea_cache.php');
			for ($i=1;$i<=4;$i++){
				$tmp = 'flea_area_parent_id_'.$i;
				if (intval($$tmp) >= 0){
					flea_Cache::getCache('flea_area',array('deep'=>intval($i),'new'=>'1'));
				}
			}	    	
	    	
			showMessage($lang['region_import_succ'],'index.php?act=flea_region&op=flea_region');
		}else {
			showMessage($lang['region_import_csv_null']);
		}
	}
}