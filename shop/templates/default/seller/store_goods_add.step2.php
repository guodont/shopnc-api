<?php defined('InShopNC') or exit('Access Invalid!');?>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script>
<!--[if lt IE 8]>
  <script src="<?php echo RESOURCE_SITE_URL;?>/js/json2.js"></script>
<![endif]-->
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/store_goods_add.step2.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<style type="text/css">
#fixedNavBar { filter:progid:DXImageTransform.Microsoft.gradient(enabled='true',startColorstr='#CCFFFFFF', endColorstr='#CCFFFFFF');background:rgba(255,255,255,0.8); width: 90px; margin-left: 510px; border-radius: 4px; position: fixed; z-index: 999; top: 172px; left: 50%;}
#fixedNavBar h3 { font-size: 12px; line-height: 24px; text-align: center; margin-top: 4px;}
#fixedNavBar ul { width: 80px; margin: 0 auto 5px auto;}
#fixedNavBar li { margin-top: 5px;}
#fixedNavBar li a { font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 20px; background-color: #F5F5F5; color: #999; text-align: center; display: block;  height: 20px; border-radius: 10px;}
#fixedNavBar li a:hover { color: #FFF; text-decoration: none; background-color: #27a9e3;}
</style>

<div id="fixedNavBar">
<h3>页面导航</h3>
  <ul>
    <li><a id="demo1Btn" href="#demo1" class="demoBtn">基本信息</a></li>
    <li><a id="demo2Btn" href="#demo2" class="demoBtn">详情描述</a></li>
    <li><a id="demo3Btn" href="#demo3" class="demoBtn">特殊商品</a></li>
    <li><a id="demo4Btn" href="#demo4" class="demoBtn">物流运费</a></li>
    <li><a id="demo5Btn" href="#demo5" class="demoBtn">发票信息</a></li>
    <li><a id="demo6Btn" href="#demo6" class="demoBtn">其他信息</a></li>
  </ul>
</div>
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
  <li class="current"><i class="icon icon-edit"></i>
    <h6>STEP.2</h6>
    <h2>填写商品详情</h2>
    <i class="arrow icon-angle-right"></i> </li>
  <li><i class="icon icon-camera-retro "></i>
    <h6>STEP.3</h6>
    <h2>上传商品图片</h2>
    <i class="arrow icon-angle-right"></i> </li>
  <li><i class="icon icon-ok-circle"></i>
    <h6>STEP.4</h6>
    <h2>商品发布成功</h2>
  </li>
</ul>
<?php }?>
<div class="item-publish">
  <form method="post" id="goods_form" action="<?php if ($output['edit_goods_sign']) { echo urlShop('store_goods_online', 'edit_save_goods');} else { echo urlShop('store_goods_add', 'save_goods');}?>">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="commonid" value="<?php echo $output['goods']['goods_commonid'];?>" />
    <input type="hidden" name="type_id" value="<?php echo $output['goods_class']['type_id'];?>" />
    <input type="hidden" name="ref_url" value="<?php echo $_GET['ref_url'] ? $_GET['ref_url'] : getReferer();?>" />
    <div class="ncsc-form-goods">
      <h3 id="demo1"><?php echo $lang['store_goods_index_goods_base_info']?></h3>
      <dl>
        <dt><?php echo $lang['store_goods_index_goods_class'].$lang['nc_colon'];?></dt>
        <dd id="gcategory"> <?php echo $output['goods_class']['gc_tag_name'];?> <a class="ncsc-btn" href="<?php if ($output['edit_goods_sign']) { echo urlShop('store_goods_online', 'edit_class', array('commonid' => $output['goods']['goods_commonid'], 'ref_url' => getReferer())); } else { echo urlShop('store_goods_add', 'add_step_one'); }?>"><?php echo $lang['nc_edit'];?></a>
          <input type="hidden" id="cate_id" name="cate_id" value="<?php echo $output['goods_class']['gc_id'];?>" class="text" />
          <input type="hidden" name="cate_name" value="<?php echo $output['goods_class']['gc_tag_name'];?>" class="text"/>
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i><?php echo $lang['store_goods_index_goods_name'].$lang['nc_colon'];?></dt>
        <dd>
          <input name="g_name" type="text" class="text w400" value="<?php echo $output['goods']['goods_name']; ?>" />
          <span></span>
          <p class="hint"><?php echo $lang['store_goods_index_goods_name_help'];?></p>
        </dd>
      </dl>
      <dl>
        <dt>商品卖点<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <textarea name="g_jingle" class="textarea h60 w400"><?php echo $output['goods']['goods_jingle']; ?></textarea>
          <span></span>
          <p class="hint">商品卖点最长不能超过140个汉字</p>
        </dd>
      </dl>
      <dl>
        <dt nc_type="no_spec"><i class="required">*</i><?php echo $lang['store_goods_index_store_price'].$lang['nc_colon'];?></dt>
        <dd nc_type="no_spec">
          <input name="g_price" value="<?php echo $output['goods']['goods_price']; ?>" type="text"  class="text w60" /><em class="add-on"><i class="icon-renminbi"></i></em> <span></span>
          <p class="hint"><?php echo $lang['store_goods_index_store_price_help'];?>，且不能高于市场价。<br>
            此价格为商品实际销售价格，如果商品存在规格，该价格显示最低价格。</p>
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i>市场价<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input name="g_marketprice" value="<?php echo $output['goods']['goods_marketprice']; ?>" type="text" class="text w60" /><em class="add-on"><i class="icon-renminbi"></i></em> <span></span>
          <p class="hint"><?php echo $lang['store_goods_index_store_price_help'];?>，此价格仅为市场参考售价，请根据该实际情况认真填写。</p>
        </dd>
      </dl>
      <dl>
        <dt>成本价<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input name="g_costprice" value="<?php echo $output['goods']['goods_costprice']; ?>" type="text" class="text w60" /><em class="add-on"><i class="icon-renminbi"></i></em> <span></span>
          <p class="hint">价格必须是0.00~9999999之间的数字，此价格为商户对所销售的商品实际成本价格进行备注记录，非必填选项，不会在前台销售页面中显示。</p>
        </dd>
      </dl>
      <dl>
        <dt>折扣<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input name="g_discount" value="<?php echo $output['goods']['goods_discount']; ?>" type="text" class="text w60" readonly="readonly" style="background:#E7E7E7 none;" /><em class="add-on">%</em>
          <p class="hint">根据销售价与市场价比例自动生成，不需要编辑。</p>
        </dd>
      </dl>
      <?php if(is_array($output['spec_list']) && !empty($output['spec_list'])){?>
      <?php $i = '0';?>
      <?php foreach ($output['spec_list'] as $k=>$val){?>
      <dl nc_type="spec_group_dl_<?php echo $i;?>" nctype="spec_group_dl" class="spec-bg" <?php if($k == '1'){?>spec_img="t"<?php }?>>
        <dt>
          <input name="sp_name[<?php echo $k;?>]" type="text" class="text w60 tip2 tr" title="自定义规格类型名称，规格值名称最多不超过4个字" value="<?php if (isset($output['goods']['spec_name'][$k])) { echo $output['goods']['spec_name'][$k];} else {echo $val['sp_name'];}?>" maxlength="4" nctype="spec_name" data-param="{id:<?php echo $k;?>,name:'<?php echo $val['sp_name'];?>'}"/>
          <?php echo $lang['nc_colon']?></dt>
        <dd <?php if($k == '1'){?>nctype="sp_group_val"<?php }?>>
          <ul class="spec">
            <?php if(is_array($val['value'])){?>
            <?php foreach ($val['value'] as $v) {?>
            <li><span nctype="input_checkbox">
              <input type="checkbox" value="<?php echo $v['sp_value_name'];?>" nc_type="<?php echo $v['sp_value_id'];?>" <?php if($k == '1'){?>class="sp_val"<?php }?> name="sp_val[<?php echo $k;?>][<?php echo $v['sp_value_id']?>]">
              </span><span nctype="pv_name"><?php echo $v['sp_value_name'];?></span></li>
            <?php }?>
            <?php }?>
            <li data-param="{gc_id:<?php echo $output['goods_class']['gc_id'];?>,sp_id:<?php echo $k;?>,url:'<?php echo urlShop('store_goods_add', 'ajax_add_spec');?>'}">
              <div nctype="specAdd1"><a href="javascript:void(0);" class="ncsc-btn" nctype="specAdd"><i class="icon-plus"></i>添加规格值</a></div>
              <div nctype="specAdd2" style="display:none;">
                <input class="text w60" type="text" placeholder="规格值名称" maxlength="20">
                <a href="javascript:void(0);" nctype="specAddSubmit" class="ncsc-btn ncsc-btn-acidblue ml5 mr5">确认</a><a href="javascript:void(0);" nctype="specAddCancel" class="ncsc-btn ncsc-btn-orange">取消</a></div>
            </li>
          </ul>
          <?php if($output['edit_goods_sign'] && $k == '1'){?>
          <p class="hint">添加或取消颜色规格时，提交后请编辑图片以确保商品图片能够准确显示。</p>
          <?php }?>
        </dd>
      </dl>
      <?php $i++;?>
      <?php }?>
      <?php }?>
      <dl nc_type="spec_dl" class="spec-bg" style="display:none; overflow: visible;">
        <dt><?php echo $lang['srore_goods_index_goods_stock_set'].$lang['nc_colon'];?></dt>
        <dd class="spec-dd">
          <table border="0" cellpadding="0" cellspacing="0" class="spec_table">
            <thead>
              <?php if(is_array($output['spec_list']) && !empty($output['spec_list'])){?>
              <?php foreach ($output['spec_list'] as $k=>$val){?>
            <th nctype="spec_name_<?php echo $k;?>"><?php if (isset($output['goods']['spec_name'][$k])) { echo $output['goods']['spec_name'][$k];} else {echo $val['sp_name'];}?></th>
              <?php }?>
              <?php }?>
              <th class="w90"><span class="red">*</span>市场价
                <div class="batch"><i class="icon-edit" title="批量操作"></i>
                  <div class="batch-input" style="display:none;">
                    <h6>批量设置价格：</h6>
                    <a href="javascript:void(0)" class="close">X</a>
                    <input name="" type="text" class="text price" />
                    <a href="javascript:void(0)" class="ncsc-btn-mini" data-type="marketprice">设置</a><span class="arrow"></span></div>
                </div></th>
              <th class="w90"><span class="red">*</span><?php echo $lang['store_goods_index_price'];?>
                <div class="batch"><i class="icon-edit" title="批量操作"></i>
                  <div class="batch-input" style="display:none;">
                    <h6>批量设置价格：</h6>
                    <a href="javascript:void(0)" class="close">X</a>
                    <input name="" type="text" class="text price" />
                    <a href="javascript:void(0)" class="ncsc-btn-mini" data-type="price">设置</a><span class="arrow"></span></div>
                </div></th>
              <th class="w60"><span class="red">*</span><?php echo $lang['store_goods_index_stock'];?>
                <div class="batch"><i class="icon-edit" title="批量操作"></i>
                  <div class="batch-input" style="display:none;">
                    <h6>批量设置库存：</h6>
                    <a href="javascript:void(0)" class="close">X</a>
                    <input name="" type="text" class="text stock" />
                    <a href="javascript:void(0)" class="ncsc-btn-mini" data-type="stock">设置</a><span class="arrow"></span></div>
                </div></th>
              <th class="w70">预警值
                <div class="batch"><i class="icon-edit" title="批量操作"></i>
                  <div class="batch-input" style="display:none;">
                    <h6>批量设置预警值：</h6>
                    <a href="javascript:void(0)" class="close">X</a>
                    <input name="" type="text" class="text stock" />
                    <a href="javascript:void(0)" class="ncsc-btn-mini" data-type="alarm">设置</a><span class="arrow"></span></div>
                </div></th>
              <th class="w100"><?php echo $lang['store_goods_index_goods_no'];?></th>
                </thead>
            <tbody nc_type="spec_table">
            </tbody>
          </table>
          <p class="hint">点击<i class="icon-edit"></i>可批量修改所在列的值。</p>
        </dd>
      </dl>
      <dl>
        <dt nc_type="no_spec"><i class="required">*</i><?php echo $lang['store_goods_index_goods_stock'].$lang['nc_colon'];?></dt>
        <dd nc_type="no_spec">
          <input name="g_storage" value="<?php echo $output['goods']['g_storage']; ?>" type="text" class="text w60" />
          <span></span>
          <p class="hint"><?php echo $lang['store_goods_index_goods_stock_help'];?></p>
        </dd>
      </dl>
      <dl>
        <dt>库存预警值<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input name="g_alarm" value="<?php echo $output['goods']['goods_storage_alarm'];?>" type="text" class="text w60" />
          <span></span>
          <p class="hint">设置最低库存预警值。当库存低于预警值时商家中心商品列表页库存列红字提醒。<br>
            请填写0~255的数字，0为不预警。</p>
        </dd>
      </dl>
      <dl>
        <dt nc_type="no_spec"><?php echo $lang['store_goods_index_goods_no'].$lang['nc_colon'];?></dt>
        <dd nc_type="no_spec">
          <p>
            <input name="g_serial" value="<?php echo $output['goods']['goods_serial']; ?>" type="text"  class="text"  />
          </p>
          <p class="hint"><?php echo $lang['store_goods_index_goods_no_help'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i><?php echo $lang['store_goods_album_goods_pic'].$lang['nc_colon'];?></dt>
        <dd>
          <div class="ncsc-goods-default-pic">
            <div class="goodspic-uplaod">
              <div class="upload-thumb"> <img nctype="goods_image" src="<?php echo thumb($output['goods'], 240);?>"/> </div>
              <input type="hidden" name="image_path" id="image_path" nctype="goods_image" value="<?php echo $output['goods']['goods_image']?>" />
              <span></span>
              <p class="hint"><?php echo $lang['store_goods_step2_description_one'];?><?php printf($lang['store_goods_step2_description_two'],intval(C('image_max_filesize'))/1024);?></p>
              <div class="handle">
                <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
                  <input type="file" hidefocus="true" size="1" class="input-file" name="goods_image" id="goods_image">
                  </span>
                  <p><i class="icon-upload-alt"></i>图片上传</p>
                  </a> </div>
                <a class="ncsc-btn mt5" nctype="show_image" href="<?php echo urlShop('store_album', 'pic_list', array('item'=>'goods'));?>"><i class="icon-picture"></i>从图片空间选择</a> <a href="javascript:void(0);" nctype="del_goods_demo" class="ncsc-btn mt5" style="display: none;"><i class="icon-circle-arrow-up"></i>关闭相册</a></div>
            </div>
          </div>
          <div id="demo"></div>
        </dd>
      </dl>
      <h3 id="demo2"><?php echo $lang['store_goods_index_goods_detail_info']?></h3>
      <dl style="overflow: visible;">
        <dt><?php echo $lang['store_goods_index_goods_brand'].$lang['nc_colon'];?></dt>
        <dd>
          <div class="ncsc-brand-select">
            <div class="selection">
              <input name="b_name" id="b_name" value="<?php echo $output['goods']['brand_name'];?>" type="text" class="text w180" readonly="readonly" />
              <input type="hidden" name="b_id" id="b_id" value="<?php echo $output['goods']['brand_id'];?>" />
              <em class="add-on" nctype="add-on"><i class="icon-collapse"></i></em></div>
            <div class="ncsc-brand-select-container">
              <div class="brand-index" data-tid="<?php echo $output['goods_class']['type_id'];?>" data-url="<?php echo urlShop('store_goods_add', 'ajax_get_brand');?>">
                <div class="letter" nctype="letter">
                  <ul>
                    <li><a href="javascript:void(0);" data-letter="all">全部</a></li>
                    <li><a href="javascript:void(0);" data-letter="A">A</a></li>
                    <li><a href="javascript:void(0);" data-letter="B">B</a></li>
                    <li><a href="javascript:void(0);" data-letter="C">C</a></li>
                    <li><a href="javascript:void(0);" data-letter="D">D</a></li>
                    <li><a href="javascript:void(0);" data-letter="E">E</a></li>
                    <li><a href="javascript:void(0);" data-letter="F">F</a></li>
                    <li><a href="javascript:void(0);" data-letter="G">G</a></li>
                    <li><a href="javascript:void(0);" data-letter="H">H</a></li>
                    <li><a href="javascript:void(0);" data-letter="I">I</a></li>
                    <li><a href="javascript:void(0);" data-letter="J">J</a></li>
                    <li><a href="javascript:void(0);" data-letter="K">K</a></li>
                    <li><a href="javascript:void(0);" data-letter="L">L</a></li>
                    <li><a href="javascript:void(0);" data-letter="M">M</a></li>
                    <li><a href="javascript:void(0);" data-letter="N">N</a></li>
                    <li><a href="javascript:void(0);" data-letter="O">O</a></li>
                    <li><a href="javascript:void(0);" data-letter="P">P</a></li>
                    <li><a href="javascript:void(0);" data-letter="Q">Q</a></li>
                    <li><a href="javascript:void(0);" data-letter="R">R</a></li>
                    <li><a href="javascript:void(0);" data-letter="S">S</a></li>
                    <li><a href="javascript:void(0);" data-letter="T">T</a></li>
                    <li><a href="javascript:void(0);" data-letter="U">U</a></li>
                    <li><a href="javascript:void(0);" data-letter="V">V</a></li>
                    <li><a href="javascript:void(0);" data-letter="W">W</a></li>
                    <li><a href="javascript:void(0);" data-letter="X">X</a></li>
                    <li><a href="javascript:void(0);" data-letter="Y">Y</a></li>
                    <li><a href="javascript:void(0);" data-letter="Z">Z</a></li>
                    <li><a href="javascript:void(0);" data-letter="0-9">其他</a></li>
                    <li><a href="javascript:void(0);" data-empty="0">清空</a></li>
                  </ul>
                </div>
                <div class="search" nctype="search">
                  <input name="search_brand_keyword" id="search_brand_keyword" type="text" class="text" placeholder="品牌名称关键字查找"/><a href="javascript:void(0);" class="ncsc-btn-mini" style="vertical-align: top;">Go</a></div>
              </div>
              <div class="brand-list" nctype="brandList">
                <ul nctype="brand_list">
                  <?php if(is_array($output['brand_list']) && !empty($output['brand_list'])){?>
                  <?php foreach($output['brand_list'] as $val) { ?>
                  <li data-id='<?php echo $val['brand_id'];?>'data-name='<?php echo $val['brand_name'];?>'><em><?php echo $val['brand_initial'];?></em><?php echo $val['brand_name'];?></li>
                  <?php } ?>
                  <?php }?>
                </ul>
              </div>
              <div class="no-result" nctype="noBrandList" style="display: none;">没有符合"<strong>搜索关键字</strong>"条件的品牌</div>
            </div>
          </div>
        </dd>
      </dl>
      <?php if(is_array($output['attr_list']) && !empty($output['attr_list'])){?>
      <dl>
        <dt><?php echo $lang['store_goods_index_goods_attr'].$lang['nc_colon']; ?></dt>
        <dd>
          <?php foreach ($output['attr_list'] as $k=>$val){?>
          <span class="mr30">
          <label class="mr5"><?php echo $val['attr_name']?></label>
          <input type="hidden" name="attr[<?php echo $k;?>][name]" value="<?php echo $val['attr_name']?>" />
          <?php if(is_array($val) && !empty($val)){?>
          <select name="" attr="attr[<?php echo $k;?>][__NC__]" nc_type="attr_select">
            <option value='不限' nc_type='0'>不限</option>
            <?php foreach ($val['value'] as $v){?>
            <option value="<?php echo $v['attr_value_name']?>" <?php if(isset($output['attr_checked']) && in_array($v['attr_value_id'], $output['attr_checked'])){?>selected="selected"<?php }?> nc_type="<?php echo $v['attr_value_id'];?>"><?php echo $v['attr_value_name'];?></option>
            <?php }?>
          </select>
          <?php }?>
          </span>
          <?php }?>
        </dd>
      </dl>
      <?php }?>
      <dl>
        <dt><?php echo $lang['store_goods_index_goods_desc'].$lang['nc_colon'];?></dt>
        <dd id="ncProductDetails">
          <div class="tabs">
            <ul class="ui-tabs-nav" jquery1239647486215="2">
              <li class="ui-tabs-selected"><a href="#panel-1" jquery1239647486215="8"><i class="icon-desktop"></i> 电脑端</a></li>
              <li class="selected"><a href="#panel-2" jquery1239647486215="9"><i class="icon-mobile-phone"></i>手机端</a></li>
            </ul>
            <div id="panel-1" class="ui-tabs-panel" jquery1239647486215="4">
              <?php showEditor('g_body',$output['goods']['goods_body'],'100%','480px','visibility:hidden;',"false",$output['editor_multimedia']);?>
              <div class="hr8">
                <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
                  <input type="file" hidefocus="true" size="1" class="input-file" name="add_album" id="add_album" multiple="multiple">
                  </span>
                  <p><i class="icon-upload-alt" data_type="0" nctype="add_album_i"></i>图片上传</p>
                  </a> </div>
                <a class="ncsc-btn mt5" nctype="show_desc" href="index.php?act=store_album&op=pic_list&item=des"><i class="icon-picture"></i><?php echo $lang['store_goods_album_insert_users_photo'];?></a> <a href="javascript:void(0);" nctype="del_desc" class="ncsc-btn mt5" style="display: none;"><i class=" icon-circle-arrow-up"></i>关闭相册</a> </div>
              <p id="des_demo"></p>
            </div>
            <div id="panel-2" class="ui-tabs-panel ui-tabs-hide" jquery1239647486215="5">
              <div class="ncsc-mobile-editor">
                <div class="pannel">
                  <div class="size-tip"><span nctype="img_count_tip">图片总数得超过<em>20</em>张</span><i>|</i><span nctype="txt_count_tip">文字不得超过<em>5000</em>字</span></div>
                  <div class="control-panel" nctype="mobile_pannel">
                    <?php if (!empty($output['goods']['mb_body'])) {?>
                    <?php foreach ($output['goods']['mb_body'] as $val) {?>
                    <?php if ($val['type'] == 'text') {?>
                    <div class="module m-text">
                      <div class="tools"><a nctype="mp_up" href="javascript:void(0);">上移</a><a nctype="mp_down" href="javascript:void(0);">下移</a><a nctype="mp_edit" href="javascript:void(0);">编辑</a><a nctype="mp_del" href="javascript:void(0);">删除</a></div>
                      <div class="content">
                        <div class="text-div"><?php echo $val['value'];?></div>
                      </div>
                      <div class="cover"></div>
                    </div>
                    <?php }?>
                    <?php if ($val['type'] == 'image') {?>
                    <div class="module m-image">
                      <div class="tools"><a nctype="mp_up" href="javascript:void(0);">上移</a><a nctype="mp_down" href="javascript:void(0);">下移</a><a nctype="mp_rpl" href="javascript:void(0);">替换</a><a nctype="mp_del" href="javascript:void(0);">删除</a></div>
                      <div class="content">
                        <div class="image-div"><img src="<?php echo $val['value'];?>"></div>
                      </div>
                      <div class="cover"></div>
                    </div>
                    <?php }?>
                    <?php }?>
                    <?php }?>
                  </div>
                  <div class="add-btn">
                    <ul class="btn-wrap">
                      <li><a href="javascript:void(0);" nctype="mb_add_img"><i class="icon-picture"></i>
                        <p>图片</p>
                        </a></li>
                      <li><a href="javascript:void(0);" nctype="mb_add_txt"><i class="icon-font"></i>
                        <p>文字</p>
                        </a></li>
                    </ul>
                  </div>
                </div>
                <div class="explain">
                  <dl>
                    <dt>1、基本要求：</dt>
                    <dd>（1）手机详情总体大小：图片+文字，图片不超过20张，文字不超过5000字；</dd>
                    <dd>建议：所有图片都是本宝贝相关的图片。</dd>
                  </dl><dl>
                    <dt>2、图片大小要求：</dt>
                    <dd>（1）建议使用宽度480 ~ 620像素、高度小于等于960像素的图片；</dd>
                    <dd>（2）格式为：JPG\JEPG\GIF\PNG；</dd>
                    <dd>举例：可以上传一张宽度为480，高度为960像素，格式为JPG的图片。</dd>
                  </dl><dl>
                    <dt>3、文字要求：</dt>
                    <dd>（1）每次插入文字不能超过500个字，标点、特殊字符按照一个字计算；</dd>
                    <dd>建议：不要添加太多的文字，这样看起来更清晰。</dd>
                  </dl>
                </div>
              </div>
              <div class="ncsc-mobile-edit-area" nctype="mobile_editor_area">
                <div nctype="mea_img" class="ncsc-mea-img" style="display: none;"></div>
                <div class="ncsc-mea-text" nctype="mea_txt" style="display: none;">
                  <p id="meat_content_count" class="text-tip"></p>
                  <textarea class="textarea valid" nctype="meat_content"></textarea>
                  <div class="button"><a class="ncsc-btn ncsc-btn-blue" nctype="meat_submit" href="javascript:void(0);">确认</a><a class="ncsc-btn ml10" nctype="meat_cancel" href="javascript:void(0);">取消</a></div>
                  <a class="text-close" nctype="meat_cancel" href="javascript:void(0);">X</a>
                </div>
              </div>
              <input name="m_body" autocomplete="off" type="hidden" value='<?php echo $output['goods']['mobile_body'];?>'>
            </div>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>关联版式：</dt>
        <dd> <span class="mr50">
          <label>顶部版式</label>
          <select name="plate_top">
            <option>请选择</option>
            <?php if (!empty($output['plate_list'][1])) {?>
            <?php foreach ($output['plate_list'][1] as $val) {?>
            <option value="<?php echo $val['plate_id']?>" <?php if ($output['goods']['plateid_top'] == $val['plate_id']) {?>selected="selected"<?php }?>><?php echo $val['plate_name'];?></option>
            <?php }?>
            <?php }?>
          </select>
          </span> <span class="mr50">
          <label>底部版式</label>
          <select name="plate_bottom">
            <option>请选择</option>
            <?php if (!empty($output['plate_list'][0])) {?>
            <?php foreach ($output['plate_list'][0] as $val) {?>
            <option value="<?php echo $val['plate_id']?>" <?php if ($output['goods']['plateid_bottom'] == $val['plate_id']) {?>selected="selected"<?php }?>><?php echo $val['plate_name'];?></option>
            <?php }?>
            <?php }?>
          </select>
          </span> </dd>
      </dl>
      <h3 id="demo3">特殊商品</h3>
      <!-- 只有可发布虚拟商品才会显示 S -->
      <?php if ($output['goods_class']['gc_virtual'] == 1) {?>
      <dl class="special-01">
        <dt>虚拟商品<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <ul class="ncsc-form-radio-list">
            <li>
              <input type="radio" name="is_gv" value="1" id="is_gv_1" <?php if ($output['goods']['is_virtual'] == 1) {?>checked<?php }?>>
              <label for="is_gv_1">是</label>
            </li>
            <li>
              <input type="radio" name="is_gv" value="0" id="is_gv_0" <?php if ($output['goods']['is_virtual'] == 0) {?>checked<?php }?>>
              <label for="is_gv_0">否</label>
            </li>
          </ul>
          <p class="hint vital">*虚拟商品不能参加限时折扣和组合销售两种促销活动。也不能赠送赠品和推荐搭配。</p>
        </dd>
      </dl>
      <dl class="special-01" nctype="virtual_valid" <?php if ($output['goods']['is_virtual'] == 0) {?>style="display:none;"<?php }?>>
        <dt><i class="required">*</i>虚拟商品有效期至<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input type="text" name="g_vindate" id="g_vindate" class="w80 text" value="<?php if($output['goods']['is_virtual'] == 1 && !empty($output['goods']['virtual_indate'])) { echo date('Y-m-d', $output['goods']['virtual_indate']);}?>"><em class="add-on"><i class="icon-calendar"></i></em>
          <span></span>
          <p class="hint">虚拟商品可兑换的有效期，过期后商品不能购买，电子兑换码不能使用。</p>
        </dd>
      </dl>
      <dl class="special-01" nctype="virtual_valid" <?php if ($output['goods']['is_virtual'] == 0) {?>style="display:none;"<?php }?>>
        <dt><i class="required">*</i>虚拟商品购买上限<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input type="text" name="g_vlimit" id="g_vlimit" class="w80 text" value="<?php if ($output['goods']['is_virtual'] == 1) {echo $output['goods']['virtual_limit'];}?>">
          <span></span>
          <p class="hint">请填写1~10之间的数字，虚拟商品最高购买数量不能超过10个。</p>
        </dd>
      </dl>
      <dl class="special-01" nctype="virtual_valid" <?php if ($output['goods']['is_virtual'] == 0) {?>style="display:none;"<?php }?>>
        <dt>支持过期退款<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <ul class="ncsc-form-radio-list">
            <li>
              <input type="radio" name="g_vinvalidrefund" id="g_vinvalidrefund_1" value="1" <?php if ($output['goods']['virtual_invalid_refund'] ==1) {?>checked<?php }?>>
              <label for="g_vinvalidrefund_1">是</label>
            </li>
            <li>
              <input type="radio" name="g_vinvalidrefund" id="g_vinvalidrefund_0" value="0" <?php if ($output['goods']['virtual_invalid_refund'] == 0) {?>checked<?php }?>>
              <label for="g_vinvalidrefund_0">否</label>
            </li>
          </ul>
          <p class="hint">兑换码过期后是否可以申请退款。</p>
        </dd>
      </dl>
      <?php }?>
      <!-- 只有可发布虚拟商品才会显示 E --> 
      <!-- F码商品专有项 S -->
      <dl class="special-02" nctype="virtual_null" <?php if ($output['goods']['is_virtual'] == 1) {?>style="display:none;"<?php }?>>
        <dt>F码商品<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <ul class="ncsc-form-radio-list">
            <li>
              <input type="radio" name="is_fc" id="is_fc_1" value="1" <?php if ($output['goods']['is_fcode'] == 1) {?>checked<?php }?>>
              <label for="is_fc_1">是</label>
            </li>
            <li>
              <input type="radio" name="is_fc" id="is_fc_0" value="0" <?php if ($output['goods']['is_fcode'] == 0) {?>checked<?php }?>>
              <label for="is_fc_0">否</label>
            </li>
          </ul>
          <p class="hint vital">*F码商品不能参加抢购、限时折扣和组合销售三种促销活动。也不能预售和推荐搭配。</p>
        </dd>
      </dl>
      <dl class="special-02" nctype="fcode_valid" <?php if ($output['goods']['is_fcode'] == 0) {?>style="display:none;"<?php }?>>
        <dt>
          <?php if (!$output['edit_goods_sign']) {?>
          <i class="required">*</i>
          <?php }?>
          生成F码数量<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input type="text" name="g_fccount" id="g_fccount" class="w80 text" value="">
          <span></span>
          <p class="hint">请填写100以内的数字。编辑商品时添加F码会不计算原有F码数量继续生成相应数量。</p>
        </dd>
      </dl>
      <dl class="special-02" nctype="fcode_valid" <?php if ($output['goods']['is_fcode'] == 0) {?>style="display:none;"<?php }?>>
        <dt>
          <?php if (!$output['edit_goods_sign']) {?>
          <i class="required">*</i>
          <?php }?>
          F码前缀<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input type="text" name="g_fcprefix" id="g_fcprefix" class="w80 text" value="">
          <span></span>
          <p class="hint">请填写3~5位的英文字母。建议每次生成的F码使用不同的前缀。</p>
        </dd>
      </dl>
      <?php if ($output['goods']['is_fcode'] == 1) {?>
      <dl class="special-02" nctype="fcode_valid">
        <dt>
            <a class="ncsc-btn-mini ncsc-btn-red" href="<?php echo urlShop('store_goods_online', 'download_f_code_excel', array('commonid' => $val['goods_commonid']));?>">下载F码</a>&nbsp;&nbsp;F码<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <ul class="ncsc-form-radio-list">
            <?php if (!empty($output['fcode_array'])) {?>
            <?php foreach ($output['fcode_array'] as $val) {?>
            <li><?php echo $val['fc_code']?>(
              <?php if ($val['fc_state'] == 1) {?>
              使用
              <?php } else {?>
              未用
              <?php }?>
              )</li>
            <?php }?>
            <?php }?>
          </ul>
        </dd>
      </dl>
      <?php }?>
      <!-- F码商品专有项 E --> 
      <!-- 预售商品 S -->
      <dl class="special-03" nctype="virtual_null" <?php if ($output['goods']['is_virtual'] == 1) {?>style="display:none;"<?php }?>>
        <dt>预售<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <ul class="ncsc-form-radio-list">
            <li>
              <input type="radio" name="is_presell" id="is_presell_1" value="1" <?php if($output['goods']['is_presell'] == 1) {?>checked<?php }?>>
              <label for="is_presell_1">是</label>
            </li>
            <li>
              <input type="radio" name="is_presell" id="is_presell_0" value="0" <?php if($output['goods']['is_presell'] == 0) {?>checked<?php }?>>
              <label for="is_presell_0">否</label>
            </li>
          </ul>
          <p class="hint vital">*预售商品不能参加抢购、限时折扣和组合销售三种促销活动。也不能推荐搭配。</p>
        </dd>
      </dl>
      <dl class="special-03" nctype="is_presell" <?php if ($output['goods']['is_presell'] == 0) {?>style="display:none;"<?php }?>>
        <dt><i class="required">*</i>发货日期<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input type="text" name="g_deliverdate" id="g_deliverdate" class="w80 text" value="<?php if ($output['goods']['presell_deliverdate'] > 0) {echo date('Y-m-d', $output['goods']['presell_deliverdate']);}?>"><em class="add-on"><i class="icon-calendar"></i></em>
          <span></span>
          <p class="hint">商家发货时间。</p>
        </dd>
      </dl>
      <!-- 预售商品 E --> 
      <!-- 商品物流信息 S -->
      <h3 id="demo4"><?php echo $lang['store_goods_index_goods_transport']?></h3>
      <dl>
        <dt><?php echo $lang['store_goods_index_goods_szd'].$lang['nc_colon']?></dt>
        <dd>
          <p id="region">
            <select class="d_inline" name="province_id" id="province_id">
            </select>
          </p>
        </dd>
      </dl>
      <dl nctype="virtual_null" <?php if ($output['goods']['is_virtual'] == 1) {?>style="display:none;"<?php }?>>
        <dt><?php echo $lang['store_goods_index_goods_transfee_charge'].$lang['nc_colon']; ?></dt>
        <dd>
          <ul class="ncsc-form-radio-list">
            <li>
              <input id="freight_0" nctype="freight" name="freight" class="radio" type="radio" <?php if (intval($output['goods']['transport_id']) == 0) {?>checked="checked"<?php }?> value="0">
              <label for="freight_0">固定运费</label>
              <div nctype="div_freight" <?php if (intval($output['goods']['transport_id']) != 0) {?>style="display: none;"<?php }?>>
                <input id="g_freight" class="w50 text" nc_type='transport' type="text" value="<?php printf('%.2f', floatval($output['goods']['goods_freight']));?>" name="g_freight"><em class="add-on"><i class="icon-renminbi"></i></em> </div>
            </li>
            <li>
              <input id="freight_1" nctype="freight" name="freight" class="radio" type="radio" <?php if (intval($output['goods']['transport_id']) != 0) {?>checked="checked"<?php }?> value="1">
              <label for="freight_1"><?php echo $lang['store_goods_index_use_tpl'];?></label>
              <div nctype="div_freight" <?php if (intval($output['goods']['transport_id']) == 0) {?>style="display: none;"<?php }?>>
                <input id="transport_id" type="hidden" value="<?php echo $output['goods']['transport_id'];?>" name="transport_id">
                <input id="transport_title" type="hidden" value="<?php echo $output['goods']['transport_title'];?>" name="transport_title">
                <span id="postageName" class="transport-name" <?php if ($output['goods']['transport_title'] != '') {?>style="display: inline-block;"<?php }?>><?php echo $output['goods']['transport_title'];?></span><a href="JavaScript:void(0);" onclick="window.open('index.php?act=store_transport&type=select')" class="ncsc-btn" id="postageButton"><i class="icon-truck"></i><?php echo $lang['store_goods_index_select_tpl'];?></a> </div>
            </li>
          </ul>
          <p class="hint">运费设置为 0 元，前台商品将显示为免运费。</p>
        </dd>
      </dl>
      <!-- 商品物流信息 E -->
      <h3 id="demo5" nctype="virtual_null" <?php if ($output['goods']['is_virtual'] == 1) {?>style="display:none;"<?php }?>>发票信息</h3>
      <dl nctype="virtual_null" <?php if ($output['goods']['is_virtual'] == 1) {?>style="display:none;"<?php }?>>
        <dt>是否开增值税发票：</dt>
        <dd>
          <ul class="ncsc-form-radio-list">
            <li>
              <label>
                <input name="g_vat" value="1" <?php if (!empty($output['goods']) && $output['goods']['goods_vat'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                <?php echo $lang['nc_yes'];?></label>
            </li>
            <li>
              <label>
                <input name="g_vat" value="0" <?php if (empty($output['goods']) || $output['goods']['goods_vat'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                <?php echo $lang['nc_no'];?></label>
            </li>
          </ul>
          <p class="hint"></p>
        </dd>
      </dl>
      <h3 id="demo6"><?php echo $lang['store_goods_index_goods_other_info']?></h3>
      <dl>
        <dt><?php echo $lang['store_goods_index_store_goods_class'].$lang['nc_colon'];?></dt>
        <dd><span class="new_add"><a href="javascript:void(0)" id="add_sgcategory" class="ncsc-btn"><?php echo $lang['store_goods_index_new_class'];?></a> </span>
          <?php if (!empty($output['store_class_goods'])) { ?>
          <?php foreach ($output['store_class_goods'] as $v) { ?>
          <select name="sgcate_id[]" class="sgcategory">
            <option value="0"><?php echo $lang['nc_please_choose'];?></option>
            <?php foreach ($output['store_goods_class'] as $val) { ?>
            <option value="<?php echo $val['stc_id']; ?>" <?php if ($v==$val['stc_id']) { ?>selected="selected"<?php } ?>><?php echo $val['stc_name']; ?></option>
            <?php if (is_array($val['child']) && count($val['child'])>0){?>
            <?php foreach ($val['child'] as $child_val){?>
            <option value="<?php echo $child_val['stc_id']; ?>" <?php if ($v==$child_val['stc_id']) { ?>selected="selected"<?php } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
            <?php }?>
            <?php }?>
            <?php } ?>
          </select>
          <?php } ?>
          <?php } else { ?>
          <select name="sgcate_id[]" class="sgcategory">
            <option value="0"><?php echo $lang['nc_please_choose'];?></option>
            <?php if (!empty($output['store_goods_class'])){?>
            <?php foreach ($output['store_goods_class'] as $val) { ?>
            <option value="<?php echo $val['stc_id']; ?>"><?php echo $val['stc_name']; ?></option>
            <?php if (is_array($val['child']) && count($val['child'])>0){?>
            <?php foreach ($val['child'] as $child_val){?>
            <option value="<?php echo $child_val['stc_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
            <?php }?>
            <?php }?>
            <?php } ?>
            <?php } ?>
          </select>
          <?php } ?>
          <p class="hint"><?php echo $lang['store_goods_index_belong_multiple_store_class'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_index_goods_show'].$lang['nc_colon'];?></dt>
        <dd>
          <ul class="ncsc-form-radio-list">
            <li>
              <label>
                <input name="g_state" value="1" type="radio" <?php if (empty($output['goods']) || $output['goods']['goods_state'] == 1 || $output['goods']['goods_state'] == 10) {?>checked="checked"<?php }?> />
                <?php echo $lang['store_goods_index_immediately_sales'];?> </label>
            </li>
            <li>
              <label>
                <input name="g_state" value="0" type="radio" nctype="auto" />
                <?php echo $lang['store_goods_step2_start_time'];?> </label>
              <input type="text" class="w80 text" name="starttime" disabled="disabled" style="background:#E7E7E7 none;" id="starttime" value="<?php echo date('Y-m-d');?>" />
              <select disabled="disabled" style="background:#E7E7E7 none;" name="starttime_H" id="starttime_H">
                <?php foreach ($output['hour_array'] as $val){?>
                <option value="<?php echo $val;?>" <?php $sign_h = 0;if($val>=date('h') && $sign_h != 1){?>selected="selected"<?php $sign_H = 1;}?>><?php echo $val;?></option>
                <?php }?>
              </select>
              <?php echo $lang['store_goods_step2_hour'];?>
              <select disabled="disabled" style="background:#E7E7E7 none;" name="starttime_i" id="starttime_i">
                <?php foreach ($output['minute_array'] as $val){?>
                <option value="<?php echo $val;?>" <?php $sign_i = 0;if($val>=date('i') && $sign_i != 1){?>selected="selected"<?php $sign_i = 1;}?>><?php echo $val;?></option>
                <?php }?>
              </select>
              <?php echo $lang['store_goods_step2_minute'];?> </li>
            <li>
              <label>
                <input name="g_state" value="0" type="radio" <?php if (!empty($output['goods']) && $output['goods']['goods_state'] == 0) {?>checked="checked"<?php }?> />
                <?php echo $lang['store_goods_index_in_warehouse'];?> </label>
            </li>
          </ul>
        </dd>
      </dl>
      <dl>
        <dt>预约<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <ul class="ncsc-form-radio-list">
            <li>
              <input type="radio" name="is_appoint" id="is_appoint_1" value="1"  <?php if($output['goods']['is_appoint'] == 1) {?>checked<?php }?>>
              <label for="is_appoint_1">是</label>
            </li>
            <li>
              <input type="radio" name="is_appoint" id="is_appoint_0" value="0"  <?php if($output['goods']['is_appoint'] == 0) {?>checked<?php }?>>
              <label for="is_appoint_0">否</label>
            </li>
          </ul>
          <p class="hint">只有库存为零的商品才可以设为预约商品。商家补货后，平台自动发布消息通知已经预约的会员。</p>
        </dd>
      </dl>
      <dl nctype="is_appoint"  <?php if ($output['goods']['is_appoint'] == 0) {?>style="display:none;"<?php }?>>
        <dt><i class="required">*</i>发售日期<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input type="text" name="g_saledate" id="g_saledate" class="w80 text" value="<?php if ($output['goods']['appoint_satedate'] > 0) {echo date('Y-m-d', $output['goods']['appoint_satedate']);}?>">
          <span></span>
          <p class="hint">预约商品的发售日期。</p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_index_goods_recommend'].$lang['nc_colon'];?></dt>
        <dd>
          <ul class="ncsc-form-radio-list">
            <li>
              <label>
                <input name="g_commend" value="1" <?php if (empty($output['goods']) || $output['goods']['goods_commend'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                <?php echo $lang['nc_yes'];?></label>
            </li>
            <li>
              <label>
                <input name="g_commend" value="0" <?php if (!empty($output['goods']) && $output['goods']['goods_commend'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                <?php echo $lang['nc_no'];?></label>
            </li>
          </ul>
          <p class="hint"><?php echo $lang['store_goods_index_recommend_tip'];?></p>
        </dd>
      </dl>
    </div>
    <div class="bottom tc hr32">
      <label class="submit-border">
        <input type="submit" class="submit" value="<?php if ($output['edit_goods_sign']) {echo '提交';} else {?><?php echo $lang['store_goods_add_next'];?>，上传商品图片<?php }?>" />
      </label>
    </div>
  </form>
</div>
<script type="text/javascript">
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
var DEFAULT_GOODS_IMAGE = "<?php echo thumb(array(), 60);?>";
var SHOP_RESOURCE_SITE_URL = "<?php echo SHOP_RESOURCE_SITE_URL;?>";

$(function(){
	//电脑端手机端tab切换
	$(".tabs").tabs();
	
    $.validator.addMethod('checkPrice', function(value,element){
    	_g_price = parseFloat($('input[name="g_price"]').val());
        _g_marketprice = parseFloat($('input[name="g_marketprice"]').val());
        if (_g_price > _g_marketprice) {
            return false;
        }else {
            return true;
        }
    }, '<i class="icon-exclamation-sign"></i>商品价格不能高于市场价格');
	jQuery.validator.addMethod("checkFCodePrefix", function(value, element) {       
		return this.optional(element) || /^[a-zA-Z]+$/.test(value);       
	},'<i class="icon-exclamation-sign"></i>请填写不多于5位的英文字母');  
    $('#goods_form').validate({
        errorPlacement: function(error, element){
            $(element).nextAll('span').append(error);
        },
        <?php if ($output['edit_goods_sign']) {?>
        submitHandler:function(form){
            ajaxpost('goods_form', '', '', 'onerror');
        },
        <?php }?>
        rules : {
            g_name : {
                required    : true,
                minlength   : 3,
                maxlength   : 50
            },
            g_jingle : {
                maxlength   : 140
            },
            g_price : {
                required    : true,
                number      : true,
                min         : 0.01,
                max         : 9999999,
                checkPrice  : true
            },
            g_marketprice : {
                required    : true,
                number      : true,
                min         : 0.01,
                max         : 9999999
            },
            g_costprice : {
                number      : true,
                min         : 0.00,
                max         : 9999999
            },
            g_storage  : {
                required    : true,
                digits      : true,
                min         : 0,
                max         : 999999999
            },
            image_path : {
                required    : true
            },
            g_vindate : {
                required    : function() {if ($("#is_gv_1").prop("checked")) {return true;} else {return false;}}
            },
			g_vlimit : {
				required	: function() {if ($("#is_gv_1").prop("checked")) {return true;} else {return false;}},
				range		: [1,10]
			},
			g_fccount : {
				<?php if (!$output['edit_goods_sign']) {?>required	: function() {if ($("#is_fc_1").prop("checked")) {return true;} else {return false;}},<?php }?>
				range		: [1,100]
			},
			g_fcprefix : {
				<?php if (!$output['edit_goods_sign']) {?>required	: function() {if ($("#is_fc_1").prop("checked")) {return true;} else {return false;}},<?php }?>
				checkFCodePrefix : true,
				rangelength	: [3,5]
			},
			g_saledate : {
				required	: function () {if ($('#is_appoint_1').prop("checked")) {return true;} else {return false;}}
			},
			g_deliverdate : {
				required	: function () {if ($('#is_presell_1').prop("checked")) {return true;} else {return false;}}
			}
        },
        messages : {
            g_name  : {
                required    : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_goods_name_null'];?>',
                minlength   : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_goods_name_help'];?>',
                maxlength   : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_goods_name_help'];?>'
            },
            g_jingle : {
                maxlength   : '<i class="icon-exclamation-sign"></i>商品卖点不能超过140个字符'
            },
            g_price : {
                required    : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_store_price_null'];?>',
                number      : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_store_price_error'];?>',
                min         : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_store_price_interval'];?>',
                max         : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_store_price_interval'];?>'
            },
            g_marketprice : {
                required    : '<i class="icon-exclamation-sign"></i>请填写市场价',
                number      : '<i class="icon-exclamation-sign"></i>请填写正确的价格',
                min         : '<i class="icon-exclamation-sign"></i>请填写0.01~9999999之间的数字',
                max         : '<i class="icon-exclamation-sign"></i>请填写0.01~9999999之间的数字'
            },
            g_costprice : {
                number      : '<i class="icon-exclamation-sign"></i>请填写正确的价格',
                min         : '<i class="icon-exclamation-sign"></i>请填写0.00~9999999之间的数字',
                max         : '<i class="icon-exclamation-sign"></i>请填写0.00~9999999之间的数字'
            },
            g_storage : {
                required    : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_goods_stock_null'];?>',
                digits      : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_goods_stock_error'];?>',
                min         : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_goods_stock_checking'];?>',
                max         : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_goods_stock_checking'];?>'
            },
            image_path : {
                required    : '<i class="icon-exclamation-sign"></i>请设置商品主图'
            },
            g_vindate : {
                required    : '<i class="icon-exclamation-sign"></i>请选择有效期'
            },
			g_vlimit : {
				required	: '<i class="icon-exclamation-sign"></i>请填写1~10之间的数字',
				range		: '<i class="icon-exclamation-sign"></i>请填写1~10之间的数字'
			},
			g_fccount : {
				required	: '<i class="icon-exclamation-sign"></i>请填写1~100之间的数字',
				range		: '<i class="icon-exclamation-sign"></i>请填写1~100之间的数字'
			},
			g_fcprefix : {
				required	: '<i class="icon-exclamation-sign"></i>请填写3~5位的英文字母',
				rangelength	: '<i class="icon-exclamation-sign"></i>请填写3~5位的英文字母'
			},
			g_saledate : {
				required	: '<i class="icon-exclamation-sign"></i>请选择有效期'
			},
			g_deliverdate : {
				required	: '<i class="icon-exclamation-sign"></i>请选择有效期'
			}
        }
    });
    <?php if (isset($output['goods'])) {?>
	setTimeout("setArea(<?php echo $output['goods']['areaid_1'];?>, <?php echo $output['goods']['areaid_2'];?>)", 1000);
	<?php }?>
});
// 按规格存储规格值数据
var spec_group_checked = [<?php for ($i=0; $i<$output['sign_i']; $i++){if($i+1 == $output['sign_i']){echo "''";}else{echo "'',";}}?>];
var str = '';
var V = new Array();

<?php for ($i=0; $i<$output['sign_i']; $i++){?>
var spec_group_checked_<?php echo $i;?> = new Array();
<?php }?>

$(function(){
	$('dl[nctype="spec_group_dl"]').on('click', 'span[nctype="input_checkbox"] > input[type="checkbox"]',function(){
		into_array();
		goods_stock_set();
	});

	// 提交后不没有填写的价格或库存的库存配置设为默认价格和0
	// 库存配置隐藏式 里面的input加上disable属性
	$('input[type="submit"]').click(function(){
		$('input[data_type="price"]').each(function(){
			if($(this).val() == ''){
				$(this).val($('input[name="g_price"]').val());
			}
		});
		$('input[data_type="stock"]').each(function(){
			if($(this).val() == ''){
				$(this).val('0');
			}
		});
		$('input[data_type="alarm"]').each(function(){
			if($(this).val() == ''){
				$(this).val('0');
			}
		});
		if($('dl[nc_type="spec_dl"]').css('display') == 'none'){
			$('dl[nc_type="spec_dl"]').find('input').attr('disabled','disabled');
		}
	});
	
});

// 将选中的规格放入数组
function into_array(){
<?php for ($i=0; $i<$output['sign_i']; $i++){?>
		
		spec_group_checked_<?php echo $i;?> = new Array();
		$('dl[nc_type="spec_group_dl_<?php echo $i;?>"]').find('input[type="checkbox"]:checked').each(function(){
			i = $(this).attr('nc_type');
			v = $(this).val();
			c = null;
			if ($(this).parents('dl:first').attr('spec_img') == 't') {
				c = 1;
			}
			spec_group_checked_<?php echo $i;?>[spec_group_checked_<?php echo $i;?>.length] = [v,i,c];
		});

		spec_group_checked[<?php echo $i;?>] = spec_group_checked_<?php echo $i;?>;

<?php }?>
}

// 生成库存配置
function goods_stock_set(){
    //  店铺价格 商品库存改为只读
    $('input[name="g_price"]').attr('readonly','readonly').css('background','#E7E7E7 none');
    $('input[name="g_storage"]').attr('readonly','readonly').css('background','#E7E7E7 none');

    $('dl[nc_type="spec_dl"]').show();
    str = '<tr>';
    <?php recursionSpec(0,$output['sign_i']);?>
    if(str == '<tr>'){
        //  店铺价格 商品库存取消只读
        $('input[name="g_price"]').removeAttr('readonly').css('background','');
        $('input[name="g_storage"]').removeAttr('readonly').css('background','');
        $('dl[nc_type="spec_dl"]').hide();
    }else{
        $('tbody[nc_type="spec_table"]').empty().html(str)
            .find('input[nc_type]').each(function(){
                s = $(this).attr('nc_type');
                try{$(this).val(V[s]);}catch(ex){$(this).val('');};
                if ($(this).attr('data_type') == 'marketprice' && $(this).val() == '') {
                    $(this).val($('input[name="g_marketprice"]').val());
                }
                if ($(this).attr('data_type') == 'price' && $(this).val() == ''){
                    $(this).val($('input[name="g_price"]').val());
                }
                if ($(this).attr('data_type') == 'stock' && $(this).val() == ''){
                    $(this).val('0');
                }
                if ($(this).attr('data_type') == 'alarm' && $(this).val() == ''){
                    $(this).val('0');
                }
            }).end()
            .find('input[data_type="stock"]').change(function(){
                computeStock();    // 库存计算
            }).end()
            .find('input[data_type="price"]').change(function(){
                computePrice();     // 价格计算
            }).end()
            .find('input[nc_type]').change(function(){
                s = $(this).attr('nc_type');
                V[s] = $(this).val();
            });
    }
}

<?php 
/**
 * 
 * 
 *  生成需要的js循环。递归调用	PHP
 * 
 *  形式参考 （ 2个规格）
 *  $('input[type="checkbox"]').click(function(){
 *      str = '';
 *      for (var i=0; i<spec_group_checked[0].length; i++ ){
 *      td_1 = spec_group_checked[0][i];
 *          for (var j=0; j<spec_group_checked[1].length; j++){
 *              td_2 = spec_group_checked[1][j];
 *              str += '<tr><td>'+td_1[0]+'</td><td>'+td_2[0]+'</td><td><input type="text" /></td><td><input type="text" /></td><td><input type="text" /></td>';
 *          }
 *      }
 *      $('table[class="spec_table"] > tbody').empty().html(str);
 *  });
 */
function recursionSpec($len,$sign) {
    if($len < $sign){
        echo "for (var i_".$len."=0; i_".$len."<spec_group_checked[".$len."].length; i_".$len."++){td_".(intval($len)+1)." = spec_group_checked[".$len."][i_".$len."];\n";
        $len++;
        recursionSpec($len,$sign);
    }else{
        echo "var tmp_spec_td = new Array();\n";
        for($i=0; $i< $len; $i++){
            echo "tmp_spec_td[".($i)."] = td_".($i+1)."[1];\n";
        }
        echo "tmp_spec_td.sort(function(a,b){return a-b});\n";
        echo "var spec_bunch = 'i_';\n";
        for($i=0; $i< $len; $i++){
            echo "spec_bunch += tmp_spec_td[".($i)."];\n";
        }
        echo "str += '<input type=\"hidden\" name=\"spec['+spec_bunch+'][goods_id]\" nc_type=\"'+spec_bunch+'|id\" value=\"\" />';";
        for($i=0; $i< $len; $i++){
            echo "if (td_".($i+1)."[2] != null) { str += '<input type=\"hidden\" name=\"spec['+spec_bunch+'][color]\" value=\"'+td_".($i+1)."[1]+'\" />';}";
            echo "str +='<td><input type=\"hidden\" name=\"spec['+spec_bunch+'][sp_value]['+td_".($i+1)."[1]+']\" value=\"'+td_".($i+1)."[0]+'\" />'+td_".($i+1)."[0]+'</td>';\n";
        }
        echo "str +='<td><input class=\"text price\" type=\"text\" name=\"spec['+spec_bunch+'][marketprice]\" data_type=\"marketprice\" nc_type=\"'+spec_bunch+'|marketprice\" value=\"\" /><em class=\"add-on\"><i class=\"icon-renminbi\"></i></em></td><td><input class=\"text price\" type=\"text\" name=\"spec['+spec_bunch+'][price]\" data_type=\"price\" nc_type=\"'+spec_bunch+'|price\" value=\"\" /><em class=\"add-on\"><i class=\"icon-renminbi\"></i></em></td><td><input class=\"text stock\" type=\"text\" name=\"spec['+spec_bunch+'][stock]\" data_type=\"stock\" nc_type=\"'+spec_bunch+'|stock\" value=\"\" /></td><td><input class=\"text stock\" type=\"text\" name=\"spec['+spec_bunch+'][alarm]\" data_type=\"alarm\" nc_type=\"'+spec_bunch+'|alarm\" value=\"\" /></td><td><input class=\"text sku\" type=\"text\" name=\"spec['+spec_bunch+'][sku]\" nc_type=\"'+spec_bunch+'|sku\" value=\"\" /></td></tr>';\n";
        for($i=0; $i< $len; $i++){
            echo "}\n";
        }
    }
}

?>


<?php if (!empty($output['goods']) && $_GET['class_id'] <= 0 && !empty($output['sp_value']) && !empty($output['spec_checked']) && !empty($output['spec_list'])){?>
//  编辑商品时处理JS
$(function(){
	var E_SP = new Array();
	var E_SPV = new Array();
	<?php
	$string = '';
	foreach ($output['spec_checked'] as $v) {
		$string .= "E_SP[".$v['id']."] = '".$v['name']."';";
	}
	echo $string;
	echo "\n";
	$string = '';
	foreach ($output['sp_value'] as $k=>$v) {
		$string .= "E_SPV['{$k}'] = '{$v}';";
	}
	echo $string;
	?>
	V = E_SPV;
	$('dl[nc_type="spec_dl"]').show();
	$('dl[nctype="spec_group_dl"]').find('input[type="checkbox"]').each(function(){
		//  店铺价格 商品库存改为只读
		$('input[name="g_price"]').attr('readonly','readonly').css('background','#E7E7E7 none');
		$('input[name="g_storage"]').attr('readonly','readonly').css('background','#E7E7E7 none');
		s = $(this).attr('nc_type');
		if (!(typeof(E_SP[s]) == 'undefined')){
			$(this).attr('checked',true);
			v = $(this).parents('li').find('span[nctype="pv_name"]');
			if(E_SP[s] != ''){
				$(this).val(E_SP[s]);
				v.html('<input type="text" maxlength="20" value="'+E_SP[s]+'" />');
			}else{
				v.html('<input type="text" maxlength="20" value="'+v.html()+'" />');
			}
			change_img_name($(this));			// 修改相关的颜色名称
		}
	});

    into_array();	// 将选中的规格放入数组
    str = '<tr>';
    <?php recursionSpec(0,$output['sign_i']);?>
    if(str == '<tr>'){
        $('dl[nc_type="spec_dl"]').hide();
        $('input[name="g_price"]').removeAttr('readonly').css('background','');
        $('input[name="g_storage"]').removeAttr('readonly').css('background','');
    }else{
        $('tbody[nc_type="spec_table"]').empty().html(str)
            .find('input[nc_type]').each(function(){
                s = $(this).attr('nc_type');
                try{$(this).val(E_SPV[s]);}catch(ex){$(this).val('');};
            }).end()
            .find('input[data_type="stock"]').change(function(){
                computeStock();    // 库存计算
            }).end()
            .find('input[data_type="price"]').change(function(){
                computePrice();     // 价格计算
            }).end()
            .find('input[type="text"]').change(function(){
                s = $(this).attr('nc_type');
                V[s] = $(this).val();
            });
    }
});
<?php }?>
</script> 
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/scrolld.js"></script>
<script type="text/javascript">$("[id*='Btn']").stop(true).on('click', function (e) {e.preventDefault();$(this).scrolld();})</script>
