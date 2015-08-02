<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncm-flow-layout">
  <div class="ncm-flow-container">
    <div class="title"><a href="javascript:history.go(-1);" class="ncm-btn-mini fr"><i class="icon-reply"></i>返&nbsp;回</a>
      <h3><?php echo $lang['member_evaluation_toevaluategoods'];?></h3>
    </div>
    <form id="evalform" method="post" action="index.php?act=member_evaluate&op=<?php echo $_GET['op'];?>&order_id=<?php echo $_GET['order_id'];?>">
      <div class="alert alert-block">
        <h4>操作提示：</h4>
        <ul>
          <li><?php echo $lang['member_evaluation_rule_3'];?></li>
          <li><?php echo $output['ruleexplain'];?></li>
          <li><?php echo $lang['member_evaluation_rule_4'];?></li>
        </ul>
      </div>
      <div class="tabmenu">
        <ul class="tab">
          <li class="active"><a href="javascript:void(0);">对购买过的商品评价</a></li>
        </ul>
      </div>
      <table class="ncm-default-table deliver mb30">
        <thead>
          <tr>
            <th colspan="2"><?php echo $lang['member_evaluation_order_desc'];?></th>
            <th>商品评分</th>
            <th>评价详情</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th colspan="20" class="tr"><span class="mr10">
              <input type="checkbox" class="checkbox vm" name="anony">
              &nbsp;<?php echo $lang['member_evaluation_modtoanonymous'];?></span>
              </td>
          </tr>
          <?php if(!empty($output['order_goods'])){?>
          <?php foreach($output['order_goods'] as $goods){?>
          <tr class="bd-line">
            <td valign="top" class="w40"><div class="pic-thumb"><a href="index.php?act=goods&goods_id=<?php echo $goods['goods_id']; ?>" target="_blank"><img src="<?php echo $goods['goods_image_url']; ?>"/></a></span></div></td>
            <td valign="top" class="tl w200"><dl class="goods-name">
                <dt style="width: 190px;"><a href="index.php?act=goods&goods_id=<?php echo $goods['goods_id'];?>" target="_blank"><?php echo $goods['goods_name'];?></a></dt>
                <dd><span class="rmb-price"><?php echo $goods['goods_price'];?></span>&nbsp;*&nbsp;<?php echo $goods['goods_num'];?>&nbsp;件</dd>
              </dl></td>
            <td valign="top" class="w100"><div class="ncgeval mb10">
                <div class="raty">
                  <input nctype="score" name="goods[<?php echo $goods['goods_id'];?>][score]" type="hidden">
                </div>
              </div></td>
            <td valign="top" class="tr"><textarea name="goods[<?php echo $goods['goods_id'];?>][comment]" cols="150" style="width: 280px;"></textarea></td>
          </tr>
          <?php }?>
          <?php }?>
        </tbody>
      </table>
      <?php if (!$output['store_info']['is_own_shop'] && $_GET['op'] != 'add_vr') { ?>
      <div class="tabmenu">
        <ul class="tab">
          <li class="active"><a href="javascript:void(0);">对该店此次服务的评分</a></li>
        </ul>
      </div>
      <?php } ?>
      <div class="ncm-default-form">
      <?php if (!$output['store_info']['is_own_shop'] && $_GET['op'] != 'add_vr') { ?>
        <dl>
          <dt><?php echo $lang['member_evaluation_evalstore_type_1'].$lang['nc_colon'];?></dt>
          <dd>
            <div class="raty-x2">
              <input nctype="score" name="store_desccredit" type="hidden">
            </div>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['member_evaluation_evalstore_type_2'].$lang['nc_colon'];?></dt>
          <dd>
            <div class="raty-x2">
              <input nctype="score" name="store_servicecredit" type="hidden">
            </div>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['member_evaluation_evalstore_type_3'].$lang['nc_colon'];?></dt>
          <dd>
            <div class="raty-x2">
              <input nctype="score" name="store_deliverycredit" type="hidden">
            </div>
          </dd>
        </dl>
        <?php } ?>
        <div class="bottom">
          <label class="submit-border">
            <input id="btn_submit" type="button" class="submit" value="<?php echo $lang['member_evaluation_submit'];?>"/>
          </label>
        </div>
      </div>
    </form>
  </div>
  <div class="ncm-flow-item">
  <?php if (!$output['store_info']['is_own_shop']) { ?>
    <?php require('evaluation.store_info.php');?>
  <?php } ?>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.raty').raty({
            path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
            click: function(score) {
                $(this).find('[nctype="score"]').val(score);
            }
        });

        $('.raty-x2').raty({
            path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
            starOff: 'star-off-x2.png',
            starOn: 'star-on-x2.png',
            width: 150,
            click: function(score) {
                $(this).find('[nctype="score"]').val(score);
            }
        });


        $('#btn_submit').on('click', function() {
			ajaxpost('evalform', '', '', 'onerror')
        });
    });
</script>
