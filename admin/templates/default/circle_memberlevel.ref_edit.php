<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['circle_memberlevel'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=circle_memberlevel"><span><?php echo $lang['circle_defaultlevel'];?></span></a></li>
        <li><a href="index.php?act=circle_memberlevel&op=ref"><span><?php echo $lang['circle_memberlevelref'];?></span></a></li>
        <li><a href="index.php?act=circle_memberlevel&op=ref_add"><span><?php echo $lang['circle_memberleveladd'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['circle_memberleveledit'];?></span></a></li>
        <li><a href="index.php?act=circle_memberlevel&op=update_cache"><span><?php echo $lang['nc_circle_cache'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" id="clmdEditForm" name="clmdEditForm">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="mlref_id" value="<?php echo $output['mlref_info']['mlref_id']?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="mlref_name"><?php echo $lang['circle_memberlevelgroup'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="mlref_name" name="mlref_name" class="txt" type="text" value="<?php echo $output['mlref_info']['mlref_name'];?>"></td>
          <td class="vatop tips"><span class="vatop rowform"></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['circle_is_use'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
            <label for="mlref_status1" class="cb-enable <?php if($output['mlref_info']['mlref_status'] == 1){?>selected<?php }?>" ><span><?php echo $lang['open'];?></span></label>
            <label for="mlref_status0" class="cb-disable <?php if($output['mlref_info']['mlref_status'] == 0){?>selected<?php }?>" ><span><?php echo $lang['close'];?></span></label>
            <input id="mlref_status1" name="mlref_status" <?php if($output['mlref_info']['mlref_status'] == 1){?>checked="checked"<?php }?> value="1" type="radio">
            <input id="mlref_status0" name="mlref_status" <?php if($output['mlref_info']['mlref_status'] == 0){?>checked="checked"<?php }?> value="0" type="radio"></td>
          <td class="vatop tips"><span class="vatop rowform"></span></td>
        </tr>
      </tbody>
    </table>
    <table class="table tb-type2">
      <thead>
        <tr>
          <th><?php echo $lang['circle_level'];?></th>
          <th class="w40pre"><?php echo $lang['circle_rankname'];?></th>
          <th><?php echo $lang['circle_level'];?></th>
          <th class="w40pre"><?php echo $lang['circle_rankname'];?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td><input type="text" name="mlref_1" value="<?php echo $output['mlref_info']['mlref_1'];?>" /></td>
          <td>9</td>
          <td><input type="text" name="mlref_9" value="<?php echo $output['mlref_info']['mlref_9'];?>" /></td>
        </tr>
        <tr>
          <td>2</td>
          <td><input type="text" name="mlref_2" value="<?php echo $output['mlref_info']['mlref_2'];?>" /></td>
          <td>10</td>
          <td><input type="text" name="mlref_10" value="<?php echo $output['mlref_info']['mlref_10'];?>" /></td>
        </tr>
        <tr>
          <td>3</td>
          <td><input type="text" name="mlref_3" value="<?php echo $output['mlref_info']['mlref_3'];?>" /></td>
          <td>11</td>
          <td><input type="text" name="mlref_11" value="<?php echo $output['mlref_info']['mlref_11'];?>" /></td>
        </tr>
        <tr>
          <td>4</td>
          <td><input type="text" name="mlref_4" value="<?php echo $output['mlref_info']['mlref_4'];?>" /></td>
          <td>12</td>
          <td><input type="text" name="mlref_12" value="<?php echo $output['mlref_info']['mlref_12'];?>" /></td>
        </tr>
        <tr>
          <td>5</td>
          <td><input type="text" name="mlref_5" value="<?php echo $output['mlref_info']['mlref_5'];?>" /></td>
          <td>13</td>
          <td><input type="text" name="mlref_13" value="<?php echo $output['mlref_info']['mlref_13'];?>" /></td>
        </tr>
        <tr>
          <td>6</td>
          <td><input type="text" name="mlref_6" value="<?php echo $output['mlref_info']['mlref_6'];?>" /></td>
          <td>14</td>
          <td><input type="text" name="mlref_14" value="<?php echo $output['mlref_info']['mlref_14'];?>" /></td>
        </tr>
        <tr>
          <td>7</td>
          <td><input type="text" name="mlref_7" value="<?php echo $output['mlref_info']['mlref_7'];?>" /></td>
          <td>15</td>
          <td><input type="text" name="mlref_15" value="<?php echo $output['mlref_info']['mlref_15'];?>" /></td>
        </tr>
        <tr>
          <td>8</td>
          <td><input type="text" name="mlref_8" value="<?php echo $output['mlref_info']['mlref_8'];?>" /></td>
          <td>16</td>
          <td><input type="text" name="mlref_16" value="<?php echo $output['mlref_info']['mlref_16'];?>" /></td>
        </tr>
      </tbody>
    </table>
    <table>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
 </form>
</div>
<script>
$(function(){
	$("#submitBtn").click(function(){
	    if($("#clmdEditForm").valid()){
	    	$("#clmdEditForm").submit();
		}
	});
	$("#clmdEditForm").validate({
		errorPlacement: function(error, element){
			if(element.attr('id') == 'mlref_name'){
				error.appendTo(element.parentsUntil('tr').parent().prev().find('td:first'));
			}else{
				error.appendTo(element.parent());
			}
        },
        rules : {
        	mlref_name : {
        		required : true
        	}
        	<?php for($i=1;$i<=16;$i++){?>
        	,mlref_<?php echo $i;?> : {
            	required : true,
            	maxlength : 4
        	}
        	<?php }?>
        },
		messages : {
			mlref_name : {
				required : '<?php echo $lang['circle_memberlevelgroupname_not_null'];?>'
			}
			<?php for($i=1;$i<=16;$i++){?>
			,mlref_<?php echo $i;?> : {
				required : '<?php echo $lang['circle_rank_not_null'];?>',
				maxlength : '<?php echo $lang['circle_rank_maxlength'];?>'
			}
			<?php }?>
		}
	});
});
</script>