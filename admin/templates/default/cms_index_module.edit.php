<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo CMS_SITE_URL.DS;?>templates/cms_special.css" rel="stylesheet" type="text/css"/>
<style type="text/css">
.dialog_content {
	overflow: hidden;
	padding: 0 15px 15px !important;
}
</style>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.VMiddleImg.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jcarousel/jquery.jcarousel.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/template.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/kindeditor/kindeditor-min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/kindeditor/lang/zh_CN.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/cms/cms_index.js" charset="utf-8"></script>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_cms_index_manage'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" action="index.php?act=cms_index&op=save_page_module">
    <input name="module_id" type="hidden" value="<?php echo $output['module_detail']['module_id'];?>" />
    <table class="table tb-type2 nohover">
      <tbody>
      <tr class="noborder">
          <td colspan="2" class="required"> <!-- <label><?php echo $lang['cms_index_module_edit'];?><?php echo $lang['nc_colon'];?></label> --></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" id="cmsIndexModuleEdit" class="vatop"><?php $module_content = unserialize(base64_decode($output['module_detail']['module_content']));?>
            <?php $value['module_style'] = $output['module_detail']['module_style'];?>
            <?php require($output['module_template']);?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="Javascript: void(0)" class="btn" id="btn_module_save"><span><?php echo $lang['cms_text_save'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
  <!--编辑标题-->
  <div id="dialog_module_title_edit" style="display:none;">
    <h4 class="dialog-handle-title"><?php echo $lang['cms_index_module_title'];?></h4>
    <div class="dialog-handle-box clearfix"><span class="left">
      <input name="input_module_title" type="text" class=" w150" id="input_module_title" maxlength="8" />
      </span><span class="right"><?php echo $lang['cms_index_module_title_explain'];?></span></div>
    <a class="btn" id="btn_module_title_save" href="JavaScript:void(0);"> <span><?php echo $lang['cms_text_save'];?></span></a></div>
  <!-- 关键字标题 -->
  <div id="dialog_module_tag_edit" style="display:none;">
    <h4 class="dialog-handle-title"><?php echo $lang['cms_index_module_tag_selected'];?></h4>
    <ul id="article_tag_selected_list" class="article-tag-selected-list">
    </ul>
    <div class="clear"></div>
    <h4 class="dialog-handle-title"><?php echo $lang['cms_index_module_tag_list'];?></h4>
    <ul class="article-tag-list">
      <?php if(!empty($output['tag_list']) && is_array($output['tag_list'])) {?>
      <?php foreach($output['tag_list'] as $value){ ?>
      <li nctype="btn_tag_select" data-tag-id="<?php echo $value['tag_id'];?>"><a href="<?php echo CMS_SITE_URL;?>/index.php?act=article&op=article_tag_search&tag_id=<?php echo $value['tag_id'];?>" ><?php echo $value['tag_name'];?></a><i></i></li>
      <?php } ?>
      <?php } ?>
    </ul>
    <a class="btn" id="btn_module_tag_save" href="JavaScript:void(0);"><span><?php echo $lang['cms_text_save'];?></span></a></div>
  <!--编辑图片-->
  <div id="dialog_module_image_edit" style="display:none;">
    <form action="index.php?act=cms_index&op=image_upload" method="post">
      <div id="module_image_edit_explain" class="s-tips"></div>
      <ul id="image_selected_list" class="image-selected-list clearfix">
      </ul>
      <h4 class="dialog-handle-title"><?php echo $lang['cms_index_module_image_select'];?></h4>
      <div class="dialog-handle-box clearfix"><span class="left">
        <input id="btn_image_upload" name="image_upload" type="file" />
        </span></div>
      <a id="btn_module_image_save" href="JavaScript:void(0);" class="btn" ><span><?php echo $lang['cms_text_save'];?></span></a>
    </form>
  </div>
  <!--编辑文章-->
  <div id="dialog_module_article_edit" style="display:none;">
    <h4 class="dialog-handle-title"><?php echo $lang['cms_index_module_article_seleceted'];?></h4>
    <ul id="article_selected_list" class="dialog-article-selected-list">
    </ul>
    <h4 class="dialog-handle-title"><?php echo $lang['cms_index_module_article_search'];?></h4>
    <div class="dialog-show-box">
      <table class="tb-type1 noborder search">
        <tbody>
          <tr>
            <th class="w120"><input id="radio_article_search_type_1" name="article_search_type" type="radio" value="article_id" checked />
              <label for="radio_article_search_type_1"><?php echo $lang['cms_text_id'];?></label>
              <input id="radio_article_search_type_2" name="article_search_type" type="radio" value="article_keyword"/>
              <label for="radio_article_search_type_2"><?php echo $lang['cms_text_keyword'];?></label></th>
            <th><input id="input_article_search_keyword" type="text" class="txt" />
              <a href="JavaScript:void(0);" id="btn_article_search" class="btn-search " title="<?php echo $lang['cms_text_search'];?>"></a></th>
          </tr>
        </tbody>
      </table>
      <div id="div_article_select_list" class="show-recommend-goods-list"> </div>
    </div>
    <a class="btn" id="btn_module_article_save" href="JavaScript:void(0);"> <span><?php echo $lang['cms_text_save'];?></span> </a> </div>
  <!--编辑商品-->
  <div id="dialog_module_goods_edit" class="dialog-special-insert-goods upload_adv_dialog" style="display:none;">
      <div class="s-tips"><i></i><?php echo $lang['cms_index_module_goods_explain'];?></div>
    <table id="upload_adv_type" class="table tb-type2">
      <tbody>
        <tr>
          <td class="required" colspan="2"><?php echo $lang['cms_index_module_goods_input_url'];?><?php echo $lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="input_goods_link" type="text" class="txt" style=" width:200px; margin: 0;" />
            <a class="btns"  id="btn_goods_search" href="javascript:void(0);"><span><?php echo $lang['cms_text_add'];?></span></a></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['cms_index_module_goods_explain'];?></span></td>
        </tr>
        <tr class="noborder">
          <td colspan="2"><ul id="goods_selected_list" class="special-goods-list">
            </ul></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a id="btn_module_goods_save" href="JavaScript:void(0);" class="btn" ><span><?php echo $lang['cms_text_save'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </div>
  <!-- 品牌选择弹出窗口 -->
  <div id="dialog_module_brand_edit" class="brand_list_dialog" style="display:none;">
    <div id="upload_adv_type" >
      <h4 class="dialog-handle-title"><?php echo $lang['cms_index_module_brand_selected'];?><?php echo $lang['nc_colon'];?></h4>
      <div class="s-tips"> <i></i><?php echo $lang['cms_index_module_brand_explain'];?>  </div>
      <ul id="brand_selected_list" class="cms-brand-list">
      </ul>
      <h4 class="dialog-handle-title"><?php echo $lang['cms_index_module_brand_list'];?><?php echo $lang['nc_colon'];?></h4>
      <div id="div_brand_select_list" class="dialog-show-box"></div>
      <a id="btn_module_brand_save" href="JavaScript:void(0);" class="btn" ><span><?php echo $lang['cms_text_save'];?></span></a> </div>
</div>
    <!-- 商品分类选择弹出窗口 -->
    <div id="dialog_module_goods_class_edit" class="goods_class_list_dialog" style="display:none;">
      <div class="s-tips"><i></i><?php echo $lang['cms_index_module_goods_class_explain'];?></div>
      <div class="dialog-handle">
        <h4 class="dialog-handle-title"><?php echo $lang['cms_index_module_goods_class'];?></h4>
        <p><span class="handle">
          <select id="select_goods_class_list" class=" w200">
          </select>
          </span><span class="note"><?php echo $lang['cms_index_module_goods_class_explain'];?></span></p>
      </div>
      <div id="goods_class_selected_list" class="category-list category-list-edit"></div>
      <a id="btn_module_goods_class_save" href="JavaScript:void(0);" class="btn" ><span><?php echo $lang['cms_text_save'];?></span></a> 
</div>
<!--编辑店铺-->
<div id="dialog_module_store_edit" style="display:none;">
    <h4 class="dialog-handle-title">已选店铺：</h4>
    <ul id="store_selected_list" class="dialog-store-selected-list">
    </ul>
    <h4 class="dialog-handle-title">搜索店铺：</h4>
    <div class="dialog-show-box">
        <table class="tb-type1 noborder search">
            <tbody>
            <tr>
                <th class="w120">店铺关键字：</th>
                <th>
                    <input id="input_store_search_keyword" type="text" class="txt" />
                    <a href="JavaScript:void(0);" id="btn_store_search" class="btn-search " title="<?php echo $lang['cms_text_search'];?>"></a>
            </th>
            </tr>
            </tbody>
        </table>
        <div id="div_store_select_list" class="show-store-list"> </div>
    </div>
    <a class="btn" id="btn_module_store_save" href="JavaScript:void(0);"><span><?php echo $lang['cms_text_save'];?></span></a> 
</div>
<!--编辑会员-->
<div id="dialog_module_member_edit" style="display:none;">
    <h4 class="dialog-handle-title">已选会员：</h4>
    <ul id="member_selected_list" class="dialog-member-selected-list">
    </ul>
    <h4 class="dialog-handle-title">搜索会员：</h4>
    <div class="dialog-show-box">
        <table class="tb-type1 noborder search">
            <tbody>
            <tr>
                <th class="w120">会员关键字：</th>
                <th>
                    <input id="input_member_search_keyword" type="text" class="txt" />
                    <a href="JavaScript:void(0);" id="btn_member_search" class="btn-search " title="<?php echo $lang['cms_text_search'];?>"></a>
            </th>
            </tr>
            </tbody>
        </table>
        <div id="div_member_select_list" class="show-member-list"> </div>
    </div>
    <a class="btn" id="btn_module_member_save" href="JavaScript:void(0);"><span><?php echo $lang['cms_text_save'];?></span></a> 
</div>
<!--编辑FLASH-->
<div id="dialog_module_flash_edit" style="display:none;">
  <div id="module_image_edit_explain" class="s-tips"> <i></i> 输入扩展名为".swf"的flash文件地址，并根据模块区域大小设定宽高。 </div>
  <h4 class="dialog-handle-title">FLASH地址：</h4>
  <div class="dialog-handle-box">
    <input id="input_flash_address" type="text" class="w300" />
  </div>
  <h4 class="dialog-handle-title">FLASH尺寸</h4>
  <div class="dialog-handle-box"><span style="margin-right: 30px;">宽:
    <input id="input_flash_width" type="text" class="w36" />
    px</span><span>高:
    <input id="input_flash_height" type="text" class="w36" />
    px</span></div>
  <a id="btn_module_flash_save" href="JavaScript:void(0);" class="btn" ><span><?php echo $lang['cms_text_save'];?></span></a> </div>
<!-- FLASH组件模板 -->
<script id="module_assembly_flash_template" type="text/html">
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<%=width%>" height="<%=height%>" id="FlashID" >
    <param name="movie" value="<%=address%>"/>
    <param name="quality" value="high" />
    <param name="wmode" value="opaque" />
    <param name="swfversion" value="6.0.65.0" />
    <!--[if !IE]>-->
    <object type="application/x-shockwave-flash" data="<%=address%>" width="<%=width%>" height="<%=height%>" id="FlashID">
        <param name="movie" value="<%=address%>"/>
    </object>
    <!--<![endif]-->
</object>
</script>
<!--编辑自定义html -->
<div id="dialog_module_html_edit" style="display:none;">
    <h4 class="dialog-handle-title">自定义块内容</h4>
    <div class="dialog-handle-box">
    <textarea id="textarea_module_html" name="textarea_module_html" style="width:600px;height:300px;"></textarea>
    </div>
    <a id="btn_module_html_save" href="JavaScript:void(0);" class="btn" ><span><?php echo $lang['cms_text_save'];?></span></a>
</div>


