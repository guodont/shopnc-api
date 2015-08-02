<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=store&op=store" ><span><?php echo $lang['manage'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_joinin"><span><?php echo $lang['pending'];?></span></a></li>
        <li><a href="index.php?act=store&op=reopen_list" ><span>续签申请</span></a></li>
        <li><a href="index.php?act=store&op=store_bind_class_applay_list" ><span>经营类目申请</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>编辑经营类目</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div>
        </th>
      </tr>
      <tr>
        <td><ul>
            <li>删除店铺的经营类目会造成相应商品下架，请谨慎操作</li>
            <li>所有修改即时生效</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2">
    <thead class="thead">
      <tr class="space">
        <th colspan="15">店铺名称：<?php echo $output['store_info']['store_name'];?></th>
      </tr>
    </thead>
    <thead>
      <tr class="thead">
        <th>分类1</th>
        <th>分类2</th>
        <th>分类3</th>
        <th>分佣比例</th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['store_bind_class_list']) && is_array($output['store_bind_class_list'])){ ?>
      <?php foreach($output['store_bind_class_list'] as $key => $value){ ?>
      <tr class="hover edit">
        <td class="w25pre"><?php echo $value['class_1_name'];?></td>
        <td class="w25pre"><?php echo $value['class_2_name'];?></td>
        <td class="w25pre"><?php echo $value['class_3_name'];?></td>
        <td class="sort"><span nc_type="commis_rate" column_id="<?php echo $value['bid'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable " style="vertical-align: middle; margin-right: 4px;"><?php echo $value['commis_rate'];?></span>% </td>
        <td class="w60 align-center"><a nctype="btn_del_store_bind_class" href="javascript:;" data-bid="<?php echo $value['bid'];?>">删除</a></td>
      </tr>
      <?php } ?>
      <?php }else { ?>
      <tr class="no_data">
        <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <table class="table tb-type2" >
    <thead class="thead">
      <tr class="space">
        <th colspan="15"><span>添加经营类目</span></th>
      </tr>
    </thead>
    <tbody>
      <tr class="noborder">
        <td class="required" colspan="2" >选择分类：</td>
      </tr>
      <tr class="noborder">
        <td colspan="2" id="gcategory" class="vatop rowform"><select id="gcategory_class1" style="width: auto;">
            <option value="0">全部分类</option>
            <?php if(!empty($output['gc_list']) && is_array($output['gc_list']) ) {?>
            <?php foreach ($output['gc_list'] as $gc) {?>
            <option value="<?php echo $gc['gc_id'];?>" data-explain="<?php echo $gc['commis_rate']; ?>"><?php echo $gc['gc_name'];?></option>
            <?php }?>
            <?php }?>
          </select><span id="error_message" style="color:red;"></span></td>
      </tr>
      <tr>
        <td class="required" colspan="2" >分佣比例(必须为0-100的整数)：</td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><form id="add_form" action="<?php echo urlAdmin('store', 'store_bind_class_add');?>" method="post">
            <input name="store_id" type="hidden" value="<?php echo $output['store_info']['store_id'];?>">
            <input id="goods_class" name="goods_class" type="hidden" value="">
            <input id="commis_rate" name="commis_rate" class="w60" type="text" value="" />
            % <span id="error_message1" style="color:red;"></span>
          </form></td>
        <td class="vatop tips"></td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2"><a id="btn_add_category" class="btn" href="JavaScript:void(0);" /><span>确认</span></a></td>
      </tr>
    </tfoot>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
	gcategoryInit("gcategory");

    // 提交新添加的类目
    $('#btn_add_category').on('click', function() {
        $('#error_message').hide();
        $('#error_message1').hide();
        var category_id = '';
        var validation = true;
        $('#gcategory').find('select').each(function() {
            if(parseInt($(this).val(), 10) > 0) {
                category_id += $(this).val() + ',';
            } else {
                validation = false;
            }
        });
        /*if(!validation) {
            $('#error_message').text('请选择分类');
            $('#error_message').show();
            return false;
        }*/

        var commis_rate = parseInt($('#commis_rate').val(), 10);
        if(isNaN(commis_rate) || commis_rate < 0 || commis_rate > 100) {
            $('#error_message1').text('请填写正确的分佣比例');
            $('#error_message1').show();
            return false;
        }

        $('#goods_class').val(category_id);
        $('#add_form').submit();
    });

    $('#gcategory select').live('change', function() {
        var cr = $(this).children(':selected').attr('data-explain');
        $('#commis_rate').val(parseInt(cr) || '');
    });

    // 删除现有类目
    $('[nctype="btn_del_store_bind_class"]').on('click', function() {
        if(confirm('确认删除？删除后店铺对应分类商品将全部下架')) {
            var bid = $(this).attr('data-bid');
            $this = $(this);
            $.post('<?php echo urlAdmin('store', 'store_bind_class_del');?>', {bid: bid}, function(data) {
                 if(data.result) {
                     $this.parents('tr').hide();
                 } else {
                     showError(data.message);
                 }
            }, 'json');
        }
    });

    // 修改分佣比例
    $('span[nc_type="commis_rate"]').inline_edit({act: 'store',op: 'store_bind_class_update'});
});

</script>
