<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
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
<script type="text/javascript">
$(function(){
    /*鼠标触及li显示dd内的控制按钮*/
    $('.album').children('li').bind('mouseenter',function(){
        $('.album').children('li').attr('class','hidden');
        $(this).attr('class','show');
    });
    $('.album').children('li').bind('mouseleave',function(){
        $('.album').children('li').attr('class','hidden');
    });
    $("#img_sort").change(function(){
        $('#select_sort').submit();
    });
});
</script>
<div class="sns-main-all">
  <div class="tabmenu">
    <?php include template('layout/submenu'); ?>
  </div>
  <div id="pictureIndex" class="picture-index">
    <?php if($output['relation'] == '3'){?>
    <div class="album-info">
      <div class="build-album">
        <div class="button"><a uri="index.php?act=sns_album&op=album_add" nc_type="dialog" dialog_title="<?php echo $lang['album_new_class_add'];?>" class="btn" ><i></i><?php echo $lang['album_new_class_add'];?></a></div>
      </div>
      <div class="upload-photo">
          <div class="button"><a id="open_uploader" href="JavaScript:void(0);" class="ncsc-btn ncsc-btn-acidblue"><i class="icon-cloud-upload"></i><?php echo $lang['sns_upload_more_pic'];?></a></div>
          <div class="upload-con" id="uploader" style="display: none;">
            <form method="post" action="" id="fileupload" enctype="multipart/form-data">
              <div class="upload-con-div"><?php echo $lang['album_plist_move_album_change'].$lang['nc_colon'];?>
                <select name="category_id" id="category_id" class="select w80">
                  <?php foreach ($output['ac_list'] as $v){?>
                  <option value='<?php echo $v['ac_id']?>' class="w80"><?php echo $v['ac_name']?></option>
                  <?php }?>
                </select>
              </div>
              <div class="upload-con-div mt10">
                <div class="ncsc-upload-btn"><span>
                  <input type="file" hidefocus="true" size="1" class="input-file" name="file" multiple="multiple"/>
                  </span>
                  <p>选择图片上传</p>
                  </div>
              </div>
              <div nctype="file_msg"></div>
              <div class="upload-pmgressbar" nctype="file_loading"></div>
              <div class="upload-txt"><span><?php echo $lang['album_batch_upload_description'].$output['setting_config']['image_max_filesize'].'KB'.$lang['album_batch_upload_description_1'];?></span> </div>
            </form>
          </div>
      </div>
      <div class="stat"><?php if(C('malbum_max_sum') > 0){?>
      <?php printf($lang['sns_batch_upload_tips1'], count($output['ac_list']), $output['count'], (10-count($output['ac_list'])), (C('malbum_max_sum')-intval($output['count'])))?>
      <?php }else{?>
      <?php printf($lang['sns_batch_upload_tips2'], count($output['ac_list']), (10-count($output['ac_list'])))?>
      <?php }?></div>
    </div>
    <?php }?>
    <?php if(!empty($output['ac_list'])){?>
    <?php foreach ($output['ac_list'] as $v){?>
    <div class="album-cover">
      <div class="cover"> <span class="thumb size190"><i></i><a href="index.php?act=sns_album&op=album_pic_list&id=<?php echo $v['ac_id']?>&mid=<?php echo $output['master_id'];?>">
        <?php if($v['ac_cover'] != ''){ ?>
        <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$output['master_id'].DS.$v['ac_cover'];?>" onerror="this.src='<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>'" >
        <?php }else{?>
        <img src="<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" onload=>
        <?php }?>
        </a></span></div>
      <div class="title">
        <h3><?php echo $v['ac_name'];?></h3>
        <em>(<?php echo $v['count']?>)</em></div>
      <?php if($output['relation'] == '3'){?>
      <div class="handle"><a href="JavaScript:void(0);" class="edit" nc_type="dialog" dialog_title="<?php echo $lang['album_class_deit'];?>" dialog_id='album_<?php echo $v['ac_id'];?>' dialog_width="480" uri="index.php?act=sns_album&op=album_edit&id=<?php echo $v['ac_id'];?>"><i></i><?php echo $lang['album_class_edit'];?></a>
        <?php if($v['is_default'] != '1'){?>
        <a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['album_class_delete_confirm_message'];?>', 'index.php?act=sns_album&op=album_del&id=<?php echo $v['ac_id'];?>');" class="del"><i></i><?php echo $lang['album_class_delete'];?></a>
        <?php }?>
      </div>
      <?php }?>
    </div>
    <?php }?>
    <div class="clear"></div>
    <div class="pagination"><?php echo $output['show_page']; ?></div>
    <div class="clear"></div>
    <?php }else{?>
    <dl>
      <dd class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></dd>
    </dl>
    <?php }?>
  </div>
</div>
