<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="base-layout">
  <div class="mainbox">
    <?php include circle_template('group_manage_top');?>
    <form id="circle_level" name="circle_level" method="post" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage_level&op=level&c_id=<?php echo $output['c_id']; ?>">
    <input type="hidden" value="ok" name="form_submit">
    <table class="base-table-style">
      <thead>
        <tr>
          <th colspan="15" class="tl"> <ul class="level-set">
              <li>
                <input type="radio" name="levelset" nctype="levelset" <?php if($output['ml_info']['mlref_id'] === '0'){?>checked="checked"<?php }?> id="levelset0" checked="checked" value="0" data-param="<?php echo str_replace('"',"'",json_encode($output['mld_array']));?>" />
                <label for="levelset0"><?php echo $lang['circle_default_series'];?></label>
              </li>
              <?php if(!empty($output['mlr_array'])){?>
              <?php foreach ($output['mlr_array'] as $key=>$val){?>
              <li>
                <input type="radio" name="levelset" nctype="levelset" <?php if($output['ml_info']['mlref_id'] == $key){?>checked="checked"<?php }?> id="levelset<?php echo $key;?>" value="<?php echo $key;?>" data-param="<?php echo str_replace('"',"'",json_encode($val['info']));?>" />
                <label for="levelset<?php echo $key;?>"><?php echo $val['name'];?></label>
              </li>
              <?php }?>
              <?php }?>
              <li>
                <input type="radio" name="levelset" id="user-defined" <?php if(!empty($output['ml_info']) && $output['ml_info']['mlref_id'] == null){?>checked="checked" data-param="<?php echo str_replace('"',"'",json_encode($output['ml_info']['info']));?>"<?php }?> value="custom" />
                <label for="user-defined"><?php echo $lang['circle_custom'];?></label>
              </li>
            </ul>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="w100"><?php echo $lang['circle_level'];?></td>
          <td class="w100"><?php echo $lang['circle_exp'];?></td>
          <td><?php echo $lang['circle_rank'];?></td>
          <td class="w100"><?php echo $lang['circle_level'];?></td>
          <td class="w100"><?php echo $lang['circle_exp'];?></td>
          <td><?php echo $lang['circle_rank'];?></td>
        </tr>
        <?php if(!empty($output['mld_array'])){?>
        <?php for($i=1;$i<=8;$i++){?>
        <tr>
          <td><span class="member-level member-level-<?php echo $i;?>"><strong><?php echo $i;?></strong></span></td>
          <td><?php echo $output['mld_array'][$i]['exp'];?></td>
          <td nctype="mlname<?php echo $i;?>"><span class="member-level-name"><?php echo $output['mld_array'][$i]['name'];?></span></td>
          <td><span class="member-level member-level-<?php echo $i+8;?>"><strong><?php echo $i+8;?></strong></span></td>
          <td><?php echo $output['mld_array'][$i+8]['exp'];?></td>
          <td nctype="mlname<?php echo $i+8;?>"><span class="member-level-name"><?php echo $output['mld_array'][$i+8]['name'];?></span></td>
        </tr>
        <?php }?>
        <?php }?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="10" class="bottom tc"><a href="JavaScript:void(0);" class="submit-btn" nctype="submitBtn" style="display: inline-block; float: none; margin: 10px auto 20px auto;"><?php echo $lang['circle_submit_setting'];?></a></td>
        </tr>
      </tfoot>
    </table>
    </form>
  </div>
  <div class="sidebar">
    <?php include circle_template('group_manage_sidebar');?>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script> 
<script>
$(function(){
	// init
	var _this = $('.level-set').find('input:checked')
	$val = _this.val();
	if($val != 0 && $val != 'custom'){
		checkedLevel(_this);
	}else if($val == 'custom'){
		customLevel(_this);
	}

	// submit
	$('a[nctype="submitBtn"]').click(function(){
		ajaxpost('circle_level', '', '', 'onerror'); 
	});

	$('input[nctype="levelset"]').click(function(){
		checkedLevel($(this));
	});

	$('#user-defined').click(function(){
		customLevel($(this));
	});
});
function checkedLevel($this){
	var data_str = $this.attr('data-param'); eval(' data_str = '+data_str);
	for($i=1;$i<=16;$i++){
		$('td[nctype="mlname'+$i+'"]').html('<span class="member-level-name">'+data_str[$i].name+'</span>');
	}
}
function customLevel($this){
	var _sign = typeof($this.attr('data-param')) == 'undefined' ?　false : true ;
	if(_sign){
		var data_str = $this.attr('data-param'); eval(' data_str = '+data_str);
	}
	for($i=1;$i<=16;$i++){
		if(_sign){
			$('td[nctype="mlname'+$i+'"]').html('<input type="text" class="text w100" name="levelname['+$i+']" value="'+data_str[$i].name+'" maxlength="4" />');
		}else{
			$('td[nctype="mlname'+$i+'"]').html('<input type="text" class="text w100" name="levelname['+$i+']" maxlength="4" />');
		}
	}
}
</script>