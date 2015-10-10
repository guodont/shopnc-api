<?php
defined('InShopNC') or exit('Access Invalid!');

// index
$lang['promotion_unavailable'] = '商品促銷功能尚未開啟';
$lang['bundling_quota']				= '套餐';
$lang['bundling_list']				= '活動';
$lang['bundling_setting']			= '設置';
$lang['bundling_gold_price']		= '購買組合銷售所需金幣數量';
$lang['bundling_sum']				= '組合銷售發佈數量';
$lang['bundling_goods_sum']			= '每個組合加入商品數量';
$lang['bundling_price_prompt']		= '購買單位為月(30天)，購買後賣家可以在所購買周期內發佈組合銷售活動。';
$lang['bundling_sum_prompt']		= '允許店舖發佈組合銷售的最大數量，0為沒有限制。';
$lang['bundling_goods_sum_prompt']	= '每個組合能加入商品的最大數量，不大於5的數字。';
$lang['bundling_price_error']		= '不能為空，且不小於1的整數';
$lang['bundling_sum_error']			= '不能為空，且不小於0的整數';
$lang['bundling_goods_sum_error']	= '不能為空，且為1到5之間的整數，包括1和5';
$lang['bundling_update_succ']		= '更新成功';
$lang['bundling_update_fail']		= '更新失敗';

$lang['bundling_state_all']			= '全部狀態';
$lang['bundling_state_1']			= '開啟';
$lang['bundling_state_0']			= '關閉';


// 活動列表
$lang['bundling_quota_list_prompts']= '賣家購買組合銷售活動的列表，並可以對結束時間、狀態進行修改。注意：結束時間小於當前時間活動狀態無法開啟。';
$lang['bundling_quota_store_name']	= '店舖名稱';

// 活動編輯
$lang['bundling_quota_endtime_required']	= '請添加結束時間';
$lang['bundling_quota_endtime_dateValidate']= '結束時間需要大於開始時間';
$lang['bundling_quota_store_name']			= '店舖名稱';
$lang['bundling_quota_quantity']			= '購買數量';
$lang['bundling_quota_starttime']			= '開始時間';
$lang['bundling_quota_endtime']				= '結束時間';
$lang['bundling_quota_endtime_tips']		= '如果狀態選擇開啟，請設置結束時間大於當前時候，否則不能開啟。';
$lang['bundling_quota_state_tips']			= '設置狀態為開啟時，結束時間必須大於當前時間，否則狀態無法開啟。';
$lang['bundling_quota_prompts']				= '查看每個店舖的組合銷售活動信息，您可以取消某個活動。';

// 套餐列表
$lang['bundling_name']						= '活動名稱';
$lang['bundling_price']						= '活動銷售價格';
$lang['bundling_goods_count']				= '商品數量';
