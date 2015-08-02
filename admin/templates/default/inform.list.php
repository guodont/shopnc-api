<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['inform_manage_title'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="search_form" method="get" name="formSearch">
    <input type="hidden" id="act" name="act" value="inform" />
    <input type="hidden" id="op" name="op" value="inform_list" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th> <label for="input_inform_goods_name"><?php echo $lang['inform_goods_name'];?></label></th>
          <td><input class="txt" type="text" name="input_inform_goods_name" id="input_inform_goods_name" value="<?php echo $_GET['input_inform_goods_name'];?>"></td>
          <th><label for="input_inform_type"><?php echo $lang['inform_type'];?></label></th>
          <td colspan="2"><input class="txt" type="text" name="input_inform_type" id="input_inform_type" value="<?php echo $_GET['input_inform_type'];?>"  style=" width:100px;">
            <label for="input_inform_member_name"><?php echo $lang['inform_member_name'];?></label>
            <input class="txt" type="text" name="input_inform_member_name" id="input_inform_member_name" value="<?php echo $_GET['input_inform_member_name'];?>" style=" width:100px;"></td>
        </tr>
        <tr>
          <th><label for="input_inform_subject"><?php echo $lang['inform_subject'];?></label></th>
          <td><input class="txt" type="text" name="input_inform_subject" id="input_inform_subject" value="<?php echo $_GET['input_inform_subject'];?>"></td>
          <th><label for="time_from"><?php echo $lang['inform_datetime'];?></label></th>
          <td><input id="time_from" class="txt date" type="text" name="input_inform_datetime_start" value="<?php echo $_GET['input_inform_datetime_start'];?>">
            <label for="time_to">~</label>
            <input id="time_to" class="txt date" type="text" name="input_inform_datetime_end" value="<?php echo $_GET['input_inform_datetime_end'];?>"></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if(!(empty($_GET['input_inform_goods_name'])&&empty($_GET['input_inform_member_name'])&&empty($_GET['input_inform_type'])&&empty($_GET['input_inform_subject'])&&empty($_GET['input_inform_datetime_start'])&&empty($_GET['input_inform_datetime_end']))) { ?>
            <a href="index.php?act=inform&op=inform_list" class="btns " title="<?php echo $lang['nc_cancel_search'];?>"><span><?php echo $lang['nc_cancel_search'];?></span></a>
            <?php } ?></td>
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
            <li><?php echo $lang['inform_help1'];?></li>
            <li><?php echo $lang['inform_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="list_form" action="index.php?act=voucher_price&op=voucher_price_drop">
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th><?php echo $lang['inform_goods_name'];?></th>
          <th><?php echo $lang['inform_member_name'];?></th>
          <th><?php echo $lang['inform_type'];?></th>
          <th><?php echo $lang['inform_subject'];?></th>
          <th><?php echo $lang['inform_pic'];?></th>
          <th><?php echo $lang['inform_datetime'];?></th>
          <th><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $v){ ?>
        <tr class="line">
          <td><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$v['inform_goods_id']));?>" target="_blank"><?php echo $v['inform_goods_name'];?></a></td>
          <td><span><?php echo $v['inform_member_name'];?></span></td>
          <td><span><?php echo $v['inform_subject_type_name'];?></span></td>
          <td><span><?php echo $v['inform_subject_content'];?></span></td>
          <td><?php 
                        if(empty($v['inform_pic1'])&&empty($v['inform_pic2'])&&empty($v['inform_pic3'])) {
                            echo $lang['inform_pic_none'];
                        }
                        else {
                            $pic_link = 'index.php?act=show_pics&type=inform&pics=';
                            if(!empty($v['inform_pic1'])) {
                                $pic_link .= $v['inform_pic1'].'|';
                            }
                            if(!empty($v['inform_pic2'])) {
                                $pic_link .= $v['inform_pic2'].'|';
                            }
                            if(!empty($v['inform_pic3'])) {
                                $pic_link .= $v['inform_pic3'].'|';
                            }
                            $pic_link = rtrim($pic_link,'|'); 
                    ?>
            <a href="<?php echo $pic_link;?>" target="_blank"><?php echo $lang['inform_pic_view'];?></a>
            <?php } ?></td>
          <td><span><?php echo date('Y-m-d',$v['inform_datetime']);?></span></td>
          <td><a href="JavaScript:void(0);" class="show_detail"><?php echo $lang['nc_detail'];?></a> <a href="index.php?act=inform&op=show_handle_page&inform_id=<?php echo $v['inform_id'];?>&inform_goods_name=<?php echo $v['inform_goods_name'];?>"><?php echo $lang['inform_text_handle'];?></a></td>
        </tr>
        <tr class="inform_detail">
          <td colspan="15"><div class="shadow2">
              <div class="content">
                <dl>
                  <dt><?php echo $lang['inform_content'];?></dt>
                  <dd><?php echo $v['inform_content'];?></dd>
                </dl>
                <div class="close_detail"><a href="JavaScript:void(0);" title="<?php echo $lang['nc_close'];?>"><?php echo $lang['nc_close'];?></a></div>
              </div>
            </div></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="7"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <tr class="tfoot">
          <td  colspan="15"><div class="pagination"><?php echo $output['show_page'];?></div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"/>
<script type="text/javascript">
$(document).ready(function(){
	//表格移动变色
    $(".inform_detail").hide();
    $(".show_detail").click(function(){
        $(".inform_detail").hide();
        $(this).parents("tr").next(".inform_detail").show();
    });
    $(".close_detail").click(function(){
        $(this).parents(".inform_detail").hide();
    });

	$("tbody .line").hover(
    function()
    {
        $(this).addClass("inform_highlight");
    },
    function()
    {
        $(this).removeClass("inform_highlight");
    });
    $('#time_from').datepicker({onSelect:function(dateText,inst){
        var year2 = dateText.split('-') ;
        $('#time_to').datepicker( "option", "minDate", new Date(parseInt(year2[0]),parseInt(year2[1])-1,parseInt(year2[2])) );
    }});
    $('#time_to').datepicker({onSelect:function(dateText,inst){
        var year1 = dateText.split('-') ;
        $('#time_from').datepicker( "option", "maxDate", new Date(parseInt(year1[0]),parseInt(year1[1])-1,parseInt(year1[2])) );
    }});
});
</script> 
