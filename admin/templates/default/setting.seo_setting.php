<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_seo_set']?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" nctype="index" class="current"><span><?php echo $lang['seo_set_index'];?></span></a></li>
        <li><a href="JavaScript:void(0);" nctype="group"><span><?php echo $lang['seo_set_group'];?></span></a></li>
        <li><a href="JavaScript:void(0);" nctype="brand"><span><?php echo $lang['seo_set_brand'];?></span></a></li>
        <li><a href="JavaScript:void(0);" nctype="point"><span><?php echo $lang['seo_set_point'];?></span></a></li>
        <li><a href="JavaScript:void(0);" nctype="article"><span><?php echo $lang['seo_set_article'];?></span></a></li>
        <li><a href="JavaScript:void(0);" nctype="shop"><span><?php echo $lang['seo_set_shop'];?></span></a></li>
        <li><a href="JavaScript:void(0);" nctype="product"><span><?php echo $lang['seo_set_product'];?></span></a></li>
        <li><a href="JavaScript:void(0);" nctype="category"><span><?php echo $lang['seo_set_category'];?></span></a></li>
        <li><a href="JavaScript:void(0);" nctype="sns"><span>SNS</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
        	<li><?php echo $lang['seo_set_prompt'];?></li>
            <li><?php echo $lang['seo_set_tips1'];?></li>
            <li nctype="vmore"><?php echo $lang['seo_set_tips2'];?></li>
            <li nctype="vmore"><?php echo $lang['seo_set_tips3'];?></li>
            <li nctype="vmore"><?php echo $lang['seo_set_tips4'];?></li>
            <li nctype="vmore"><?php echo $lang['seo_set_tips5'];?></li>
            <li nctype="vmore"><?php echo $lang['seo_set_tips6'];?></li>
            <!--<li><?php echo $lang['seo_set_tips7'];?></li>-->
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" name="form_index" action="index.php?act=setting&op=seo_update">
    <input type="hidden" name="form_submit" value="ok" />
	<span style="display:none" nctype="hide_tag"><a>{sitename}</a></span>
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['seo_set_index'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="w96">title</td><td><input id="SEO[index][title]" name="SEO[index][title]" value="<?php echo $output['seo']['index']['title'];?>" class="w300" type="text"/></td>
        </tr>
        <tr class="noborder">
          <td class="w96">keywords</td><td><input id="SEO[index][keywords]" name="SEO[index][keywords]" value="<?php echo $output['seo']['index']['keywords'];?>" class="w300" type="text" maxlength="200" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">description</td><td><input id="SEO[index][description]" name="SEO[index][description]" value="<?php echo $output['seo']['index']['description'];?>" class="w300" type="text" maxlength="200"/></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form_index.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
  <form method="post" name="form_group" action="index.php?act=setting&op=seo_update">
    <input type="hidden" name="form_submit" value="ok" />
    <span style="display:none" nctype="hide_tag"><a>{sitename}</a><a>{name}</a></span>
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['seo_set_group'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="w96">title</td><td><input id="SEO[group][title]" name="SEO[group][title]" value="<?php echo $output['seo']['group']['title'];?>" class="w300" type="text"/></td>
        </tr>
        <tr class="noborder">
          <td class="w96">keywords</td><td><input id="SEO[group][keywords]" name="SEO[group][keywords]" value="<?php echo $output['seo']['group']['keywords'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">description</td><td><input id="SEO[group][description]" name="SEO[group][description]" value="<?php echo $output['seo']['group']['description'];?>" class="w300" type="text" /></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['seo_set_group_content'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="w96">title</td><td><input id="SEO[group_content][title]" name="SEO[group_content][title]" value="<?php echo $output['seo']['group_content']['title'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">keywords</td><td><input id="SEO[group_content][keywords]" name="SEO[group_content][keywords]" value="<?php echo $output['seo']['group_content']['keywords'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">description</td><td><input id="SEO[group_content][description]" name="SEO[group_content][description]" value="<?php echo $output['seo']['group_content']['description'];?>" class="w300" type="text" /></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form_group.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
  <form method="post" name="form_brand" action="index.php?act=setting&op=seo_update">
    <input type="hidden" name="form_submit" value="ok" />
    <span style="display:none" nctype="hide_tag"><a>{sitename}</a><a>{name}</a></span>
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['seo_set_brand'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="w96">title</td><td><input id="SEO[brand][title]" name="SEO[brand][title]" value="<?php echo $output['seo']['brand']['title'];?>" class="w300" type="text"/></td>
        </tr>
        <tr class="noborder">
          <td class="w96">keywords</td><td><input id="SEO[brand][keywords]" name="SEO[brand][keywords]" value="<?php echo $output['seo']['brand']['keywords'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">description</td><td><input id="SEO[brand][description]" name="SEO[brand][description]" value="<?php echo $output['seo']['brand']['description'];?>" class="w300" type="text" /></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['seo_set_brand_list'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="w96">title</td><td><input id="SEO[brand_list][title]" name="SEO[brand_list][title]" value="<?php echo $output['seo']['brand_list']['title'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">keywords</td><td><input id="SEO[brand_list][keywords]" name="SEO[brand_list][keywords]" value="<?php echo $output['seo']['brand_list']['keywords'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">description</td><td><input id="SEO[brand_list][description]" name="SEO[brand_list][description]" value="<?php echo $output['seo']['brand_list']['description'];?>" class="w300" type="text" /></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form_brand.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
  <form method="post" name="form_point" action="index.php?act=setting&op=seo_update">
    <input type="hidden" name="form_submit" value="ok" />
    <span style="display:none" nctype="hide_tag"><a>{sitename}</a><a>{name}</a><a>{key}</a><a>{description}</a></span>
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['seo_set_point'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="w96">title</td><td><input id="SEO[point][title]" name="SEO[point][title]" value="<?php echo $output['seo']['point']['title'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">keywords</td><td><input id="SEO[point][keywords]" name="SEO[point][keywords]" value="<?php echo $output['seo']['point']['keywords'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">description</td><td><input id="SEO[point][description]" name="SEO[point][description]" value="<?php echo $output['seo']['point']['description'];?>" class="w300" type="text" /></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['seo_set_point_content'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="w96">title</td><td><input id="SEO[point_content][title]" name="SEO[point_content][title]" value="<?php echo $output['seo']['point_content']['title'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">keywords</td><td><input id="SEO[point_content][title]" name="SEO[point_content][keywords]" value="<?php echo $output['seo']['point_content']['keywords'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">description</td><td><input id="SEO[point_content][title]" name="SEO[point_content][description]" value="<?php echo $output['seo']['point_content']['description'];?>" class="w300" type="text" /></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form_point.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
  <form method="post" name="form_article" action="index.php?act=setting&op=seo_update">
    <input type="hidden" name="form_submit" value="ok" />
    <span style="display:none" nctype="hide_tag"><a>{sitename}</a><a>{article_class}</a><a>{name}</a><a>{key}</a><a>{description}</a></span>
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['seo_set_atricle_list'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="w96">title</td><td><input id="SEO[article][title]" name="SEO[article][title]" value="<?php echo $output['seo']['article']['title'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">keywords</td><td><input id="SEO[article][keywords]" name="SEO[article][keywords]" value="<?php echo $output['seo']['article']['keywords'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">description</td><td><input id="SEO[article][description]" name="SEO[article][description]" value="<?php echo $output['seo']['article']['description'];?>" class="w300" type="text" /></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['seo_set_atricle_content'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="w96">title</td><td><input id="SEO[article_content][title]" name="SEO[article_content][title]" value="<?php echo $output['seo']['article_content']['title'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">keywords</td><td><input id="SEO[article_content][keywords]" name="SEO[article_content][keywords]" value="<?php echo $output['seo']['article_content']['keywords'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">description</td><td><input id="SEO[article_content][description]" name="SEO[article_content][description]" value="<?php echo $output['seo']['article_content']['description'];?>" class="w300" type="text" /></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form_article.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
  <form method="post" name="form_shop" action="index.php?act=setting&op=seo_update">
    <input type="hidden" name="form_submit" value="ok" />
    <span style="display:none" nctype="hide_tag"><a>{sitename}</a><a>{shopname}</a><a>{key}</a><a>{description}</a></span>
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['seo_set_shop'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="w96">title</td><td><input id="SEO[shop][title]" name="SEO[shop][title]" value="<?php echo $output['seo']['shop']['title'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">keywords</td><td><input id="SEO[shop][keywords]" name="SEO[shop][keywords]" value="<?php echo $output['seo']['shop']['keywords'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">description</td><td><input id="SEO[shop][description]" name="SEO[shop][description]" value="<?php echo $output['seo']['shop']['description'];?>" class="w300" type="text" /></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form_shop.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
  <form method="post" name="form_product" action="index.php?act=setting&op=seo_update">
    <input type="hidden" name="form_submit" value="ok" />
    <span style="display:none" nctype="hide_tag"><a>{sitename}</a><a>{name}</a><a>{key}</a><a>{description}</a></span>
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['seo_set_product'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="w96">title</td><td><input id="SEO[product][title]" name="SEO[product][title]" value="<?php echo $output['seo']['product']['title'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">keywords</td><td><input id="SEO[product][keywords]" name="SEO[product][keywords]" value="<?php echo $output['seo']['product']['keywords'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">description</td><td><input id="SEO[product][desciption]" name="SEO[product][description]" value="<?php echo $output['seo']['product']['description'];?>" class="w300" type="text" /></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form_product.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>  
  <form method="post" name="form_category" action="index.php?act=setting&op=seo_category">
    <input type="hidden" name="form_submit" value="ok" />
    <span style="display:none" nctype="hide_tag"><a>{sitename}</a><a>{name}</a></span>
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['seo_set_category'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="w96"><?php echo $lang['seo_set_category'];?></td><td>
          <select name="category" id="category">
          <option value=""><?php echo $lang['nc_common_pselect'];?></option>
          <?php foreach ((array)$output['category'] as $key=>$value) {?>
          	<?php if ($value['gc_parent_id'] != 0) break;?>
          	<option value="<?php echo $value['gc_id'];?>">1 <?php echo $value['gc_name'];?></option>
	          	<?php foreach ((array)explode(',',$value['child']) as $value1) {?>
	          		<option value="<?php echo $output['category'][$value1]['gc_id'];?>">&nbsp;&nbsp;&nbsp;&nbsp;2 <?php echo $output['category'][$value1]['gc_name'];?></option>
			          	<?php foreach ((array)explode(',',$output['category'][$value1]['child']) as $value2) {?>
			          		<option value="<?php echo $output['category'][$value2]['gc_id'];?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3 <?php echo $output['category'][$value2]['gc_name'];?></option>
			          	<?php }?>
	          	<?php }?>
          <?php }?>
          </select>
          </td>
        </tr>        
        <tr class="noborder">
          <td class="w96">title</td><td><input id="cate_title" name="cate_title" value="" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">keywords</td><td><input id="cate_keywords" name="cate_keywords" value="" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">description</td><td><input id="cate_description" name="cate_description" value="" class="w300" type="text" /></td>
        </tr>       
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form_category.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
  <form method="post" name="form_sns" action="index.php?act=setting&op=seo_update">
    <input type="hidden" name="form_submit" value="ok" />
    <span style="display:none" nctype="hide_tag"><a>{sitename}</a><a>{name}</a></span>
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label>SNS</label></td>
        </tr>
        <tr class="noborder">
          <td class="w96">title</td><td><input id="SEO[sns][title]" name="SEO[sns][title]" value="<?php echo $output['seo']['sns']['title'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">keywords</td><td><input id="SEO[sns][keywords]" name="SEO[sns][keywords]" value="<?php echo $output['seo']['sns']['keywords'];?>" class="w300" type="text" /></td>
        </tr>
        <tr class="noborder">
          <td class="w96">description</td><td><input id="SEO[sns][desciption]" name="SEO[sns][description]" value="<?php echo $output['seo']['sns']['description'];?>" class="w300" type="text" /></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form_sns.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>  
	<div id="tag_tips">
	<span class="dialog_title"><?php echo $lang['seo_set_insert_tips'];?></span>
	<div style="margin: 0px; padding: 0px;line-height:25px;"></div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$('.tab-base').find('a').bind('click',function(){
		$("#tag_tips").css('display','none');
		$('.tab-base').find('a').removeClass('current');
		$(this).addClass('current');
		$('form').css('display','none');
		$('form[name="form_'+$(this).attr('nctype')+'"]').css('display','');
		if ($(this).attr('nctype') == 'rewrite'){
			$('#prompt').css('display','none');
		}else{
			$('#prompt').css('display','');
		}
		$('span[nctype="hide_tag"]').find('a').css('padding-left','5px');
		$("#tag_tips>div").html($('form[name="form_'+$(this).attr('nctype')+'"]').find('span').html());
		$("#tag_tips").find('a').css('cursor','pointer');
		$("#tag_tips").find('a').bind('click',function(){
			var value = $(CUR_INPUT).val();
			if(value.indexOf($(this).html())<0 ){
				$(CUR_INPUT).val(value+$(this).html());
			}
		});
	});
	$('input[type="text"]').bind('focus',function(){
		CUR_INPUT = this;
		//定位弹出层的坐标
		var pos = $(this).position();
		var pos_x = pos.left+370;
		var pos_y = pos.top-20;
		$("#tag_tips").css({'left' : pos_x, 'top' : pos_y,'position' : 'absolute','display' : 'block'});
	});

	$('form').css('display','none');
	$('form[name="form_index"]').css('display','');
	$('#prompt').css('display','none');

	$('#category').bind('change',function(){
		$.getJSON('index.php?act=setting&op=ajax_category&id='+$(this).val(), function(data){
			if(data){
				$('#cate_title').val(data.gc_title);
				$('#cate_keywords').val(data.gc_keywords);
				$('#cate_description').val(data.gc_description);
			}else{
				$('#cate_title').val('');
				$('#cate_keywords').val('');
				$('#cate_description').val('');			
			}
		});
	});
	$('#toggmore').bind('click',function(){
		$('li[nctype="vmore"]').toggle();
	});
	$('li[nctype="vmore"]').hide();

});
</script>
<style>
#tag_tips{
	padding:4px;border-radius: 2px 2px 2px 2px;box-shadow: 0 0 4px rgba(0, 0, 0, 0.75);display:none;padding: 4px;width:300px;z-index:9999;background-color:#FFFFFF;
}
.dialog_title {
    background-color: #F2F2F2;
    border-bottom: 1px solid #EAEAEA;
    color: #666666;
    display: block;
    font-weight: bold;
    line-height: 14px;
    padding: 5px;
}
</style>