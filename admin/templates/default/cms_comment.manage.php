<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript">
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
        $('#list_form').attr('action','index.php?act=cms_comment&op=comment_drop');
        $('#comment_id').val(id);
        $('#list_form').submit();
    }
}
</script>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3><?php echo $lang['nc_cms_comment_manage'];?></h3>
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
        <input type="hidden" value="cms_comment" name="act">
        <input type="hidden" value="comment_manage" name="op">
        <table class="tb-type1 noborder search">
            <tbody>
                <tr>
                    <th><label for="comment_id"><?php echo $lang['cms_text_id'];?></label></th>
                    <td><input type="text" value="<?php echo $_GET['comment_id'];?>" name="comment_id" class="txt"></td>
                    <th><label for="member_name"><?php echo $lang['cms_text_publisher'];?></label></th>
                    <td><input type="text" value="<?php echo $_GET['member_name'];?>" name="member_name" class="txt"></td>
                    <th><label for="member_type"><?php echo $lang['cms_text_type'];?></label></th>
                    <td>
                        <select name="comment_type">
                            <option value="0"><?php echo $lang['nc_please_choose'];?></option>
                            <?php if(!empty($output['type_array']) && is_array($output['type_array'])) {?>
                            <?php foreach($output['type_array'] as $key=>$value) {?>
                            <option value="<?php echo $key;?>" <?php if($key==$_GET['comment_type']) { echo 'selected'; } ?> ><?php echo $value['name'];?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>                    
                    </td>
                    <th><label for="comment_object_id"><?php echo $lang['cms_comment_object_id'];?></label></th>
                    <td><input type="text" value="<?php echo $_GET['comment_object_id'];?>" name="comment_object_id" class="txt"></td>
                    <th><label for="comment_message"><?php echo $lang['cms_text_content'];?></label></th>
                    <td><input type="text" value="<?php echo $_GET['comment_message'];?>" name="comment_message" class="txt"></td>
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
                        <li><?php echo $lang['cms_comment_tip1'];?></li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
    <form method="post" id="list_form">
        <input id="comment_id" name="comment_id" type="hidden" />
        <table class="table tb-type2">
            <thead>
                <tr class="thead">
                    <th class="w24"></th>
                    <th class="w48"><?php echo $lang['cms_text_id'];?></th>
                    <th class="w96"><?php echo $lang['cms_text_publisher'];?></th>
                    <th class="w48"><?php echo $lang['cms_text_type'];?></th>
                    <th class="w48"><?php echo $lang['cms_comment_object_id'];?></th>
                    <th><?php echo $lang['cms_text_content'];?></th>
                    <th class="w48"><?php echo $lang['nc_handle'];?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
                <?php $cms_url = CMS_SITE_URL;?>
                <?php foreach($output['list'] as $key => $value){ ?>
                <tr class="hover edit">
                    <td><input type="checkbox" value="<?php echo $value['comment_id'];?>" name="del_id[]" class="checkitem"></td>
                    <td><?php echo $value['comment_id'];?></td>
                    <td><?php echo $value['member_name'];?></td>
                    <td><?php echo $output['type_array'][$value['comment_type']]['name'];?></td>
                    <td>
                        <?php if(empty($cms_url)) { ?>
                        <?php echo $value['comment_object_id'];?>
                        <?php } else { ?>
                        <a href="<?php echo $cms_url.DS.'index.php?act='.$output['type_array'][$value['comment_type']]['key'].'&op='.$output['type_array'][$value['comment_type']]['key'].'_detail&'.$output['type_array'][$value['comment_type']]['key'].'_id='.$value['comment_object_id'];?>" target="_blank">
                            <?php echo $value['comment_object_id'];?>
                        </a>
                        <?php } ?>
                    </td>
                    <td><?php echo parsesmiles($value['comment_message']);?></td>
                    <td><a href="###" onclick="submit_delete(<?php echo $value['comment_id'];?>)"><?php echo $lang['nc_del'];?></a></td>
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
