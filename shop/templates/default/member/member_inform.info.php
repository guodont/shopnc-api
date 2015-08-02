<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncm-flow-layout">
  <div id="ncmInformFlow" class="ncm-flow-container">
    <div class="title">
      <h3><?php echo $lang['inform_page_title']; ?></h3>
    </div>
    <div class="ncm-flow-step">
      <dl class="step-first current">
        <dt>填写举报内容</dt>
        <dd class="bg"></dd>
      </dl>
      <dl class="current">
        <dt>平台审核处理</dt>
        <dd class="bg"> </dd>
      </dl>
      <dl class="<?php if ($output['inform_info']['inform_state'] == 2) {?>current<?php }?>">
        <dt>举报完成</dt>
        <dd class="bg"> </dd>
      </dl>
    </div>
    <div class="ncm-default-form">
      <div id="warning"></div>
      <dl>
        <dt>被举报商家：</dt>
        <dd><a href="<?php echo urlShop('show_store', 'index', array('store_id' => $output['goods_info']['goods_id']));?>" ><?php echo $output['goods_info']['store_name'];?></a></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['inform_goods_name'].$lang['nc_colon'];?></dt>
        <dd>
          <div class="ncm-inform-item">
            <div class="ncm-goods-thumb-mini"><a href="<?php echo urlShop('goods', 'index',array('goods_id'=>$output['goods_info']['goods_id']));?>" target="_blank"><img src="<?php echo thumb($output['goods_info'],60); ?>" onMouseOver="toolTip('<img src=<?php echo thumb($output['goods_info'],240); ?>>')" onMouseOut="toolTip()" /></a></div>
            <a href="<?php echo urlShop('goods', 'index',array('goods_id'=>$output['goods_info']['goods_id']));?>" target="_blank"> <?php echo $output['goods_info']['goods_name']; ?> </a></div>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['inform_type'].$lang['nc_colon'];?></dt>
        <dd> <?php echo $output['subject_info']['inform_subject_content'];?> </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['inform_subject'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['subject_info']['inform_subject_type_name'];?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['inform_content'].$lang['nc_colon'];?></dt>
        <dd>
          <?php echo $output['inform_info']['inform_content'];?>
        </dd>
      </dl>
      <dl class="noborder">
        <dt><?php echo $lang['inform_pic'].$lang['nc_colon'];?></dt>
        <dd>
        <ul class="ncm-evidence-pic">
        <?php if (!empty($output['inform_info']['inform_pic1'])) {?>
        <li><a href="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/inform/'.$output['inform_info']['inform_pic1'];?>" nctype="nyroModal" rel="gal"><img class="show_image" src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/inform/'.$output['inform_info']['inform_pic1'];?>"></a></li>
        <?php }?>
        <?php if (!empty($output['inform_info']['inform_pic2'])) {?>
        <li><a href="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/inform/'.$output['inform_info']['inform_pic2'];?>" nctype="nyroModal" rel="gal"><img class="show_image" src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/inform/'.$output['inform_info']['inform_pic2'];?>"></a></li>
        <?php }?>
        <?php if (!empty($output['inform_info']['inform_pic3'])) {?>
        <li><a href="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/inform/'.$output['inform_info']['inform_pic3'];?>" nctype="nyroModal" rel="gal"><img class="show_image" src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/inform/'.$output['inform_info']['inform_pic3'];?>"></a></li>
        <?php }?>
        </ul>
        </dd>
      </dl>
      <div class="bottom"><a href="javascript:history.go(-1);" class="ncm-btn"><i class="icon-reply"></i>返回列表</a></div>
    </div>
  </div>
  <div class="ncm-flow-item">
    <div class="title">违规举报须知</div>
    <div class="content">
      <div class="alert">
        <ul>
          <li> 1.请提供充分的证据以确保举报成功，请珍惜您的会员权利，帮助商城更好地管理网站；</li>
          <li> 2.被举报待处理的商品不能反复进行违规提交，处理下架后的商品不能再次举报，商家如重新上架后仍存在违规现象，可再次对该商品进行违规举报；</li>
          <li> 3.举报仅针对商品或商家本身，如需处理交易中产生的纠纷，请选择投诉；</li>
          <li> 4.举报时依次选择举报类型及举报主题（必填），填写违规描述（必填，不超过200字），上传3张以内的举证图片（选填），详细的举报内容有助于平台对该条举报的准确处理。</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.selectboxes.pack.js" charset="utf-8" ></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#btn_inform_submit").attr('disabled',true);
    //默认选中第一个radio
    $(":radio").first().attr("checked",true);
    bindInformSubject($(":radio").first().val());
    $(":radio").click(function(){
        bindInformSubject($(this).val());
    });
    //页面输入内容验证
	$("#add_form").validate({
		errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
    	submitHandler:function(form){
    		ajaxpost('add_form', '', '', 'onerror')
    	},
        rules : {
        	inform_content : {
                required : true,
                maxlength : 100
            },
        	inform_subject: {
                required : true
            },
            inform_pic1 : {
                accept : 'jpg|jpeg|gif|png'
            },
            inform_pic2 : {
                accept : 'jpg|jpeg|gif|png'
            },
            inform_pic3 : {
                accept : 'jpg|jpeg|gif|png'
            }
        },
        messages : {
	    	inform_content : {
                required : '<?php echo $lang['inform_content_null'];?>',
                maxlength : '<?php echo $lang['inform_content_null'];?>'
            },
        	inform_subject: {
                required : '<?php echo $lang['inform_subject_select'];?>'
            },
            inform_pic1: {
                accept : '<?php echo $lang['inform_pic_error'];?>'
            },
            inform_pic2: {
                accept : '<?php echo $lang['inform_pic_error'];?>'
            },
            inform_pic3: {
                accept : '<?php echo $lang['inform_pic_error'];?>'
            }
        }
	});

});
function bindInformSubject(key) {
    type_id = key.split(",")[0];
    $("#inform_subject").empty();
    $.ajax({
        type:'POST',
        url:'index.php?act=member_inform&op=get_subject_by_typeid',
        cache:false,
        data:'typeid='+type_id,
        dataType:'json',
        success:function(type_list){
            $("#btn_inform_submit").attr('disabled',false);
            if(type_list.length >= 1) {
                $("#inform_subject").addOption('','<?php echo $lang['nc_please_choose'];?>');
                for(var i = 0; i < type_list.length; i++)
                {
                    $("#inform_subject").addOption(type_list[i].inform_subject_id+","+type_list[i].inform_subject_content,type_list[i].inform_subject_content);
                }
                $("#inform_subject").selectOptions('');
            }
            else {
                $("#btn_inform_submit").attr('disabled',true);
                alert("<?php echo $lang['inform_subject_null'];?>");
            }

        }
	});
}
</script>
