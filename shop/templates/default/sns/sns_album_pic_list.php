<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="sns-main-all">
  <div class="tabmenu">
    <?php include template('layout/submenu'); ?>
  </div>
  <div id="pictureFolder" class="album">
    <div class="intro">
      <div class="covers"><span class="thumb size60"><i></i>
        <?php if($output['class_info']['ac_cover'] != ''){ ?>
        <img id="aclass_cover" src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$output['master_id'].DS.$output['class_info']['ac_cover'];?>"  onerror="this.src='<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>'" onload="javascript:DrawImage(this,60,60);">
        <?php }else{?>
        <img id="aclass_cover" src="<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" onload="javascript:DrawImage(this,60,60);">
        <?php }?>
        </span></div>
      <dl>
        <dt><?php echo $output['class_info']['ac_name']?></dt>
        <dd><?php echo $output['class_info']['ac_des']?></dd>
      </dl>
      <?php if($output['relation'] == 3){?>
          <div class="button"><a id="open_uploader" href="JavaScript:void(0);" class="ncsc-btn ncsc-btn-acidblue "><i class="icon-cloud-upload"></i><?php echo $lang['sns_upload_more_pic'];?></a></div>
          <div class="upload-con" id="uploader" style="display: none;">
            <form method="post" action="" id="fileupload" enctype="multipart/form-data">
              <input type="hidden" name="category_id" value="<?php echo $output['class_info']['ac_id']?>">
              <div class="upload-con-div">
                <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
                  <input type="file" hidefocus="true" size="1" class="input-file" name="file" multiple="multiple"/>
                  </span>
                  <p>选择图片上传</p>
                  </a> </div>
              </div>
              <div nctype="file_msg"></div>
              <div class="upload-pmgressbar" nctype="file_loading"></div>
              <div class="upload-txt"><span><?php echo $lang['album_batch_upload_description'].$output['setting_config']['image_max_filesize'].'KB'.$lang['album_batch_upload_description_1'];?></span> </div>
            </form>
          </div>
      <?php }?>
    </div>
  </div>
  <?php if(is_array($output['pic_list']) && !empty($output['pic_list'])){?>
    <ul class="nc-sns-pinterest masoned mt20"  id="snsPinterest">
      	<?php $ii=0;?>
        <?php foreach($output['pic_list'] as $v){?>
        <?php
        	$curpage = intval($_GET['curpage']) ? intval($_GET['curpage']) : 1;
        	$ii++;
        ?>
      <li class="item">
        <?php if(is_array($output['pic_list']) && !empty($output['pic_list']) && $output['relation'] == 3){?>
        <ul class="handle">
          <li class="cover"><a href="JavaScript:void(0);" onclick="cover(<?php echo $v['ap_id'];?>)"><i></i><?php echo $lang['album_plist_set_to_cover'];?></a></li>
          <li class="delete"><a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['album_plist_delete_confirm_message'];?>','index.php?act=sns_album&op=album_pic_del&id=<?php echo $v['ap_id'];?>');"><i></i><?php echo $lang['nc_delete'];?></a></li>
        </ul>
        <?php }?>
        <dl>
          <dt class="goodspic"><span class="thumb size233"><i></i><a href="index.php?act=sns_album&op=album_pic_info&id=<?php echo $v['ap_id'];?>&class_id=<?php echo $v['ac_id']?>&mid=<?php echo $output['master_id'];?><?php if(!empty($_GET['sort'])){?>&sort=<?php echo $_GET['sort']; }?>&curpage=<?php echo ceil((36*($curpage-1)+$ii)/9);?>&start_index=<?php echo ($tmp = (36*($curpage-1)+$ii)%9) ? $tmp-1 :8;?>" title="<?php echo $v['ap_name']?>"> <img id="img_<?php echo $v['ap_id'];?>" src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$output['master_id'].DS.str_ireplace('.', '_240.', $v['ap_cover']);?>"></a></span> </dt>
          <dd> <span class="pinterest-addtime"><?php echo $lang['album_plist_upload_time'].$lang['nc_colon'].date("Y-m-d",$v['upload_time'])?></span><!--<span class="ops-comment"><a href="index.php?act=member_snshome&op=goodsinfo&type=like&mid=<?php echo $v['share_memberid'];?>&id=<?php echo $v['share_id'];?>" title="<?php echo $lang['sns_comment'];?>"><i></i></a><em><?php echo $v['share_commentcount'];?></em> </span>-->
          </dd>
        </dl>
      </li>
      <?php }?>
    </ul>
  <div class="clear" style="padding-top:20px;"></div>
  <div class="pagination"><?php echo $output['show_page']; ?></div>
  <div class="clear"></div>
  <?php }else{?>
  <?php if ($output['relation'] == 3){?>
  <div class="sns-norecord"><i class="pictures pngFix">&nbsp;</i><span><?php echo $lang['sns_no_pic_tips1'];?></span></div>
  <?php }else {?>
  <div class="sns-norecord"><i class="pictures pngFix">&nbsp;</i><span><?php echo $lang['sns_no_pic_tips2'];?></span></div>
  <?php }?>
  <?php }?>
  <script type="text/javascript">
function cover(id){
	if($('#aclass_cover').attr('src') != $('#img_'+id).attr('src')){
		ajaxget('index.php?act=sns_album&op=change_album_cover&id='+id);
	}else{
		showError('<?php echo $lang['album_plist_not_set_same_image'];?>');
	}
}
</script>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.masonry.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
	$("#snsPinterest").imagesLoaded( function(){
		$("#snsPinterest").masonry({
			itemSelector : '.item'
		});
	});
});
</script>
<?php if($output['relation'] == '3'){?>
<script type="text/javascript">
$(function(){
    // ajax 上传图片
    var upload_num = 0; // 上传图片成功数量
    $('#fileupload').fileupload({
        dataType: 'json',
        url: '<?php echo SHOP_SITE_URL;?>/index.php?act=sns_album&op=swfupload',
        add: function (e,data) {
            $.each(data.files, function (index, file) {
                $('<div nctype=' + file.name.replace(/\./g, '_') + '><p>'+ file.name +'</p><p class="loading"></p></div>').appendTo('div[nctype="file_loading"]');
            });
            data.submit();
        },
        done: function (e,data) {
            var param = data.result;
            $this = $('div[nctype="' + param.origin_file_name.replace(/\./g, '_') + '"]');
            $this.fadeOut(3000, function(){
                $(this).remove();
                if ($('div[nctype="file_loading"]').html() == '') {
                    setTimeout("window.location.reload()", 1000);
                }
            });
            if(param.state == 'true'){
                upload_num++;
                $('div[nctype="file_msg"]').html('<i class="icon-ok-sign">'+'</i>'+'<?php echo $lang['album_upload_complete_one'];?>'+upload_num+'<?php echo $lang['album_upload_complete_two'];?>');
            } else {
                $this.find('.loading').html(param.message).removeClass('loading');
            }
        }
    });
});
</script>
<?php }?>
