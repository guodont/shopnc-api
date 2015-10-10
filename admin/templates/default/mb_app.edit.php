<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>下载设置</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>下载设置</span></a></li>
        <li><a href="index.php?act=mb_app&op=mb_qr"><span>生成二维码</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li>当前安卓安装包版本用于安卓包在线升级，请保证所填版本号与提供下载的apk文件保持一致</li>
            <li>下载地址为完整的网址，以“http://”开头，“生成二维码”中网址为程序自动生成</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="post_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="" for="mobile_apk">安卓安装包:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <input type="text" name="mobile_apk" id="mobile_apk" value="<?php echo $output['mobile_apk']['value'];?>" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="" for="mobile_apk">当前安卓安装包版本:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <input type="text" name="mobile_apk_version" id="mobile_apk_version" value="<?php echo $output['mobile_version']['value'];?>" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="" for="mobile_ios">iOS版:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <input type="text" name="mobile_ios" id="mobile_ios" value="<?php echo $output['mobile_ios']['value'];?>" class="txt" >
          </td>
          <td class="vatop tips"></td>
        </tr>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#post_form").valid()){
     $("#post_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#post_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            mobile_apk : {
                url      : true
            },
            mobile_ios  : {
                url      : true
            }
        },
        messages : {
            mobile_apk  : {
                url      : '链接格式不正确'
            },
            mobile_ios  : {
                url      : '链接格式不正确'
            }
        }
    });
});
</script>
