<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
function submit_batch(){
    /* 获取选中的项 */
    var items = '';
    $('.checkitem:checked').each(function(){
        items += this.value + ',';
    });
    if(items != '') {
        items = items.substr(0, (items.length - 1));
        submit_add(items);
    }
    else {
        alert('<?php echo $lang['nc_please_select_item'];?>');
    }
}
function submit_add(id){
    if(confirm('<?php echo $lang['microshop_store_add_confirm'];?>')) {
        $('#list_form').attr('method','post');
        $('#list_form').attr('action','index.php?act=microshop&op=store_add_save');
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
        <input type="hidden" value="store_add" name="op">
        <table class="tb-type1 noborder search">
            <tbody>
                <tr>
                    <th><label for="store_name"><?php echo $lang['store_name'];?></label></th>
                    <td><input type="text" value="<?php echo $_GET['store_name'];?>" name="store_name" id="store_name" class="txt"></td>
                    <th><label for="owner_and_name"><?php echo $lang['store_user'];?></label></th>
                    <td><input type="text" value="<?php echo $_GET['owner_and_name'];?>" name="owner_and_name" id="owner_and_name" class="txt"></td>
                    <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
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
                        <li><?php echo $lang['microshop_store_add_tip1'];?></li>
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
                    <th class="w200"><?php echo $lang['store_name'];?></th>
                    <th class="w108"><?php echo $lang['store_user_name'];?></th>
                    <th><?php echo $lang['location'];?></th>
                    <th class="w84"><?php echo $lang['period_to'];?></th>
                    <th class="w48"><?php echo $lang['operation'];?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($output['store_list']) && is_array($output['store_list'])){ ?>
                <?php foreach($output['store_list'] as $key => $value){ ?>
                <tr class="hover edit">
                    <?php $store_exist = FALSE; ?>
                    <?php if(in_array($value['store_id'],$output['microshop_store_array'])) {?>
                    <?php $store_exist = TRUE;?>
                    <?php } ?>
                    <td>
                    </td>
                    <td>
                        <a href="<?php echo urlShop('show_store','index', array('store_id' => $value['store_id']));?>" >
                            <?php echo $value['store_name'];?>
                        </a>
                    </td>
                    <td><?php echo $value['member_name'];?></td>
                    <td class="w150"><?php echo $value['area_info'];?></td>
                    <td><?php echo empty($value['store_end_time'])?L('no_limit'):date('Y-m-d H:i:s',$value['store_end_time']);?></td>
                    <td>
                        <?php if($store_exist) {?>
                        <?php echo $lang['microshop_store_add'];?>
                        <?php } else { ?>
                        <a href="###" onclick="submit_add(<?php echo $value['store_id'];?>)"><?php echo $lang['nc_add'];?></a>
                        <?php } ?>
                    </td>
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
                    <td></td>
                    <td colspan="16">
                        <div class="pagination"><?php echo $output['page'];?></div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
