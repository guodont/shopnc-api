<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncsc-flow-layout" id="ncscComplainFlow">
  <div class="ncsc-flow-container">
    <div class="title">
      <h3>交易投诉申请</h3>
    </div>
    <div class="ncsc-flow-step">
      <dl id="state_new" class="step-first current">
        <dt><?php echo $lang['complain_state_new'];?></dt>
        <dd class="bg"></dd>
      </dl>
      <dl id="state_appeal" class="">
        <dt><?php echo $lang['complain_state_appeal'];?></dt>
        <dd class="bg"></dd>
      </dl>
      <dl id="state_talk" class="">
        <dt><?php echo $lang['complain_state_talk'];?></dt>
        <dd class="bg"></dd>
      </dl>
      <dl id="state_handle" class="">
        <dt><?php echo $lang['complain_state_handle'];?></dt>
        <dd class="bg"></dd>
      </dl>
      <dl id="state_finish" class="">
        <dt><?php echo $lang['complain_state_finish'];?></dt>
        <dd class="bg"></dd>
      </dl>
    </div>
    <div class="ncsc-form-default">
      <h3><?php echo $lang['complain_message'];?></h3>
      <dl>
        <dt>投&nbsp;&nbsp;诉&nbsp;&nbsp;人：</dt>
        <dd><?php echo $output['complain_info']['accuser_name'];?></dd>
        <dt><?php echo $lang['complain_subject_content'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['complain_info']['complain_subject_content'];?></dd>
        <dt><?php echo $lang['complain_datetime'].$lang['nc_colon'];?></dt>
        <dd><?php echo date('Y-m-d H:i:s',$output['complain_info']['complain_datetime']);?></dd>
        <dt><?php echo $lang['complain_content'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['complain_info']['complain_content'];?></dd>
        <dt><?php echo $lang['complain_evidence'].$lang['nc_colon'];?></dt>
        <dd>
          <?php
                        if(empty($output['complain_info']['complain_pic1'])&&empty($output['complain_info']['complain_pic2'])&&empty($output['complain_info']['complain_pic3'])) {
                            echo $lang['complain_pic_none'];
                        }
                        else {
                            $pic_link = SHOP_SITE_URL.'/index.php?act=show_pics&type=complain&pics=';
                            if(!empty($output['complain_info']['complain_pic1'])) {
                                $pic_link .= $output['complain_info']['complain_pic1'].'|';
                            }
                            if(!empty($output['complain_info']['complain_pic2'])) {
                                $pic_link .= $output['complain_info']['complain_pic2'].'|';
                            }
                            if(!empty($output['complain_info']['complain_pic3'])) {
                                $pic_link .= $output['complain_info']['complain_pic3'].'|';
                            }
                            $pic_link = rtrim($pic_link,'|');
                    ?>
          <a href="<?php echo $pic_link;?>" target="_blank"><?php echo $lang['complain_pic_view'];?></a>
          <?php } ?>
        </dd>
      </dl>
      <h3><?php echo $lang['complain_appeal_message'];?></h3>
      <dl>
        <dt><?php echo $lang['complain_appeal_datetime'].$lang['nc_colon'];?></dt>
        <dd><?php echo date('Y-m-d H:i:s',$output['complain_info']['appeal_datetime']);?></dd>
        <dt><?php echo $lang['complain_appeal_content'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['complain_info']['appeal_message'];?></dd>
        <dt><?php echo $lang['complain_appeal_evidence'].$lang['nc_colon'];?></dt>
        <dd>
          <?php
                        if(empty($output['complain_info']['appeal_pic1'])&&empty($output['complain_info']['appeal_pic2'])&&empty($output['complain_info']['appeal_pic3'])) {
                            echo $lang['complain_pic_none'];
                        }
                        else {
                            $pic_link = SHOP_SITE_URL.'/index.php?act=show_pics&type=complain&pics=';
                            if(!empty($output['complain_info']['appeal_pic1'])) {
                                $pic_link .= $output['complain_info']['appeal_pic1'].'|';
                            }
                            if(!empty($output['complain_info']['appeal_pic2'])) {
                                $pic_link .= $output['complain_info']['appeal_pic2'].'|';
                            }
                            if(!empty($output['complain_info']['appeal_pic3'])) {
                                $pic_link .= $output['complain_info']['appeal_pic3'].'|';
                            }
                            $pic_link = rtrim($pic_link,'|');
                    ?>
          <a href="<?php echo $pic_link;?>" target="_blank"><?php echo $lang['complain_pic_view'];?></a>
          <?php } ?>
        </dd>
      </dl>
      <?php
    if(intval($output['complain_info']['complain_state'])>20) {
        include template('seller/complain_talk.info');
    }
?>
      <?php if ($output['complain_info']['complain_state'] == 99) { ?>
      <h3><?php echo $lang['final_handle_message'];?></h3>
      <dl>
        <dt><?php echo '处理意见'.$lang['nc_colon'];?></dt>
        <dd><?php echo $output['complain_info']['final_handle_message'];?>&nbsp; </dd>
        <dt><?php echo $lang['final_handle_datetime'].$lang['nc_colon'];?></dt>
        <dd><?php echo date('Y-m-d H:i:s',$output['complain_info']['final_handle_datetime']);?></dd>
      </dl>
      <?php } ?>
      <div class="bottom"><a href="javascript:history.go(-1);" class="ncsc-btn"><i class="icon-reply"></i>返回列表</a></div>
    </div>
  </div>
  <?php include template('seller/complain_order.info');?>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var state = <?php echo empty($output['complain_info']['complain_state'])?0:$output['complain_info']['complain_state'];?>;
    if(state <= 10) {
        $("#state_new").addClass('current');
    }
    if(state == 20 ){
        $("#state_new").addClass('current');
        $("#state_appeal").addClass('current');
    }
    if(state == 30 ){
        $("#state_new").addClass('current');
        $("#state_appeal").addClass('current');
        $("#state_talk").addClass('current');
    }
    if(state == 40 ){
        $("#state_new").addClass('current');
        $("#state_appeal").addClass('current');
        $("#state_talk").addClass('current');
        $("#state_handle").addClass('current');
    }
    if(state == 99 ){
        $("#state_new").addClass('current');
        $("#state_appeal").addClass('current');
        $("#state_talk").addClass('current');
        $("#state_handle").addClass('current');
        $("#state_finish").addClass('current');
    }
});
</script>