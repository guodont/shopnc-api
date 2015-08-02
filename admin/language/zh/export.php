<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 導出語言包，只有在執行導出行為時，才會調用
 */

//品牌
$lang['exp_brandid']		= '品牌ID';
$lang['exp_brand']			= '品牌';
$lang['exp_brand_cate']		= '類別';
$lang['exp_brand_img']		= '標識圖';

//商品
$lang['exp_product']		= '商品';
$lang['exp_pr_cate']		= '分類';
$lang['exp_pr_brand']		= '品牌';
$lang['exp_pr_price']		= '價格';
$lang['exp_pr_serial']		= '貨號';
$lang['exp_pr_state']		= '狀態';
$lang['exp_pr_type']		= '類型';
$lang['exp_pr_addtime']		= '發佈時間';
$lang['exp_pr_store']		= '店舖';
$lang['exp_pr_storeid']		= '店舖ID';
$lang['exp_pr_wgxj']		= '違規下架';
$lang['exp_pr_sj']			= '上架';
$lang['exp_pr_xj']			= '下架';
$lang['exp_pr_new']			= '全新';
$lang['exp_pr_old']			= '二手';

//類型
$lang['exp_type_name']		= '類型';

//規格
$lang['exp_spec']			= '規格';
$lang['exp_sp_content']		= '規格內容';

//店舖
$lang['exp_store']			= '店舖';
$lang['exp_st_name']		= '店主賬號';
$lang['exp_st_sarea']		= '所在地';
$lang['exp_st_grade']		= '等級';
$lang['exp_st_adtime']		= '創店時間';
$lang['exp_st_yxq']			= '有效期';
$lang['exp_st_state']		= '狀態';
$lang['exp_st_xarea']		= '詳細地址';
$lang['exp_st_post']		= '郵編';
$lang['exp_st_tel']			= '聯繫電話';
$lang['exp_st_kq']			= '開啟';
$lang['exp_st_shz']			= '審核中';
$lang['exp_st_close']		= '關閉';

//會員
$lang['exp_member']			= '會員';
$lang['exp_mb_name']		= '真實姓名';
$lang['exp_mb_jf']			= '積分';
$lang['exp_mb_yck']			= '預存款';
$lang['exp_mb_jbs']			= '金幣數';
$lang['exp_mb_sex']			= '性別';
$lang['exp_mb_ww']			= '旺旺';
$lang['exp_mb_dcs']			= '登錄次數';
$lang['exp_mb_rtime']		= '註冊時間';
$lang['exp_mb_ltime']		= '上次登錄';
$lang['exp_mb_storeid']		= '店舖ID';
$lang['exp_mb_nan']			= '男';
$lang['exp_mb_nv']			= '女';

//積分明細
$lang['exp_pi_member']		= '會員';
$lang['exp_pi_system']		= '管理員';
$lang['exp_pi_point']		= '積分值';
$lang['exp_pi_time']		= '發生時間';
$lang['exp_pi_jd']			= '操作階段';
$lang['exp_pi_ms']			= '描述';
$lang['exp_pi_jfmx']		= '積分明細';

//預存款充值
$lang['exp_yc_no']			= '充值編號';
$lang['exp_yc_member']		= '會員名';
$lang['exp_yc_money']		= '充值金額';
$lang['exp_yc_pay']			= '付款方式';
$lang['exp_yc_ctime']		= '創建時間';
$lang['exp_yc_paystate']	= '支付狀態';
$lang['exp_yc_memberid']	= '會員ID';
$lang['exp_yc_yckcz']		= '預存款充值';

//預存款提現
$lang['exp_tx_no']			= '提現編號';
$lang['exp_tx_member']		= '會員名';
$lang['exp_tx_money']		= '提現金額';
$lang['exp_tx_type']		= '提現方式';
$lang['exp_tx_ctime']		= '創建時間';
$lang['exp_tx_state']		= '提現狀態';
$lang['exp_tx_memberid']	= '會員ID';
$lang['exp_tx_title']		= '預存款提現';

//預存款明細
$lang['exp_mx_member']		= '會員';
$lang['exp_mx_ctime']		= '發生時間';
$lang['exp_mx_money']		= '金額';
$lang['exp_mx_type']		= '金額類型';
$lang['exp_mx_system']		= '管理員';
$lang['exp_mx_stype']		= '事件類型';
$lang['exp_mx_mshu']		= '描述';
$lang['exp_mx_rz']			= '預存款明細日誌';

//訂單
$lang['exp_od_no']			= '訂單號';
$lang['exp_od_store']		= '店舖';
$lang['exp_od_buyer']		= '買家';
$lang['exp_od_xtimd']		= '下單時間';
$lang['exp_od_count']		= '訂單總額';
$lang['exp_od_yfei']		= '運費';
$lang['exp_od_paytype']		= '支付方式';
$lang['exp_od_state']		= '訂單狀態';
$lang['exp_od_storeid']		= '店舖ID';
$lang['exp_od_selerid']		= '賣家ID';
$lang['exp_od_buyerid']		= '買家ID';
$lang['exp_od_bemail']		= '買家Email';
$lang['exp_od_sta_qx']		= '已取消';
$lang['exp_od_sta_dfk']		= '待付款';
$lang['exp_od_sta_dqr']		= '已付款、待確認';
$lang['exp_od_sta_yfk']		= '已付款';
$lang['exp_od_sta_yfh']		= '已發貨';
$lang['exp_od_sta_yjs']		= '已結算';
$lang['exp_od_sta_dsh']		= '待審核';
$lang['exp_od_sta_yqr']		= '已確認';
$lang['exp_od_order']		= '訂單';

//金幣購買記錄
$lang['exp_jbg_member']		= '會員名';
$lang['exp_jbg_store']		= '店舖';
$lang['exp_jbg_jbs']		= '購買金幣數';
$lang['exp_jbg_money']		= '所需金額';
$lang['exp_jbg_gtime']		= '購買時間';
$lang['exp_jbg_paytype']	= '支付方式';
$lang['exp_jbg_paystate']	= '支付狀態';
$lang['exp_jbg_storeid']	= '店舖ID';
$lang['exp_jbg_memberid']	= '會員ID';
$lang['exp_jbg_wpay']		= '未支付';
$lang['exp_jbg_ypay']		= '已支付';
$lang['exp_jbg_jbgm']		= '金幣購買';

//金幣日誌
$lang['exp_jb_member']		= '會員';
$lang['exp_jb_store']		= '店舖';
$lang['exp_jb_jbs']			= '金幣數';
$lang['exp_jb_type']		= '變更類型';
$lang['exp_jb_btime']		= '變更時間';
$lang['exp_jb_mshu']		= '描述';
$lang['exp_jb_storeid']		= '店舖ID';
$lang['exp_jb_memberid']	= '會員ID';
$lang['exp_jb_add']			= '增加';
$lang['exp_jb_del']			= '減少';
$lang['exp_jb_log']			= '金幣日誌';


?>