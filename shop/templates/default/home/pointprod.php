<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_point.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_login.css" rel="stylesheet" type="text/css">
<div class="ncp-container">
  <div class="ncp-base-layout">
    <div class="ncp-member-left">
      <?php if($_SESSION['is_login'] == '1'){?>
      <?php include_once BASE_TPL_PATH.'/home/pointshop.minfo.php'; ?>
      <?php } else { ?>
      <div class="ncp-not-login">
        <div class="member"><a href="javascript:login_dialog();">立即登录</a>
          <p>获知会员信息详情</p>
        </div>
        <div class="function" style="border: none;">
        <i class="voucher"></i>
          <dl>
            <dt>店铺代金券</dt>
            <dd>换取店铺代金券购买商品更划算</dd>
          </dl>
        </div>
        <div class="function">
        <i class="exchange"></i>
          <dl>
            <dt>积分兑换礼品</dt>
            <dd>可使用积分兑换商城超值礼品</dd>
          </dl>
        </div>
        <div class="button"> <a href="javascript:login_dialog();" class="ncp-btn" style="width:120px;"><?php echo $lang['pointprod_list_hello_login']; ?></a> </div>
      </div>
      <?php }?>
    </div>
    <div class="ncp-banner-right"><?php echo loadadv(35,'html');?></div>
  </div>
  <?php if (C('voucher_allow')==1){?>
  <div class="ncp-main-layout">
    <div class="title">
      <h3><i class="voucher"></i>热门代金券</h3>
      <span class="more"><a href="<?php echo urlShop('pointvoucher', 'index');?>"><?php echo $lang['home_voucher_moretitle'];?></a></span> </div>
    <?php if (!empty($output['recommend_voucher'])){?>
    <ul class="ncp-voucher-list">
      <?php foreach ($output['recommend_voucher'] as $k=>$v){?>
      <li>
        <div class="ncp-voucher">
          <div class="cut"></div>
          <div class="info"><a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$v['voucher_t_store_id']));?>" class="store"><?php echo $v['voucher_t_storename'];?></a>
            <p class="store-classify"><?php echo $v['voucher_t_sc_name'];?></p>
            <div class="pic"><img src="<?php echo $v['voucher_t_customimg'];?>" onerror="this.src='<?php echo UPLOAD_SITE_URL.DS.defaultGoodsImage(240);?>'"/></div>
          </div>
          <dl class="value">
            <dt><?php echo $lang['currency'];?><em><?php echo $v['voucher_t_price'];?></em></dt>
            <dd>购物满<?php echo $v['voucher_t_limit'];?>元可用</dd>
            <dd class="time">有效期至<?php echo @date('Y-m-d',$v['voucher_t_end_date']);?></dd>
          </dl>
          <div class="point">
            <p class="required">需<em><?php echo $v['voucher_t_points'];?></em>积分</p>
            <p><em><?php echo $v['voucher_t_giveout'];?></em>人已兑换</p>
          </div>
          <div class="button"><a target="_blank" href="javascript:void(0);" nc_type="exchangebtn" data-param='{"vid":"<?php echo $v['voucher_t_id'];?>"}' class="ncp-btn ncp-btn-red">立即兑换</a></div>
        </div>
      </li>
      <?php }?>
    </ul>
    <?php }else{?>
    <div class="norecord"><?php echo $lang['home_voucher_list_null'];?></div>
    <?php }?>
  </div>
  <?php }?>
  <?php if (C('pointprod_isuse')==1){?>
  <div class="ncp-main-layout mb30">
    <div class="title">
      <h3><i class="exchange"></i>热门礼品</h3>
      <span class="more"><a href="<?php echo urlShop('pointprod', 'plist');?>"><?php echo $lang['pointprod_list_more'];?></a></span> </div>
    <?php if (is_array($output['recommend_pointsprod']) && count($output['recommend_pointsprod'])>0){?>
    <ul class="ncp-exchange-list">
      <?php foreach ($output['recommend_pointsprod'] as $k=>$v){?>
      <li>
        <div class="gift-pic"><a target="_blank" href="<?php echo urlShop('pointprod', 'pinfo', array('id' => $v['pgoods_id']));?>"> <img src="<?php echo $v['pgoods_image'] ?>" alt="<?php echo $v['pgoods_name']; ?>" /> </a></div>
        <div class="gift-name"><a href="<?php echo urlShop('pointprod', 'pinfo', array('id' => $v['pgoods_id']));?>" target="_blank" tile="<?php echo $v['pgoods_name']; ?>"><?php echo $v['pgoods_name']; ?></a></div>
        <div class="exchange-rule">
          <?php if (intval($v['pgoods_limitmgrade']) > 0){ ?>
          <span class="pgoods-grade"><?php echo $v['pgoods_limitgradename']; ?></span>
          <?php } ?>
          <span class="pgoods-price"><?php echo $lang['pointprod_goodsprice'].$lang['nc_colon']; ?><em><?php echo $lang['currency'].$v['pgoods_price']; ?></em></span> <span class="pgoods-points"><?php echo $lang['pointprod_pointsname'].$lang['nc_colon'];?><strong><?php echo $v['pgoods_points']; ?></strong><?php echo $lang['points_unit']; ?></span> </div>
      </li>
      <?php } ?>
    </ul>
    <?php }else{?>
    <div class="norecord"><?php echo $lang['pointprod_list_null'];?></div>
    <?php }?>
  </div>
  <?php }?>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/home.js" id="dialog_js" charset="utf-8"></script>
