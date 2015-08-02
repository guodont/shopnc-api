<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_circle_thememanage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['circle_theme_list'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="circle_theme">
    <input type="hidden" name="op" value="theme_list">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="searchname"><?php echo $lang['circle_theme_name'];?></label></th>
          <td><input type="text" name="searchname" id="searchname" class="txt" value='<?php echo $_GET['searchname'];?>'></td>
          <th><label for="classname"><?php echo $lang['circle_name'];?></label></th>
          <td><input type="text" name="circlename" id="circlename" class="txt" value="<?php echo $_GET['circlename'];?>" /></td>
          <th><label><?php echo $lang['circle_top'];?></label></th>
          <td><select name="searchtop">
              <option value=""><?php echo $lang['nc_common_pselect'];?></option>
              <option value="1" <?php if ($_GET['searchtop'] == '1'){echo 'selected=selected';}?>><?php echo $lang['nc_yes'];?></option>
              <option value="0" <?php if ($_GET['searchtop'] == '0'){echo 'selected=selected';}?>><?php echo $lang['nc_no'];?></option>
            </select>
          </td>
          <th><label><?php echo $lang['circle_cream'];?></label></th>
          <td><select name="searchcream">
              <option value=""><?php echo $lang['nc_common_pselect'];?></option>
              <option value="1" <?php if ($_GET['searchcream'] == '1'){echo 'selected=selected';}?>><?php echo $lang['nc_yes'];?></option>
              <option value="0" <?php if ($_GET['searchcream'] == '0'){echo 'selected=selected';}?>><?php echo $lang['nc_no'];?></option>
            </select>
          </td>
          <th><label><?php echo $lang['nc_recommend'];?></label></th>
          <td><select name="searchrecommend">
              <option value=""><?php echo $lang['nc_common_pselect'];?></option>
              <option value="1" <?php if ($_GET['searchrecommend'] == '1'){echo 'selected=selected';}?>><?php echo $lang['nc_yes'];?></option>
              <option value="0" <?php if ($_GET['searchrecommend'] == '0'){echo 'selected=selected';}?>><?php echo $lang['nc_no'];?></option>
            </select>
          </td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query']; ?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
   <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
          <ul>
            <li><?php echo $lang['circle_theme_prompts_one'];?></li>
            <li><?php echo $lang['circle_theme_prompts_two'];?></li>
            <li><?php echo $lang['circle_theme_prompts_three'];?></li>
          </ul>
        </td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="list_form" name="list_form">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="submit_type" id="submit_type" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th><th></th>
          <th><?php echo $lang['circle_theme_name'];?></th>
          <th class="align-center"><?php echo $lang['circle_reply'];?></th>
          <th class="align-center"><?php echo $lang['circle_top'];?></th>
          <th class="align-center"><?php echo $lang['circle_cream'];?></th>
          <th class="align-center"><?php echo $lang['circle_no_speak'];?></th>
          <th class="align-center"><?php echo $lang['nc_recommend'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['theme_list']) && is_array($output['theme_list'])){ ?>
        <?php foreach($output['theme_list'] as $val){ ?>
        <tr class="hover edit member">
          <td class="w24"><input type="checkbox" name="check_theme_id[]" value="<?php echo $val['theme_id'];?>" class="checkitem"></td>
          <td class="w48 picture"><?php if(isset($val['affix'])){?><span class="thumb size-44x44"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>" target="_blank"><img width="44" height="44"  src="<?php echo $val['affix'];?>" /></a></span><?php }?></td>
          <td class="">
            <p><strong><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>" target="_blank"><?php echo $val['theme_name'];?></a></strong></p>
            <p class="smallfont"><?php echo $lang['circle_belong_to_circle'];?><a target="_blank" href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>"><?php echo $val['circle_name'];?></a></p>
          </td>
          <td class="align-center w96"><?php echo $val['theme_commentcount'];?></td>
          <td class="align-center w96"><?php if($val['is_stick'] == 1){echo $lang['nc_yes'];}else{echo $lang['nc_no'];}?></td>
          <td class="align-center w96"><?php if($val['is_digest'] == 1){echo $lang['nc_yes'];}else{echo $lang['nc_no'];}?></td>
          <td class="align-center w96"><?php if($val['is_closed'] == 1){echo $lang['nc_yes'];}else{echo $lang['nc_no'];}?></td>
          <td class="align-center yes-onoff w96">
            <a href="JavaScript:void(0);" class=" <?php echo $val['is_recommend']? 'enabled':'disabled'?>" ajax_branch='recommend' nc_type="inline_edit" fieldname="is_recommend" fieldid="<?php echo $val['theme_id']?>" fieldvalue="<?php echo $val['is_recommend'];?>" title="<?php echo $val['is_recommend'] ? $lang['nc_yes'] : $lang['nc_no'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
          </td>
          <td class="w120"><a href="index.php?act=circle_theme&op=theme_info&t_id=<?php echo $val['theme_id'];?>"><?php echo $lang['nc_view'];?></a> | <a href="index.php?act=circle_theme&op=theme_reply&t_id=<?php echo $val['theme_id'];?>"><?php echo $lang['circle_reply'];?></a> | <a href="javascript:void(0);" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=circle_theme&op=theme_del&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>';}else{return false;}"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['theme_list']) && is_array($output['theme_list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_2"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#submit_type').val('batchdel');$('#list_form').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"><?php echo $output['page'];?></div>
            </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>  
