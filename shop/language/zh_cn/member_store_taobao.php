<?php
defined('InShopNC') or exit('Access Invalid!');

$lang['store_goods_index_goods_limit']			= '您已经达到了添加商品的上限';
$lang['store_goods_index_goods_limit1']			= '个，如果您想继续增加商品，请到“店铺设置”升级店铺等级';
$lang['store_goods_index_pic_limit']			= '您已经达到了图片空间的上限';
$lang['store_goods_index_pic_limit1']			= 'M，如果您想继续增加商品，请到“店铺设置”升级店铺等级';
$lang['store_goods_index_time_limit']			= '您已经达到店铺使用期限，如果您想继续增加商品，请到“店铺设置”升级店铺等级';
$lang['store_goods_index_no_pay_type']			= '平台还未设置支付方式，请及时与平台联系';
/**
 * 图片上传
 */
$lang['store_goods_upload_pic_limit']			= '您已经达到了图片空间的上限';
$lang['store_goods_upload_pic_limit1']			= 'M，如果您想继续增加商品，请到“店铺设置”升级店铺等级';
$lang['store_goods_upload_fail']				= '上传失败';
$lang['store_goods_upload_upload']				= '上传';
$lang['store_goods_upload_normal']				= '普通上传';
$lang['store_goods_upload_del_fail']			= '删除图片失败';
$lang['store_goods_img_upload']					= '图片上传';

/**
 * 淘宝导入
 */
$lang['store_goods_import_choose_file']		= '请选择要上传csv的文件';
$lang['store_goods_import_unknown_file']	= '文件来源不明';
$lang['store_goods_import_wrong_type']		= '文件类型必须为csv,您所上传的文件类型为:';
$lang['store_goods_import_size_limit']		= '文件大小必须为'.ini_get('upload_max_filesize').'以内';
$lang['store_goods_import_wrong_class']		= '请选择商品分类（必须选到最后一级）';
$lang['store_goods_import_wrong_class1']	= '该商品分类不可用，请重新选择商品分类（必须选到最后一级）';
$lang['store_goods_import_wrong_class2']	= '必须选到最后一级';
$lang['store_goods_import_wrong_column']	= '文件内字段与系统要求的字段不符,请详细阅读导入说明';
$lang['store_goods_import_choose']			= '请选择...';
$lang['store_goods_import_step1']			= '第一步：导入CSV文件';
$lang['store_goods_import_choose_csv']		= '请选择文件：';
$lang['store_goods_import_title_csv']		= '导入程序默认从第二行执行导入，请保留CSV文件第一行的标题行，最大'.ini_get('upload_max_filesize');
$lang['store_goods_import_goods_class']		= '商品分类：';
$lang['store_goods_import_store_goods_class']	= '本店分类：';
$lang['store_goods_import_new_class']			= '新增分类';
$lang['store_goods_import_belong_multiple_store_class']	= '可以从属于多个本店分类';
$lang['store_goods_import_unicode']			= '字符编码：';
$lang['store_goods_import_file_type']		= '文件格式：';
$lang['store_goods_import_file_csv']		= 'csv文件';
$lang['store_goods_import_desc']			= '导入说明：';
$lang['store_goods_import_csv_desc']		= '1.如果修改CSV文件请务必使用微软excel软件，且必须保证第一行表头名称含有如下项目: 
宝贝名称、宝贝类目、新旧程度、宝贝价格、宝贝数量、有效期、运费承担、平邮、EMS、快递、橱窗推荐、宝贝描述、新图片。<br/>
2.如果因为淘宝助理版本差异表头名称有出入，请先修改成上述的名称方可导入，不区分全新、二手、闲置等新旧程度，导入后商品类型都是全新。<br/>
3.如果CSV文件超过'.ini_get('upload_max_filesize').'请通过excel软件编辑拆成多个文件进行导入。<br/>
4.每个商品最多支持导入5张图片。';
$lang['store_goods_import_submit']			= '导入';
$lang['store_goods_import_step2']			= '第二步：上传商品图片';
$lang['store_goods_import_tbi_desc']		= '请上传与csv文件同级的images目录(或与csv文件同名的目录)内的tbi文件';
$lang['store_goods_import_upload_complete'] = "上传完毕";
$lang['store_goods_import_doing'] 			= "正在导入...";
$lang['store_goods_import_step3']			= '第三步：整理数据';
$lang['store_goods_import_remind']			= '前两步完成后才可进行数据整理，确认整理数据吗';
$lang['store_goods_import_remind2']			= '（如果图片分多次上传，请在所有图片上传完成后整理）';
$lang['store_goods_import_pack']			= '整理数据';
$lang['store_goods_pack_wrong1']			= '请先导入CSV文件';
$lang['store_goods_pack_wrong2']			= '请导入正确的CSV文件';
$lang['store_goods_pack_success']			= '数据整理成功';
$lang['store_goods_import_end']				= '，最后';
$lang['store_goods_import_products_no_import']	= '件商品没有导入';
$lang['store_goods_import_area']			= '所在地：';

/*淘宝文件导入*/
$lang['store_goods_import_upload_album'] = '导入相册选择';
$lang['store_goods_index_batch_upload']	 = '批量上传';

/**
 * ajax修改商品标题
 */
$lang['store_goods_title_change_tip']		= '单击修改商品标题名称，长度<br/>至少3个字符，最长50个汉字';

/**
 * ajax修改商品库存
 */
$lang['store_goods_stock_change_stock']		= '修改库存';
$lang['store_goods_stock_change_tip']		= '单击修改库存';
$lang['store_goods_stock_stock_sum']		= '库存总数';
$lang['store_goods_stock_change_more_stock']= '修改更多的库存信息';
$lang['store_goods_stock_input_error']		= '请填写不小于零的数字!';

/**
 * ajax修改商品库存
 */
$lang['store_goods_price_change_price']		= '修改价格';
$lang['store_goods_price_change_tip']		= '单击修改价格';
$lang['store_goods_price_change_more_price']= '修改更多价格信息';
$lang['store_goods_price_input_error']		= '请填写正确的价格！';

/**
 * ajax修改商品推荐
 */
$lang['store_goods_commend_change_tip']		= '选择是否作为店铺推荐商品';

?>
