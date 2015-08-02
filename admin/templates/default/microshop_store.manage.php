<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    //行内ajax编辑
    $('span[nc_type="microshop_sort"]').inline_edit({act: 'microshop',op: 'store_sort_update'});
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
        $('#list_form').attr('action','index.php?act=microshop&op=store_drop_save');
        $('#store_id').val(id);
        $('#list_form').submit();
    }
}
</script>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3><?php echo $lang['nc_microshop_store_manage'];?></h3>
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
        <input type="hidden" value="store_manage" name="op">
        <table class="tb-type1 noborder search">
            <tbody>
                <tr>
                    <th><label for="store_name"><?php echo $lang['store_name'];?></label></th>
                    <td><input type="text" value="<?php echo $_GET['store_name'];?>" name="store_name" id="store_name" class="txt"></td>
                    <th><label for="owner_and_name"><?php echo $lang['store_user'];?></label></th>
                    <td><input type="text" value="<?php echo $_GET['owner_and_name'];?>" name="owner_and_name" id="owner_and_name" class="txt"></td>
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
                        <li><?php echo $lang['microshop_store_tip1'];?></li>
                        <li><?php echo $lang['microshop_store_tip2'];?></li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
    <form method="post" id="list_form">
        <input id="store_id" name="store_id" type="hidden" />
        <table class="table tb-type2">
            <thead>
                <tr class="thead">
                    <th class="w24"></th>
                    <th class="w60"><?php echo $lang['nc_sort'];?></th>
                    <th class="w200"><?php echo $lang['store_name'];?></th>
                    <th class="w150"><?php echo $lang['store_user_name'];?></th>
                    <th><?php echo $lang['location'];?></th>
                    <th class="w108"><?php echo $lang['period_to'];?></th>
                    <th class="w108"><?php echo $lang['recommended'];?></th>
                    <th class="w48"><?php echo $lang['operation'];?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($output['store_list']) && is_array($output['store_list'])){ ?>
                <?php foreach($output['store_list'] as $key => $value){ ?>
                <tr class="hover edit">
                    <td><input type="checkbox" value="<?php echo $value['store_id'];?>" name="del_id[]" class="checkitem"></td>
                    <td class="w48 sort">
                        <span nc_type="microshop_sort" column_id="<?php echo $value['store_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable "><?php echo $value['microshop_sort'];?></span>
                    </td>
                    <td>
                        <a href="<?php echo MICROSHOP_SITE_URL.DS.'index.php?act=store&op=detail&store_id='.$value['microshop_store_id'];?>" target="_blank">
                            <?php echo $value['store_name'];?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo MICROSHOP_SITE_URL.DS.'index.php?act=home&member_id='.$value['member_id'];?>" target="_blank">
                            <?php echo $value['member_name'];?>
                        </a>
                    </td>
                    <td><?php echo $value['area_info'];?></td>
                    <td><?php echo empty($valuealue['store_end_time'])?L('no_limit'):date('Y-m-d H:i:s',$value['store_end_time']);?></td>
                    <td class="yes-onoff">
                        <a href="JavaScript:void(0);" class=" <?php echo $value['microshop_commend']? 'enabled':'disabled'?>" ajax_branch='store_commend'  nc_type="inline_edit" fieldname="microshop_commend" fieldid="<?php echo $value['store_id']?>" fieldvalue="<?php echo $value['microshop_commend']?'1':'0'?>" title="<?php echo $lang['editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
                    </td>
                    <td><a href="###" onclick="submit_delete(<?php echo $value['store_id'];?>)"><?php echo $lang['nc_del'];?></a></td>
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
