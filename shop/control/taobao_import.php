<?php
/**
 * 淘宝导入插件
 *
 * by 3 3 h a o.c o m
 *
 */
defined('InShopNC') or exit('Access Invalid!');
class taobao_importControl extends BaseSellerControl {
	private function checkStore(){
        if(!checkPlatformStore()){
            // 是否到达商品数上限
            $goods_num = Model('goods')->getGoodsCommonCount(array('store_id' => $_SESSION['store_id']));
            if (intval($this->store_grade['sg_goods_limit']) != 0) {
                if ($goods_num >= $this->store_grade['sg_goods_limit']) {
                    showMessage(L('store_goods_index_goods_limit') . $this->store_grade['sg_goods_limit'] . L('store_goods_index_goods_limit1'), 'index.php?act=store_goods&op=goods_list', 'html', 'error');
                }
            }
        }
    }
    public function __construct() {
        parent::__construct();
        Language::read('member_store_goods_index');
    }

	public function indexOp(){
		$lang 	= Language::getLangContent();
		// 生成商店二维码
        require_once(BASE_RESOURCE_PATH.DS.'phpqrcode'.DS.'index.php');
        $PhpQRCode = new PhpQRCode();
        $PhpQRCode->set('pngTempDir',BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$_SESSION['store_id'].DS);
		//print_r($PhpQRCode);
		
		
		
		
		if(!$_POST){
			/**
			 * 获取商品分类
			 */
			$gc	= Model('goods_class');
			$gc_list	= $gc->getGoodsClassList(array('gc_parent_id'=>'0'));
			Tpl::output('gc_list',$gc_list);
			
			/**
			 * 获取店铺商品分类
			 */
			$model_store_class	= Model('my_goods_class');
			$store_goods_class	= $model_store_class->getClassTree(array('store_id'=>$_SESSION['store_id'],'stc_state'=>'1'));
			Tpl::output('store_goods_class',$store_goods_class);
			
			if($_GET['step'] != ''){
				Tpl::output('step',$_GET['step']);
			}else{
				Tpl::output('step','1');
			}
		}else{
			$file	= $_FILES['csv'];
			/**
			 * 上传文件存在判断
			 */
			if(empty($file['name'])){
				showMessage($lang['store_goods_import_choose_file'],'','html','error');
			}
			/**
			 * 文件来源判定
			 */
			if(!is_uploaded_file($file['tmp_name'])){
				showMessage($lang['store_goods_import_unknown_file'],'','html','error');
			}
			/**
			 * 文件类型判定
			 */
			$file_name_array	= explode('.',$file['name']);
			if($file_name_array[count($file_name_array)-1] != 'csv'){
				showMessage($lang['store_goods_import_wrong_type'].$file_name_array[count($file_name_array)-1],'','html','error');
			}
			/**
			 * 文件大小判定
			 */
			if($file['size'] > intval(ini_get('upload_max_filesize'))*1024*1024){
				showMessage($lang['store_goods_import_size_limit'],'','html','error');
			}
			/**
			 * 商品分类判定
			 */
			if(empty($_POST['gc_id'])){
				showMessage($lang['store_goods_import_wrong_class'],'','html','error');
			}
			$gc	= Model('goods_class');
			$gc_row	= $gc->getGoodsClassLineForTag($_POST['gc_id']);
		
			if(!is_array($gc_row) or count($gc_row) == 0){
				showMessage($lang['store_goods_import_wrong_class1'],'','html','error');
			}
			$gc_sub_list	=	$gc->getGoodsClassList(array('gc_parent_id'=>intval($_POST['gc_id'])));
			if(is_array($gc_sub_list) and count($gc_sub_list) > 0){
				showMessage($lang['store_goods_import_wrong_class2'],'','html','error');
			}
			

			/**
			 * 店铺商品分类判定
			 */
			$sgcate_ids	= array();
			$stc	= Model('store_goods_class');
			if(is_array($_POST['sgcate_id']) and count($_POST['sgcate_id']) > 0){
				foreach ($_POST['sgcate_id'] as $sgcate_id) {
					if(!in_array($sgcate_id,$sgcate_ids)){
						$stc_row	= $stc->getOneById($sgcate_id);
						if(is_array($stc_row) and count($stc_row) > 0){
							$sgcate_ids[]	= $sgcate_id;
						}
					}
				}
			}
	
			/**
			 * 上传文件的字符编码转换
			 */
			$csv_string	= unicodeToUtf8(file_get_contents($file['tmp_name']));
			
			/* 兼容淘宝助理5 start */
			$csv_array = explode("\tsyncStatus", $csv_string, 2);
			if(count($csv_array) == 2){
				$csv_string	= $csv_array[1];
			}
			/* 兼容淘宝助理5 end */
			
			/**
			 * 将文件转换为二维数组形式的商品数据
			 */
			$records	= $this->parse_taobao_csv($csv_string);
			if($records === false){
			showMessage($lang['store_goods_import_wrong_column'],'','html','error');
			}
			
			/**
			 * 转码
			 */
		   if (strtoupper(CHARSET) == 'GBK'){
		  	$records = Language::getGBK($records);
		}
		
         
			$model_goodsclass = Model('goods_class');
			$model_store_goods	= Model('goods');
			$model_type = Model('type');
			// 商品数量
			$goods_num=$model_store_goods->getGoodsCommonCount(array('store_id'=>$_SESSION['store_id']));
			
			/**
			 * 商品数,空间使用，使用期限判断
			 */
			$model_store	= Model('store');
			$store_info		= $model_store->getStoreInfo(array('store_id'=>$_SESSION['store_id']));
			$model_store_grade	= Model('store_grade');
			$store_grade	= $model_store_grade->getOneGrade($store_info['grade_id']);
			/*商品数判断*/
			$remain_num	= -1;
			if(intval($store_grade['sg_goods_limit']) != 0) {
				if($goods_num >= $store_grade['sg_goods_limit']) {
					showMessage($lang['store_goods_index_goods_limit'].$store_grade['sg_goods_limit'].$lang['store_goods_index_goods_limit1'],'index.php?act=store_goods&op=goods_list','html','error');
				}
				$remain_num	= $store_grade['sg_goods_limit']-$goods_num;
			}
			/*使用期限判断*/
			if(intval($store_info['store_end_time']) != 0) {
				if(time() >= $store_info['store_end_time']) {
					showMessage($lang['store_goods_index_time_limit'],'index.php?act=store_goods&op=goods_list','html','error');
				}
			}
			/**
			 * 循环添加数据
			 */
			$str ='';
			if(is_array($records) and count($records) > 0){
				foreach($records as $k=>$record){
					if($remain_num>0 and $k>=$remain_num){
						showMessage($lang['store_goods_index_goods_limit'].$store_grade['sg_goods_limit'].$lang['store_goods_index_goods_limit1'].$lang['store_goods_import_end'].(count($records)-$remain_num).$lang['store_goods_import_products_no_import'],'index.php?act=store_goods&op=taobao_import&step=4','html','error');
					}
					
					if(is_array($record['goods_image'])){
						$str .= implode(',',$record['goods_image']);
						$str .="\r\n";
					}else{
						$str .=$record['goods_image']."\r\n";
					}
					//file_put_contents('image.txt',$str,FILE_APPEND);
					$pic_array	= $this->get_goods_image($record['goods_image']);
					
					if(empty($record['goods_name']))continue;
					$param	= array();
					$param['goods_name']			= $record['goods_name'];
					$param['gc_id']					= intval($_POST['gc_id']);
					//zmr>>>
					$param['gc_id_1']					= intval($_POST['cls_1']);
					$param['gc_id_2']					= intval($_POST['cls_2']);
					$param['gc_id_3']					= intval($_POST['cls_3']);
					$param['gc_name']				= $_POST['cate_name'];
					$param['spec_name']				= 'N;';
					$param['spec_value']		    = 'N;';
					$param['store_name']	        =$store_info['store_name'];
					//zmr<<<
					$param['store_id']				= $_SESSION['store_id'];
					$param['type_id']				= '0';
					$param['goods_image']			= $pic_array['goods_image'][0];
					$param['goods_marketprice']		= $record['goods_store_price'];
					$param['goods_price']= $record['goods_store_price'];
					//$param['goods_show']			= '1';
					$param['goods_commend']			= $record['goods_commend'];
					$param['goods_addtime']		=    time();
					$param['goods_body']			= $record['goods_body'];
					$param['goods_state']			= '0';
					$param['goods_verify']			= '1';
					$param['areaid_1']				= intval($_POST['province_id']);
					$param['areaid_2']			= intval($_POST['city_id']);
					$param['goods_stcids']       = ',' . implode(',', array_unique($_POST['sgcate_id'])) . ',';  
				    $param['goods_serial']	= $record['goods_serial'];
					$goods_id	= $model_store_goods->addGoodsCommon($param);
			        
					//添加库存
			        $param	= array();
				    $param['goods_commonid']    = $goods_id;
					$param['goods_name']			= $record['goods_name'];
					$param['gc_id']					= intval($_POST['gc_id']);
					$param['store_id']				= $_SESSION['store_id'];
					$param['goods_image']			= $pic_array['goods_image'][0];
					$param['goods_marketprice']		= $record['goods_store_price'];
					$param['goods_price']= $record['goods_store_price'];
					//$param['goods_show']			= '1';
					$param['goods_commend']			= $record['goods_commend'];
					$param['goods_addtime']		=    time();
					$param['goods_state']			= '0';
					$param['goods_verify']			= '1';
					$param['areaid_1']				= intval($_POST['province_id']);
					$param['areaid_2']			= intval($_POST['city_id']);
				    $param['goods_stcids']       = ',' . implode(',', array_unique($_POST['sgcate_id'])) . ',';  
					$param['goods_storage']	= $record['spec_goods_storage'];
					$param['goods_serial']	= $record['goods_serial'];
					//zmr>>>
					$param['gc_id_1']					= intval($_POST['cls_1']);
					$param['gc_id_2']					= intval($_POST['cls_2']);
					$param['gc_id_3']					= intval($_POST['cls_3']);
					$param['goods_promotion_price']	    = $param['goods_price'];
					$param['goods_spec']				= 'N;';
					$param['store_name']	            =$store_info['store_name'];
					//zmr<<<
					
			        $goods_id1=$model_store_goods->addGoods($param);
					
					
					//zmr>v30生成二维码
					$PhpQRCode->set('date',WAP_SITE_URL . '/tmpl/product_detail.html?goods_id='.$goods_id1);
                    $PhpQRCode->set('pngTempName', $goods_id1 . '.png');
                    $PhpQRCode->init();
					//
				  
			        //规格导入
					// 更新常用分类信息
                    $goods_class = $model_goodsclass->getGoodsClassLineForTag($_POST['gc_id']);
                    $type_id=$goods_class['type_id'];
				    //添加规格表 （防止BUG暂时不做了）
		           			
				    if($type_id>0){
						//$spec_id =  $model_type->addGoodsType($goods_id1, $goods_id, array('cate_id' => $_POST['gc_id'], 'type_id' => $type_id, 'attr' => $_POST['attr']));
					}
					$goods_id_str.=",".$goods_id;
					if($goods_id){
						/**
						 * 添加商品的店铺分类表
						 */
						
						/**
						 * 商品多图的添加
						 */
						
					  	if(!empty($pic_array['goods_image']) && is_array($pic_array['goods_image'])){
							$insert_array = array();
							foreach ($pic_array['goods_image'] as $pic){
								if($pic	== '')continue;
								$param	= array();
						     	$param['goods_image']	= $pic;
								
								$param['store_id']	= $_SESSION['store_id'];
								
								
								$param['goods_commonid']	= $goods_id;
								$insert_array[] = $param;
							}
							//$rs = Model('upload');
							//$rs = $rs->add($param);
							$rs = $model_store_goods->addGoodsImagesAll($insert_array);
					    }	
					}
				}
				if($goods_id_str!=""){
					Tpl::output('goods_id_str',substr($goods_id_str,1,strlen($goods_id_str)));
				}
			}
			Tpl::output('step','4');
		}
		
		/**
		 * 相册分类
		 */
		$model_album = Model('album');
		$param = array();
		$param['album_aclass.store_id']	= $_SESSION['store_id'];
		$aclass_info = $model_album->getClassList($param);
		Tpl::output('aclass_info',$aclass_info);
		
		
		Tpl::output('PHPSESSID',session_id());
		
		Tpl::output('menu_sign','taobao_import');
		Tpl::showpage('store_goods_import');
	}
	
	private function get_goods_image($pic_string){
		if($pic_string == ''){
			return false;
		}
		$pic_array = explode(';',$pic_string);
		if(!empty($pic_array) && is_array($pic_array)){
			$array	= array();
			$goods_image	= array();
			$multi_image	= array();
			$i=0;
			foreach($pic_array as $v){
				if($v != ''){
					$line = explode(':',$v);//[0] 文件名tbi [2] 排序
					$goods_image[] = $line[0];
				}
			}
			$array['goods_image']	= array_unique($goods_image);
			$str = implode(',',$array['goods_image'])."\r\n";
			file_put_contents('imgarr.txt',$str,FILE_APPEND);
			return $array;
		}else{
			return false;
		}
	}
	/**
	 * 淘宝数据字段名
	 *
	 * @return array
	 */
	private function taobao_fields()
	{
		return array(
		'goods_name'		=> '宝贝名称',
		'cid'				=> '宝贝类目',
		'goods_form'		=> '新旧程度',
		'goods_store_price'	=> '宝贝价格',
		'spec_goods_storage'=> '宝贝数量',
		'goods_indate'		=> '有效期',
		'goods_transfee_charge'=>'运费承担',
		'py_price'			=>'平邮',
		'es_price'			=>'EMS',
		'kd_price'			=>'快递',
		//'goods_show'		=> '放入仓库',
		'spec'			=>'销售属性别名',
		'goods_commend'		=> '橱窗推荐',
		'goods_body'		=> '宝贝描述',
		'goods_image'		=> '新图片',
		'goods_serial'		=> '商家编码'
		);
		/*return array(
		'goods_name'		=> Language::get('store_goods_import_goodsname'),
		'cid'				=> Language::get('store_goods_import_goodscid'),
		'goods_store_price'	=> Language::get('store_goods_import_goodsprice'),
		'spec_goods_storage'=> Language::get('store_goods_import_goodsnum'),
		//'goods_show'		=> '放入仓库',
		'goods_commend'		=> Language::get('store_goods_import_goodstuijian'),
		'goods_body'		=> Language::get('store_goods_import_goodsdesc'),
		'goods_image'		=> Language::get('store_goods_import_goodspic'),
		'sale_attr'			=> Language::get('store_goods_import_goodsproperties')
		);*/
	}

	/**
	 * 每个字段所在CSV中的列序号，从0开始算 
	 *
	 * @param array $title_arr
	 * @param array $import_fields
	 * @return array
	 */
	private function taobao_fields_cols($title_arr, $import_fields)
	{
		$fields_cols = array();
		foreach ($import_fields as $k => $field)
		{
			$pos = array_search($field, $title_arr);
			if ($pos !== false)
			{
				$fields_cols[$k] = $pos;
			}
		}
		return $fields_cols;
	}

	/**
	 * 解析淘宝助理CSV数据
	 *
	 * @param string $csv_string
	 * @return string
	 */
	private function parse_taobao_csv($csv_string)
	{
		
		
		//zmr>>>去除前面没用的乱码
		$scount = strpos($csv_string, "宝贝名称");
		$csv_string=substr($csv_string,$scount);
		//zmr<<<
		/* 定义CSV文件中几个标识性的字符的ascii码值 */
		define('ORD_SPACE', 32); // 空格
		define('ORD_QUOTE', 34); // 双引号
		define('ORD_TAB',    9); // 制表符
		define('ORD_N',     10); // 换行\n
		define('ORD_R',     13); // 换行\r

		/* 字段信息 */
		$import_fields = $this->taobao_fields(); // 需要导入的字段在CSV中显示的名称
		$fields_cols = array(); // 每个字段所在CSV中的列序号，从0开始算
		$csv_col_num = 0; // csv文件总列数

		$pos = 0; // 当前的字符偏移量
		$status = 0; // 0标题未开始 1标题已开始
		$title_pos = 0; // 标题开始位置
		$records = array(); // 记录集
		$field = 0; // 字段号
		$start_pos = 0; // 字段开始位置
		$field_status = 0; // 0未开始 1双引号字段开始 2无双引号字段开始
		$line =0; // 数据行号
		while($pos < strlen($csv_string))
		{
			$t = ord($csv_string[$pos]); // 每个UTF-8字符第一个字节单元的ascii码
			$next = ord($csv_string[$pos + 1]);
			$next2 = ord($csv_string[$pos + 2]);
			$next3 = ord($csv_string[$pos + 3]);

			if ($status == 0 && !in_array($t, array(ORD_SPACE, ORD_TAB, ORD_N, ORD_R)))
			{
				$status = 1;
				$title_pos = $pos;
			}
			
			if ($status == 1)
			{
				if ($field_status == 0 && $t== ORD_N)
				{
					static $flag = null;
					if ($flag === null)
					{
						$title_str = substr($csv_string, $title_pos, $pos - $title_pos);
						$title_arr = explode("\t", trim($title_str));
						$fields_cols = $this->taobao_fields_cols($title_arr, $import_fields);
						
						if (count($fields_cols) != count($import_fields))
						{
							return false;
						}
						$csv_col_num = count($title_arr); // csv总列数
						$flag = 1;
					}

					if ($next == ORD_QUOTE)
					{
						$field_status = 1; // 引号数据单元开始
						$start_pos = $pos = $pos + 2; // 数据单元开始位置(相对\n偏移+2)
					}
					else
					{
						$field_status = 2; // 无引号数据单元开始
						$start_pos = $pos = $pos + 1; // 数据单元开始位置(相对\n偏移+1)
					}
					continue;
				}

				if($field_status == 1 && $t == ORD_QUOTE && in_array($next, array(ORD_N, ORD_R, ORD_TAB))) // 引号+换行 或 引号+\t
				{
					$records[$line][$field] = addslashes(substr($csv_string, $start_pos, $pos - $start_pos));
					$field++;
					if ($field == $csv_col_num)
					{
						$line++;
						$field = 0;
						$field_status = 0;
						continue;
					}
					if (($next == ORD_N && $next2 == ORD_QUOTE) || ($next == ORD_TAB && $next2 == ORD_QUOTE) || ($next == ORD_R && $next2 == ORD_QUOTE))
					{
						$field_status = 1;
						$start_pos = $pos = $pos + 3;
						continue;
					}
					if (($next == ORD_N && $next2 != ORD_QUOTE) || ($next == ORD_TAB && $next2 != ORD_QUOTE) || ($next == ORD_R && $next2 != ORD_QUOTE))
					{
						$field_status = 2;
						$start_pos = $pos = $pos + 2;
						continue;
					}
					if ($next == ORD_R && $next2 == ORD_N && $next3 == ORD_QUOTE)
					{
						$field_status = 1;
						$start_pos = $pos = $pos + 4;
						continue;
					}
					if ($next == ORD_R && $next2 == ORD_N && $next3 != ORD_QUOTE)
					{
						$field_status = 2;
						$start_pos = $pos = $pos + 3;
						continue;
					}
				}

				if($field_status == 2 && in_array($t, array(ORD_N, ORD_R, ORD_TAB))) // 换行 或 \t
				{
					$records[$line][$field] = addslashes(substr($csv_string, $start_pos, $pos - $start_pos));
					$field++;
					if ($field == $csv_col_num)
					{
						$line++;
						$field = 0;
						$field_status = 0;
						continue;
					}
					if (($t == ORD_N && $next == ORD_QUOTE) || ($t == ORD_TAB && $next == ORD_QUOTE) || ($t == ORD_R && $next == ORD_QUOTE))
					{
						$field_status = 1;
						$start_pos = $pos = $pos + 2;
						continue;
					}
					if (($t == ORD_N && $next != ORD_QUOTE) || ($t == ORD_TAB && $next != ORD_QUOTE) || ($t == ORD_R && $next != ORD_QUOTE))
					{
						$field_status = 2;
						$start_pos = $pos = $pos + 1;
						continue;
					}
					if ($t == ORD_R && $next == ORD_N && $next2 == ORD_QUOTE)
					{
						$field_status = 1;
						$start_pos = $pos = $pos + 3;
						continue;
					}
					if ($t == ORD_R && $next == ORD_N && $next2 != ORD_QUOTE)
					{
						$field_status = 2;
						$start_pos = $pos = $pos + 2;
						continue;
					}
				}
			}

			if($t > 0 && $t <= 127) {
				$pos++;
			} elseif(192 <= $t && $t <= 223) {
				$pos += 2;
			} elseif(224 <= $t && $t <= 239) {
				$pos += 3;
			} elseif(240 <= $t && $t <= 247) {
				$pos += 4;
			} elseif(248 <= $t && $t <= 251) {
				$pos += 5;
			} elseif($t == 252 || $t == 253) {
				$pos += 6;
			} else {
				$pos++;
			}	
		}
		
		$return = array();
		foreach ($records as $key => $record)
		{
			foreach ($record as $k => $col)
			{
				$col = trim($col); // 去掉数据两端的空格
				/* 对字段数据进行分别处理 */
				switch ($k)
				{
					case $fields_cols['goods_body']		: $return[$key]['goods_body'] = str_replace(array("\\\"\\\"", "\"\""), array("\\\"", "\""), $col); break;
					case $fields_cols['goods_image']	: $return[$key]['goods_image'] = trim($col,'"');break;
					//case $fields_cols['goods_show']		: $return[$key]['goods_show'] = $col == 1 ? 0 : 1; break;
					case $fields_cols['goods_name']		: $return[$key]['goods_name'] = $col; break;
					case $fields_cols['spec_goods_storage']	: $return[$key]['spec_goods_storage'] = $col; break;
					case $fields_cols['goods_store_price']: $return[$key]['goods_store_price'] = $col; break;
					case $fields_cols['goods_commend']	: $return[$key]['goods_commend'] = $col; break;
					case $fields_cols['spec']	: $return[$key]['spec'] = $col; break;
					case $fields_cols['sale_attr']		: $return[$key]['sale_attr'] = $col; break;
					case $fields_cols['goods_form']	: $return[$key]['goods_form'] = $col; break;
					case $fields_cols['goods_transfee_charge']		: $return[$key]['goods_transfee_charge'] = $col; break;
					case $fields_cols['py_price']	: $return[$key]['py_price'] = $col; break;
					case $fields_cols['es_price']		: $return[$key]['es_price'] = $col; break;
					case $fields_cols['kd_price']		: $return[$key]['kd_price'] = $col; break;
					case $fields_cols['goods_serial']		: $return[$key]['goods_serial'] = $col; break;
					
//					case $fields_cols['goods_indate']	: $return[$key]['goods_indate'] = $col; break;
				}
			}
		}
		return $return;
	}


}
