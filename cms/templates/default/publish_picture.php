<style type="text/css">
#tbox {
	display: none;
}
</style>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    //发布时间选择
    $('#picture_publish_time').datepicker();

    //摘要计数
    $("[name='picture_image_abstract[]']").nc_text_count({max:140});

    $("#btn_draft").click(function(){
        if($(".exceeded").length <= 0) {
            $("#save_type").val('draft');
            $("#add_form").submit();
        }
    });

    $("#btn_publish").click(function(){
        if($(".exceeded").length <= 0) {
            $("#save_type").val('publish');
            $("#add_form").submit();
        }
    });

    $('#add_form').validate({
        errorPlacement: function(error, element){
            element.after(error);
        },
            success: function(label){
                label.addClass('valid');
            },
            rules : {
                picture_title: {
                    required : true,
                    minlength : 4,
                    maxlength : 24 
                },
                picture_title_short: {
                    minlength : 4,
                    maxlength : 12
                },
                picture_abstract: {
                    maxlength : 140
                }
            },
            messages : {
                picture_title: {
                    required : "<?php echo $lang['article_title_null'];?>",
                    minlength: jQuery.validator.format("<?php echo $lang['article_title_error1'];?>"),
                    maxlength : jQuery.validator.format("<?php echo $lang['article_title_error'];?>")
                },
                picture_title_short: {
                    minlength: jQuery.validator.format("<?php echo $lang['article_title_error1'];?>"),
                    maxlength : jQuery.validator.format("<?php echo $lang['article_title_error'];?>")
                },
                picture_abstract: {
                    maxlength : jQuery.validator.format("<?php echo $lang['article_abstract_error'];?>")
                }
            }

    });
	//自定义滚定条
	$('#pic-upload-scrollbar').perfectScrollbar();
    //图片上传
    $("#picture_image_upload").fileupload({
        dataType: 'json',
            url: "<?php echo CMS_SITE_URL.DS.'index.php?act=publish&op=article_image_upload';?>",
            add: function(e,data) {
                $.each(data.files, function(index, file) {
                    var image_content = '<li id=' + file.name.replace(/\./g, '_') + '>';
                    image_content += '<dl class="picture-content">';
                    image_content += '<dt class="picture-img">';
                    image_content += '<div class="upload-thumb"><a href="Javascript: void(0);"><img src="' + LOADING_IMAGE + '" alt="" /></a></div>';
                    image_content += '<div class="handle">';
					image_content += '<span class="upload-state">正在上传：' + file.name + '</span>';
                    image_content += '</div>';
                    image_content += '</dt>';
                    image_content += '</dl>';
                    image_content += '</li>';
                    $(".picture-image-list").append(image_content);
                });
                data.submit();
            },
            done: function (e,data) {
                result = data.result;
                var $image_box = $('#' + result.origin_file_name.replace(/\./g, '_'));
                if(result.status == "success") {
                    $image_box.find('img').attr('src', result.file_url);
                    var $image_handle = $image_box.find('.handle');

                    var image_handle = '<a nctype="btn_set_picture_image" image_name="'+result.file_name+'"><?php echo $lang['cms_cover'];?></a>';
                    image_handle += '<a nctype="btn_drop_picture_image" image_name="'+result.file_name+'"><?php echo $lang['nc_delete'];?></a>';
                    $image_handle.html(image_handle);

                    var image_hidden = '<input name="picture_image_all[]" type="hidden" value="'+result.file_name + ',' + result.file_path +'" />';
                    $image_handle.after(image_hidden);

                    var image_content = '<dd class="picture-abstract"><h4><?php echo $lang['cms_image_abstract'];?></h4>';
                    image_content += '<textarea name="picture_image_abstract[]" rows="2" class="textarea">';
                    image_content += '</textarea></dd>';
                    image_content += '<dd class="picture-add-goods">';
                    image_content += '<input class="btn-type-s" nctype="btn_add_image_goods" image_name="'+result.file_name+'" type="button" value="添加商品" />';
                    image_content += '</dd>';
                    $image_box.find("dl").append(image_content);

                    var image_goods_list = '<div class="goods-for-picture" nctype="image_goods_list"></div>';
                    $image_box.append(image_goods_list);

                    $image_box.find("textarea").nc_text_count({max:140});

                    $image_box.attr('id', '');
                } else {
                    $image_box.remove();
                    showError(result.error);
                }
            }
    });

    //设封面图
    $("[nctype='btn_set_picture_image']").live("click",function(){
        var picture_image = $(this).parent().parent().find(".upload-thumb").html();
        $("#div_picture_image").html(picture_image);
        $("#picture_image").val($(this).attr("image_name"));
    });

    //图片删除
    $("[nctype='btn_drop_picture_image']").live("click",function(){
        var image_object = $(this).parents("li");
        var image_name = $(this).attr("image_name");
        $.getJSON("<?php echo CMS_SITE_URL.DS.'index.php?act=publish&op=article_image_drop';?>", { image_name: image_name }, function(result){
                if(result.status == "success") {
                    image_object.remove();
                } else {
                    showError(result.error);
                }
        });
    });

    //绑定商品
    $("[nctype='btn_add_image_goods']").live('click', function() {
        var add = '<div nctype="div_image_goods_add"><input class="text" style="width:235px;" nctype="image_goods_url" type="text" /><input class="btn-type-s" nctype="btn_goods_add_commit" type="button" image_name="'+$(this).attr("image_name")+'" value="<?php echo $lang['nc_confirm'];?>" /><input class="btn-type-s" nctype="btn_goods_add_cancel" type="button" value="<?php echo $lang['nc_cancel'];?>" /><div class="hint"><?php echo $lang['cms_picture_image_tips'];?></div></div>'; 
        $(this).after(add);
        $(this).hide();
    });

    //绑定商品确认
    $("[nctype='btn_goods_add_commit']").live('click', function() {
        var btn = $(this);
        var goods_list = btn.parents("li").find("[nctype='image_goods_list']");
        if(goods_list.find("dl").length < 3) {
            var url = encodeURIComponent($(this).parent().find("[nctype='image_goods_url']").val());
            var image_name = $(this).attr("image_name");
            if(url != '') {
                $.getJSON("<?php echo CMS_SITE_URL.DS.'index.php?act=api&op=goods_info_by_url';?>", { url: url}, function(data){
                    if(data.result == "true") {
                        var url_item = '<dl class="taobao-item">';
                        url_item += '<dt class="taobao-item-title"><a href="'+data.url+'" target="_blank">'+data.title+'</a></dt>';
                        url_item += '<dd class="taobao-item-img"><a href="'+data.url+'" target="_blank"><img src="'+data.image+'" alt="'+data.title+'" title="'+data.title+'" /></a></dd>';
                        url_item += '<dd class="taobao-item-price"><?php echo $lang['currency'];?><em>'+data.price+'</em></dd>';
                        url_item += '<dd class="taobao-item-delete" nctype="btn_image_goods_delete"><?php echo $lang['cms_delete'];?></dd>';
                        url_item += '<input name="image_goods_url['+image_name+'][]" type="hidden" value="'+data.url+'" />';
                        url_item += '<input name="image_goods_image['+image_name+'][]" type="hidden" value="'+data.image+'" />';
                        url_item += '<input name="image_goods_price['+image_name+'][]" type="hidden" value="'+data.price+'"/>';
                        url_item += '<input name="image_goods_title['+image_name+'][]" type="hidden" value="'+data.title+'"/>';
                        url_item += '</dl>';
                        goods_list.append(url_item);
                        btn.parent().parent().find("[nctype='btn_add_image_goods']").show();
                        btn.parent().remove();
                    } else {
                        alert(data.message);
                    }
                });
            }
        }
    });

    //绑定商品取消
    $("[nctype='btn_goods_add_cancel']").live('click', function() {
        $(this).parent().parent().find("[nctype='btn_add_image_goods']").show();
        $(this).parent().remove();
    });

    //绑定商品删除
    $("[nctype='btn_image_goods_delete']").live('click', function() {
        $(this).parent().remove();
    });

    //标签操作
    $("[nctype='cms_tag']").live("click",function(){
        var current_css = $(this).attr("class");
        if(current_css == "btn-cms-tag") {
            $(this).attr("class","btn-cms-tag-selected");
        } else {
            $(this).attr("class","btn-cms-tag");
        }
        var cms_tag_selected = '';
        $(".btn-cms-tag-selected").each(function(){
            cms_tag_selected += $(this).attr("tag_id") + ",";
        });
        $("#picture_tag").val(cms_tag_selected.substring(0, cms_tag_selected.length-1));
    });

});
</script>
<div class="cms-content mt10">
  <form id="add_form" method="post" action="index.php?act=publish&op=publish_picture_save">
    <input id="save_type" name="save_type" type="hidden" value="draft" />
    <input id="picture_id" name="picture_id" type="hidden" value="<?php if(!empty($output['picture_detail'])) echo $output['picture_detail']['picture_id'];?>" />
    <div class="cms-publish-content">
      <table class="cms-publish-table cms-publish-table-picture">
        <tbody>
          <tr>
            <th><?php echo $lang['cms_article_class'];?><?php echo $lang['nc_colon'];?></th>
            <td><select id="picture_class" name="picture_class">
                <?php if(!empty($output['picture_class_list']) && is_array($output['picture_class_list'])) {?>
                <?php foreach($output['picture_class_list'] as $value) {?>
                <option value="<?php echo $value['class_id'];?>" <?php if($value['class_id'] == $output['picture_detail']['picture_class_id']) echo 'selected';?>><?php echo $value['class_name'];?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
            <td rowspan="3" class="w200"><input id="picture_image" name="picture_image" type="hidden" value="" />
              <div class="edit-cover-pic">
                  <div id="div_picture_image" class="edit-cover-pic">
                <?php if(!empty($output['picture_detail']['picture_image'])) { ?>
                 <img alt="" src="<?php echo getCMSArticleImageUrl($output['picture_detail']['picture_attachment_path'],$output['picture_detail']['picture_image'], 'list');?>">
                 <?php } ?>
             </div>
             <p class="edit-cover-text"><?php echo $lang['cms_cover'];?></p>
              </td>
          </tr>
          <tr>
            <th><?php echo $lang['cms_title'];?><?php echo $lang['nc_colon'];?></th>
            <td><input id="picture_title" class="text w300" name="picture_title" type="text" value="<?php if(!empty($output['picture_detail'])) echo $output['picture_detail']['picture_title'];?>" />
              <div class="hint"><?php echo $lang['cms_title_explain'];?></div></td>
          </tr>
          <tr>
            <th><?php echo $lang['cms_title_short'];?><?php echo $lang['nc_colon'];?></th>
            <td><input id="article_title_short" class="text w300" name="picture_title_short" type="text" value="<?php if(!empty($output['picture_detail'])) echo $output['picture_detail']['picture_title_short'];?>" />
              <div class="hint"><?php echo $lang['cms_title_short_explain'];?></div></td>
          </tr>
          <tr>
            <th><?php echo $lang['cms_article_abstract'];?><?php echo $lang['nc_colon'];?></th>
            <td colspan="2"><div>
                <textarea name="picture_abstract" rows="3" class="textarea" style=" width:650px" id="picture_abstract"><?php if(!empty($output['picture_detail'])) echo $output['picture_detail']['picture_abstract'];?>
</textarea>
                <div class="hint"><?php echo $lang['cms_article_abstract_explain'];?></div>
              </div></td>
          </tr>
          <tr>
            <th><?php echo $lang['cms_image_upload'];?><?php echo $lang['nc_colon'];?></th>
            <td colspan="2">
            <div id="pic-upload-scrollbar"><ul class="picture-image-list">
                <?php if(!empty($output['picture_image_list'])) { ?>
                <?php if(!empty($output['picture_image_list']) && is_array($output['picture_image_list'])) { ?>
                <?php foreach ($output['picture_image_list'] as $key=>$value) { ?>
                <li>
                  <dl class="picture-content">
                    <dt class="picture-img">
                      <div class="upload-thumb"><a href="Javascript: void(0);"><img nctype="picture_image_item" alt="" src="<?php echo getCMSArticleImageUrl(empty($value['image_path'])?$output['picture_detail']['picture_attachment_path']:$value['image_path'], $value['image_name'], 'list');?>"></a></div>
                      <div class="handle"><a image_name="<?php echo $value['image_name'];?>" nctype="btn_set_picture_image"><?php echo $lang['cms_cover'];?></a><a image_name="<?php echo $value['image_name'];?>" nctype="btn_drop_picture_image"><?php echo $lang['nc_delete'];?></a></div>
                    </dt>
                    <input type="hidden" value="<?php echo $value['image_name'].','.$value['image_path'];?>" name="picture_image_all[]">
                    <dd class="picture-abstract">
                      <h4><?php echo $lang['cms_image_abstract'];?></h4>
                      <textarea name="picture_image_abstract[]" rows="2" class="textarea"><?php echo $value['image_abstract'];?></textarea>
                    </dd>
                    <dd class="picture-add-goods">
                      <input class="btn-type-s" nctype="btn_add_image_goods" image_name="<?php echo $value['image_name'];?>" type="button" value="<?php echo $lang['cms_goods_add'];?>" />
                    </dd>
                  </dl>
                  <div class="goods-for-picture" nctype="image_goods_list">
                    <?php $image_goods_list = unserialize($value['image_goods']);?>
                    <?php if(!empty($image_goods_list) && is_array($image_goods_list)) { ?>
                    <?php foreach ($image_goods_list as $image_value) {?>
                    <dl class="taobao-item">
                      <dt class="taobao-item-title"><a href="<?php echo $image_value['url'];?>" target="_blank"><?php echo $image_value['title'];?></a></dt>
                      <dd class="taobao-item-img"><a href="<?php echo $image_value['link'];?>" target="_blank"> <img src="<?php echo $image_value['image'];?>" alt="<?php echo $image_value['title'];?>" title="<?php echo $image_value['title'];?>" /> </a> </dd>
                      <dd class="taobao-item-price"><?php echo $lang['currency'];?><em><?php echo $image_value['price'];?></em></dd>
                      <dd class="taobao-item-delete" nctype="btn_image_goods_delete" title="<?php echo $lang['nc_delete'];?>"><?php echo $lang['nc_delete'];?></dd>
                      <input name="image_goods_url[<?php echo $value['image_name'];?>][]" type="hidden" value="<?php echo $image_value['url'];?>" />
                      <input name="image_goods_image[<?php echo $value['image_name'];?>][]" type="hidden" value="<?php echo $image_value['image'];?>" />
                      <input name="image_goods_price[<?php echo $value['image_name'];?>][]" type="hidden" value="<?php echo $image_value['price'];?>"/>
                      <input name="image_goods_title[<?php echo $value['image_name'];?>][]" type="hidden" value="<?php echo $image_value['title'];?>"/>
                    </dl>
                    <?php } ?>
                    <?php } ?>
                  </div>
                </li>
                <?php } ?>
                <?php } ?>
                <?php } ?>
              </ul></div>
              <div class="upload-btn"><a href="javascript:void(0);"><span>
                <input type="file" name="article_image_upload" id="picture_image_upload" multiple=""  file_id="0" style="width:120px; height: 40px; cursor: pointer; opacity:0; filter: alpha(opacity=0)" size="1" hidefocus="true" />
                </span>
                <div class="upload-button"><i></i><?php echo $lang['cms_image_upload'];?></div>
                <input id="submit_button" style="display:none" type="button" value="&nbsp;" onClick="submit_form($(this))" />
                </a></div></td>
          </tr>
          <tr>
            <th><?php echo $lang['cms_text_publisher'];?></th>
            <td colspan="2"><input id="picture_author" class="text w100" name="picture_author" type="text" value="<?php echo empty($output['picture_detail']['picture_author'])?$output['publisher_info']['name']:$output['picture_detail']['picture_author'];?>"/>
              <div class="hint"><?php echo $lang['cms_publisher_explain'];?></div></td>
          </tr>
          <tr>
            <th><?php echo $lang['cms_publish_time'];?></th>
            <td colspan="2"><input id="picture_publish_time" class="text w100" name="picture_publish_time" type="text" value="<?php echo empty($output['picture_detail'])?date('Y-m-d',time()):date('Y-m-d',$output['picture_detail']['picture_publish_time']);?>"/>
              <div class="hint"><?php echo $lang['cms_publish_time_explain'];?></div></td>
          </tr>
          <tr>
            <th><?php echo $lang['cms_tag'];?><?php echo $lang['nc_colon'];?></th>
            <td colspan="2"><?php if(!empty($output['tag_list']) && is_array($output['tag_list'])) {?>
              <ul>
                <?php $tag_selected = explode(',',$output['picture_detail']['picture_tag']);?>
                <?php foreach($output['tag_list'] as $value) {?>
                <li nctype="cms_tag" class="<?php echo in_array($value['tag_id'],$tag_selected)?'btn-cms-tag-selected':'btn-cms-tag';?>" tag_id="<?php echo $value['tag_id'];?>"><?php echo $value['tag_name'];?></li>
                <?php } ?>
              </ul>
              <?php } ?>
              <input id="picture_tag" name="picture_tag" type="hidden" value="<?php if(!empty($output['picture_detail'])) echo $output['picture_detail']['picture_tag'];?>"/></td>
          </tr>
          <tr>
            <th><?php echo $lang['cms_keyword'];?><?php echo $lang['nc_colon'];?></th>
            <td colspan="2"><input id="picture_keyword" class="text w380" name="picture_keyword" type="text" value="<?php if(!empty($output['picture_detail'])) echo $output['picture_detail']['picture_keyword'];?>"/><div class="hint"><?php echo $lang['cms_keyword_expalin'];?></div></td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="21"><a id="btn_draft" class="btn-draft" href="javascript:void(0);"><?php echo $lang['cms_article_save_draft'];?></a> <a id="btn_publish" class="btn-publish" href="javascript:void(0);"><?php echo $lang['cms_text_publish'];?></a></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </form>
</div>
