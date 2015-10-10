<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
.size182 {height: 182px;width: 182px;}
.box_arr .table_btn {width: 222px;}
.box_arr .table_btn a {float: left;}
.box_arr .table_btn a.disable_spec {background: url(<?php echo SHOP_TEMPLATES_URL;?>/images/member/btn.gif) repeat 0 -1018px;float: right;}
.dialog_body {border: 0px;}
.add_spec .add_link {color: #919191;}
.add_spec .add_link:hover {color: red;}
add_spec h2 {padding-left: 10px;}
.f_l {float: left;}
.mls_id {width: 0;filter: alpha(opacity=0);opacity: 0;}
.noSelect {color: #B9B9B9 !important;}
.flea_pic_list {background-color: #A7CAED;width: 648px;clear: both;margin-top: 10px;}
.flea_pic_list ul.menu {background-color: #FFF;width: 648px;height: 32px;border-bottom: solid 1px #A7CAED;}
.flea_pic_list .menu li {float: left;cursor: pointer;}
.flea_pic_list .menu li a {font-size: 12px;line-height: 20px;color: #555;height: 20px;float: left;padding: 6px 15px;margin: 0;}
.flea_pic_list .menu li a:hover {}
.flea_pic_list .menu li.active a, .goods-pictures .menu li.active a:hover {font-size: 13px;font-weight: 600;color: #36C;background-color: #FFF;line-height: 20px;height: 20px;float: left;padding: 5px 14px 7px 14px;border: solid 1px #A7CAED;border-bottom: 0;}
.flea_pic_list .content {width: 648px;background-color: #FFF;border: solid 1px #A7CAED;border-top: 0;}
.flea_pic_list .content .standard {padding: 10px 5px 10px 5px;*padding-bottom : 5px;}
.flea_pic_list .content .standard .big_pic {background-color: #FFF;margin-left: 7px;display: inline;width: 190px;height: 190px;float: left;}
.flea_pic_list .content .standard .big_pic .picture { /* if IE7/8/9*/*text-align: center;display: inline;width: 182px;height: 182px;float: left;padding: 2px;margin: 1px;border: dashed 1px #E7E7E7;}
.flea_pic_list .content .standard .small_pic {width: 430px;float: left;margin-left: 7px;display: inline;overflow: hidden;}
.flea_pic_list .content .standard .small_pic ul {width: 450px;float: left;display: inline;padding-bottom: 8px;}
.flea_pic_list .content .standard .small_pic ul li {display: inline;width: 80px;height: 114px;float: left;margin-right: 8px;position: relative;z-index: 99;cursor: pointer;}
.flea_pic_list .content .standard .small_pic .picture {background-color: #FFF; /* if IE7/8/9*/*text-align: center;width: 72px;height: 72px;float: left;padding: 1px;margin: 1px;border: dashed 1px #E7E7E7;position: absolute;top: 0px;left: 0px;}
.flea_pic_list .content .standard .small_pic .bg {display: none;width: 70px;height: 70px;border: 1px solid #09F;position: absolute;top: 3px;left: 3px;}
.flea_pic_list .content .standard .small_pic .operation {background-color: #09F;width: 70px;height: 17px;padding-top: 1px;position: absolute;z-index: 999;bottom: 0px;left: 0px;-moz-opacity: 0.75;opacity: .75;filter: alpha(opacity=75);}
.flea_pic_list .content .standard .small_pic .cut_in {background: url(<?php echo SHOP_TEMPLATES_URL;?>/images/member/picedit.png) 0px -64px;width: 16px;height: 16px;float: left;margin-left: 7px;display: inline;}.flea_pic_list .content .standard .small_pic .delete {background: url(<?php echo SHOP_TEMPLATES_URL;?>/images/member/picedit.png) 0 0;display: inline;width: 16px;height: 16px;float: right;margin-right: 7px;}.flea_pic_list .content .standard .small_pic .upload-btn {width: 74px;height: 32px;padding: 0px;position: absolute;*z-index: -1;z-index: 1;left: 1px;bottom: 0px;}.flea_pic_list .content .standard .small_pic .titles {width: 66px;height: 16px;line-height: 15px;text-align: center;color: #3d3f3e;background: #fdf04c;border: 1px solid #ffba2f;position: absolute;top: 1px;left: 1px;z-index: 9999;}.flea_pic_list .content .standard .small_pic .line {width: 66px;height: 2px;overflow: hidden;background: #d8deda;position: absolute;bottom: -3px;left: -1px;}.flea_pic_list .content .standard .small_pic .help {line-height: 18px;background-color: #FFFAE3;width: 420px;height: 57px;clear: both;padding: 4px;border: 1px solid #F1E38B;}.flea_pic_list .standard .small_pic .help p {padding-left: 24px;width: 398px;}.flea_pic_list .content .standard .help .ico {background: url(<?php echo SHOP_TEMPLATES_URL;?>/images/member/ico.gif) no-repeat 3px -2867px;color: #F60;}.flea_goods-attribute {width: 792px;margin-top: 0;border: none;}.flea_goods-attribute dl dd p {float: none;}.goods-gallery {width: 650px;}.goods-gallery .list li{display: inline;float: left;margin: 5px; width:90px; height:90px;position: relative;z-index: 99;cursor: pointer; border:1px solid #ddd;}</style>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <div class="ncm-default-form">
    <form method="post" id="goods_form" action="index.php?act=member_flea&op=<?php if ($output['goods']['goods_id']!='') echo 'edit_save_goods'; else echo 'save_goods'; ?>">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="goods_id" value="<?php echo $output['goods']['goods_id']; ?>" />
      <input type="hidden" name="spec_id" value="<?php echo $output['goods']['spec_id']; ?>" />
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_goods_index_flea_goods_class'].$lang['nc_colon'];?></dt>
        <dd id="gcategory">
          <?php if (!empty($output['goods']['gc_id'])) { ?>
          <span class="f_l"><?php echo $output['goods']['gc_name'];?></span> <a class="edit_gcategory btn" href="javascript:void(0)"><?php echo $lang['nc_edit'];?></a>
          <select style="display:none">
            <option value="0"><?php echo $lang['nc_please_choose'];?></option>
            <?php foreach($output['goods_class'] as $val) { ?>
            <option value="<?php echo $val['gc_id']; ?>"><?php echo $val['gc_name']; ?></option>
            <?php } ?>
          </select>
          <?php } else { ?>
          <select>
            <option value="0"><?php echo $lang['nc_please_choose'];?></option>
            <?php foreach($output['goods_class'] as $val) { ?>
            <option value="<?php echo $val['gc_id']; ?>"><?php echo $val['gc_name']; ?></option>
            <?php } ?>
          </select>
          <?php } ?>
          <input type="text" id="cate_id" name="cate_id" value="" class="mls_id text" />
          <input type="hidden" name="cate_name" value="" class="mls_names text"/>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_goods_index_flea_goods_name'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input type="text" class="text w400" name="goods_name" value="<?php echo $output['goods']['goods_name']; ?>"  />
          </p>
          <p class="hint"><?php echo $lang['store_goods_index_flea_title'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_index_flea_goods_tag'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input type="text" class="text w400" name="goods_tag" value="<?php echo $output['goods']['goods_tag']; ?>"/>
          </p>
          <p class="hint"><?php echo $lang['store_goods_index_flea_multiple_tag'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_album_flea_goods_pic'].$lang['nc_colon'];?></dt>
        <dd>
          <div class="flea_pic_list">
            <ul id="menu" class="menu">
              <li class="active" id="li_1"><a href="javascript:void(0);"><?php echo $lang['store_goods_album_flea_goods_pic'];?></a></li>
            </ul>
            <div class="content">
              <div id="demo"></div>
              <div class="standard">
                <div id="goodsCoverPicture" class="big_pic">
                  <div class="picture"> <span class="thumb size182"><i></i>
                    <?php if ($output['goods']['goods_image']) { ?>
                    <img id="big_goods_image" src="<?php echo $output['goods_image_path'].$output['goods']['goods_image'];?>" onload="javascript:DrawImage(this,182,182);" alt="" />
                    <?php } else { ?>
                    <img id="big_goods_image" src="<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" onload="javascript:DrawImage(this,182,182);" alt="" />
                    <?php } ?>
                    </span> </div>
                </div>
                <div class="small_pic" >
                  <ul id="goods_images">
                    <?php for($i=0;$i<5;$i++){?>
                    <li nc_type="handle_pic" file_id="<?php echo $output['goods_image'][$i]['upload_id']; ?>" thumbnail="<?php echo $output['goods_image'][$i]['file_thumb']; ?>" id="thumbnail_<?php echo $i;?>">
                      <input type="hidden" name="goods_file_id[]" value="<?php echo $output['goods_image'][$i]['upload_id']; ?>">
                      <div class="picture"><span class="thumb size60"><i></i>
                      <img id="img_<?php echo $i;?>" src="<?php echo $output['goods_image'][$i]['file_thumb'] !=''?$output['goods_image'][$i]['file_thumb']:SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" onerror="this.src='<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>'" onload="javascript:DrawImage(this,60,60);"/>
                      
                      
                      </span></div>
                      <div nc_type="handler" class="bg" id="<?php echo $i;?>">
                        <?php if($output['goods_image'][$i]['file_thumb'] !=''){?>
                        <p class="operation"><span class="cut_in" nc_type="set_cover" ecm_title="<?php echo $lang['store_goods_index_face'];?>"></span><span class="delete" nc_type="drop_image" ecm_title="<?php echo $lang['nc_del'];?>"></span></p>
                        <?php }?>
                      </div>
                      <div class="upload-btn"><a href="javascript:void(0);">
                        <iframe id="iframe_<?php echo $i;?>" width="86" scrolling="no" height="30" frameborder="0" src="index.php?act=member_flea&op=image_upload&id=<?php echo $i;?>&item_id=<?php echo $output['item_id']?>&file_id=<?php echo $output['goods_image'][$i]['upload_id']; ?>" ></iframe>
                        </a></div>
                    </li>
                    <?php } ?>
                  </ul>
                  <div class="help">
                    <p class="ico"><?php echo $lang['store_goods_album_flea_description_one'];?></p>
                    <p><?php echo $lang['store_goods_album_flea_description_two'];?></p>
                  </div>
                </div>
                <div class="clear"></div>
              </div>
              <div class="upload_btn" style=" display: none;"> </div>
            </div>
          </div>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['flea_old_deep'];?>:</dt>
        <dd>
          <select name="sh_quality" class="w100">
            <option value="0"<?php if($output['goods']['flea_quality']=='0'){echo ' selected="selected"';}?>><?php echo $lang['nc_please_choose'];?></option>
            <option value="10"<?php if($output['goods']['flea_quality']=='10'){echo ' selected="selected"';}?>><?php echo $lang['flea_index_new'];?></option>
            <option value="9"<?php if($output['goods']['flea_quality']=='9'){echo ' selected="selected"';}?>><?php echo $lang['flea_index_almost_new'];?></option>
            <option value="8"<?php if($output['goods']['flea_quality']=='8'){echo ' selected="selected"';}?>><?php echo $lang['flea_index_gently_used'];?></option>
            <option value="7"<?php if($output['goods']['flea_quality']=='7'){echo ' selected="selected"';}?>><?php echo $lang['flea_index_old'];?></option>
          </select>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['flea_current_area'];?>:</dt>
        <dd>
          <div class="select_add" id="region" style="width:500px;border:1px solide red;">
            <?php if(!empty($output['goods']['flea_area_id'])){?>
            <span><?php echo $output['goods']['flea_area_name'];?></span>
            <input type="button" value="<?php echo $lang['nc_edit'];?>" class="edit_region" />
            <select style="display:none;">
              <option><?php echo $lang['nc_please_choose'];?></option>
              <?php if(!empty($output['area_one_level']) && is_array($output['area_one_level'])){ ?>
              <?php foreach($output['area_one_level'] as $k => $v){ ?>
              <option value="<?php echo $v['flea_area_id'];?>"><?php echo $v['flea_area_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select>
            <?php }else{?>
            <select>
              <option><?php echo $lang['nc_please_choose'];?></option>
              <?php if(!empty($output['area_one_level']) && is_array($output['area_one_level'])){ ?>
              <?php foreach($output['area_one_level'] as $k => $v){ ?>
              <option value="<?php echo $v['flea_area_id'];?>"><?php echo $v['flea_area_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select>
            <?php }?>
            <input type="hidden" name="area_id" id="area_id" value="<?php echo $output['goods']['flea_area_id']?$output['goods']['flea_area_id']:'';?>" class="area_ids" />
            <input type="hidden" name="area_info" id="area_info" value="<?php echo $output['goods']['flea_area_name'];?>" class="area_names" />
          </div>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_goods_index_flea_goods_price'].$lang['nc_colon'];?></dt>
        <dd>
          <input name="goods_price" class="text" value="<?php echo $output['goods']['goods_price']; ?>" type="text" />
        </dd>
      </dl>
      <dl>
        <dt nc_type="no_spec" class="required"><em></em><?php echo $lang['store_goods_index_store_flea_price'].$lang['nc_colon'];?></dt>
        <dd nc_type="no_spec">
          <input name="goods_store_price" class="text" value="<?php echo $output['goods']['goods_store_price']; ?>" type="text" />
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['flea_contact_person'].$lang['nc_colon'];?></dt>
        <dd>
          <input name="flea_pname" value="<?php echo $output['goods']['flea_pname']; ?>" type="text" class="text" />
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['flea_contact_tel'].$lang['nc_colon'];?></dt>
        <dd>
          <input name="flea_pphone" value="<?php echo $output['goods']['flea_pphone']; ?>" type="text" class="text" />
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_index_flea_goods_seo_keywords'].$lang['nc_colon'];?></dt>
        <dd >
          <p>
            <input type="text" class="text w400" name="seo_keywords" value="<?php echo $output['goods']['goods_keywords']; ?>" />
          </p>
          <p class="hint"> <?php echo $lang['store_goods_index_goods_seo_keywords_help']; ?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_index_goods_seo_description'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <textarea  class="w800" name="seo_description" rows="3" id="remark_input" ><?php echo $output['goods']['goods_description']; ?></textarea>
          </p>
          <p class="hint"> <?php echo $lang['store_goods_index_goods_seo_description_help']; ?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_index_flea_goods_desc'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
<?php showEditor('g_body',$output['goods']['goods_body'],'800px','480px','visibility:hidden;',"false",$output['editor_multimedia']);?>
          </p>
          <p class="info-album"><a class="des_demo" href="index.php?act=flea_album&op=pic_list&item=des&goods_id=<?php echo $_GET['goods_id']; ?>"><?php echo $lang['store_goods_album_insert_users_flea_photo'];?></a></p>
          <p id="des_demo" style="display:none;"></p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" />
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
		$('.goods_demo').ajaxContent({
			event:'click', //mouseover
			loaderType:"img",
			loadingMsg:"<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif",
			target:'#demo'
		});
		regionInit("region");
		$('input[class="edit_region"]').click(function(){
			$(this).css('display','none');
			$('#area_id').val('');
			$(this).parent().children('select').css('display','');
			$(this).parent().children('span').css('display','none');
		});
		$('.des_demo').ajaxContent({
			event:'click', //mouseover
			loaderType:"img",
			loadingMsg:"<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif",
			target:'#des_demo'
		});

	    /* 图片控制 */
	    var handle_pic, handler, drop, cover, insert;

	    $('*[nc_type="handle_pic"]').find('img:first').hover(function(){
	        $('*[nc_type="explain_layer"]').remove();
	        handle_pic = $(this).parents('*[nc_type="handle_pic"]');
	        handler = handle_pic.find('*[nc_type="handler"]');
	        var parents = handler.parents();
	        handler.show();
	        handler.hover(function(){
	            $(this).show();
	            set_zindex(parents, "999");
	        },
	        function(){
	            $(this).hide();
	            set_zindex(parents, "0");
	        });
	        set_zindex(parents, '999');

	        cover = handler.find('*[nc_type="set_cover"]');
	        cover.unbind('click');
	        cover.click(function(){
	            set_cover(handle_pic.attr("file_id"));
	        });

	        drop = handler.find('*[nc_type="drop_image"]');
	        drop.unbind('click');
	        drop.click(function(){
	            drop_image(handler.attr("id"));
	        });

	        insert = handler.find('*[nc_type="insert_editor"]');
	        insert.unbind('click');
	        insert.click(function(){
	            insert_editor(handle_pic.attr("file_name"),handle_pic.attr("goods_image_path"));
	            return false;
	        });
	    },
	    function(){
	        handler.hide();
	        var parents = handler.parents();
	        set_zindex(parents, '0');
	    });
});

</script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/flea/common_flea_select.js"></script>
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/store_goods_add.step2.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script> 
<script type="text/javascript">
var SITE_URL = "<?php echo SHOP_SITE_URL; ?>";
$(function(){
	gcategoryInit("gcategory");
	$('#li_1').click(function(){
		$('#li_1').attr('class','active');
		$('#li_2').attr('class','');
		$('#demo').hide();
	});
	$('#goods_demo').click(function(){
		$('#li_1').attr('class','');
		$('#li_2').attr('class','active');
		$('#demo').show();
	});

	$('.des_demo').click(function(){
		if($('#des_demo').css('display') == 'none'){
            $('#des_demo').show();
        }else{
            $('#des_demo').hide();
        }
	});
});


//var SPEC = <?php echo $output['spec_json']; ?>;
var item_id = '<?php echo $output['item_id']?>';
function add_uploadedfile(file_data)
{
	file_data = jQuery.parseJSON(file_data);
	if(file_data.state == 'false') {
		alert(file_data.message);
		return false;
	}
    if(file_data.instance == 'goods_image'){
        id = file_data.id;
        $('#thumbnail_'+id).attr('thumbnail','<?php echo $output['goods_image_path']; ?>'+file_data.file_name).attr('file_id',file_data.file_id);
        $('#thumbnail_'+id).find('input[name="goods_file_id[]"]').val(file_data.file_id);
        $('#img_'+id).attr('src','<?php echo $output['goods_image_path']; ?>'+ file_data.file_name);
        $('#'+id).html('<p class="operation"><span class="cut_in" nc_type="set_cover" ecm_title="<?php echo $lang['store_goods_index_face'];?>"></span><span class="delete" nc_type="drop_image" ecm_title="<?php echo $lang['nc_del'];?>"></span></p>');
        $('#iframe_'+id).attr('src','index.php?act=member_flea&op=image_upload&id='+id+'&item_id='+item_id+'&file_id='+file_data.file_id);
        if($('#big_goods_image').attr('src') == '<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>'){
            set_cover(file_data.file_id);
        }
    }
}
function drop_image(id){
    if (confirm('<?php echo $lang['store_goods_index_goods_del_confirm']; ?>')){
            var url = SITE_URL + '/index.php?act=member_flea&op=drop_image';
            goods_file_id = $('#thumbnail_'+id).attr('file_id');
            $.getJSON(url, {'id':goods_file_id}, function(data){
                if (data.done)
                {
                	$('#thumbnail_'+id).attr('thumbnail','').attr('file_id','');
                	$('#img_'+id).attr('src','<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>');
                	$('#'+id).html('');
                }
                else
                {
                    alert(data.msg);
                }
            });
            if($('#big_goods_image').attr('src') == $('#img_'+id).attr('src')){
				$('#big_goods_image').attr('src','<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>');
            }
        }
}
function insert_editor(file_path){
	KE.appendHtml('g_body', '<img src="'+ file_path + '">');
}

function set_cover(file_id){
    if(typeof(file_id) == 'undefined'){
        $('#big_goods_image').attr('src','<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>');
        return;
    }
    var obj = $('*[file_id="'+ file_id +'"]');
    $('*[file_id="'+ file_id +'"]').clone(true).prependTo('#goods_images');
    $('*[nc_type="handler"]').hide();
    $('#big_goods_image').attr('src',obj.attr('thumbnail'));
    obj.remove();
}
function insert_img(id,item_url){
	var url = SITE_URL + '/index.php?act=member_flea&op=insert_image';
	var j	= 0;
	var y	= 'sign';
	for (var i = 0; i < 5; i++){
		if($('#thumbnail_'+i).attr('file_id') ==  ''){
			if(y == 'sign'){
				y=i;
			}
		}else{
			if($('#thumbnail_'+i).attr('thumbnail') == item_url){alert('<?php echo $lang['store_goods_index_goods_the_same'];?>');return false;}
			j++;
		}
	}
	if(j==5){
		alert('<?php echo $lang['store_goods_index_goods_not_add']; ?>');
	}else{
		$.getJSON(url, {'id':id,'item_id':item_id}, function(data){
        	if (data.done){
    			$('#thumbnail_'+y).attr('thumbnail','<?php echo $output['goods_image_path']; ?>'+data.file_name).attr('file_id',data.file_id);
    			$('#thumbnail_'+y).find('input[name="goods_file_id[]"]').val(data.file_id);
        		$('#img_'+y).attr('src','<?php echo $output['goods_image_path']; ?>'+ data.file_name);
        		$('#iframe_'+y).attr('src','index.php?act=member_flea&op=image_upload&id='+y+'&item_id='+item_id+'&file_id='+data.file_id);
        		$('#'+y).html('<p class="operation"><span class="cut_in" nc_type="set_cover" ecm_title="<?php echo $lang['store_goods_index_face'];?>"></span><span class="delete" nc_type="drop_image" ecm_title="<?php echo $lang['nc_del'];?>"></span></p>');
        		if($('#big_goods_image').attr('src') == '<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>'){
                    set_cover(data.file_id);
                }
        	}else{
            	alert(data.msg);
        	}
    	});
	}
}

$(function(){
     $('#goods_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        rules : {
<?php if ($output['goods']['goods_id']=='') { ?>
            cate_id    : {
				required : true,
                remote   : {
                    url  : 'index.php?act=member_flea&op=check_class',
                    type : 'get',
                    data : {
                        cate_id : function(){
                            return $('#cate_id').val();
                        }
                    }
                }
            },
<?php } ?>
<?php if ($output['goods']['goods_id']=='') { ?>            
area_id: {
	required: true,
	remote   : {
        url  : 'index.php?act=index&op=flea_area&check=1',
        type : 'get',
        data : {
            region_id : function(){
                return $('#area_id').val();
            }
        }
    }
},
<?php }?>	
            goods_name : {
                required   : true,
                minlength  : 5,
                maxlength  : 30
            },
            sh_quality : {
                number   : true,
                min		 : 7,
                max		 : 10
            },
            goods_price    : {
				required   : true,
                number     : true
            },
            goods_store_price : {
				required   : true,
                number     : true
            },
            flea_pname    : {
				required   : true
            },
            flea_pphone    : {
				required   : true,
                number     : true
            }            
        },
        messages : {
<?php if ($output['goods']['goods_id']=='') { ?>
            cate_id     : {
				required: '<?php echo $lang['store_goods_index_goods_class_null'];?>',
                remote  : '<?php echo $lang['store_goods_index_goods_class_error'];?>'
            },
<?php } ?>
<?php if ($output['goods']['goods_id']=='') { ?>            
area_id: {
	required: '<?php echo $lang['store_goods_index_flea_area'];?>',
	remote: '<?php echo $lang['store_goods_index_flea_next_area'];?>'
},
<?php }?>
            goods_name  : {
                required   : '<?php echo $lang['store_goods_index_flea_goods_name_null'];?>',
                minlength  : '<?php echo $lang['store_goods_index_flea_title_limit'];?>',
                maxlength  : '<?php echo $lang['store_goods_index_flea_title_limit'];?>'
            },
            sh_quality  : {
            	number   : '<?php echo $lang['store_goods_index_flea_choose_oldnew'];?>',
            	min      : '<?php echo $lang['store_goods_index_flea_choose_oldnew'];?>',
            	max      : '<?php echo $lang['store_goods_index_flea_choose_oldnew'];?>'
            },
            goods_price : {
				required: '<?php echo $lang['store_goods_index_flea_goods_price_null'];?>',
                number     : '<?php echo $lang['store_goods_index_flea_goods_price_error'];?>'
            },
            goods_store_price : {
				required: '<?php echo $lang['store_goods_index_flea_store_price_null'];?>',
                number     : '<?php echo $lang['store_goods_index_flea_store_price_error'];?>'
            },
            flea_pname  : {
                required   : '<?php echo $lang['store_goods_index_flea_contact_unnull'];?>'
            },
            flea_pphone  : {
                required   : '<?php echo $lang['store_goods_index_flea_tel_unnull'];?>',
                number     : '<?php echo $lang['store_goods_index_flea_tel_number'];?>'
            }
        }
    });

    // init spec
    spec_update();
});
</script> 
<script>
function preventSelectDisabled(oSelect)
{
   //得到当前select选中项的disabled属性。
   var isOptionDisabled = oSelect.options[oSelect.selectedIndex].disabled;
   //如果是有disabled属性的话
   if(isOptionDisabled)
   {
      //让他恢复上一次选择的状态，oSelect.defaultSelectedIndex属性是前一次选中的选项index
      //oSelect.selectedIndex = oSelect.defaultSelectedIndex;
	  //让他恢复未选择状态
	  oSelect.selectedIndex = '0';
      return false;
   }
  //如果没有disabled属性的话
   else
   {
	   var currentvalue = oSelect.value;
	   //为了实现下面的验证,先清空选择的项
       oSelect.value = '0';
	   if(checkselected(currentvalue)){
		 	//oSelect.defaultSelectedIndex属性，设置成当前选择的index
	        oSelect.value = currentvalue;   
	   }else{
		   //alert("该分类已经选择,请选择其他分类");
		   alert('<?php echo $lang['store_goods_index_add_sclasserror']; ?>');
	   }
       return true;
   }
}
function checkselected(currentvalue){
	var result = true;
	jQuery.each($(".sgcategory"),function(){
		if(currentvalue!=0 && currentvalue == $(this).val()){
			result = false;
		}
	});
	return result;
}
</script>