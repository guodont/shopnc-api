<?php
defined('InShopNC') or exit('Access Invalid!');

$lang['bundling_gold']				= '金幣';
$lang['bundling_start_time']		= '開始時間';
$lang['bundling_end_time']			= '結束時間';
$lang['bundling_add']				= '添加活動';
$lang['bundling_edit']				= '編輯組合';
$lang['bundling_name']				= '活動名稱';
$lang['bundling_status']			= '活動狀態';
$lang['bundling_status_all']		= '全部狀態';
$lang['bundling_status_0']			= '關閉';
$lang['bundling_status_1']			= '開啟';
$lang['bundling_published']			= '已發佈活動活動次數';
$lang['bundling_surplus']			= '剩餘可發佈活動數量';
$lang['bundling_gold_not_enough']	= '金幣不足，購買失敗。';
$lang['bundling_add_fail_quantity_beyond']	= '剩餘可發佈數量不足，不能在添加組合銷售活動';
$lang['promotion_unavailable']		= '商品促銷功能尚未開啟';
$lang['bundling_list']				= '活動列表';
$lang['bundling_purchase_history']	= '購買套餐記錄';
$lang['bundling_quota_add']			= '購買套餐';
$lang['bundling_quota_current_error']	= '您還沒有購買套餐，或該促銷活動已經關閉。<br />請先購買套餐，在查看活動列表。';
$lang['bundling_list_null']				= '您還沒有添加活動。';
$lang['bundling_delete_success']		= '活動刪除成功。';
$lang['bundling_delete_fail']			= '活動刪除失敗。';

/**
 * 購買活動
 */
$lang['bundling_quota_add_quantity']	= '套餐購買數量';
$lang['bundling_price_explain1']		= '購買單位為月(30天)，一次最多購買12個月，購買後立即生效，即可發佈組合銷售活動。';
$lang['bundling_price_explain2']		= '每月您需要支付%d金幣。';
$lang['bundling_quota_price_fail']		= '參數錯誤，購買失敗。';
$lang['bundling_quota_price_succ']		= '購買成功。';
$lang['bundling_quota_quantity_error']	= '不能為空，且必須為1~12之間的整數';
$lang['bundling_quota_add_confirm']		= '確認購買?您總共需要支付';
$lang['bundling_quota_success_glog_desc']= '購買組合銷售活動%d個月，單價%d金幣，總共花費%d金幣';

/**
 * 添加活動
 */
$lang['bundling_add_explain1']				= '您只能發佈%d個組合銷售活動；每個活動最多可以添加%d個商品。';
$lang['bundling_add_explain2']				= '每個活動最多可以添加%d個商品。';
$lang['bundling_add_goods_explain']			= '搭配銷售的商品名稱可<br/>自定義編輯，上下拖移<br/>商品列可自定義顯示排<br/>序；編輯、刪除、排序<br/>等操作提交後生效。';
$lang['bundling_goods']						= '搭配商品';
$lang['bundling_show_name']					= '顯示名稱';
$lang['bundling_cost_price']				= '原價';
$lang['bundling_cost_price_note']			= '&nbsp;(已添加搭配商品的預設價格總計)';
$lang['bundling_operate']					= '操作';
$lang['bundling_goods_add']					= '添加商品';
$lang['bundling_add_price']					= '組合銷售價格';
$lang['bundling_add_price_title']			= '自定義組合銷售商品的優惠價格總計';
$lang['bundling_add_img']					= '活動圖片';
$lang['bundling_add_pic_list_tip']			= '該圖組用於組合詳情頁<br/>可由相冊選擇圖片代替<br/>預設產品圖；左右拖移<br/>圖片可更改顯示排序。';
$lang['bundling_add_form_album']			= '從相冊選擇圖片';
$lang['bundling_add_freight_method']		= '運費承擔';
$lang['bundling_add_freight_method_seller']	= '賣家承擔運費';
$lang['bundling_add_freight_method_buyer']	= '買家承擔運費（快遞）';
$lang['bundling_add_desc']					= '活動描述';
$lang['bundling_add_form_album_to_desc']	= '插入相冊圖片';
$lang['bundling_add_name_error']			= '請填寫活動名稱';
$lang['bundling_add_goods_error']			= '請選擇商品';
$lang['bundling_add_price_error_null']		= '請填寫活動價格';
$lang['bundling_add_price_error_not_num']	= '價格只能為數字';
$lang['bundling_add_not_add_img']			= '不能在繼續添加圖片。';
$lang['bundling_add_goods_show_note']		= '下架商品在店舖頁面不顯示，請重新上架或選擇其他商品';

/**
 * 添加套餐商品
 */
$lang['bundling_goods_store_class']			= '店舖分類';
$lang['bundling_goods_name']				= '商品名稱';
$lang['bundling_goods_code']				= '貨號';
$lang['bundling_goods_price']				= '價格';
$lang['bundling_goods_storage']				= '庫存';
$lang['bundling_goods_storage_not_enough']	= '庫存不足，不能添加商品。';
$lang['bundling_goods_add_bundling']		= '添加搭配';
$lang['bundling_goods_add_bundling_exit']	= '取消搭配';
$lang['bundling_goods_add_enough_prompt']	= '您已經添加了%d個，不能在繼續添加商品。';
$lang['bundling_goods_remove']				= '移除';

/**
 * 購買記錄
 */
$lang['bundling_history_quantity']			= '購買數量（月）';
$lang['bundling_history_consumption_gold']	= '消費金幣';

/**
 * 活動列表
 */
$lang['bundling_list_goods_count']			= '商品數量';