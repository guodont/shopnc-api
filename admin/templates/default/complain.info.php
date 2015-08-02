<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){

    $(".complain_dialog").hide();
    $("#verify_button").click(function(){
         if(confirm("<?php echo $lang['verify_submit_message'];?>")) {
             $("#verify_form").submit();
         }
    });
    $("#close_button").click(function(){
        $("final_handle_message").text('');
        $(".complain_dialog").show();
        $("#close_complain").hide();
    });
    $("#btn_handle_submit").click(function(){
        if($("#final_handle_message").val()=='') {
            alert("<?php echo $lang['final_handle_message_error'];?>");
        }
        else {
            if(confirm("<?php echo $lang['complain_close_confirm'];?>")) {
                $("#close_form").submit();
            }
        }
    });
    $("#btn_close_cancel").click(function(){
        $(".complain_dialog").hide();
        $("#close_complain").show();
    });

});
</script>

<div class="page">
<div class="fixed-bar">
  <div class="item-title">
    <h3><?php echo $lang['complain_manage_title'];?></h3>
    <ul class="tab-base">
      <?php
		foreach($output['menu'] as $menu) {
		if($menu['menu_type'] == 'text') {
        ?>
      <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
      <?php
		}
		 else {
        ?>
      <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
      <?php
		}
		}
        ?>
    </ul>
  </div>
</div>
<div class="fixed-empty"></div>
<?php
        include template('complain_order.info');
        include template('complain_complain.info');
        if(!empty($output['complain_info']['appeal_message'])) {
            include template('complain_appeal.info');
        }
        if(intval($output['complain_info']['complain_state'])>20) {
            include template('complain_talk.info');
        }
        if(intval($output['complain_info']['complain_state']) == 99 && !empty($output['complain_info']['final_handle_message'])) {
            include template('complain_finish.info');
        }
    ?>
<?php if(intval($output['complain_info']['complain_state']) !== 99) { ?>
<table class="table tb-type2 order mtw">
  <thead class="thead">
    <tr class="space">
      <th><?php echo $lang['complain_handle'];?></th>
    </tr>
  </thead>
  <tbody>
  <tr id="close_complain">
      <td>
          <form method='post' id="verify_form" action="index.php?act=complain&op=complain_verify">
              <input name="complain_id" type="hidden" value="<?php echo $output['complain_info']['complain_id'];?>" />
              <?php if(intval($output['complain_info']['complain_state']) === 10) { ?>
              <a id="verify_button" class="btn" href="javascript:void(0)"><span><?php echo $lang['complain_text_verify'];?></span></a>
              <?php } ?>
              <?php if(intval($output['complain_info']['complain_state']) !== 99) { ?>
              <a id="close_button" class="btn" href="javascript:void(0)"><span><?php echo $lang['complain_text_close'];?></span></a>
              <?php } ?>
              <a href="JavaScript:void(0);" class="btn" onclick="history.go(-1)"><span><?php echo $lang['nc_back'];?></span></a>
          </form>
      </td>
  </tr>
  <form method='post' id="close_form" action="index.php?act=complain&op=complain_close">
  	<?php if(!empty($output['refund_goods']) && is_array($output['refund_goods'])) { ?>
    <tr class="complain_dialog">
      <th>可退款商品</th>
    </tr>
    <tr class="complain_dialog">
      <td>
        <p> 注：选中下表中订单商品可退款，可退款金额为0的商品不能进行操作。</p>
        <table class="table tb-type2 goods ">
          <tr>
            <th width="30">&nbsp;</th>
            <th colspan="2"><?php echo $lang['complain_goods_name'];?></th>
            <th>可退款金额</th>
            <th>实际支付额</th>
            <th>购买数量</th>
            <th><?php echo $lang['complain_text_price'];?></th>
          </tr>
        <?php foreach ($output['refund_goods'] as $key => $val) { ?>
          <tr>
            <td width="30">
                <?php if($val['goods_refund'] > 0) { ?>
                <input class="checkitem" name="checked_goods[<?php echo $val['rec_id'];?>]" type="checkbox" value="<?php echo $val['rec_id'];?>" />
                <?php } ?>
                </td>
            <td width="65" align="center" valign="middle"><a style="text-decoration:none;" href="<?php echo urlShop('goods','index',array('goods_id'=> $val['goods_id']));?>" target="_blank">
              <img width="50" src="<?php echo thumb($val,60);?>" />
              </a></td>
            <td class="intro">
                <p><a href="<?php echo urlShop('goods','index',array('goods_id'=> $val['goods_id']));?>" target="_blank"><?php echo $val['goods_name'];?> </a></p>
                <p><?php echo orderGoodsType($val['goods_type']); ?></p>
              </td>
            <td width="10%"><?php echo $lang['currency'].$val['goods_refund'];?></td>
            <td width="10%"><?php echo $lang['currency'].$val['goods_pay_price'];?></td>
            <td width="10%"><?php echo $val['goods_num'];?></td>
            <td width="10%"><?php echo $lang['currency'].$val['goods_price'];?></td>
          </tr>
        <?php } ?>
        </table></td>
    </tr>
  	<?php } ?>
    <tr class="complain_dialog">
      <th><?php echo $lang['final_handle_message'];?>:</th>
    </tr>
    <input name="complain_id" type="hidden" value="<?php echo $output['complain_info']['complain_id'];?>" />
    <tr class="noborder complain_dialog">
      <td><textarea id="final_handle_message" name="final_handle_message" class="tarea"></textarea></td>
    </tr>
    <tr class="complain_dialog">
        <td>
            <a id="btn_handle_submit" class="btn" href="javascript:void(0)"><span><?php echo $lang['nc_submit'];?></span></a>
            <a id="btn_close_cancel" class="btn" href="javascript:void(0)"><span><?php echo $lang['nc_cancel'];?></span></a>
        </td>
    </tr>
  </form>
    </tbody>
</table>
<?php } ?>
