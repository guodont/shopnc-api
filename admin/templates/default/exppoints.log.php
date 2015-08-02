<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>经验值管理</h3>
      <ul class="tab-base">
      	<li><a href="JavaScript:void(0);" class="current"><span>经验值明细</span></a></li>
        <li><a href="index.php?act=exppoints&op=expsetting"><span>规则设置</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="exppoints">
    <input type="hidden" name="op" value="">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label>会员名称</label></th>
          <td><input type="text" name="mname" class="txt" value='<?php echo $_GET['mname'];?>'></td>
          <th>添加时间</th>
          <td>
          	<input type="text" id="stime" name="stime" class="txt date" value="<?php echo $_GET['stime'];?>">
            <label>~</label>
            <input type="text" id="etime" name="etime" class="txt date" value="<?php echo $_GET['etime'];?>">
          </td>
          <td><select name="stage">
              <option value="" <?php if (!$_GET['stage']){echo 'selected=selected';}?>>操作阶段</option>
              <?php foreach ($output['stage_arr'] as $k=>$v){ ?>
              <option value="<?php echo $k;?>" <?php if ($_GET['stage'] == $k){echo 'selected=selected';}?>><?php echo $v; ?></option>
              <?php } ?>
          </select></td>
          <th>描述</th>
          <td><input type="text" id="description" name="description" class="txt2" value="<?php echo $_GET['description'];?>" ></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if($output['search_field_value'] != '' or $output['search_sort'] != ''){?>
            <a href="index.php?act=member&op=member" class="btns "><span><?php echo $lang['nc_cancel_search']?></span></a>
            <?php }?>
          </td>
        </tr>
      </tbody>
    </table>
  </form><div style="text-align:right;"><a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?>Excel</span></a></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
        	<li>经验值明细，展示了会员经验值增减情况的详细情况记录，经验值前有符号“-”表示减少，无符号表示增加</li>
        </ul>
       </td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2">
    <thead>
      <tr class="thead">
        <th>会员名称</th>
        <th class="align-center">经验值</th>
        <th class="align-center">添加时间</th>
        <th class="align-center">操作阶段</th>
        <th>描述</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['list_log']) && is_array($output['list_log'])){ ?>
      <?php foreach($output['list_log'] as $k => $v){?>
      <tr class="hover">
        <td><?php echo $v['exp_membername'];?></td>
        <td class="align-center"><?php echo $v['exp_points'];?></td>
        <td class="nowrap align-center"><?php echo @date('Y-m-d',$v['exp_addtime']);?></td>
        <td class="align-center"><?php echo $output['stage_arr'][$v['exp_stage']]; ?></td>
        <td><?php echo $v['exp_desc'];?></td>
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
        <td colspan="15"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
      </tr>
    </tfoot>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script language="javascript">
$(function(){
	$('#stime').datepicker({dateFormat: 'yy-mm-dd'});
	$('#etime').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncexport').click(function(){
    	$('input[name="op"]').val('export_step1');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input[name="op"]').val('index');
    	$('#formSearch').submit();
    });
});
</script>
