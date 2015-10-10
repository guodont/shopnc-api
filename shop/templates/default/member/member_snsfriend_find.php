<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <div class="ncm-friend-find"> 
    <!-- 搜索好友start -->
    <form id="search_form" method="post" action="index.php?act=member_snsfriend&op=findlist">
      <div class="search-form">
        <div class="normal">
          <?php echo $lang['snsfriend_find_keytip'];?><input type="text" class="text w400" name="searchname" id="searchname" value="<?php echo $_GET['searchname'];?>" >
          <a class="ncm-btn ncm-btn-green" nctype="search_submit"><?php echo $lang['snsfriend_search'];?></a> <a href="javascript:void(0);" nctype="advanced_search" class="ncm-btn"><?php echo $lang['snsfriend_advanced_search'];?></a> </div>
        <div class="complex" nctype="advanced_search">
          所在地：<select nctype="area" name="provinceid" id="provinceid">
          </select>
          <select nctype="area" name="cityid" id="cityid">
            <option><?php echo $lang['snsfriend_city'];?></option>
          </select>
          <select nctype="area" name="areaid" id="areaid">
            <option><?php echo $lang['snsfriend_county'];?></option>
          </select>
          <?php echo $lang['snsfriend_age'].$lang['nc_colon'];?><select name="age" id="age">
            <option value="0">-请选择-</option>
            <option value="1"><?php echo $lang['snsfriend_age_less_than_18'];?></option>
            <option value="2"><?php echo $lang['snsfriend_age_between_18_to_24'];?></option>
            <option value="3"><?php echo $lang['snsfriend_age_between_25_to_30'];?></option>
            <option value="4"><?php echo $lang['snsfriend_age_between_31_to_35'];?></option>
            <option value="5"><?php echo $lang['snsfriend_age_more_than_35'];?></option>
          </select>
          <?php echo $lang['snsfriend_sex'].$lang['nc_colon'];?><select name="sex" id="sex">
            <option value="">-请选择-</option>
            <option value="1"><?php echo $lang['snsfriend_man'];?></option>
            <option value="2"><?php echo $lang['snsfriend_woman'];?></option>
          </select>
        </div>
      </div>
    </form>
    <!-- 推荐标签列表start -->
    <div class="ncm-recommend-tag">
      <?php if(!empty($output['mtag_list'])){?>
      <?php foreach($output['mtag_list'] as $val){?>
      <?php $param_memberlist = array_slice((array)$output['tagmember_list'][$val['mtag_id']],0,20);?>
      <dl>
        <dt><i class="icon-tag"></i><?php echo $val['mtag_name'];?></dt>
        <dd>
          <div class="picture"><span class="thumb size100"><i></i><img title="<?php echo $val['mtag_name'];?>" src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_MEMBERTAG.'/'.($val['mtag_img'] != ''?$val['mtag_img']:'default_tag.gif')?>"  onload="javascript:DrawImage(this,120,120);"/></span></div>
          <div class="arrow"></div>
          <div class="content" nctype="content<?php echo $val['mtag_id'];?>">
            <p><?php echo $val['mtag_desc'];?></p>
            <div class="friends">
              <h5><?php printf($lang['snsfriend_recommend_members_desc'], count($param_memberlist));?></h5>
              <?php if(!empty($output['tagmember_list'][$val['mtag_id']])){?>
              <div>
                <p class="F-prev"><a href="javascript:void(0);"><?php echo $lang['snsfriend_prev'];?></a></p>
                <div class="list" nctype="slider_div">
                  <ul class="F-center">
                    <?php $param = array();foreach ($param_memberlist as $v){ $param[] = $v['member_id'];?>
                    <li><span class="thumb size40"><i></i><a href="javascript:void(0);"><img title="<?php echo $v['member_name'];?>" src="<?php echo getMemberAvatar($v['member_avatar']);?>"  onload="javascript:DrawImage(this,40,40);"/></a></span></li>
                    <?php }?>
                  </ul>
                </div>
                <p class="F-next"><a href="javascript:void(0);"><?php echo $lang['snsfriend_next'];?></a></p>
                <a href="javascript:void(0);" class="care" nctype="batchFollow" data-param="{ids:'<?php echo implode(',', $param);?>'}"><?php echo $lang['snsfriend_attention_them'];?></a> </div>
              <?php }else{?>
              <?php echo $lang['snsfriend_null_members_tips1']?><a href="index.php?act=member_information&op=more"><?php echo $lang['snsfriend_null_members_tips2'];?></a>
              <?php }?>
            </div>
          </div>
        </dd>
      </dl>
      <script>$(function(){$('div[nctype="content<?php echo $val['mtag_id'];?>"]').F_slider({len:<?php echo ceil(count($param_memberlist)/10);?> , axis:'x'});})</script>
      <?php }?>
      <?php }?>
    </div>
    <!-- 推荐标签列表end --> 
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns_friend.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.F_slider.js" charset="utf-8"></script> 
<script type="text/javascript">
$(function(){
	$('a[nctype="search_submit"]').click(function(){
		// 验证用户名是否为空
		if($('#searchname').val() != ''){
		    $('#search_form').submit();
		}else{
			$('#searchname').addClass('error').focus();
		}
	});


	// 高级搜索显示与隐藏
	$('a[nctype="advanced_search"]').click(function(){
		$('div[nctype="advanced_search"]').toggle('fast');
	});

	// 地区
	areaInit($('select[nctype="area"]:first'),0);
	$('select[nctype="area"]').change(function(){
		$(this).nextAll('select[nctype="area"]').each(function(){
			if ($(this).attr('id') == 'cityid') $(this).html('<option><?php echo $lang['snsfriend_city'];?></option>');
			if ($(this).attr('id') == 'areaid') $(this).html('<option><?php echo $lang['snsfriend_county'];?></option>');
		});
		if($(this).next().attr('nctype') == 'area' && !isNaN(parseInt($(this).val()))){
			$('#area_ids').val($(this).val());
			areaInit($(this).next().html(''), $(this).val());
		}
	});
});
</script>