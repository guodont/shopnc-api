<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_statgeneral'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
        	<li>设置订单金额区间，当对订单金额进行相关统计时按照以下设置的价格区间进行统计和显示</li>
        	<li>设置价格区间的几点建议：一、建议设置的第一个价格区间起始额为0；二、价格区间应该设置完整，不要缺少任何一个起始额和结束额；三、价格区间数值应该连贯例如0~100,101~200</li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" action="index.php" name="pricerangeform" id="pricerangeform">
  	<input type="hidden" value="ok" name="form_submit">
  	<input type="hidden" name="act" value="stat_general" />
    <input type="hidden" name="op" value="orderprange" />
    <table id="pricerang_table" class="table tb-type2">
    	<thead class="thead">
    		<tr class="space">
    			<th colspan='4'><a id="addrow" href="javascript:void(0);" class="btns"><span>增加一行</span></a></th>
    		</tr>
    		<tr>
    			<th>起始额</th>
    			<th>结束额</th>
    			<th>操作</th>
    		</tr>
    	</thead>
    	<tbody>
    	<?php if (!empty($output['list_setting']['stat_orderpricerange']) && is_array($output['list_setting']['stat_orderpricerange'])){?>
    		<?php foreach ($output['list_setting']['stat_orderpricerange'] as $k=>$v){ ?>
    		<tr id="row_<?php echo $k; ?>">
    			<td><input type="text" class="txt" value="<?php echo $v['s'];?>" name="pricerange[<?php echo $k;?>][s]"></td>
    			<td><input type="text" class="txt" value="<?php echo $v['e'];?>" name="pricerange[<?php echo $k;?>][e]"></td>
    			<td><a href="JavaScript:void(0);" onclick="delrow(<?php echo $k;?>);"><?php echo $lang['nc_del']; ?></a></td>
    		</tr>
    		<?php } ?>
    	<?php }?>
    	</tbody>
    	<tfoot>
    		<tr class="tfoot">
    			<td colspan="4" class="align-center"><a id="ncsubmit" class="btn" href="JavaScript:void(0);"><span>提交</span></a></td>
    		</tr>
    	</tfoot>
      </table>
      
  </form>
  
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript">
function delrow(i){
	$("#row_"+i).remove();
}
$(function(){
	var i = <?php echo count($output['list_setting']['stat_orderpricerange']); ?>;
	i += 1;
	var html = '';
	/*新增一行*/
	$('#addrow').click(function(){
		html = '<tr id="row_'+i+'">';
		html += '<td><input type="text" class="txt" name="pricerange['+i+'][s]" value="0"/></td>';
		html += '<td><input type="text" class="txt" name="pricerange['+i+'][e]" value="0"/></td>';
		html += '<td><a href="JavaScript:void(0);" onclick="delrow('+i+');"><?php echo $lang['nc_del']; ?></a></td>';
		$('#pricerang_table').find('tbody').append(html);
		i += 1;
	});
	
	$('#ncsubmit').click(function(){
		var result = true;
		$("#pricerang_table").find("[name^='pricerange']").each(function(){
			if(!$(this).val()){
				result = false;
			}
		});
		if(result){
			$('#pricerangeform').submit();
		} else {
			showDialog('请将价格区间填写完整');
		}
    });
})
</script>