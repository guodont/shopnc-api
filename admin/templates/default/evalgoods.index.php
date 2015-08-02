<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_goods_evaluate']; ?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_evaluate_list'];?></span></a></li>
        <li><a href="index.php?act=evaluate&op=evalstore_list" ><span><?php echo $lang['admin_evalstore_list'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="evaluate" />
    <input type="hidden" name="op" value="evalgoods_list" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="goods_name"><?php echo $lang['admin_evaluate_goodsname']?></label></th>
          <td><input class="txt" type="text" name="goods_name" id="goods_name" value="<?php echo $_GET['goods_name'];?>" /></td>
          <th><label for="store_name"><?php echo $lang['admin_evaluate_storename']?></label></th>
          <td><input class="txt" type="text" name="store_name" id="store_name" value="<?php echo $_GET['store_name'];?>" /></td>
          <td><?php echo $lang['admin_evaluate_addtime']; ?></td>
          <td><input class="txt date" type="text" name="stime" id="stime" value="<?php echo $_GET['stime'];?>" />
            ~
            <input class="txt date" type="text" name="etime" id="etime" value="<?php echo $_GET['etime'];?>" /></td>
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
            <li><?php echo $lang['admin_evaluate_help1'];?></li>
            <li><?php echo $lang['admin_evaluate_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2">
    <thead>
      <tr class="thead">
        <th class="w300"><?php echo $lang['admin_evaluate_goodsname'];?> </th>
        <th><?php echo $lang['admin_evaluate_buyerdesc']; ?></th>
        <th class="w108 align-center"><?php echo $lang['admin_evaluate_frommembername'];?> </th>
        <th class="w108 align-center"><?php echo $lang['admin_evaluate_storename'];?></th>
        <th class="w72 align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
    <?php if(!empty($output['evalgoods_list'])){?>
      <?php foreach($output['evalgoods_list'] as $v){?>
      <tr class="hover">
        <td><a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['geval_goodsid']));?>" target="_blank"><?php echo $v['geval_goodsname'];?></a></td>
        <td class="evaluation"><div>商品评分：<span class="raty" data-score="<?php echo $v['geval_scores'];?>"></span><time>[<?php echo @date('Y-m-d',$v['geval_addtime']);?>]</time></div>
          <div>评价内容：<?php echo $v['geval_content'];?></div>
          
          <?php if(!empty($v['geval_image'])) {?>
          <div>晒单图片：
            <ul class="evaluation-pic-list">
              <?php $image_array = explode(',', $v['geval_image']);?>
              <?php foreach ($image_array as $value) { ?>
              <li><a nctype="nyroModal"  href="<?php echo snsThumb($value, 1024);?>"> <img src="<?php echo snsThumb($value);?>"> </a></li>
              <?php } ?>
            </ul>
          </div>
          <?php } ?>
          
          <?php if(!empty($v['geval_explain'])){?>
          <div id="explain_div_<?php echo $v['geval_id'];?>"> <span style="color:#996600;padding:5px 0px;">[<?php echo $lang['admin_evaluate_explain']; ?>]<?php echo $v['geval_explain'];?></span> </div>
          <?php }?></td>
        <td class="align-center"><?php echo $v['geval_frommembername'];?></td>
        <td class="align-center"><?php echo $v['geval_storename'];?></td>
        <td class="align-center"><a nctype="btn_del" href="javascript:void(0)" data-geval-id="<?php echo $v['geval_id']; ?>"><?php echo $lang['nc_del']; ?></a></td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr class="no_data">
        <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php }?>
    <?php if(!empty($output['evalgoods_list'])){?>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15" id="dataFuncs"><div class="pagination"><?php echo $output['show_page'];?></div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
<form id="submit_form" action="<?php echo urlAdmin('evaluate', 'evalgoods_del');?>" method="post">
  <input id="geval_id" name="geval_id" type="hidden">
</form>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
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

        $('a[nctype="nyroModal"]').nyroModal();

        $('[nctype="btn_del"]').on('click', function() {
            if(confirm("<?php echo $lang['nc_ensure_del'];?>")) {
                var geval_id = $(this).attr('data-geval-id');
                $('#geval_id').val(geval_id);
                $('#submit_form').submit();
            }
        });
    });
</script> 
