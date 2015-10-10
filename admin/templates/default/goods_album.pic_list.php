<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['g_album_manage']; ?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=goods_album&op=list"><span><?php echo $lang['g_album_list'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['g_album_pic_list'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" action="index.php">
    <input type="hidden" name="act" value="goods_album">
    <input type="hidden" name="op" value="pic_list">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="pic_name"><?php echo $lang['g_album_keyword']; ?></label></th>
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
<form method='post' action="index.php" name="picForm" id="picForm">
	<input type="hidden" name="act" value="goods_album" />
	<input type="hidden" name="op" value="del_more_pic" />
    <table class="table tb-type2">
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      	<tr><td colspan="20"><ul class="thumblists">
        <?php foreach($output['list'] as $k => $v){ ?>
          <li class="picture">
            <div class="size-64x64">
              <span class="thumb">
                <i></i>
				<?php if($v['apic_cover'] != ''){ ?>
				<a nctype="nyroModal"  href="<?php echo cthumb($v['apic_cover'], 1280, $v['store_id']);?>" rel="gal"><img title="<?php echo date('Y-m-d',$v['upload_time']);?><br/><?php echo $v['apic_spec'];?>px<br/><?php echo number_format($v['apic_size']/1024,2);?>k" width="64" height="64"  class="tip" src="<?php echo cthumb($v['apic_cover'], 60, $v['store_id']);?>"></a>
				<?php }else{?>
				<img height="64" src="<?php echo ADMIN_SITE_URL.'/templates/'.TPL_NAME.'/images/member/default_image.png';?>" max-height='70px' max-width="70px">
				<?php }?>
            </span>
            </div>
            <p>
              <span><input class="checkitem" type="checkbox" name="delbox[]" value="<?php echo $v['apic_id'];?>"></span><span><a href="javascript:void(0);" nc_type="delete" nc_key="<?php echo $v['apic_id'].'|'.$v['apic_cover'];?>"><?php echo $lang['nc_del'];?></a></span>
            </p>
          </li>
          <?php } ?>
      	</ul></td></tr>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td class="w48"><input id="checkallBottom" class="checkall" type="checkbox" /></td>
          <td colspan="16">
            <label for="checkallBottom"><?php echo $lang['nc_select_all'];?></label>
            <a class="btn" href="javascript:void(0);" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#picForm').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"><?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script>
$(function(){
	$('a[nctype="nyroModal"]').nyroModal();
	$('a[nc_type="delete"]').bind('click',function(){
		if(!confirm('<?php echo $lang['nc_ensure_del'];?>')) return false;
		cur_note = this;
		$.get("index.php?act=goods_album&op=del_album_pic", {'key':$(this).attr('nc_key')}, function(data){
            if (data == 1)
            	$(cur_note).parent().parent().parent().remove();
            else
            	alert('<?php echo $lang['nc_common_del_fail'];?>');
        });
	});
	$('.tip').poshytip({
		className: 'tip-yellowsimple',
		//showOn: 'focus',
		alignTo: 'target',
		alignX: 'center',
		alignY: 'bottom',
		offsetX: 0,
		offsetY: 5,
		allowTipHover: false
	});
});
</script>
