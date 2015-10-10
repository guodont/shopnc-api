<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_domain_manage'];?></h3>
      <ul class="tab-base">
     	<li><a href="index.php?act=domain&op=store_domain_setting"><span><?php echo $lang['nc_config'];?></span></a></li>
      	<li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_domain_shop'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
  <input type="hidden" value="domain" name="act">
  <input type="hidden" value="store_domain_list" name="op">
  <table class="tb-type1 noborder search">
  <tbody>
    <tr>
      <th><label for="store_name"><?php echo $lang['store_name'];?></label></th>
      <td><input type="text" value="<?php echo $_GET['store_name'];?>" name="store_name" id="store_name" class="txt"></td>
      <th><label for="owner_and_name"><?php echo $lang['store_domain'];?></label></th>
      <td><input type="text" value="<?php echo $_GET['store_domain'];?>" name="store_domain" id="store_domain" class="txt"></td>
      <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
    </tr></tbody>
  </table>
  </form>
  <form method="post" id="store_form">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th class="align-center"><?php echo $lang['store_domain'];?></th>
          <th class="align-center"><?php echo $lang['store_name'];?></th>
          <th class="align-center"><?php echo $lang['store_domain_times'];?></th>
          <th class="align-center"><?php echo $lang['store_user_name'];?></th>
          <th class="align-center"><?php echo $lang['operation'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['store_list']) && is_array($output['store_list'])){ ?>
        <?php foreach($output['store_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td></td>
          <td class="align-center"><?php echo $v['store_domain'];?></td>
          <td class="align-center"><?php echo $v['store_name'];?>&nbsp;</td>
          <td class="align-center"><?php echo $v['store_domain_times'];?></td>
          <td class="align-center"><?php echo $v['member_name'];?></td>
          <td class="w150 align-center"><a href="index.php?act=domain&op=store_domain_edit&store_id=<?php echo $v['store_id']?>"><?php echo $lang['nc_edit'];?></a>
			 		</td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="16">
            <div class="pagination"><?php echo $output['page'];?></div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
