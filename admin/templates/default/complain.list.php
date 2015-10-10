<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['complain_manage_title'];?></h3>
      <ul class="tab-base">
        <?php foreach($output['menu'] as $menu) { if($menu['menu_type'] == 'text') { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php } else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php } } ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="search_form" method="get" name="formSearch">
    <input type="hidden" id="act" name="act" value="complain" />
    <input type="hidden" id="op" name="op" value="<?php echo $output['op'];?>" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="input_complain_accuser"><?php echo $lang['complain_accuser'];?></label></th>
          <td><input class="txt" type="text" name="input_complain_accuser" id="input_complain_accuser" value="<?php echo $_GET['input_complain_accuser'];?>"></td>
          <th><label for="input_complain_subject_content"><?php echo $lang['complain_subject_content'];?></label></th>
          <td colspan="2"><input class="txt2" type="text" name="input_complain_subject_content" id="input_complain_subject_content" value="<?php echo $_GET['input_complain_subject_content'];?>"></td>
        </tr>
        <tr>
          <th><label for="input_complain_accused"><?php echo $lang['complain_accused'];?></label></th>
          <td><input class="txt" type="text" name="input_complain_accused" id="input_complain_accused" value="<?php echo $_GET['input_complain_accused'];?>"></td>
          <th><label for="time_from"><?php echo $lang['complain_datetime'];?></label></th>
          <td><input id="time_from" class="txt date" type="text" name="input_complain_datetime_start" value="<?php echo $_GET['input_complain_datetime_start'];?>">
            <label for="time_to">~</label>
            <input id="time_to" class="txt date" type="text" name="input_complain_datetime_end" value="<?php echo $_GET['input_complain_datetime_end'];?>"></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if(!(empty($_GET['input_complain_accuser'])&&empty($_GET['input_complain_accused'])&&empty($_GET['input_complain_subject_content'])&&empty($_GET['input_complain_datetime_start'])&&empty($_GET['input_complain_datetime_end']))) { ?>
            <a class="btns " href="index.php?act=complain&op=<?php echo $output['op'];?>" title="<?php echo $lang['nc_cancel_search'];?>"><span><?php echo $lang['nc_cancel_search'];?></span></a>
            <?php }?></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['complain_help1'];?></li>
            <li><?php echo $lang['complain_help2'];?></li>
			<li><?php echo $lang['complain_help3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="list_form" action="index.php?act=voucher_price&op=voucher_price_drop">
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th class="w12">&nbsp;</th>
          <th><?php echo $lang['complain_accuser'];?></th>
          <th><?php echo $lang['complain_accused'];?></th>
          <th><?php echo $lang['complain_subject_content'];?></th>
          <th class="align-center"><?php echo $lang['complain_datetime'];?></th>
          <th class="w72 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $v){ ?>
        <tr class="hover">
          <td>&nbsp;</td>
          <td><?php echo $v['accuser_name'];?></td>
          <td><?php echo $v['accused_name'];?></td>
          <td><?php echo $v['complain_subject_content'];?></td>
          <td class="nowarp align-center"><?php echo date('Y-m-d H:i:s',$v['complain_datetime']);?></td>
          <td class="align-center"><a href="index.php?act=complain&op=complain_progress&complain_id=<?php echo $v['complain_id'];?>"><?php echo $lang['complain_text_detail'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr>
          <td colspan="15"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(document).ready(function(){
	//表格移动变色
	$("tbody .line").hover(
    function()
    {
        $(this).addClass("complain_highlight");
    },
    function()
    {
        $(this).removeClass("complain_highlight");
    });
    $('#time_from').datepicker({dateFormat: 'yy-mm-dd',onSelect:function(dateText,inst){
        var year2 = dateText.split('-') ;
        $('#time_to').datepicker( "option", "minDate", new Date(parseInt(year2[0]),parseInt(year2[1])-1,parseInt(year2[2])) );
    }});
    $('#time_to').datepicker({onSelect:function(dateText,inst){
        var year1 = dateText.split('-') ;
        $('#time_from').datepicker( "option", "maxDate", new Date(parseInt(year1[0]),parseInt(year1[1])-1,parseInt(year1[2])) );
    }});

});
</script> 
