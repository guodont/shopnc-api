<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript">
$(document).ready(function(){
    //行内ajax编辑
    $('span[nc_type="microshop_sort"]').inline_edit({act: 'microshop',op: 'goods_sort_update'});
    //时间
    $('#commend_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#commend_time_to').datepicker({dateFormat: 'yy-mm-dd'});
});
function submit_batch(){
    /* 获取选中的项 */
    var items = '';
    $('.checkitem:checked').each(function(){
        items += this.value + ',';
    });
    if(items != '') {
        items = items.substr(0, (items.length - 1));
        submit_delete(items);
    }  
    else {
        alert('<?php echo $lang['nc_please_select_item'];?>');
    }
}
function submit_delete(id){
    if(confirm("<?php echo $lang['nc_ensure_del'];?>")) {
        $('#list_form').attr('method','post');
        $('#list_form').attr('action','index.php?act=microshop&op=goods_drop');
        $('#commend_id').val(id);
        $('#list_form').submit();
    }
}
</script>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3><?php echo $lang['nc_microshop_goods_manage'];?></h3>
            <ul class="tab-base">
                <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
                <li><a href="<?php echo $menu['menu_url'];?>" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
                <?php }  else { ?>
                <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
                <?php  } }  ?>
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form method="get" name="formSearch">
        <input type="hidden" value="microshop" name="act">
        <input type="hidden" value="goods_manage" name="op">
        <table class="tb-type1 noborder search">
            <tbody>
                <tr>
                    <th><label for="commend_id"><?php echo $lang['microshop_text_id'];?></label></th>
                    <td><input type="text" value="<?php echo $_GET['commend_id'];?>" name="commend_id" class="txt"></td>
                    <th><label for="member_name"><?php echo $lang['microshop_member'];?></label></th>
                    <td><input type="text" value="<?php echo $_GET['member_name'];?>" name="member_name" class="txt"></td>
                    <th><label for="commend_goods_name"><?php echo $lang['microshop_goods_name'];?></label></th>
                    <td><input type="text" value="<?php echo $_GET['commend_goods_name'];?>" name="commend_goods_name" class="txt"></td>
                    <th><label for="commend_time_from"><?php echo $lang['microshop_commend_time'];?></label></th>
                    <td>
                        <input class="txt date" type="text" value="<?php echo $_GET['commend_time_from'];?>" id="commend_time_from" name="commend_time_from">
                        <label for="commend_time_to">~</label>
                        <input class="txt date" type="text" value="<?php echo $_GET['commend_time_to'];?>" id="commend_time_to" name="commend_time_to"/>
                    </td>
                    <td>
                        <a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <table class="table tb-type2" id="prompt">
        <tbody>
            <tr class="space odd">
                <th colspan="12">
                    <div class="title">
                        <h5><?php echo $lang['nc_prompts'];?></h5>
                        <span class="arrow"></span>
                    </div>
                </th>
            </tr>
            <tr>
                <td>
                    <ul>
                        <li><?php echo $lang['microshop_goods_tip1'];?></li>
                        <li><?php echo $lang['microshop_goods_tip2'];?></li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
    <form method="post" id="list_form">
        <input id="commend_id" name="commend_id" type="hidden" />
        <table class="table tb-type2">
            <thead>
                <tr class="thead">
                    <th class="w24"></th>
                    <th class="w36"><?php echo $lang['nc_sort'];?></th>
                    <th class="w60"><?php echo $lang['microshop_goods_image'];?></th>
                    <th class="w24"><?php echo $lang['microshop_text_id'];?></th>
                    <th class="w96"><?php echo $lang['microshop_member'];?></th>
                    <th class="w270"><?php echo $lang['microshop_goods_name'];?></th>
                    <th><?php echo $lang['microshop_commend_message'];?></th>
                    <th class="w60"><?php echo $lang['microshop_commend_time'];?></th>
                    <th class="w48"><?php echo $lang['microshop_commend'];?></th>
                    <th class="w48 align-center"><?php echo $lang['nc_handle'];?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
                <?php foreach($output['list'] as $key => $value){ ?>
                <tr class="hover edit">
                    <td><input type="checkbox" value="<?php echo $value['commend_id'];?>" name="del_id[]" class="checkitem"></td>
                    <td class="w48 sort">
                        <span nc_type="microshop_sort" column_id="<?php echo $value['commend_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable "><?php echo $value['microshop_sort'];?></span>
                    </td>
                    <td>
                            <?php $image_url = cthumb($value['commend_goods_image'], 60, $value['commend_goods_store_id']);?>
                        <a href="<?php echo MICROSHOP_SITE_URL.DS.'index.php?act=goods&op=detail&goods_id='.$value['commend_id'];?>" style="background:url(<?php echo $image_url;?>) no-repeat center center; width:60px; height:60px; float:left; margin-right:5px;" target="_blank">
                            <img  class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"  style=" width:60px; height:60px; display:block;"/>
                            <div class="type-file-preview">
                                <?php $image_url_240 = cthumb($value['commend_goods_image'], 240, $value['commend_goods_store_id']);?>
                                <img  src="<?php echo $image_url_240;?>" title="<?php echo $value['commend_goods_name'];?>" alt="<?php echo $value['commend_goods_name'];?>" />
                            </div>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo MICROSHOP_SITE_URL.DS.'index.php?act=goods&op=detail&goods_id='.$value['commend_id'];?>" target="_blank">
                            <?php echo $value['commend_id'];?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo MICROSHOP_SITE_URL.DS.'index.php?act=home&member_id='.$value['commend_member_id'];?>" target="_blank">
                            <?php echo $value['member_name'];?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo MICROSHOP_SITE_URL.DS.'index.php?act=goods&op=detail&goods_id='.$value['commend_id'];?>" target="_blank">
                            <?php echo $value['commend_goods_name'];?>
                        </a>
                    </td>
                    <td><?php echo $value['commend_message'];?></td>
                    <td><?php echo date('Y-m-d',$value['commend_time']);?></td>
                    <td class="yes-onoff">
                        <a href="JavaScript:void(0);" class=" <?php echo $value['microshop_commend']? 'enabled':'disabled'?>" ajax_branch='goods_commend'  nc_type="inline_edit" fieldname="microshop_commend" fieldid="<?php echo $value['commend_id']?>" fieldvalue="<?php echo $value['microshop_commend']?'1':'0'?>" title="<?php echo $lang['editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
                    </td>
                    <td class="align-center"><a href="###" onclick="submit_delete(<?php echo $value['commend_id'];?>)"><?php echo $lang['nc_del'];?></a></td>
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
                    <td colspan="16">
                        <label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
                        &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_batch();"><span><?php echo $lang['nc_del'];?></span></a>
                        <div class="pagination"><?php echo $output['show_page'];?></div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
