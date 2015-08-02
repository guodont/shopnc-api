<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['brand_index_brand'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=brand&op=brand_add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="index.php?act=brand&op=brand_apply"><span><?php echo $lang['brand_index_to_audit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="brand">
    <input type="hidden" name="op" value="brand">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_brand_name"><?php echo $lang['brand_index_name'];?></label></th>
          <td><input class="txt" name="search_brand_name" id="search_brand_name" value="<?php echo $output['search_brand_name']?>" type="text"></td>
          <th><label for="search_brand_class"><?php echo $lang['brand_index_class'];?></label></th>
          <td><input class="txt" name="search_brand_class" id="search_brand_class" value="<?php echo $output['search_brand_class']?>" type="text"></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if($output['search_brand_name'] != '' or $output['search_brand_class'] != ''){?>
            <a class="btns " href="index.php?act=brand&op=brand" title="<?php echo $lang['nc_cancel_search'];?>"><span><?php echo $lang['nc_cancel_search'];?></span></a>
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
            <li><?php echo $lang['brand_index_help1'];?></li>
            <li><?php echo $lang['brand_index_help2'];?></li>
            <li><?php echo $lang['brand_index_help3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' onsubmit="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){return true;}else{return false;}" name="brandForm">
    <input type="hidden" name="form_submit" value="ok" />
    <div style="text-align:right;"><a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?>Excel</span></a></div>
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th class="w48"><?php echo $lang['nc_sort'];?></th>
          <th class="w270"><?php echo $lang['brand_index_name'];?></th>
          <th class="w150"><?php echo $lang['brand_index_class'];?></th>
          <th><?php echo $lang['brand_index_pic_sign'];?></th>
          <th class="align-center">展示方式</th>
          <th class="align-center"><?php echo $lang['nc_recommend'];?></th>
          <th class="w72 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['brand_list']) && is_array($output['brand_list'])){ ?>
        <?php foreach($output['brand_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td><input value="<?php echo $v['brand_id']?>" class="checkitem" type="checkbox" name="del_brand_id[]"></td>
          <td class="sort"><span class=" editable"  nc_type="inline_edit" fieldname="brand_sort" ajax_branch='brand_sort' fieldid="<?php echo $v['brand_id']?>" datatype="pint" maxvalue="255" title="<?php echo $lang['nc_editable'];?>"><?php echo $v['brand_sort']?></span></td>
          <td class="name"><span class=" editable" nc_type="inline_edit" fieldname="brand_name" ajax_branch='brand_name' fieldid="<?php echo $v['brand_id']?>" required="1"  title="<?php echo $lang['nc_editable'];?>"><?php echo $v['brand_name']?></span></td>
          <td class="class"><?php echo $v['brand_class']?></td>
          <td class="picture"><div class="brand-picture"><img src="<?php echo brandImage($v['brand_pic']);?>"/></div></td>
          <td class="align-center"><?php echo $v['show_type']==1?'文字':'图片'; ?></td>
          <td class="align-center yes-onoff"><?php if($v['brand_recommend'] == '0'){ ?>
            <a href="JavaScript:void(0);" class=" disabled" ajax_branch='brand_recommend' nc_type="inline_edit" fieldname="brand_recommend" fieldid="<?php echo $v['brand_id']?>" fieldvalue="0" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class=" enabled" ajax_branch='brand_recommend' nc_type="inline_edit" fieldname="brand_recommend" fieldid="<?php echo $v['brand_id']?>" fieldvalue="1"  title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>
          <td class="align-center"><a href="index.php?act=brand&op=brand_edit&brand_id=<?php echo $v['brand_id'];?>"><?php echo $lang['nc_edit'];?></a>&nbsp;|&nbsp;<a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=brand&op=brand_del&del_brand_id=<?php echo $v['brand_id'];?>';}else{return false;}"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['brand_list']) && is_array($output['brand_list'])){ ?>
        <tr colspan="15" class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="document.brandForm.submit()"><span><?php echo $lang['nc_del'];?></span></a>
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
<script>
$(function(){
    $('#ncexport').click(function(){
    	$('input[name="op"]').val('export_step1');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input[name="op"]').val('brand');$('#formSearch').submit();
    });	
});
</script>