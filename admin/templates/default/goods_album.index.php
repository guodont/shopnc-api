<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['g_album_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['g_album_list'];?></span></a></li>
        <li><a href="index.php?act=goods_album&op=pic_list" ><span><?php echo $lang['g_album_pic_list'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="goods_album">
    <input type="hidden" name="op" value="list">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_brand_name"><?php echo $lang['g_album_keyword'];?></label></th>
          <td><input class="txt" name="keyword" id="keyword" value="" type="text"></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if($output['store_name'] != '' && !empty($output['list']) ){?>
            <a class="btns" href="<?php echo urlShop('show_store','index', array('store_id'=>$output['list'][0]['store_id']));?>"><span><?php echo $output['store_name'];?></span></a>
            <?php }?>
            </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['g_album_del_tips'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="picForm" name="picForm">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="act" value="goods_album" />
    <input type="hidden" name="op" value="list" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th class="w72 center"><?php echo $lang['g_album_fmian']; ?></th>
          <th class="w270"><?php echo $lang['g_album_one'];?></th>
          <th class=" w270"><?php echo $lang['g_album_shop'];?></th>
          <th><?php echo $lang['g_album_pic_count'];?></th>
          <th class="w72 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td><input value="<?php echo $v['aclass_id']?>" class="checkitem" type="checkbox" name="aclass_id[]"></td>
          <td>
          <?php if($v['aclass_cover'] != ''){ ?>
              <img src="<?php echo cthumb($v['aclass_cover'], 60, $v['store_id']);?>" onload="javascript:DrawImage(this,70,70);">
              <?php }else{?>
              <img src="<?php echo ADMIN_SITE_URL.'/templates/'.TPL_NAME.'/images/member/default_image.png';?>" onload="javascript:DrawImage(this,70,70);">
              <?php }?>
          </td>
          <td class="name"><?php echo $v['aclass_name'];?></td>
          <td class="class"><a href="<?php echo urlShop('show_store','index', array('store_id'=>$v['store_id']));?>" ><?php echo $v['store_name'];?></td>
          <td><?php echo $output['pic_count'][$v['aclass_id']]?$output['pic_count'][$v['aclass_id']]:0;?></td>
          <td class="align-center"><a href="index.php?act=goods_album&op=pic_list&aclass_id=<?php echo $v['aclass_id'];?>"><?php echo $lang['d'];?><?php echo $lang['g_album_pic_one'];?></a>&nbsp;|&nbsp;<a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=goods_album&op=aclass_del&aclass_id=<?php echo $v['aclass_id'];?>';}else{return false;}"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <tr colspan="15" class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#picForm').submit()}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
  <div class="clear"></div>
</div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
