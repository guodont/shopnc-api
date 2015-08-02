<?php defined('InShopNC') or exit('Access Invalid!');?>
  <div class="tabmenu">
  	<?php include template('layout/submenu');?>
    <a class="ncsc-btn ncsc-btn-green" href="index.php?act=store_livegroup&op=groupbuy_add" title=""><i class="icon-plus-sign"></i>新增线下抢</a>
  </div>
  <div class="alert alert-block mt10 mb10">
      <h4><?php echo $lang['nc_explain'].$lang['nc_colon'];?></h4>
      <ul>
          <li>1、选择“新增线下抢”可添加新的抢购活动。</li>
          <li>2、线下抢活动添加后需经平台审核处理，未经审核的活动仍可进行编辑修改或删除。</li>
          <li>3、平台审核通过后，商家将不可对线下抢活动进行编辑或删除，如有特殊情况请与平台联系。</li>
      </ul>
  </div>
  <form method="get">
    <table class="search-form">
      <input type="hidden" id='act' name='act' value='store_livegroup' />
      <input type="hidden" id='op' name='op' value='store_livegroup' />
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <th>审核状态</th>
        <td class="w120">
          <select class="w80" name="is_audit">
        	<option value="">请选择...</option>
        	<option value="2" <?php if($_GET['is_audit']==2){ echo 'selected';}?> >审核通过</option>
        	<option value="3" <?php if($_GET['is_audit']==3){ echo 'selected';}?> >审核未通过</option>
			<option value="1" <?php if($_GET['is_audit']==1){ echo 'selected';}?> >待审核</option>
          </select>
        </td>
        <th class="w60">抢购名称</th>
        <td class="w160"><input type="text" class="text w150"  id="txt_keyword" name="txt_keyword" value="<?php echo $_GET['txt_keyword'];?>"/></td>
        <td class="tc w70"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
    </table>
  </form>
  <table class="ncsc-table-style">
    <thead>
      <tr><th class="w10"></th>
      <th class="w50"></th>    
        <th class="tl">抢购名称</th>
        <th class="w130">开始时间</th>
        <th class="w130">结束时间</th>
        <th class="w80">已购买</th>
        <th class="w80">审核</th>
        <th class="w80">状态</th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($output['list'])>0) { ?>
      <?php foreach($output['list'] as $val) { ?>
      <tr class="bd-line">
      <td></td>
      <td><div class="pic-thumb"><a href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$val['groupbuy_id']));?>" target="_blank"><img src="<?php echo lgthumb($val['groupbuy_pic'], 'small');?>"/></a></div></td>
        <td class="tl"><dl class="goods-name">
          <dt><a href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$val['groupbuy_id']));?>" target="_blank"><?php echo $val['groupbuy_name'];?></a></dt><dd></dd></dl></td>
        <td><?php echo date("Y-m-d H:i",$val['start_time']);?></td>
        <td><?php echo date("Y-m-d H:i",$val['end_time']);?></td>
        <td><?php echo $val['buyer_num'];?></td>
        <td>
            <?php if($val['is_audit'] == 1){?>
				<!-- 待审核 -->
				<?php echo '待审核';?>
			<?php }elseif($val['is_audit'] == 2){?>
				<!-- 审核通过 -->
				<?php echo '通过';?>
			<?php }else{?>
				<!-- 审核不通过 -->
				<?php echo '拒绝';?>
			<?php }?>
        </td>
        <td>
				<?php if($val['is_open']==1){?>
					<?php if($val['start_time']>time()){?>
					<?php echo '即将开始';?>
					<?php }elseif(($val['start_time']<=time()) && ($val['end_time']>time())){?>
					<?php echo '正在进行';?>
					<?php }elseif($val['end_time']<time()){?>
					<?php echo '已经结束';?>
					<?php }?>
				<?php }elseif($val['is_open']==2){?>
					<?php echo '已关闭';?>
				<?php }?>
        </td>
        <td>
        	<?php if($val['is_audit']!=2 && $val['is_open']!=2){?>
        	<a href="index.php?act=store_livegroup&op=edit_livegroupbuy&groupbuy_id=<?php echo $val['groupbuy_id'];?>">编辑</a>&nbsp;|&nbsp;
        	<a href="javascript:;" onclick="javascript:delgroup('<?php echo $val['groupbuy_id'];?>');">删除</a>
        	<?php }?>
        </td>
      </tr>
      <?php }?>
      <?php } else { ?>
      <tr>
        <td colspan="17" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php  if (count($output['list'])>0) { ?>
      <tr>
        <td colspan="17"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8" ></script> 
<script type="text/javascript">
$(document).ready(function(){
	$('#txt_startdate').datepicker();
	$('#txt_enddate').datepicker();
});

function delgroup(group_id){
	if(confirm('确认删除该抢购?')){
		location.href = 'index.php?act=store_livegroup&op=delgroup&groupbuy_id='+group_id;
	}	
}
</script>
