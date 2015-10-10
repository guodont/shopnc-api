<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="addshare">
<div class="goods-pic"><span class="thumb size120"><i></i><img src="<?php echo cthumb($output['sharegoods_info']['snsgoods_goodsimage'], 240,$output['sharegoods_info']['snsgoods_storeid']);?>"/></span></div>
  <ul id="goods_images">
    <?php for($i=0;$i<5;$i++){?>
    <li nc_type="handle_pic" data-param="{'apid':'<?php echo isset($output['pic_list'][$i])?$output['pic_list'][$i]['ap_id']:0;?>'}" >
      <div class="picture"><span class="thumb size60"><i></i> <img src="<?php echo isset($output['pic_list'][$i])?$output['pic_list'][$i]['ap_cover']:UPLOAD_SITE_URL.DS.defaultGoodsImage(60);?>" onload="javascript:DrawImage(this,60,60);"/> </span></div>
      <div class="bg" nc_type="handler" style="display:none;"><span class="delete" title="<?php echo $lang['nc_delete'];?>" nctype="drop_image"><?php echo $lang['nc_delete'];?></span></div>
      <div class="upload-btn"><a href="javascript:void(0);"><span style="width: 66px; height: 28px; position: absolute; left: 0; top: 0; z-index: 999; cursor:pointer; ">
        <input type="file" id="file<?php echo $i;?>" name="file<?php echo $i;?>" style="width: 66px; height: 28px; cursor: pointer; opacity:0; filter: alpha(opacity=0)" size="1" hidefocus="true">
        </span>
        <div class="upload-button"><?php echo $lang['sns_upload'];?></div>
        <input id="submit_button" style="display:none" type="button" value="<?php echo $lang['nc_submit'];?>" onClick="submit_form($(this))">
        </a></div>
    </li>
    <?php }?>
  </ul>
  <div class="sns-skin-button"> <a class="save" onclick="DialogManager.close('add_share');location.reload();" href="javascript:void(0);"><?php echo $lang['sns_complete'];?></a> </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js" charset="utf-8"></script> 
<script type="text/javascript">
$(function(){
	img_handle();
	$('#goods_images').find('input[type="file"]').change(function(){
		ajaxFileUpload($(this).attr('id'));
	});

	$('span[nctype="drop_image"]').click(function(){
		var p_li = $(this).parents('li:first');
		var data_str; eval( "data_str = "+p_li.attr('data-param'));
		$.getJSON('index.php?act=member_snshome&op=del_sharepic', {apid:data_str.apid}, function(data){
			if(data.type == 'false'){
				alert('<?php echo $lang['wrong_argument'];?>');
			}else{
				p_li.attr("data-param","{'apid':'0'}");
				p_li.find('img:first').attr('src','<?php echo UPLOAD_SITE_URL.DS.defaultGoodsImage(60)?>');
				p_li.find('*[nc_type="handler"]').hide().css('z-index', '0');
				img_handle();
			}
		});
	});
});

function img_handle(){
    $('*[nc_type="handle_pic"]').each(function(){
    	$(this).unbind();
    	if($(this).find('img:first').attr('src') != '<?php echo UPLOAD_SITE_URL.DS.defaultGoodsImage(60);?>'){
    		$(this).hover(function(){
    			var obj = $(this).find('img:first');
    			handler = $(this).find('*[nc_type="handler"]');
    			handler.show();
    			handler.hover(function(){
    				set_zindex($(this), "999");
    			},
    			function(){
    				set_zindex($(this), "0");
    			});
    			set_zindex($(this), '999');
    		},
    		function(){
    			handler.hide();
    			set_zindex($(this), '0');
    		});
    	}
    });
}

// 上传图片js
function ajaxFileUpload(id){
	var img_path = '<?php echo UPLOAD_SITE_URL.'/'.ATTACH_MALBUM.'/'.$_SESSION['member_id'].'/'?>';
	var loading_img = SHOP_TEMPLATES_URL+'/images/loading.gif';
	var data_str; eval( "data_str = "+$('#'+id).parents('li:first').attr('data-param'));
	var img = $('#'+id).parents('li:first').find('img');
	var default_img = img.attr('src');
	
	// loading
	img.attr('src', loading_img);
	$.ajaxFileUpload
	({
		url:SITEURL + '/index.php?act=member_snshome&op=image_upload',
		secureuri:false,
		fileElementId:id,
		dataType: 'json',
		data:{sid:<?php echo $output['sid'];?>, id:id, apid:data_str.apid},
		success: function (data, status)
		{
			img.removeAttr('width').removeAttr('height');
			if(typeof(data.error) != 'undefined')
			{
				alert(data.error);
				img.attr('src', img_path + default_img);
			}else{
				img.attr('src', img_path + data.file_name + '?' + Math.random());
				$('#'+id).parents('li:first').attr("data-param","{'apid':'"+ data.file_id +"'}");
			}
		},
		error: function (data, status, e)
		{
			alert(e);
			img.attr('src', default_img);
		}
	});
	img_handle();
	$('#'+id).unbind().change(function(){
		ajaxFileUpload(id);
	});
}
</script>