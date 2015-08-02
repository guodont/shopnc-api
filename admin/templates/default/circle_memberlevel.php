<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['circle_memberlevel'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['circle_defaultlevel'];?></span></a></li>
        <li><a href="index.php?act=circle_memberlevel&op=ref"><span><?php echo $lang['circle_memberlevelref'];?></span></a></li>
        <li><a href="index.php?act=circle_memberlevel&op=ref_add"><span><?php echo $lang['circle_memberleveladd'];?></span></a></li>
        <li><a href="index.php?act=circle_memberlevel&op=update_cache"><span><?php echo $lang['nc_circle_cache'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li class="tips"><?php echo $lang['circle_memberlevelprompts'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="clmdForm" name="clmdForm">
    <input type="hidden" name="form_submit" value="ok" />          
    <table class="table tb-type2 nomargin">
        <thead>
          <tr class="thead">
            <th><?php echo $lang['circle_level'];?></th>
            <th><?php echo $lang['circle_medal'];?></th>
            <th class="w40pre"><?php echo $lang['circle_rank'];?></th>
            <th class="w40pre"><?php echo $lang['circle_experience_required'];?></th>
          </tr>
        </thead>
        <tbody>
          <?php for ($i=1;$i<=16;$i++){?>
          <tr>
            <td class="tc"><?php echo $i;?><input type="hidden" name="cmld[<?php echo $i;?>][id]" value="<?php echo $i;?>" /></td>
            <td class="circle-level"><span class="circle-level-<?php echo $i;?>"><strong><?php echo $i;?></strong></span></td>
            <td><input type="text" name="cmld[<?php echo $i;?>][name]" value="<?php echo $output['mld_list'][$i]['mld_name'];?>" /></td>
            <td><input type="text" name="cmld[<?php echo $i;?>][exp]" value="<?php echo $output['mld_list'][$i]['mld_exp'];?>" /></td>
          </tr>
          <?php }?>
        </tbody>
       
      <tfoot>
        <tr>
          <td colspan="10"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
 	</table>
 </form>
</div>
<script>
$(function(){
	$("#submitBtn").click(function(){
	    if($("#clmdForm").valid()){
	    	$("#clmdForm").submit();
		}
	});
	$("#clmdForm").validate({
        rules : {
            <?php for($i=1;$i<=16;$i++){?>
        	"cmld[<?php echo $i;?>][name]": {
        		required : true,
        		maxlength:4
        	},
        	"cmld[<?php echo $i;?>][exp]": {
        		required : true,
        		digits:4
        	}<?php if($i!=16){?>,<?php }?>
        	<?php }?>
        },
		messages : {
			<?php for($i=1;$i<=16;$i++){?>
        	"cmld[<?php echo $i;?>][name]": {
        		required : '<?php echo $lang['circle_rank_not_null'];?>',
        		maxlength: '<?php echo $lang['circle_rank_maxlength'];?>'
        	},
        	"cmld[<?php echo $i;?>][exp]": {
        		required : '<?php echo $lang['circle_experience_error'];?>',
        		digits: '<?php echo $lang['circle_experience_error'];?>'
        	}<?php if($i!=16){?>,<?php }?>
        	<?php }?>
		}
	});
});
</script>