<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_circle_informnamage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="circle_inform">
    <input type="hidden" name="op" value="inform_list">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="searchtitle"><?php echo $lang['circle_informer'];?></label></th>
          <td><input type="text" name="searchname" id="searchname" class="txt" value='<?php echo $_GET['searchname'];?>'></td>
          <th><label for="circlename"><?php echo $lang['circle_name'];?></label></th>
          <td><input type="text" name="circlename" id="circlename" class="txt" value="<?php echo $_GET['circlename'];?>" /></td>
          <th><label><?php echo $lang['nc_status'];?></label></th>
          <td>
            <select name="searchstate">
              <option value=""><?php echo $lang['nc_common_pselect'];?></option>
              <option value="1" <?php echo $_GET['searchstate'] == '1'?'selected':'';?>><?php echo $lang['circle_inform_treated'];?></option>
              <option value="0" <?php echo $_GET['searchstate'] == '0'?'selected':'';?>><?php echo $lang['circle_inform_untreated'];?></option>
            </select>
          </td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query']; ?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method="post" id="inform_form" name="inform_form">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th class="tl"><?php echo $lang['circle_inform_info'];?></th>
          <th class="w120"><?php echo $lang['circle_come_from'];?></th>
          <th class="w210"><?php echo $lang['circle_handel_state'];?></th>
          <th class="w120"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['inform_list'])){?>
        <?php foreach ($output['inform_list'] as $val){?>
        <tr>
          <td><input type="checkbox" class="checkitem" name="i_id[]" value="<?php echo $val['inform_id'];?>" /></td>
          <td class="tl">
            <p><b><?php echo $lang['circle_inform_url'].$lang['nc_colon'];?></b><a href="<?php echo CIRCLE_SITE_URL.DS.$val['url'];?>" target="_blank"><?php echo $val['title'];?></a></p>
            <p><b><?php echo $lang['circle_inform_content'].$lang['nc_colon'];?></b><?php echo $val['inform_content'];?></p>
          </td>
          <td><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>" target="_blank"><?php echo $val['circle_name'];?></a></td>
          <td>
            <p><?php echo $lang['circle_handel_state'].$lang['nc_colon'].$val['state'];?></p>
            <?php if($val['inform_state'] != 0){?>
            <p><?php echo $lang['circle_handler'].$lang['nc_colon'].$val['inform_opname'];?></p>
            <p><?php echo $lang['circle_rewards'].$lang['nc_colon']; if($val['inform_opexp'] == '0'){ echo $lang['circle_not_rewards'];}else{ echo $val['inform_opexp'].$lang['circle_inform_exp'];}?></p>
            <p><?php echo $lang['circle_message'].$lang['nc_colon'].$val['inform_opresult'];?></p>
            <?php }?>
          </td>
          <td class="handle">
            <a href="javascript:void(0);" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=circle_inform&op=inform_del&i_id=<?php echo $val['inform_id'];?>'}"><?php echo $lang['nc_del'];?></a>
          </td>
        </tr>
        <?php }?>
        <?php }else{?>
        <tr>
          <td colspan="20" class="noborder"><p class="no-record"><?php echo $lang['no_record'];?></p></td>
        </tr>
        <?php }?>
      </tbody>
      <?php if(!empty($output['inform_list'])){ ?>
      <tfoot class="tfoot">
        <tr>
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del']?>')){$('#inform_form').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>