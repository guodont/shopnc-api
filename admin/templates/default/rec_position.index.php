<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['rec_position'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=rec_position&op=rec_add"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
  <input type="hidden" value="rec_position" name="act">
  <input type="hidden" value="rec_list" name="op">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><?php echo $lang['rec_ps_type'];?></th>
          <td><select name='pic_type'><option value=""><?php echo $lang['nc_please_choose'];?></option><option value="1"><?php echo $lang['rec_ps_pic'];?></option><option value="0"><?php echo $lang['rec_ps_txt'];?></option></select></td>
          <th><?php echo $lang['rec_ps_title'];?></th>
          <td><input type="text" value="" name="keywords" class="txt"></td>
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
      <tr><td><ul><li><?php echo $lang['rec_ps_help1'];?></li></ul></td></tr>
    </tbody>
  </table>
  <form method='post' id="form_rec"> 
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th>&nbsp;</th>
          <th><?php echo $lang['rec_ps_title'];?></th>
          <th><?php echo $lang['rec_ps_type'];?></th>
          <th><?php echo $lang['rec_ps_content'];?></th>
          <th><?php echo $lang['rec_ps_gourl'];?></th>
          <th><?php echo $lang['rec_ps_target'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" name="rec_id[]" value="<?php echo $v['rec_id'];?>" class="checkitem"></td>
          <td><?php echo $v['title'];?></td>
          <td><?php echo str_replace(array(0,1,2),array($lang['rec_ps_txt'],$lang['rec_ps_picb'],$lang['rec_ps_picy']),$v['pic_type']);?>
          <?php if ($v['pic_type'] != 0){echo count($v['content']['body']) == 1 ? $lang['rec_ps_picdan'] : $lang['rec_ps_picduo'];}?>
          </td>
          <td class="picture"><?php 
				if($v['pic_type'] == 0){
					echo $v['content']['body'][0]['title'];
				}else{
					echo "<a target='_blank' href='".$v['content']['body'][0]['title']."'><img height=\"31\" src='".$v['content']['body'][0]['title']."' /></a>";
				}
				?></td>
          <td><?php echo $v['content']['body'][0]['url'];?></td>
          <td><?php echo str_replace(array(1,2),array($lang['rec_ps_tg1'],$lang['rec_ps_tg2']),$v['content']['target']);?></td>
          <td class="w180 align-center"><a href="index.php?act=rec_position&op=rec_edit&rec_id=<?php echo $v['rec_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){return true;}else{return false;}" href="index.php?act=rec_position&op=rec_del&rec_id=<?php echo $v['rec_id'];?>"><?php echo $lang['nc_del'];?></a> | <a nctype="jscode" rec_id="<?php echo $v['rec_id'];?>" href="javascript:void(0)"><?php echo $lang['rec_ps_code']?></a> | <a target="_blank" href="index.php?act=rec_position&op=rec_view&rec_id=<?php echo $v['rec_id'];?>"><?php echo $lang['rec_ps_view'];?></a>
          </td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <tr class="tfoot" id="dataFuncs">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16" id="batchAction"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp; <a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#form_rec').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script>
$(function(){
	$('a[nctype="jscode"]').click(function(){
		copyToClipBoard($(this).attr('rec_id'));return ;		
	});

	function copyToClipBoard(id){
	    if(window.clipboardData)
	    { 
	        // the IE-manier
	        window.clipboardData.clearData();
	        window.clipboardData.setData("Text", "<\?php echo rec("+id+");?>");
	        alert("<?php echo $lang['rec_ps_clip_succ'];?>!");
	    }
	    else if(navigator.userAgent.indexOf("Opera") != -1)
	    {
	        window.location = "<\?php echo rec("+id+");?>";
	        alert("<?php echo $lang['rec_ps_clip_succ'];?>!");
	    }
	    else
	    {
	        ajax_form('copy_rec', '<?php echo $lang['rec_ps_code'];?>', 'index.php?act=rec_position&op=rec_code&rec_id='+id);
	    }
	}
});
</script>
