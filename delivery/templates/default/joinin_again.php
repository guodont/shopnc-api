<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
body {
background: #637159 url(<?php echo DELIVERY_TEMPLATES_URL;
?>/images/login_bg.png) no-repeat center top;
}
</style>

<div class="ncd-joinin">
  <h1>物流自提服务站加盟-重新申请</h1>
  <form id="delivery_joinin" method="post" enctype="multipart/form-data" action="<?php echo DELIVERY_SITE_URL?>/index.php?act=joinin_again&op=edit_delivery">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="did" value="<?php echo $output['dpoint_info']['dlyp_id'];?>">
    <dl class="r1">
      <dt>账户登录信息：</dt>
      <dd>
        <label class="phrases">输入用户名</label>
        <input class="input-txt tip" type="text" name="dname" id="dname" value="<?php echo $output['dpoint_info']['dlyp_name'];?>"  title="3-15位字符，可由中文、英文、数字及“_”、“-”组成。">
        <span></span>
      </dd>
      <dd>
        <label class="phrases">设定密码</label>
        <input class="input-txt tip" type="password" name="dpasswd" id="dpasswd" title="6-20位字符，可由英文、数字及标点符号组成。">
        <span></span>
      </dd>
      <dd>
        <label class="phrases">确认密码</label>
        <input class="input-txt tip" type="password" name="dpasswd_confirm" id="dpasswd_confirm" title="请再次输入您的密码，保持两次一致。">
        <span></span>
      </dd>
    </dl>
    <dl class="r3">
      <dt>申请人认证：</dt>
      <dd>
        <label class="phrases">您的真实姓名</label>
        <input class="input-txt tip w100" type="text" name="dtruename" id="dtruename" value="<?php echo $output['dpoint_info']['dlyp_truename'];?>" title="如实填写申请人的真实姓名，平台将严格保密，仅用于申请审核使用。">
        <span></span>
      </dd>
      <dd>
        <label class="phrases">您的身份证号码</label>
        <input class="input-txt tip w200" type="text" name="didcard" id="didcard" value="<?php echo $output['dpoint_info']['dlyp_idcard'];?>" title="如实填写申请人18位身份证号码，平台将严格保密，仅用于申请审核使用。">
        <span></span>
      </dd>
      <dd>
        <input type="file" class="input-txt tip w200" name="didcardimg" id="didcardimg" title="上传申请人身份证复印件，大小控制在1M以内。">
        <span></span>
      </dd>
    </dl>
    <dl class="r2">
      <dt>服务站信息提交：</dt>
      <dd>
        <label class="phrases">服务站名称</label>
        <input class="input-txt tip" type="text" name="daddressname" id="daddressname" value="<?php echo $output['dpoint_info']['dlyp_address_name']?>" title="服务站名称请使用您的实体店铺或经营场所、办公地点名称，例如“某某超市”、“某某小区物业”，便于收货人自提时使用；最多不超过15位字符。">
      </dd>
      <dd id="region">
        <label class="txt">所在地区</label>
        <select class="select">
        </select>
        <input type="hidden" name="area_id_2" id="area_id_2" value="">
        <input type="hidden" name="area_info" id="area_info" value="" class="area_names" />
        <input type="hidden" name="area_id" id="area_id" value="" class="area_ids" />
        <span></span>
      </dd>
      <dd>
        <label class="phrases">详细地址</label>
        <input class="input-txt tip w400" type="text" name="daddress" id="daddress" value="<?php echo $output['dpoint_info']['dlyp_address'];?>" title="服务站详细地址不需要重新填写省市区，必须大于5个字符，小于50个字符。">
        <span></span>
      </dd>
      <dd>
        <label class="phrases">联系用手机</label>
        <input class="input-txt tip" type="text" name="dmobile" id="dmobile" value="<?php echo $output['dpoint_info']['dlyp_mobile'];?>" title="联系用手机将提供给收货人，方便自提咨询时联系。">
        <span></span>
      </dd>
      <dd>
        <label class="phrases">联系用固定电话</label>
        <input class="input-txt tip" type="text" name="dtelephony" id="dtelephony" value="<?php echo $output['dpoint_info']['dlyp_telephony'];?>" title="联系用固定电话将提供给收货人，方便自提咨询时联系。">
        <span></span>
      </dd>
      
    </dl>
    <div style="text-align: center; padding: 10px 0;">
      <input type="submit" class="submit" value="入驻申请再次提交">
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js" charset="utf-8"></script> 
<script type="text/javascript">
regionInit("region");
$(function(){
    $("#delivery_joinin .input-txt").placeholder()
    //注册表单提示
    $('.tip').poshytip({
        className: 'tip-yellowsimple',
        showOn: 'focus',
        alignTo: 'target',
        alignX: 'center',
        alignY: 'top',
        offsetX: 0,
        offsetY: 5,
        allowTipHover: false
    });
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[^:%,'\*\"\s\<\>\&]+$/i.test(value);
    }, "只能由中文、英文、数字及“_”、“-”组成"); 
    $('#delivery_joinin').validate({
        errorPlacement: function(error, element){
            element.next().append(error);
        },
        submitHandler:function(form){
            $('#area_id_2').val($("#region").find('select:eq(1)').val());
            ajaxpost('delivery_joinin', '', '', 'onerror');
        },
        rules : {
            dname : {
                required : true,
                rangelength : [3,15],
                lettersonly : true,
                remote   : 'index.php?act=joinin_again&op=check&did=<?php echo $output['dpoint_info']['dlyp_id'];?>'
            },
            dpasswd : {
                required : true,
                rangelength : [3,15]
            },
            dpasswd_confirm : {
                required : true,
                rangelength : [3,15],
                equalTo : '#dpasswd'
            },
            dtruename : {
                required : true,
                rangelength : [2,15]
            },
            daddressname : {
                required : true,
                maxlength : 15,
            },
            didcard : {
                required : true,
                rangelength : [18,18],
                remote   : 'index.php?act=joinin_again&op=check&did=<?php echo $output['dpoint_info']['dlyp_id'];?>'
            },
            didcardimg : {
                required : true,
                accept : 'png|jpe?g|gif'
            },
            area_id : {
                required : true,
                min : 1,
                checkarea : true
            },
            daddress : {
                required : true
            },
            dmobile : {
                required : true,
                digits : true,
                rangelength : [11,11],
                remote   : 'index.php?act=joinin_again&op=check&did=<?php echo $output['dpoint_info']['dlyp_id'];?>'
            }
        },
        messages : {
            dname : {
                required : '请输入您的用户名',
                rangelength : '用户名长度在3-15个字符之间',
                remote : '用户名已经存在'
            },
            dpasswd  : {
                required : '请输入您的密码',
                rangelength : '密码长度在3-15个字符之间'
            },
            dpasswd_confirm : {
                required : '请输入您的密码',
                rangelength : '密码长度在3-15个字符之间',
                equalTo : '请输入相同的密码'
            },
            dtruename : {
                required : '请输入您的真实姓名',
                rangelength : '真实姓名长度在2-15个字符之间'
            },
            daddressname : {
                required : '请填写服务站名称',
                maxlength : '长度不超过15个字符',
            },
            didcard : {
                required : '请输入您的身份证号码',
                rangelength : '请输入有效的身份证号码',
                remote : '身份证号码已经被使用过了'
            },
            didcardimg : {
                required : '请上传您的身份证复件',
                accept : '请上传正确的图片'
            },
            area_id : {
                required : '请选择所在地区',
                min : '请选择所在地区',
                checkarea : '请选择所在地区'
            },
            daddress : {
                required : '请输入您的详细地址'
            },
            dmobile : {
                required : '请输入您的手机号码',
                digits : '请输入正确的手机号码',
                rangelength : '请输入正确的手机号码',
                remote : '手机号码已经被使用过了'
            }
        }
    });
})
</script>