<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>自营店铺</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=ownshop&op=list"><span>管理</span></a></li>
        <li><a href="index.php?act=ownshop&op=add"><span>新增</span></a></li>
        <li><a href="javascript:;" class="current"><span>编辑</span></a></li>
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
            <li>可以修改自营店铺的店铺名称以及店铺状态是否为开启状态</li>
            <li>可以修改自营店铺的店主商家中心登录账号</li>
            <li>如需修改店主登录密码，请到会员管理中，搜索“店主账号”相应的会员并编辑</li>
            <li>已绑定所有类目的自营店，如果将“绑定所有类目”设置为“否”，则会下架其所有商品，请谨慎操作！</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="store_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="store_id" value="<?php echo $output['store_array']['store_id']; ?>" />
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="store_name">店铺名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['store_array']['store_name'];?>" id="store_name" name="store_name" class="txt" /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="store_name">开店时间:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo ($t = $output['store_array']['store_time'])?@date('Y-m-d',$t):'';?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label>店主账号:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['store_array']['member_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="seller_name">店主卖家账号:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['store_array']['seller_name'];?>" id="seller_name" name="seller_name" class="txt" /></td>
          <td class="vatop tips">用于登录商家中心，可与店主账号不同</td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td colspan="2" class="required"><label>
            <label for="bind_all_gc">绑定所有类目:</label>
            </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
            <label for="bind_all_gc1" class="cb-enable <?php if ($output['store_array']['bind_all_gc'] == '1'){ ?>selected<?php } ?>" ><span>是</span></label>
            <label for="bind_all_gc0" class="cb-disable <?php if($output['store_array']['bind_all_gc'] == '0'){ ?>selected<?php } ?>" ><span>否</span></label>
            <input id="bind_all_gc1" name="bind_all_gc" <?php if($output['store_array']['bind_all_gc'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="bind_all_gc0" name="bind_all_gc" <?php if($output['store_array']['bind_all_gc'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
          </td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td colspan="2" class="required"><label>
            <label for="state">状态:</label>
            </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="store_state1" class="cb-enable <?php if($output['store_array']['store_state'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['open'];?></span></label>
            <label for="store_state0" class="cb-disable <?php if($output['store_array']['store_state'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['close'];?></span></label>
            <input id="store_state1" name="store_state" <?php if($output['store_array']['store_state'] == '1'){ ?>checked="checked"<?php } ?> onclick="$('#tr_store_close_info').hide();" value="1" type="radio">
            <input id="store_state0" name="store_state" <?php if($output['store_array']['store_state'] == '0'){ ?>checked="checked"<?php } ?> onclick="$('#tr_store_close_info').show();" value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody id="tr_store_close_info">
        <tr >
          <td colspan="2" class="required"><label for="store_close_info">关闭原因:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="store_close_info" rows="6" class="tarea" id="store_close_info"><?php echo $output['store_array']['store_close_info'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
$(function(){

    $('input[name=store_state][value=<?php echo $output['store_array']['store_state'];?>]').trigger('click');

    //按钮先执行验证再提交表单
    $("#submitBtn").click(function(){
        if($("#store_form").valid()){
            $("#store_form").submit();
        }
    });

    $('#store_form').validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parentsUntil('tr').parent().prev().find('td:first'));
        },
        rules : {
            store_name: {
                required : true,
                remote : '<?php echo urlAdmin('ownshop', 'ckeck_store_name', array('store_id' => $output['store_array']['store_id']))?>'
            },
            seller_name: {
                required : true,
                remote   : {
                    url : 'index.php?act=ownshop&op=check_seller_name&id=<?php echo $output['store_array']['store_id']; ?>',
                    type: 'get',
                    data:{
                        seller_name : function(){
                            return $('#seller_name').val();
                        }
                    }
                }
            }
        },
        messages : {
            store_name: {
                required: '请输入店铺名称',
                remote : '店铺名称已存在'
            },
            seller_name: {
                required : '请输入店主卖家账号',
                remote   : '此名称已被其它店铺占用，请重新输入'
            }
        }
    });
});
</script>
