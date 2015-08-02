<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--//zmr>v50-->
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=store&op=store" ><span><?php echo $lang['manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['pending'];?></span></a></li>
        <li><a href="index.php?act=store&op=reopen_list" ><span>续签申请</span></a></li>
        <li><a href="index.php?act=store&op=store_bind_class_applay_list" ><span>经营类目申请</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" value="store" name="act">
    <input type="hidden" value="store_joinin" name="op">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="store_name"><?php echo $lang['store_name'];?></label></th>
          <td><input type="text" value="" name="store_name" id="store_name" class="txt"></td>
          <th><label for="owner_and_name"><?php echo $lang['store_user'];?></label></th>
          <td><input type="text" value="" name="owner_and_name" id="owner_and_name" class="txt"></td>
          <th><label><?php echo $lang['belongs_level'];?></label></th>
          <td><select name="grade_id">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['grade_list']) && is_array($output['grade_list'])){ ?>
              <?php foreach($output['grade_list'] as $k => $v){ ?>
              <option value="<?php echo $v['sg_id'];?>" <?php if($v['sg_id']==$_GET['grade_id']) { echo 'selected'; }?>><?php echo $v['sg_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
            <td>
                <select name="joinin_state">
                    <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
                    <?php if(!empty($output['joinin_state_array']) && is_array($output['joinin_state_array'])){ ?>
                    <?php foreach($output['joinin_state_array'] as $k => $v){ ?>
                    <option value="<?php echo $k;?>" <?php if($k==$_GET['joinin_state']) { echo 'selected'; }?>><?php echo $v;?></option>
                    <?php } ?>
                    <?php } ?>
                </select>
            </td>
            <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
                <?php if($output['owner_and_name'] != '' or $output['store_name'] != '' or $output['grade_id'] != ''){?>
                <a href="index.php?act=store&op=store_joinin" class="btns " title="<?php echo $lang['nc_cancel_search'];?>"><span><?php echo $lang['nc_cancel_search'];?></span></a>
                <?php }?></td>
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
      <tr>
        <td><ul>
            <li>点击审核按钮可以对开店申请进行审核，点击查看按钮可以查看开店信息</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="store_form" name="store_form">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="type" id="type" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th><?php echo $lang['store_name'];?></th>
          <th><?php echo $lang['store_user_name'];?></th>
          <th><?php echo $lang['location'];?></th>
          <th class="align-center"><?php echo $lang['belongs_level'];?></th>
          <th class="align-center"><?php echo $lang['state'];?></th>
          <th class="align-center"><?php echo $lang['operation'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['store_list']) && is_array($output['store_list'])){ ?>
        <?php foreach($output['store_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td><?php echo $v['store_name'];?></td>
          <td><?php echo $v['member_name'];?></td>
          <td class="w150"><?php echo $v['company_address'];?></td>
          <td class="align-center"><?php echo $v['sg_name'];?></td>
          <td class="align-center"><?php echo $output['joinin_state_array'][$v['joinin_state']];?></td>
          <td class="w72 align-center">
              <?php if(in_array(intval($v['joinin_state']), array(STORE_JOIN_STATE_NEW, STORE_JOIN_STATE_PAY))) { ?>
              <a href="index.php?act=store&op=store_joinin_detail&member_id=<?php echo $v['member_id'];?>">审核</a>
              <?php } else { ?>
              <a href="index.php?act=store&op=store_joinin_detail&member_id=<?php echo $v['member_id'];?>">查看</a>
              <?php } ?>
               <?php if(intval($v['joinin_state'])<40) { ?>
              &nbsp;&nbsp; <a href="index.php?act=store&op=del_join&id=<?php echo $v['member_id']?>">删除</a>
               <?php } ?>
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
        <tr class="tfoot">
          <td></td>
          <td colspan="15">
              <?php if(!empty($output['store_list']) && is_array($output['store_list'])){ ?>
              <div class="pagination"><?php echo $output['page'];?></div>
              <?php } ?>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script>
function audit_submit(type){
	$('#type').val(type);
	$("#store_form").submit();
	return true;
}
</script>
