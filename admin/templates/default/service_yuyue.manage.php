<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>预约管理</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>管理</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
	<input type="hidden" name="act" value="service">
	<input type="hidden" name="op" value="service_yuyue">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label>服务名称</label></th>
          <td id="gcategory"><input type="hidden" id="cate_id" name="cate_id" value="" class="mls_id" />
            <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names" />
            <select class="querySelect">
              <option><?php echo $lang['nc_please_choose'];?>...</option>
<?php if(!empty($output['service_list']) && is_array($output['service_list'])){ ?>
              <?php foreach($output['service_list'] as $k => $v){ ?>
              <option <?php if($output['search_ac_id'] == $v['yuyue_id']){ ?>selected='selected'<?php } ?> value="<?php echo $v['yuyue_id'];?>"><?php echo $v['service_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
		  <th><label for="search_service_name">服务时间</label></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['query_start_time'];?>" id="query_start_time" name="query_start_time">
            <label for="query_start_time">~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['query_end_time'];?>" id="query_end_time" name="query_end_time"/><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>	
        </tr>
      </tbody>
    </table>
  </form>
  <form method='post' id="form_yuyue">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="type" id="type" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th width="25px"></th>
          <th>预约服务</th>
          <th>用户</th>		  
          <th>服务单位</th>
		  <th class="align-center">起止时间</th>		  
		  <th class="align-center">通过预约</th>
		  <th class="align-center">支付状态</th>
          <th class="align-center">服务状态</th>
          <th class="align-center">操作 </th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){ ?>
        <?php foreach($output['goods_list'] as $k => $v){?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" name="del_id[]" value="<?php echo $v['yuyue_id'];?>" class="checkitem"></td>
          <td class="goods-name w170"><?php echo $v['service_name'];?></td>
          <td><?php echo $v['yuyue_member_name']; ?></td>		  
          <td><?php echo $v['yuyue_company']; ?></td>
          <td class="goods-name w270 align-center"><?php echo date('Y-m-d',$v['yuyue_start_time']);?>——<?php echo date('Y-m-d',$v['yuyue_end_time']);?></td>			  
		  <td class="align-center yes-onoff"><?php if($v['yuyue_status'] == 0){ ?>
            <a href="JavaScript:void(0);" class=" disabled" fieldvalue="0" fieldid="<?php echo $v['yuyue_id'];?>" ajax_branch="yuyue_status" fieldname="yuyue_status" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class=" enabled" fieldvalue="1" fieldid="<?php echo $v['yuyue_id'];?>" ajax_branch="yuyue_status" fieldname="yuyue_status" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>	
		  <td class="align-center yes-onoff"><?php if($v['yuyue_pay_status'] == 0){ ?>
            <a href="JavaScript:void(0);" class=" disabled" fieldvalue="0" fieldid="<?php echo $v['yuyue_id'];?>" ajax_branch="yuyue_pay_status" fieldname="yuyue_pay_status" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class=" enabled" fieldvalue="1" fieldid="<?php echo $v['yuyue_id'];?>" ajax_branch="yuyue_pay_status" fieldname="yuyue_pay_status" nc_type="inline_edit" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>	
          <td class="align-center">
		  <?php echo $v['yuyue_status']?>
		  </td>
          <td class="w48 align-center"><a href="index.php?act=service&op=service_yuyue_edit&yuyue_id=<?php echo $v['yuyue_id']; ?>">安排</a></td>
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
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_form('del');"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_flea_select.js" charset="utf-8"></script>
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
$(function(){
	gcategoryInit("gcategory");
});

function submit_form(type){
	if(type=='del'){
		if(!confirm('<?php echo $lang['goods_index_ensure_handle'];?>?')){
			return false;
		}
	}
	$('#type').val(type);
	$('#form_yuyue').submit();
}
</script>
<script type="text/javascript">
$(function(){
    $('#query_start_time').datepicker({dateFormat: 'yy-mm-dd'});
    $('#query_end_time').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncsubmit').click(function(){
    	$('input[name="op"]').val('index');$('#form_yuyue').submit();
    });
});
</script> 
