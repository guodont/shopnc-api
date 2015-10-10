<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <table class="ncm-default-table">
    <thead>
      <tr>
        <th class="w30"></th>
        <th colspan="2"><?php echo $lang['favorite_store_name'];?></th>
        <th class="w150">所 在 地</th>
        <th class="w150"><?php echo $lang['favorite_date'];?></th>
        <th class="w100"><?php echo $lang['favorite_popularity'];?></th>
        <th class="w110"><?php echo $lang['favorite_handle'];?></th>
      </tr>
      <?php if(!empty($output['favorites_list']) && is_array($output['favorites_list'])){?>
      <tr>
        <td colspan="20"><input type="checkbox" id="all" class="checkall"/>
          <label for="all"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncm-btn-mini" uri="index.php?act=member_favorites&op=delfavorites&type=store" name="fav_id" confirm="<?php echo $lang['nc_ensure_del'];?>" nc_type="batchbutton"><i class="icon-trash"></i><?php echo $lang['nc_del'];?></a></td>
      </tr>
      <?php }?>
    </thead>
    <?php if(!empty($output['favorites_list']) && is_array($output['favorites_list'])){?>
    <tbody>
      <?php foreach($output['favorites_list'] as $key=>$favorites){?>
      <tr class="bd-line">
        <td class="tc"><input type="checkbox" class="checkitem" value="<?php echo $favorites['fav_id'];?>"/></td>
        <td class="w70"><div class="ncm-goods-thumb"><a href="<?php echo urlShop('show_store', 'index', array('store_id' => $favorites['store']['store_id']), $favorites['store']['store_domain']);?>" ><img src="<?php echo getStoreLogo($favorites['store']['store_avatar']);?>" onMouseOver="toolTip('<img src=<?php echo getStoreLogo($favorites['store']['store_avatar']);?>>')" onMouseOut="toolTip()"/></a></div></td>
        <td class="tl"><dl class="goods-name">
            <dt><a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$favorites['store']['store_id']), $favorites['store']['store_domain'])?>" ><?php echo $favorites['store']['store_name'];?></a> </dt>
            <dd><?php echo $lang['favorite_message'].$lang['nc_colon'];?><span member_id="<?php echo $favorites['store']['member_id'];?>"></span>
              <?php if(!empty($favorites['store']['store_qq'])){?>
              <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $favorites['store']['store_qq'];?>&site=qq&menu=yes" title="QQ: <?php echo $favorites['store']['store_qq'];?>"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $favorites['store']['store_qq'];?>:52" style=" vertical-align: middle;"/></a>
              <?php }?>
              <?php if(!empty($favorites['store']['store_ww'])){?>
              <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $favorites['store']['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $favorites['store']['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" alt="Wang Wang"  style=" vertical-align: middle;"/></a>
              <?php }?>
            </dd>
          </dl></td>
        <td><?php echo $favorites['store']['area_info'];?></td>
        <td class="goods-time"><?php echo date("Y-m-d",$favorites['fav_time']);?></td>
        <td><?php echo $favorites['store']['store_collect'];?></td>
        <td class="ncm-table-handle"><span><a href="javascript:void(0);" class="btn-acidblue" nc_type="sharestore" data-param='{"sid":"<?php echo $favorites['store']['store_id'];?>"}'><i class="icon-share"></i>
          <p><?php echo $lang['nc_snsshare'];?></p>
          </a></span> <span><a href="javascript:void(0)" class="btn-red" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=member_favorites&op=delfavorites&type=store&fav_id=<?php echo $favorites['fav_id'];?>');"><i class="icon-trash"></i>
          <p><?php echo $lang['nc_del'];?></p>
          </a></span></td>
      </tr>
      <tr id="store-goods-<?php echo $favorites['store']['store_id'];?>" class="shop-new-goods" style="display:none;">
        <td colspan="20" style=" padding-top: 0;" ><div class="fr pr">
            <div class="arrow"></div>
            <ul class="jcarousel-skin-tango">
            </ul>
          </div></td>
      </tr>
      <?php }?>
    </tbody>
    <?php }else{?>
    <tbody>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
    </tbody>
    <?php }?>
    <?php if(!empty($output['favorites_list']) && is_array($output['favorites_list'])){?>
    <tfoot>
      <tr>
        <th colspan="20"><input type="checkbox" id="all2" class="checkall"/>
          <label for="all2"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncm-btn-mini" uri="index.php?act=member_favorites&op=delfavorites&type=store" name="fav_id" confirm="<?php echo $lang['nc_ensure_del'];?>" nc_type="batchbutton"><i class="icon-trash"></i><?php echo $lang['nc_del'];?></a> </th>
      </tr>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
    </tfoot>
    <?php }?>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jcarousel/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script>
