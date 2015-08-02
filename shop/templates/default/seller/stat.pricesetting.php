<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>

<div class="alert mt10" style="clear:both;">
	<ul class="mt5">
		<li>1、设置商品价格区间，当对商品价格进行相关统计时按照以下设置的价格区间进行统计和显示</li>
        <li>2、设置价格区间的几点建议：一、建议设置的第一个价格区间起始额为0；二、价格区间应该设置完整，不要缺少任何一个起始额和结束额；三、价格区间数值应该连贯例如0~100,101~200</li>
    </ul>
</div>

<form id="pricerangeform" method="post" action="index.php" target="_self" onsubmit="return checksubmit();">
	<input type="hidden" name="act" value="statistics_general" />
    <input type="hidden" name="op" value="pricesetting" />
    <input type="hidden" value="ok" name="form_submit">
    <table id="pricerang_table" class="ncsc-default-table">
      <thead>
        <tr>
          <th class="tl" style="padding-left:10px;">起始额</th>
          <th class="tl">结束额</th>
          <th class="w120"><?php echo $lang['nc_handle'];?></th>
        </tr>
        <tr>
          <td colspan="20">
            <a id="addrow" href="javascript:void(0);" class="ncsc-btn-mini"><span>增加一行</span></a>
          </td>
        </tr>
      </thead>
      <tbody>
      	<?php if ($output['pricerange']){ ?>
      	<?php foreach ((array)$output['pricerange'] as $k=>$v){ ?>
    	<tr id="row_<?php echo $k; ?>">
    		<td class="tl"><input type="text" class="txt" value="<?php echo $v['s'];?>" name="pricerange[<?php echo $k;?>][s]"></td>
    		<td class="tl"><input type="text" class="txt" value="<?php echo $v['e'];?>" name="pricerange[<?php echo $k;?>][e]"></td>
    		<td class="nscs-table-handle">
    			<span><a class="btn-red" href="JavaScript:void(0);" onclick="delrow(<?php echo $k;?>);"><i class="icon-trash"></i><p><?php echo $lang['nc_del']; ?></p></a></span>
    		</td>
    	</tr>
    	<?php } } else { ?>
    	<tr id="row_0">
    		<td class="tl"><input type="text" class="txt" value="0" name="pricerange[0][s]"></td>
    		<td class="tl"><input type="text" class="txt" value="0" name="pricerange[0][e]"></td>
    		<td class="nscs-table-handle">
    			<span><a class="btn-red" href="JavaScript:void(0);" onclick="delrow(0);"><i class="icon-trash"></i><p><?php echo $lang['nc_del']; ?></p></a></span>
    		</td>
    	</tr>
    	<?php } ?>
      </tbody>
      	<tfoot>
        	<tr class="tfoot">
        		<td colspan="4" class="align-center">
        			<div class="bottom">
        				<label class="submit-border"><input type="submit" value="提交" class="submit"></label>
        			</div>
        		</td>
        	</tr>
        </tfoot>
    </table>
</form>
<script type="text/javascript">
function delrow(i){
	$("#row_"+i).remove();
}
function checksubmit(){
	var result = true;
	$("#pricerang_table").find("[name^='pricerange']").each(function(){
		if(!$(this).val()){
			result = false;
		}
	});
	if(!result){
		showDialog('请将价格区间填写完整');
	}
	return result;
}

$(function(){
	var i = <?php echo count($output['pricerange']); ?>;
	i += 1;
	var html = '';
	/*新增一行*/
	$('#addrow').click(function(){
		html = '<tr id="row_'+i+'">';
		html += '<td class="tl"><input type="text" name="pricerange['+i+'][s]" value="0"/></td>';
		html += '<td class="tl"><input type="text" name="pricerange['+i+'][e]" value="0"/></td>';
		html += '<td class="nscs-table-handle"><span><a class="btn-red" href="JavaScript:void(0);" onclick="delrow('+i+');"><i class="icon-trash"></i><p><?php echo $lang['nc_del']; ?></p></a></span></td>';
		
		$('#pricerang_table').find('tbody').append(html);
		i += 1;
	});
});

</script>