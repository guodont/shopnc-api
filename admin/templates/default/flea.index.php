<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>闲置物品</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>所有闲置物品</span></a></li>
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
          <th><label for="search_goods_name"> 闲置物品名</label></th>
          <td><input type="text" value="<?php echo $output['search']['search_goods_name'];?>" name="search_goods_name" id="search_goods_name" class="txt"></td>
		  <th><label for="search_member_name"> 发布会员名</label></th>
		  <td><input type="text" value="<?php echo $output['search']['search_store_name'];?>" name="search_store_name" class="queryInput">
          <th><label>分类</label></th>
          <td id="gcategory"><input type="hidden" id="cate_id" name="cate_id" value="" class="mls_id" />
            <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names" />
            <select class="querySelect">
              <option><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['goods_class']) && is_array($output['goods_class'])){ ?>
              <?php foreach($output['goods_class'] as $val) { ?>
              <option value="<?php echo $val['gc_id']; ?>" <?php if($output['search']['cate_id'] == $val['gc_id']){?>selected<?php }?>><?php echo $val['gc_name']; ?></option>
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
          <th colspan="2">闲置物品名</th>
		  <th>发布会员名</th>
          <th>分类</th>
          <th class="align-center">浏览</th>
          <th class="align-center">操作 </th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){ ?>
        <?php foreach($output['goods_list'] as $k => $v){?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" name="del_id[]" value="<?php echo $v['goods_id'];?>" class="checkitem"></td>
          <td class="w60 picture">
		  <div class="size-56x56"><span class="thumb size-56x56"><img height="56" width="56" src="<?php echo $v['goods_image']?UPLOAD_SITE_URL.DS.ATTACH_MALBUM.'/'.$v['member_id'].'/'.str_replace('_small', '_tiny', $v['goods_image']):TEMPLATES_PATH.'/images/default_goods_image.gif';?>" onload="javascript:DrawImage(this,56,56);"/></span></div></td>
          <td class="goods-name w270"><p><span title="<?php echo $lang['nc_editable'];?>" class="editable-tarea tooltip" required="1" ajax_branch_textarea="goods_name" fieldid="<?php echo $v['goods_id'];?>" fieldname="goods_name" nc_type="inline_edit_textarea"><?php echo $v['goods_name'];?></span></p></td>
          <td class="w156"><?php echo $v['member_name'];?></td>
          <td><?php echo $v['gc_name'];?></td>
          <td class="align-center"><?php echo $v['goods_click']?></td>
          <td class="w48 align-center"><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=flea_goods&goods_id=<?php echo $v['goods_id'];?>" target="_blank"><?php echo $lang['nc_view'];?></a></td>
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