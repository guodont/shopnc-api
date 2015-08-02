<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_goods_evaluate']; ?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=evaluate&op=evalgoods_list" ><span><?php echo $lang['admin_evaluate_list'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_evalstore_list'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="evaluate" />
    <input type="hidden" name="op" value="evalstore_list" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="store_name"><?php echo $lang['admin_evaluate_storename'];?></label></th>
          <td><input class="txt" type="text" name="store_name" id="store_name" value="<?php echo $_GET['store_name'];?>" /></td>
          <th><label for="from_name"><?php echo $lang['admin_evaluate_frommembername'];?></label></th>
          <td><input class="txt" type="text" name="from_name" id="from_name" value="<?php echo $_GET['from_name'];?>" /></td>
          <td><?php echo $lang['admin_evaluate_addtime'];?></td>
          <td><input class="txt date" type="text" name="stime" id="stime" value="<?php echo $_GET['stime'];?>" />~
          	<input class="txt date" type="text" name="etime" id="etime" value="<?php echo $_GET['etime'];?>" />
          </td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['admin_evalstore_help1'];?></li>
            <li><?php echo $lang['admin_evalstore_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2 evallist">
    <thead>
      <tr class="thead">
        <th><?php echo $lang['admin_evaluate_storename'];?></th>
        <th class="w150 align-center"><?php echo $lang['admin_evaluate_ordersn'];?></th>
        <th class="w150 align-center"><?php echo $lang['admin_evaluate_frommembername'];?></th>
        <th class="w150 align-center"><?php echo $lang['admin_evalstore_score'];?></th>
        <th class="w150 align-center"><?php echo $lang['admin_evaluate_addtime'];?></th>
        <th class="w72 align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
        <?php if(!empty($output['evalstore_list']) && is_array($output['evalstore_list'])){?>
      <?php foreach($output['evalstore_list'] as $v){?>
      <tr class="hover">
      	<td><?php echo $v['seval_storename'];?></td>
      	<td class="align-center"><?php echo $v['seval_orderno'];?></td>
      	<td class="align-center"><?php echo $v['seval_membername'];?></td>
        <td class="align-center">
              描述相符<div class="raty" style="display:inline-block;" data-score="<?php echo $v['seval_desccredit'];?>"></div>
              服务态度<div class="raty" style="display:inline-block;" data-score="<?php echo $v['seval_servicecredit'];?>"></div>
              发货速度<div class="raty" style="display:inline-block;" data-score="<?php echo $v['seval_deliverycredit'];?>"></div>
        </td>
      	<td class="align-center"><?php echo date('Y-m-d',$v['seval_addtime']);?></td>
        <td class="align-center">
        	<a nctype="btn_del" href="javascript:void(0)" data-seval-id="<?php echo $v['seval_id']; ?>"><?php echo $lang['nc_del']; ?></a>
        </td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr class="no_data">
        <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php }?>
    <tfoot>
        <?php if(!empty($output['evalstore_list']) && is_array($output['evalstore_list'])){?>
      <tr class="tfoot">
        <td colspan="15" id="dataFuncs"><div class="pagination"><?php echo $output['show_page'];?></div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
<form id="submit_form" action="<?php echo urlAdmin('evaluate', 'evalstore_del');?>" method="post">
    <input id="seval_id" name="seval_id" type="hidden">
</form>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#stime').datepicker({dateFormat: 'yy-mm-dd'});
        $('#etime').datepicker({dateFormat: 'yy-mm-dd'});

        $('.raty').raty({
            path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
            readOnly: true,
            score: function() {
              return $(this).attr('data-score');
            }
        });

        $('[nctype="btn_del"]').on('click', function() {
            if(confirm("<?php echo $lang['nc_ensure_del'];?>")) {
                var seval_id = $(this).attr('data-seval-id');
                $('#seval_id').val(seval_id);
                $('#submit_form').submit();
            }
        });
    });
</script>

