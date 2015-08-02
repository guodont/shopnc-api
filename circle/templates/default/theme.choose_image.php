<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="choose-image">
  <ul class="tabs-nav">
    <li <?php if($_GET['curpage'] == ''){?>class="tabs-selected"<?php }?>><a href="javascript:void(0)"><?php echo $lang['circle_network_image'];?></a></li>
    <?php if($_GET['type'] != 'm'){?><li <?php if($_GET['curpage'] != ''){?>class="tabs-selected"<?php }?>><a href="javascript:void(0)"><?php echo $lang['circle_album_image'];?></a></li><?php }?>
  </ul>
  <div class="url-image tabs-panel <?php if($_GET['curpage'] != ''){?>tabs-hide<?php }?>">
    <label><i></i><?php echo $lang['circle_insert_image_url'];?></label>
    <input name="" type="text" class="text w400" nctype="imageurl" />
    <div class="handle-bar" style="padding-left:0px;"><a href="Javascript: void(0)" class="button" nctype="imageurl"><?php echo $lang['circle_insert_theme'];?></a></div>
  </div>
  <div class="goods-gallery tabs-panel <?php if($_GET['curpage'] == ''){?>tabs-hide<?php }?>">
    <div class="nav"><i></i><?php echo $lang['circle_select_image_from_album'];?>
      <select name="jumpMenu" id="jumpMenu" style="width:100px;">
        <option value="0" style="width:80px;"><?php echo $lang['nc_common_pselect'];?></option>
        <?php if(!empty($output['class_list'])){?>
        <?php foreach($output['class_list'] as $val) { ?>
        <option style="width:80px;" value="<?php echo $val['ac_id']; ?>" <?php if($val['ac_id']==$_GET['class_id']){echo 'selected="selected"';}?>><?php echo $val['ac_name']; ?></option>
        <?php } ?>
        <?php }?>
      </select>
    </div>
    <ul class="list">
      <?php if(!empty($output['pic_list'])){?>
      <?php foreach ($output['pic_list'] as $v){?>
      <li><a href="javascript:void(0);" nctype="chooseimage" data-param="{'img':'<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$_SESSION['member_id'].DS.$v['ap_cover'];?>'}"><img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$_SESSION['member_id'].DS.str_ireplace('.', '_240.', $v['ap_cover']);?>" title='<?php echo $v['ap_name']?>'/>
      <p class="extra"><?php echo $lang['circle_selected'];?></p>
      </a></li>
      <?php }?>
      <?php }else{?>
      <span><?php echo $lang['circle_upload_image_null'];?></span>
      <?php }?>
    </ul>
    <div class="ubb-pagination"><?php echo $output['show_page']; ?></div>
    <div class="handle-bar" style="padding-left:0px;"><a href="Javascript: void(0)" class="button" nctype="imagealbum"><?php echo $lang['circle_insert_theme'];?></a></div>
  </div>
</div>
<script>
var c_id = <?php echo $output['c_id'];?>;
$(function() {
	$(".tabs-nav > li > a").mousedown(function(e) {
		if (e.target == this) {
			var tabs = $(this).parent().parent().children("li");
			var panels = $(this).parent().parent().parent().children(".tabs-panel");
			var index = $.inArray(this, $(this).parent().parent().find("a"));
			if (panels.eq(index)[0]) {
				tabs.removeClass("tabs-selected")
					.eq(index).addClass("tabs-selected");
				panels.addClass("tabs-hide")
					.eq(index).removeClass("tabs-hide");
			}
		}
	});
	// 翻页跳转
	$('.choose-image').find('a[class="demo"]').click(function(){
		DialogManager.close('uploadimage');
		var _uri = $(this).attr('href');
		CUR_DIALOG = ajax_form("uploadimage", '<?php echo $lang['circle_select_image'];?>', _uri, 480);
		return false;
	});
	// 选择分类跳转
	$('#jumpMenu').change(function(){
		DialogManager.close('uploadimage');
	    var _uri = CIRCLE_SITE_URL + '/index.php?act=theme&op=choose_image&curpage=1&c_id='+c_id+'&class_id='+$(this).val();
		CUR_DIALOG = ajax_form("uploadimage", '<?php echo $lang['circle_select_image'];?>', _uri, 480);
	});
	// 选择相册图片
	$('.choose-image').find('a[nctype="chooseimage"]').click(function(){
		$('.choose-image').find('a[nctype="chooseimage"]').removeClass('selected');	// 移除分类
		$(this).addClass('selected');	// 添加分类
	});
});
</script>