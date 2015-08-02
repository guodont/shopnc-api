<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['link_index_mb_ad'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=mb_ad&op=mb_ad_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
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
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th>&nbsp;</th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['link_index_title'];?></th>
          <th><?php echo $lang['link_index_pic_sign'];?></th>
          <th>关键词</th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['link_list']) && is_array($output['link_list'])){ ?>
        <?php foreach($output['link_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td class="w24"></td>
          <td class="w48 sort"><span class="tooltip editable" title="<?php echo $lang['nc_editable'];?>" ajax_branch='link_sort' datatype="number" fieldid="<?php echo $v['link_id'];?>" fieldname="link_sort" nc_type="inline_edit"><?php echo $v['link_sort'];?></span></td>
          <td><?php echo $v['link_title'];?></td>
          <td class="picture"><?php 
				if($v['link_pic'] != ''){
					echo "<div class='size-88x31'><span class='thumb size-88x31'><i></i><img width=\"88\" height=\"31\" src='".$v['link_pic_url']."' onload='javascript:DrawImage(this,88,31);' /></span></div>";
				}
				?></td>
          <td><?php echo $v['link_keyword'];?></td>
          <td class="w96 align-center"><a href="index.php?act=mb_ad&op=mb_ad_edit&link_id=<?php echo $v['link_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>'))window.location = 'index.php?act=mb_ad&op=mb_ad_del&link_id=<?php echo $v['link_id'];?>';"><?php echo $lang['nc_del'];?></a></td>
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
          <td></td>
          <td colspan="16" id="batchAction">
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
