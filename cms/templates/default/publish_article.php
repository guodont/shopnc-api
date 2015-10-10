<style type="text/css">
#tbox {
	display: none;
}
</style>

<div class="cms-content mt10">
  <form id="add_form" method="post" action="index.php?act=publish&op=publish_article_save">
    <input id="save_type" name="save_type" type="hidden" value="draft" />
    <input id="article_id" name="article_id" type="hidden" value="<?php if(!empty($output['article_detail'])) echo $output['article_detail']['article_id'];?>" />
    <div class="cms-publish-content" id="main-nav-holder">
      <div class="cms-publish-sidebar" id="main-nav">
        <div class="upload-btn"><a href="javascript:void(0);"><span>
          <input type="file" name="article_image_upload" id="article_image_upload" multiple=""  file_id="0" style="width:120px; height: 40px; cursor: pointer; opacity:0; filter: alpha(opacity=0)" size="1" hidefocus="true" />
          </span>
          <div class="upload-button"><i></i><?php echo $lang['cms_image_upload'];?></div>
          <input id="submit_button" style="display:none" type="button" value="&nbsp;" onClick="submit_form($(this))" />
          </a></div>
        <div class="upload-images-box">
          <ul id="article_image_list2" class="article-image-list" style="position:relative;">
            <?php $article_image_all = unserialize($output['article_detail']['article_image_all']);?>
          </ul>
          <!-- <div id="btn_image_list_up" class="up-btn" title="<?php echo $lang['cms_text_up'];?>"><i></i><?php echo $lang['cms_text_up'];?></div>-->
          <div class="upload-img-list" id="art-upload-scrollbar">
            <ul id="article_image_list" class="article-image-list" style="position:relative;">
              <?php if(!empty( $output['article_detail']['article_image_all'])) { ?>
              <?php if(!empty($article_image_all) && is_array($article_image_all)) { ?>
              <?php foreach ($article_image_all as $key=>$value) { ?>
              <li><div class="picture"><a href="Javascript: void(0);"><img alt="" src="<?php echo getCMSArticleImageUrl($output['article_detail']['article_attachment_path'], serialize($value), 'max');?>"></a></div>
                <div class="handle"><a nctype="btn_insert_article_image"><?php echo $lang['cms_text_insert'];?></a><a image_name="<?php echo $key;?>" nctype="btn_set_article_image"><?php echo $lang['cms_cover'];?></a> <a image_name="<?php echo $key;?>" nctype="btn_drop_article_image"><?php echo $lang['cms_delete'];?></a></div>
                <input type="hidden" value="<?php echo $key.','.$value['path'];?>" name="article_image_all[]">
              </li>
              <?php } ?>
              <?php } ?>
              <?php } ?>
            </ul>
          </div>
          <!-- <div id="btn_image_list_down" class="down-btn" title="<?php echo $lang['cms_text_down'];?>"/> 
          <i></i><?php echo $lang['cms_text_down'];?></div>-->
      </div>
    </div>
    <table class="cms-publish-table">
      <tbody>
        <tr>
          <th><?php echo $lang['cms_article_class'];?></th>
          <td><select id="article_class" name="article_class">
              <?php if(!empty($output['article_class_list']) && is_array($output['article_class_list'])) {?>
              <?php foreach($output['article_class_list'] as $value) {?>
              <option value="<?php echo $value['class_id'];?>" <?php if($value['class_id'] == $output['article_detail']['article_class_id']) echo 'selected';?>><?php echo $value['class_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td rowspan="3" align="center" valign="middle" class="w200">
              <div id="div_article_image" class="edit-cover-pic">
              <?php if(!empty($output['article_detail']['article_image'])) { ?>
              <img alt="" src="<?php echo getCMSArticleImageUrl($output['article_detail']['article_attachment_path'],$output['article_detail']['article_image'], 'list');?>">
              <?php } ?>
              </div>
              <p class="edit-cover-text"><?php echo $lang['cms_cover'];?></p>
            <input id="article_image" name="article_image" type="hidden" value="<?php if(!empty($output['article_detail'])) echo getCMSImageName($output['article_detail']['article_image']);?>" /></td>
        </tr>
        <tr>
          <th><?php echo $lang['cms_title'];?><?php echo $lang['nc_colon'];?></th>
          <td><input id="article_title" class="text w300" name="article_title" type="text" value="<?php if(!empty($output['article_detail'])) echo $output['article_detail']['article_title'];?>" />
            <div class="hint"><?php echo $lang['cms_title_explain'];?></div></td>
        </tr>
        <tr>
          <th><?php echo $lang['cms_title_short'];?><?php echo $lang['nc_colon'];?></th>
          <td><input id="article_title_short" class="text w300" name="article_title_short" type="text" value="<?php if(!empty($output['article_detail'])) echo $output['article_detail']['article_title_short'];?>" />
            <div class="hint"><?php echo $lang['cms_title_short_explain'];?></div></td>
        </tr>
        <tr>
          <th><?php echo $lang['cms_article_abstract'];?><?php echo $lang['nc_colon'];?></th>
          <td colspan="2"><div class="abstract">
              <textarea  id="article_abstract" class="textarea" name="article_abstract"><?php if(!empty($output['article_detail'])) echo $output['article_detail']['article_abstract'];?>
</textarea>
              <div class="hint"><?php echo $lang['cms_article_abstract_explain'];?></div>
            </div></td>
        </tr>
        <tr>
          <th><?php echo $lang['cms_article_content'];?><?php echo $lang['nc_colon'];?></th>
          <td colspan="2"><?php showEditor('article_content',$output['article_detail']['article_content'],'700px','400px','visibility:hidden;',"false",$output['editor_multimedia'],'simple');?></td>
        </tr>
        <tr>
          <th><?php echo $lang['cms_text_publisher'];?><?php echo $lang['nc_colon'];?></th>
          <td colspan="2"><input id="article_author" class="text w100" name="article_author" type="text" value="<?php echo empty($output['article_detail']['article_author'])?$output['publisher_info']['name']:$output['article_detail']['article_author'];?>"/>
            <div class="hint"><?php echo $lang['cms_publisher_explain'];?></div></td>
        </tr>
        <tr>
          <th><?php echo $lang['cms_publish_time'];?><?php echo $lang['nc_colon'];?></th>
          <td colspan="2"><input id="article_publish_time" class="text w100" name="article_publish_time" type="text" value="<?php echo empty($output['article_detail']['article_publish_time'])?date('Y-m-d',time()):date('Y-m-d',$output['article_detail']['article_publish_time']);?>"/>
            <div class="hint"><?php echo $lang['cms_publish_time_explain'];?></div></td>
        </tr>
        <tr>
          <th><?php echo $lang['cms_article_orgin'];?><?php echo $lang['nc_colon'];?></th>
          <td colspan="3"><input id="article_origin" class="text w100" name="article_origin" type="text" value="<?php if(!empty($output['article_detail'])) echo $output['article_detail']['article_origin'];?>"/>
            <span><?php echo $lang['cms_article_orgin_address'];?><?php echo $lang['nc_colon'];?></span>
            <input id="article_origin_address" class="text w200" name="article_origin_address" type="text" value="<?php if(!empty($output['article_detail'])) echo $output['article_detail']['article_origin_address'];?>"/>
            <div class="hint"><?php echo $lang['cms_article_orgin_explain'];?></div></td>
        </tr>
        <tr>
          <th><?php echo $lang['cms_article_goods'];?><?php echo $lang['nc_colon'];?></th>
          <td colspan="2">
            <ul id="article_goods_list" class="article-goods-list">
              <?php if(!empty($output['article_goods_list'])) { ?>
              <?php foreach($output['article_goods_list'] as $value) { ?>
              <li nctype="btn_goods_select">
                <dl>
                  <dt class="name"> <a target="_blank" href="<?php echo $value['url'];?>"><?php echo $value['title'];?></a> </dt>
                  <dd nctype="btn_goods_select" class="image"> <img src="<?php echo $value['image'];?>" title="<?php echo $value['title'];?>"> </dd>
                  <dd class="price"><?php echo $lang['cms_price'];?><?php echo $lang['nc_colon'];?><em><?php echo $value['price'];?></em></dd>
                </dl>
                <i><?php echo $lang['cms_article_goods_delete_explain'];?></i>
                <input type="hidden" value="<?php echo $value['url'];?>" name="article_goods_url[]">
                <input type="hidden" value="<?php echo $value['title'];?>" name="article_goods_title[]">
                <input type="hidden" value="<?php echo $value['image'];?>" name="article_goods_image[]">
                <input type="hidden" value="<?php echo $value['price'];?>" name="article_goods_price[]">
                <input type="hidden" value="<?php echo $value['type'];?>" name="article_goods_type[]">
                 </li>
              <?php } ?>
              <?php } ?>
            </ul>
            <p>
              <input id="goods_search_type_url" value="goods_url" name="goods_search_type" type="radio" checked />
              <label for="goods_search_type_url"><?php echo $lang['cms_goods_link'];?></label>
              <input id="goods_search_type_title" value="goods_name" name="goods_search_type" type="radio" />
              <label for="goods_search_type_title"><?php echo $lang['cms_goods_name'];?></label>
            </p>
            <input id="goods_search_keyword" class="text w380" name="goods_search_keyword" type="text" />
            <input id="btn_goods_search" class="btn-type-s" type="button" value="<?php echo $lang['cms_text_add'];?>" />
            <div id="div_goods_select"> </div>
            <div class="hint"><?php echo $lang['cms_goods_explain'];?></div></td>
        </tr>
        <tr>
          <th><?php echo $lang['cms_tag'];?><?php echo $lang['nc_colon'];?></th>
          <td colspan="3"><?php if(!empty($output['tag_list']) && is_array($output['tag_list'])) {?>
            <ul>
              <?php $tag_selected = explode(',',$output['article_detail']['article_tag']);?>
              <?php foreach($output['tag_list'] as $value) {?>
              <li nctype="cms_tag" class="<?php echo in_array($value['tag_id'],$tag_selected)?'btn-cms-tag-selected':'btn-cms-tag';?>" tag_id="<?php echo $value['tag_id'];?>"><?php echo $value['tag_name'];?></li>
              <?php } ?>
            </ul>
            <?php } ?>
            <input id="article_tag" name="article_tag" type="hidden" value="<?php if(!empty($output['article_detail'])) echo $output['article_detail']['article_tag'];?>"/>
            <div class="hint"></div></td>
        </tr>
        <tr>
          <th><?php echo $lang['cms_keyword'];?><?php echo $lang['nc_colon'];?></th>
          <td colspan="3"><input id="article_keyword" class="text w380" name="article_keyword" type="text" value="<?php if(!empty($output['article_detail'])) echo $output['article_detail']['article_keyword'];?>"/>
          <div class="hint"><?php echo $lang['cms_keyword_expalin'];?></div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang['cms_other_article'];?><?php echo $lang['nc_colon'];?></th>
          <td colspan="2"><input id="article_link" name="article_link" type="hidden" value="<?php if(!empty($output['article_detail'])) echo $output['article_detail']['article_link'];?>"/>
            <ul id="article_link_list" class="article-link-list">
              <?php if(!empty($output['article_link_list'])) { ?>
              <?php foreach($output['article_link_list'] as $value) { ?>
              <li article_id="<?php echo $value['article_id'];?>" nctype="btn_article_select"><a target="_blank" href="<?php echo getCMSArticleUrl($value['article_id']);?>"> <?php echo $value['article_title'];?> </a> <i><?php echo $lang['cms_article_article_delete_explain'];?></i> </li>
              <?php } ?>
              <?php } ?>
            </ul>
            <div id="div_article_search" class="div_article_search">
            <p>
              <input id="article_search_type_id" name="article_search_type" type="radio" value="article_id" checked />
              <label for="article_search_type_id"><?php echo $lang['cms_article_id'];?></label>
              <input id="article_search_type_title" name="article_search_type" value="article_keyword" type="radio" />
              <label for="article_search_type_title"><?php echo $lang['cms_article_title'];?></label>
            </p>
            <input id="article_search_keyword" class="text w380" name="article_search_keyword" type="text" />
            <input id="btn_article_search"  class="btn-type-s" type="button" value="<?php echo $lang['cms_text_search'];?>" />
            <div id="div_article_select"> </div>
            <div class="hint"><?php echo $lang['cms_article_expalin'];?></div></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20"><a id="btn_draft" class="btn-draft" href="javascript:void(0);"><?php echo $lang['cms_article_save_draft'];?></a> <a id="btn_publish" class="btn-publish" href="javascript:void(0);"><?php echo $lang['cms_text_publish'];?></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo CMS_RESOURCE_SITE_URL;?>/js/waypoints.js"></script> 
<script type="text/javascript" src="<?php echo CMS_RESOURCE_SITE_URL;?>/js/cms_article_publish.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
	//侧边滚动上传图片列表
	 $('#main-nav-holder').waypoint(function(event, direction) {
        $(this).parent().parent().toggleClass('sticky', direction === "down");
        event.stopPropagation();
    }); 
    //发布时间选择
    $('#article_publish_time').datepicker();
	//自定义滚定条
	$('#art-upload-scrollbar').perfectScrollbar();
    //摘要计数
    $("#article_abstract").nc_text_count({max:140});

    $("#btn_draft").click(function(){
        $("#save_type").val('draft');
        $("#add_form").submit();
    });

    $("#btn_publish").click(function(){
        $("#save_type").val('publish');
        $("#add_form").submit();
    });

    $('#add_form').validate({
        errorPlacement: function(error, element){
            element.after(error);
        },
            success: function(label){
                label.addClass('valid');
            },
                rules : {
                    article_title: {
                        required : true,
                        minlength : 4,
                        maxlength : 24 
                    },
                    article_title_short: {
                        minlength : 4,
                        maxlength : 12
                    },
                    article_abstract: {
                        maxlength : 140
                    }
                },
                messages : {
                    article_title: {
                        required : "<?php echo $lang['article_title_null'];?>",
                        minlength: jQuery.validator.format("<?php echo $lang['article_title_error1'];?>"),
                        maxlength : jQuery.validator.format("<?php echo $lang['article_title_error'];?>")
                    },
                    article_title_short: {
                        minlength: jQuery.validator.format("<?php echo $lang['article_title_error1'];?>"),
                        maxlength : jQuery.validator.format("<?php echo $lang['article_title_error'];?>")
                    },
                    article_abstract: {
                        maxlength : jQuery.validator.format("<?php echo $lang['article_abstract_error'];?>")
                    }
                }
    });
 });
</script>


