<?php defined('InShopNC') or exit('Access Invalid!');?>

<script type="text/javascript">
$(document).ready(function(){
    //绑定二级分类
    $("#goods_class").change(function(){
        $("#goods_class_add_list").html("");
        $.getJSON('index.php?act=microshop&op=goodsclass_get',{class_id:$(this).val()},function(data){
            if(data != null)
            {
                var goods_class_child_html = '';
                for(var i =0;i < data.length; i++) {
                    if(data[i] != undefined) {
                        if(data[i].selected) {
                            var item = "<li gc_id='"+data[i].gc_id+"' class='class_selected'>"+data[i].gc_name+"</li>";
                        } else {
                            var item = "<li gc_id='"+data[i].gc_id+"' class='class_add_item'>"+data[i].gc_name+"</li>";
                        }
                        goods_class_child_html += item;
                    }
                }
                $("#goods_class_add_list").append(goods_class_child_html);

                var class_array = $("#shop_class_id").val().split(",");
                $.each(class_array,function(key,value){
                    $("li[gc_id="+value+"]").attr("class","class_selected");

                });
            }
        });
    });

    //添加分类
    $(".class_add_item").live("click",function(){
        var class_array = $("#shop_class_id").val().split(",");
        var exist = $.inArray($(this).attr('gc_id'),class_array);
        $("li[gc_id="+$(this).attr('gc_id')+"]").attr("class","class_selected");
        if( exist < 0) {
            var item = "<li class='class_binding_item'>";
			item += $(this).html();
            item += "<i gc_id='"+$(this).attr('gc_id')+"' class='class_binding_item_delete'>&nbsp;</i>";
            item += "</li>";
            class_array.push($(this).attr('gc_id'));
            $("#shop_class_id").val(class_array.join(","));
            $("#goods_class_binding_list").append(item);
            $(".class_binding_item_delete").hide();
        }
    });

    $(".class_binding_item").live("mouseenter",function(){
        $(this).children(".class_binding_item_delete").show();
    });

    $(".class_binding_item").live("mouseleave",function(){
        $(this).children(".class_binding_item_delete").hide();
    });

    //删除分类
    $(".class_binding_item_delete").live("click",function(){
        var class_array = $("#shop_class_id").val().split(",");
        var index = $.inArray($(this).attr('gc_id'),class_array);
        if(index >= 0) {
            class_array.splice(index, 1);
            $("li[gc_id="+$(this).attr('gc_id')+"]").attr("class","class_add_item");
        }
        $("#shop_class_id").val(class_array.join(","));
        $(this).parent("li").remove();
    });

    $("#submit").click(function(){
        $("#add_form").submit();
    });
});
</script>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_microshop_goods_class'];?></h3>
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
  <!-- 操作说明 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['microshop_goods_class_binding_tip1'];?></li>
            <li><?php echo $lang['microshop_goods_class_binding_tip2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <input name="class_id" type="hidden" value="<?php echo $output['class_info']['class_id'];?>" />
  <table class="table tb-type2">
    <tbody>
      <tr class="noborder">
        <td colspan="2" class="required"><label for="class_name"><?php echo $lang['microshop_goods_class_binded'].$lang['nc_colon'];?></label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform" colspan="2"><ul id="goods_class_binding_list" class="goods-class-binding-list">
            <?php if(!empty($output['class_binding_list']) && is_array($output['class_binding_list'])) {?>
            <?php foreach($output['class_binding_list'] as $key=>$val) {?>
            <li class="class_binding_item"><?php echo $output['goods_class'][$val['shop_class_id']]['gc_name'];?> <i class="class_binding_item_delete" gc_id="<?php echo $val['shop_class_id'];?>" style="display: none;">&nbsp;</i> </li>
            <?php } ?>
            <?php } ?>
          </ul></td>
        
      </tr>
      <tr class="noborder">
        <td colspan="2" class="required"><label for="class_name"><?php echo $lang['microshop_goods_class_binding_select'].$lang['nc_colon'];?></label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform" colspan="2"><select id="goods_class" name="goods_class">
            <option value="0"><?php echo $lang['nc_common_pselect'];?></option>
            <?php if(!empty($output['goods_class_root']) && is_array($output['goods_class_root'])){ ?>
            <?php foreach($output['goods_class_root'] as $val) { ?>
            <option value="<?php echo $val['gc_id']; ?>"><?php echo $val['gc_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
          <ul id="goods_class_add_list" class="goods-class-add-list"></ul></td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2"><a id="submit" href="javascript:void(0)" class="btn"><span><?php echo $lang['nc_submit'];?></span></a></td>
      </tr>
    </tfoot>
  </table>
</div>
<form id="add_form" method="POST" action="index.php?act=microshop&op=goodsclass_binding_save">
  <input id="class_id" name="class_id" type="hidden" value="<?php echo $output['class_id'];?>" />
  <input id="shop_class_id" name="shop_class_id" type="hidden" value="<?php echo $output['class_binding_string'];?>" />
</form>
