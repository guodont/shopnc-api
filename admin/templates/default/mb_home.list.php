<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>首页设置</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
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
            <li><?php echo $lang['home_help1'];?></li>
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
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['home_index_title'];?></th>
          <th><?php echo $lang['home_index_desc'];?></th>
          <th>类型</th>
          <th><?php echo $lang['home_index_keyword'];?></th>
          <th>多关键词</th>
          <th><?php echo $lang['home_index_pic_sign'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['h_list']) && is_array($output['h_list'])){ ?>
        <?php foreach($output['h_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td class="w24"></td>
          <td class="w48 sort"><span class="tooltip editable" title="<?php echo $lang['nc_editable'];?>" ajax_branch='h_sort' datatype="number" fieldid="<?php echo $v['h_id'];?>" fieldname="h_sort" nc_type="inline_edit"><?php echo $v['h_sort'];?></span></td>
          <td><?php echo $v['h_title'];?></td>
          <td><?php echo $v['h_desc'];?></td>
          <td><?php echo $v['h_type'];?></td>
          <td><?php echo $v['h_keyword'];?></td>
          <td><?php echo $v['h_multi_keyword'];?></td>
          <td class="picture"><?php 
				if($v['h_img'] != ''){
					echo "<div class='size-32x32'><span class='thumb size-32x32'><i></i><img width=\"32\" height=\"32\" src='".$v['h_img_url']."' /></span></div>";
				}
				?></td>
          <td class="w96 align-center"><a href="index.php?act=mb_home&op=mb_home_edit&h_id=<?php echo $v['h_id'];?>"><?php echo $lang['nc_edit'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot" id="dataFuncs">
          <td colspan="16"></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
