<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 積分禮品功能公用
 */
$lang['admin_pointprodp']	 		= '禮品';
$lang['admin_pointprod_unavailable']	 		= '系統未開啟積分中心，是否自動開啟';
$lang['admin_pointprod_parameter_error']		= '參數錯誤';
$lang['admin_pointprod_record_error']			= '記錄信息錯誤';
$lang['admin_pointprod_userrecord_error']		= '用戶信息錯誤';
$lang['admin_pointprod_goodsrecord_error']		= '禮品信息錯誤';
$lang['admin_pointprod_list_title']			= '禮品列表';
$lang['admin_pointprod_add_title']			= '新增禮品';
$lang['admin_pointprod_state']				= '狀態';
$lang['admin_pointprod_show_up']			= '上架';
$lang['admin_pointprod_show_down']			= '下架';
$lang['admin_pointprod_commend']			= '推薦';
$lang['admin_pointprod_forbid']				= '禁售';
$lang['admin_pointprod_goods_name']			= '禮品名稱';
$lang['pointprod_help1']					= '禮品會出現在積分中心，會員可憑積兌換';
$lang['admin_pointprod_goods_points']		= '兌換積分';
$lang['admin_pointprod_goods_price']		= '禮品原價';
$lang['admin_pointprod_goods_storage']		= '庫存';
$lang['admin_pointprod_goods_view']			= '瀏覽';
$lang['admin_pointprod_salenum']			= '售出';
$lang['admin_pointprod_yes']				= '是';
$lang['admin_pointprod_no']					= '否';
$lang['admin_pointprod_delfail']			= '刪除失敗';
$lang['admin_pointorder_list_title']		= '兌換列表';
/**
 * 添加
 */
$lang['admin_pointprod_baseinfo']		= '禮品基本信息';
$lang['admin_pointprod_goods_image']	= '禮品圖片';
$lang['admin_pointprod_goods_tag']		= '禮品標籤';
$lang['admin_pointprod_goods_serial']	= '禮品編號';
$lang['admin_pointprod_requireinfo']	= '兌換要求';
$lang['admin_pointprod_limittip']		= '限制每會員兌換數量';
$lang['admin_pointprod_limit_yes']		= '限制';
$lang['admin_pointprod_limit_no']		= '不限制';
$lang['admin_pointprod_limitnum']		= '每會員限兌數量';
$lang['admin_pointprod_freightcharge']	= '運費承擔方式';
$lang['admin_pointprod_freightcharge_saler']	= '賣家';
$lang['admin_pointprod_freightcharge_buyer']	= '買家';
$lang['admin_pointprod_freightprice']	= '運費價格';
$lang['admin_pointprod_limittimetip']		= '限制兌換時間';
$lang['admin_pointprod_limittime_yes']		= '限制';
$lang['admin_pointprod_limittime_no']		= '不限制';
$lang['admin_pointprod_starttime']	= '開始時間';
$lang['admin_pointprod_endtime']	= '結束時間';
$lang['admin_pointprod_time_day']	= '日';
$lang['admin_pointprod_time_hour']	= '時';
$lang['admin_pointprod_stateinfo']	= '狀態設置';
$lang['admin_pointprod_isshow']	= '是否上架';
$lang['admin_pointprod_iscommend']	= '是否推薦';
$lang['admin_pointprod_isforbid']	= '是否禁售';
$lang['admin_pointprod_forbidreason']= '禁售原因';
$lang['admin_pointprod_seoinfo']	= 'SEO設置';
$lang['admin_pointprod_seokey']		= '關鍵字';
$lang['admin_pointprod_otherinfo']		= '其他設置';
$lang['admin_pointprod_sort']		= '禮品排序';
$lang['admin_pointprod_sorttip']		= '註：數值越小排序越靠前';
$lang['admin_pointprod_seodescription']		= 'SEO描述';
$lang['admin_pointprod_descriptioninfo']	= '禮品描述';
$lang['admin_pointprod_uploadimg']	= '圖片上傳';
$lang['admin_pointprod_uploadimg_more']	= '批量上傳';
$lang['admin_pointprod_uploadimg_common']	= '普通上傳';
$lang['admin_pointprod_uploadimg_complete']	= '已傳圖片';
$lang['admin_pointprod_uploadimg_add']	= '插入';
$lang['admin_pointprod_uploadimg_addtoeditor']	= '插入編輯器';
$lang['admin_pointprod_add_goodsname_error']	= '請添加禮品名稱';
$lang['admin_pointprod_add_goodsprice_null_error']	= '請添加禮品原價';
$lang['admin_pointprod_add_goodsprice_number_error']	= '禮品原價必須為數字且大於等於0';
$lang['admin_pointprod_add_goodspoint_null_error']	= '請添加兌換積分';
$lang['admin_pointprod_add_goodspoint_number_error']	= '兌換積分為整數且大於等於0';
$lang['admin_pointprod_add_goodsserial_null_error']	= '請添加禮品編號';
$lang['admin_pointprod_add_storage_null_error']	    = '請添加禮品庫存';
$lang['admin_pointprod_add_storage_number_error']	= '禮品庫存必須為整數且大於等於0';
$lang['admin_pointprod_add_limitnum_error']			= '請添加每會員限兌數量';
$lang['admin_pointprod_add_limitnum_digits_error']	= '會員限兌數量為整數且大於等於0';
$lang['admin_pointprod_add_freightprice_null_error']		= '請添加運費價格';
$lang['admin_pointprod_add_freightprice_number_error']		= '運費價格必須為數字且大於等於0';
$lang['admin_pointprod_add_limittime_null_error']		= '請添加開始時間和結束時間';
$lang['admin_pointprod_add_sort_null_error']		= '請添加禮品排序';
$lang['admin_pointprod_add_sort_number_error']		= '禮品排序為整數且大於等於0';
$lang['admin_pointprod_add_upload']		= '上傳';
$lang['admin_pointprod_add_upload_img_error']		= '圖片限于png,gif,jpeg,jpg格式';
$lang['admin_pointprod_add_iframe_uploadfail']		= '上傳失敗';
$lang['admin_pointprod_add_success']		= '禮品添加成功';
/**
 * 更新
 */
$lang['admin_pointprod_edit_success']		= '禮品更新成功';
$lang['admin_pointprod_edit_addtime']		= '添加時間';
$lang['admin_pointprod_edit_viewnum']		= '瀏覽次數';
$lang['admin_pointprod_edit_salenum']		= '售出數量';
/**
 * 刪除
 */
$lang['admin_pointprod_del_success']		= '刪除成功';
$lang['admin_pointprod_del_fail']			= '刪除失敗';