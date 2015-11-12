<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>服务管理</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>所有服务</span></a></li>
        <li><a href="index.php?act=service&op=service_add" ><span><?php echo $lang['nc_new'];?></span></a></li>		
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
	<input type="hidden" name="act" value="flea">
	<input type="hidden" name="op" value="flea">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_service_name">服务名称</label></th>
          <td><input type="text" value="<?php echo $output['search']['search_service_name'];?>" name="search_service_name" id="search_service_name" class="txt"></td>
          <th><label>服务分类</label></th>
          <td id="gcategory"><input type="hidden" id="cate_id" name="cate_id" value="" class="mls_id" />
            <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names" />
            <select class="querySelect">
              <option><?php echo $lang['nc_please_choose'];?>...</option>
<?php if(!empty($output['class_list']) && is_array($output['class_list'])){ ?>
              <?php foreach($output['class_list'] as $k => $v){ ?>
              <option <?php if($output['search_ac_id'] == $v['class_id']){ ?>selected='selected'<?php } ?> value="<?php echo $v['class_id'];?>"><?php echo $v['class_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method='post' id="form_goods">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="type" id="type" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th width="25px"></th>
          <th colspan="2">服务名称</th>
          <th>服务分类</th>
		  <th class="align-center">服务上架</th>		  
		  <th class="align-center">在线预约</th>
		  <th class="align-center">在线支付</th>
          <th class="align-center">浏览</th>
          <th class="align-center">操作 </th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){ ?>
        <?php foreach($output['goods_list'] as $k => $v){?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" name="del_id[]" value="<?php echo $v['service_id'];?>" class="checkitem"></td>
          <td class="w60 picture">
		  <div class="size-56x56"><span class="thumb size-56x56"><img height="56" width="56" src="<?php echo $v['service_image']?UPLOAD_SITE_URL.DS.ATTACH_MALBUM.'/'.$v['member_id'].'/'.str_replace('_small', '_tiny', $v['service_image']):TEMPLATES_PATH.'/images/default_goods_image.gif';?>" onload="javascript:DrawImage(this,56,56);"/></span></div></td>
          <td class="goods-name w270"><p><span title="<?php echo $lang['nc_editable'];?>" class="editable-tarea tooltip" required="1" ajax_branch_textarea="service_name" fieldid="<?php echo $v['service_id'];?>" fieldname="service_name" nc_type="inline_edit_textarea"><?php echo $v['service_name'];?></span></p></td>
          <td><?php echo $v['gc_name'];?></td>
          <td class="align-center yes-onoff"><?php if($v['service_show'] == 0){ ?>
            <a href="JavaScript:void(0);" class=" disabled" fieldvalue="0" fieldid="<?php echo $v['service_id'];?>" ajax_branch="service_show" fieldname="service_show" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class=" enabled" fieldvalue="1" fieldid="<?php echo $v['service_id'];?>" ajax_branch="service_show" fieldname="service_show" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>			  
		  <td class="align-center yes-onoff"><?php if($v['order_online'] == 0){ ?>
            <a href="JavaScript:void(0);" class=" disabled" fieldvalue="0" fieldid="<?php echo $v['service_id'];?>" ajax_branch="commend" fieldname="order_online" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class=" enabled" fieldvalue="1" fieldid="<?php echo $v['service_id'];?>" ajax_branch="commend" fieldname="order_online" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>		  
		  <td class="align-center yes-onoff"><?php if($v['pay_online'] == 0){ ?>
            <a href="JavaScript:void(0);" class=" disabled" fieldvalue="0" fieldid="<?php echo $v['service_id'];?>" ajax_branch="pay_online" fieldname="pay_online" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class=" enabled" fieldvalue="1" fieldid="<?php echo $v['service_id'];?>" ajax_branch="pay_online" fieldname="pay_online" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>
          <td class="align-center"><?php echo $v['service_click']?></td>
          <td class="w48 align-center"><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=flea_goods&service_id=<?php echo $v['service_id'];?>" target="_blank"><?php echo $lang['nc_edit'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_form('del');"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_flea_select.js" charset="utf-8"></script>
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
$(function(){
	gcategoryInit("gcategory");
});

function submit_form(type){
	if(type=='del'){
		if(!confirm('<?php echo $lang['goods_index_ensure_handle'];?>?')){
			return false;
		}
	}
	$('#type').val(type);
	$('#form_goods').submit();
}
</script>