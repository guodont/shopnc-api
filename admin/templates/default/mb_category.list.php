<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['link_index_mb_category'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=mb_category&op=mb_category_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['link_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_link">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th>&nbsp;</th>
          <th><?php echo $lang['link_index_title'];?></th>
          <th><?php echo $lang['link_index_pic_sign'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['link_list']) && is_array($output['link_list'])){ ?>
        <?php foreach($output['link_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" name="del_id[]" value="<?php echo $v['gc_id'];?>" class="checkitem"></td>
          <td><?php echo $output['goods_class'][$v['gc_id']]['gc_name'];?></td>
          <td class="picture"><?php
				if($v['gc_thumb'] != ''){
					echo "<div class='size-88x31'><span class='thumb size-88x31'><i></i><img width=\"88\" height=\"31\" src='".$v['gc_thumb']."' onload='javascript:DrawImage(this,88,31);' /></span></div>";
				}
				?></td>
          <td class="w96 align-center"><a href="index.php?act=mb_category&op=mb_category_edit&gc_id=<?php echo $v['gc_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>'))window.location = 'index.php?act=mb_category&op=mb_category_del&gc_id=<?php echo $v['gc_id'];?>';"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['link_list']) && is_array($output['link_list'])){ ?>
        <tr class="tfoot" id="dataFuncs">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16" id="batchAction"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp; <a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#form_link').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
