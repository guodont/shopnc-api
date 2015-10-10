<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['circle_memberlevel'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=circle_memberlevel"><span><?php echo $lang['circle_defaultlevel'];?></span></a></li>
        <li><a href="index.php?act=circle_memberlevel&op=ref"><span><?php echo $lang['circle_memberlevelref'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['circle_memberleveladd'];?></span></a></li>
        <li><a href="index.php?act=circle_memberlevel&op=update_cache"><span><?php echo $lang['nc_circle_cache'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" id="clmdAddForm" name="clmdAddForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="mlref_name"><?php echo $lang['circle_memberlevelgroup'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="mlref_name" name="mlref_name" class="txt" type="text"></td>
          <td class="vatop tips"><span class="vatop rowform"></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['circle_is_use'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
            <label for="mlref_status1" class="cb-enable selected" ><span><?php echo $lang['open'];?></span></label>
            <label for="mlref_status0" class="cb-disable" ><span><?php echo $lang['close'];?></span></label>
            <input id="mlref_status1" name="mlref_status" checked="checked" value="1" type="radio">
            <input id="mlref_status0" name="mlref_status" value="0" type="radio"></td>
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
        <?php for($i=1;$i<=8;$i++){?>
        <tr>
          <td><?php echo $i;?></td>
          <td><input type="text" name="mlref_<?php echo $i;?>" /></td>
          <td><?php echo $i+8;?></td>
          <td><input type="text" name="mlref_<?php echo $i+8;?>" /></td>
        </tr>
        <?php }?>
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
	    if($("#clmdAddForm").valid()){
	    	$("#clmdAddForm").submit();
		}
	});
	$("#clmdAddForm").validate({
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