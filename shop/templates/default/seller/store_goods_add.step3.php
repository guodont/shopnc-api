<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if ($output['edit_goods_sign']) {?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<?php } else {?>
<ul class="add-goods-step">
  <li><i class="icon icon-list-alt"></i>
    <h6>STEP.1</h6>
    <h2>选择商品分类</h2>
    <i class="arrow icon-angle-right"></i> </li>
  <li><i class="icon icon-edit"></i>
    <h6>STEP.2</h6>
    <h2>填写商品详情</h2>
    <i class="arrow icon-angle-right"></i> </li>
  <li class="current"><i class="icon icon-camera-retro "></i>
    <h6>STEP.3</h6>
    <h2>上传商品图片</h2>
    <i class="arrow icon-angle-right"></i> </li>
  <li><i class="icon icon-ok-circle"></i>
    <h6>STEP.4</h6>
    <h2>商品发布成功</h2>
  </li>
</ul>
<?php }?>
<form method="post" id="goods_image" action="<?php if ($output['edit_goods_sign']) { echo urlShop('store_goods_online', 'edit_save_image'); } else { echo urlShop('store_goods_add', 'save_image');}?>">
  <input type="hidden" name="form_submit" value="ok">
  <input type="hidden" name="commonid" value="<?php echo $output['commonid'];?>">
  <input type="hidden" name="ref_url" value="<?php echo $_GET['ref_url'];?>" />
  <?php if (!empty($output['value_array'])) {?>
  <div class="ncsc-form-goods-pic">
    <div class="container">
      <?php foreach ($output['value_array'] as $value) {?>
      <div class="ncsc-goodspic-list">
        <div class="title">
          <h3>颜色：<?php if (isset($output['value'][$value['sp_value_id']])) { echo $output['value'][$value['sp_value_id']];} else {echo $value['sp_value_name'];}?></h3></div>
        <ul nctype="ul<?php echo $value['sp_value_id'];?>">
          <?php for ($i = 0; $i < 5; $i++) {?>
          <li class="ncsc-goodspic-upload">
            <div class="upload-thumb"><img src="<?php echo cthumb($output['img'][$value['sp_value_id']][$i]['goods_image'], 240);?>" nctype="file_<?php echo $value['sp_value_id'] . $i;?>">
              <input type="hidden" name="img[<?php echo $value['sp_value_id'];?>][<?php echo $i;?>][name]" value="<?php echo $output['img'][$value['sp_value_id']][$i]['goods_image'];?>" nctype="file_<?php echo $value['sp_value_id'] . $i;?>">
            </div>
            <div class="show-default<?php if ($output['img'][$value['sp_value_id']][$i]['is_default'] == 1) {echo ' selected';}?>" nctype="file_<?php echo $value['sp_value_id'] . $i;?>">
              <p><i class="icon-ok-circle"></i>默认主图
                <input type="hidden" name="img[<?php echo $value['sp_value_id'];?>][<?php echo $i;?>][default]" value="<?php if ( $output['img'][$value['sp_value_id']][$i]['is_default'] == 1) {echo '1';}else{echo '0';}?>">
              </p><a href="javascript:void(0)" nctype="del" class="del" title="移除">X</a>
            </div>
            <div class="show-sort">排序：<input name="img[<?php echo $value['sp_value_id'];?>][<?php echo $i;?>][sort]" type="text" class="text" value="<?php echo intval($output['img'][$value['sp_value_id']][$i]['goods_image_sort']);?>" size="1" maxlength="1">
            </div>
            <div class="ncsc-upload-btn"><a href="javascript:void(0);"><span><input type="file" hidefocus="true" size="1" class="input-file" name="file_<?php echo $value['sp_value_id'] . $i;?>" id="file_<?php echo $value['sp_value_id'] . $i;?>"></span><p><i class="icon-upload-alt"></i>上传</p>
              </a></div>
            
          </li>
          <?php }?>
        </ul>
        <div class="ncsc-select-album">
          <a class="ncsc-btn" href="index.php?act=store_album&op=pic_list&item=goods_image&color_id=<?php echo $value['sp_value_id'];?>" nctype="select-<?php echo $value['sp_value_id'];?>"><i class="icon-picture"></i>从图片空间选择</a>
          <a href="javascript:void(0);" nctype="close_album" class="ncsc-btn ml5" style="display: none;"><i class=" icon-circle-arrow-up"></i>关闭相册</a>
        </div>
        <div nctype="album-<?php echo $value['sp_value_id'];?>"></div>
      </div>
      <?php }?>
    </div>
    <div class="sidebar"><div class="alert alert-info alert-block" id="uploadHelp">
    <div class="faq-img"></div>
    <h4>上传要求：</h4><ul>
    <li>1. 请使用jpg\jpeg\png等格式、单张大小不超过<?php echo intval(C('image_max_filesize'))/1024;?>M的正方形图片。</li>
    <li>2. 上传图片最大尺寸将被保留为1280像素。</li>
    <li>3. 每种颜色最多可上传5张图片或从图片空间中选择已有的图片，上传后的图片也将被保存在店铺图片空间中以便其它使用。</li>
    <li>4. 通过更改排序数字修改商品图片的排列显示顺序。</li>
    <li>5. 图片质量要清晰，不能虚化，要保证亮度充足。</li>
    <li>6. 操作完成后请点下一步，否则无法在网站生效。</li>
    </ul><h4>建议:</h4><ul><li>1. 主图为白色背景正面图。</li><li>2. 排序依次为正面图->背面图->侧面图->细节图。</li></ul></div></div>
  </div>
  <?php }?>
  <div class="bottom tc hr32"><label class="submit-border"><input type="submit" class="submit" value="<?php if ($output['edit_goods_sign']) { echo '提交'; } else { ?><?php echo $lang['store_goods_add_next'];?>，确认商品发布<?php }?>" /></label></div>
</form>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/store_goods_add.step3.js" charset="utf-8"></script>
<script>
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
var DEFAULT_GOODS_IMAGE = "<?php echo UPLOAD_SITE_URL.DS.defaultGoodsImage(240);?>";
var SHOP_RESOURCE_SITE_URL = "<?php echo SHOP_RESOURCE_SITE_URL;?>";
$(function(){
    <?php if ($output['edit_goods_sign']) {?>
    $('input[type="submit"]').click(function(){
        ajaxpost('goods_image', '', '', 'onerror');
    });
    <?php }?>
    /* ajax打开图片空间 */
    <?php foreach ($output['value_array'] as $value) {?>
    $('a[nctype="select-<?php echo $value['sp_value_id'];?>"]').ajaxContent({
        event:'click', //mouseover
        loaderType:"img",
        loadingMsg:SHOP_TEMPLATES_URL+"/images/loading.gif",
        target:'div[nctype="album-<?php echo $value['sp_value_id'];?>"]'
    }).click(function(){
        $(this).hide();
        $(this).next().show();
    });
    <?php }?>
});
</script> 
