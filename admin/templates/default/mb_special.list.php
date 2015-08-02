<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
input {
	width: 270px;
}
</style>
<div class="page"> 
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $output['item_title'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_key'] == $output['menu_key']) { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <!-- 帮助 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"> <div class="title nomargin">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span> </div>
        </th>
      </tr>
      <tr>
        <td><ul>
            <li>点击添加专题按钮可以添加新的专题，专题描述可以点击后直接修改</li>
            <li>点击编辑按钮对专题内容进行修改</li>
            <li>点击删除按钮可以删除整个专题</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <!-- 列表 -->
  <form id="list_form" method="post">
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="15" class="nobg"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th class="w12">&nbsp;</th>
          <th>专题编号</th>
          <th>专题描述</th>
          <th class="w200 align-center"><span><?php echo $lang['nc_handle'];?></span></th>
        </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $key => $value){ ?>
        <tr class="hover">
          <td>&nbsp;</td>
          <td><?php echo $value['special_id'];?></td>
          <td><span nc_type="edit_special_desc" column_id="<?php echo $value['special_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable tooltip w270"><?php echo $value['special_desc'];?></span></td>
          <td class="nowrap align-center"><a href="<?php echo urlAdmin('mb_special', 'special_edit', array('special_id' => $value['special_id']));?>">编辑</a>&nbsp;|&nbsp; <a href="javascript:;" nctype="btn_del" data-special-id="<?php echo $value['special_id'];?>">删除</a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="16"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
        <tr style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
          <td colspan="20"><a id="btn_add_mb_special" href="javascript:;" class="btn-add marginleft">添加专题</a></td>
        </tr>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td colspan="16"><div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<form id="del_form" action="<?php echo urlAdmin('mb_special', 'special_del');?>" method="post">
  <input type="hidden" id="del_special_id" name="special_id">
</form>
<div id="dialog_add_mb_special" style="display:none;">
  <form id="add_form" method="post" action="<?php echo urlAdmin('mb_special', 'special_save');?>">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="special_desc">专题描述<?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="special_desc" class="txt"></td>
          <td class="vatop tips">专题描述，最多20个字</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a id="submit" href="javascript:void(0)" class="btn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js"></script> 
<script type="text/javascript">
    $(document).ready(function(){
        //添加专题
        $('#btn_add_mb_special').on('click', function() {
            $('#dialog_add_mb_special').nc_show_dialog({title: '添加专题'});
        });

        //提交
        $("#submit").click(function(){
            $("#add_form").submit();
        });

        $('#add_form').validate({
            errorPlacement: function(error, element){
                error.appendTo(element.parents('tr').prev().find('td:first'));
            },
            rules : {
                special_desc : {
                    required : true,
                    maxlength : 20
                }
            },
            messages : {
                special_desc : {
                    required : "专题描述不能为空",
                    maxlength : "专题描述最多20个字" 
                }
            }
        });

        //删除专题
        $('[nctype="btn_del"]').on('click', function() {
            if(confirm('确认删除?')) {
                $('#del_special_id').val($(this).attr('data-special-id'));
                $('#del_form').submit();
            }
        });

        //编辑专题描述
        $('span[nc_type="edit_special_desc"]').inline_edit({act: 'mb_special',op: 'update_special_desc'});
    });
</script> 
