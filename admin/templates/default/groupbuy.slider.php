<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['groupbuy_index_manage'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table id="prompt" class="table tb-type2">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"> <div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span> </div>
        </th>
      </tr>
      <tr class="odd">
        <td><ul>
            <li>该组幻灯片滚动图片应用于抢购聚合页上部使用，最多可上传4张图片。</li>
            <li>图片要求使用宽度为970像素，高度为300像素jpg/gif/png格式的图片。</li>
            <li>上传图片后请添加格式为“http://网址...”链接地址，设定后将在显示页面中点击幻灯片将以另打开窗口的形式跳转到指定网址。</li>
            <li>清空操作将删除聚合页上的滚动图片，请注意操作</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="live_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td class="required"><label>滚动图片1:</label></td>
          <td><label>链接地址:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_LIVE.DS.$output['list_setting']['live_pic1'];?>"></div>
            </span><span class="type-file-box">
            <input type='text' name='textfield1' id='textfield1' class='type-file-text' />
            <input type='button' name='button' id='button' value='' class='type-file-button' />
            <input name="live_pic1" type="file" class="type-file-file" id="live_pic1" size="30" hidefocus="true" />
            </span></td>
          <td class="vatop"><input type="text" name="live_link1" class="w200" value="<?php echo $output['list_setting']['live_link1']?>"></td>
        </tr>
        <tr>
          <td class="required"><label>滚动图片2:</label></td>
          <td><label>链接地址:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_LIVE.DS.$output['list_setting']['live_pic2'];?>"></div>
            </span><span class="type-file-box">
            <input type='text' name='textfield2' id='textfield2' class='type-file-text' />
            <input type='button' name='button' id='button' value='' class='type-file-button' />
            <input name="live_pic2" type="file" class="type-file-file" id="live_pic2" size="30" hidefocus="true" />
            </span></td>
          <td class="vatop tips"><input type="text" name="live_link2" class="w200" value="<?php echo $output['list_setting']['live_link2']?>"></td>
        </tr>
        <tr>
          <td class="required"><label>滚动图片3:</label></td>
          <td><label>链接地址:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_LIVE.DS.$output['list_setting']['live_pic3'];?>"></div>
            </span><span class="type-file-box">
            <input type='text' name='textfield3' id='textfield3' class='type-file-text' />
            <input type='button' name='button' id='button' value='' class='type-file-button' />
            <input name="live_pic3" type="file" class="type-file-file" id="live_pic3" size="30" hidefocus="true" />
            </span></td>
          <td class="vatop tips"><input type="text" name="live_link3" class="w200" value="<?php echo $output['list_setting']['live_link3']?>"></td>
        </tr>
        <tr>
          <td class="required"><label>滚动图片4:</label></td>
          <td><label>链接地址:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_LIVE.DS.$output['list_setting']['live_pic4'];?>"></div>
            </span><span class="type-file-box">
            <input type='text' name='textfield4' id='textfield4' class='type-file-text' />
            <input type='button' name='button' id='button' value='' class='type-file-button' />
            <input name="live_pic4" type="file" class="type-file-file" id="live_pic4" size="30" hidefocus="true" />
            </span></td>
          <td class="vatop tips"><input type="text" name="live_link4" class="w200" value="<?php echo $output['list_setting']['live_link4']?>"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2">
            <a href="JavaScript:void(0);" class="btn" id="submitBtn"><span>保存</span></a>
            <a href="JavaScript:void(0);" class="btn" id="clearBtn"><span>清空</span></a>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script>
//按钮先执行验证再提交表单
$(function(){
    // 图片js
    $("#live_pic1").change(function(){$("#textfield1").val($("#live_pic1").val());});
    $("#live_pic2").change(function(){$("#textfield2").val($("#live_pic2").val());});
    $("#live_pic3").change(function(){$("#textfield3").val($("#live_pic3").val());});
    $("#live_pic4").change(function(){$("#textfield4").val($("#live_pic4").val());});

    $('#live_form').validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            live_link1: {
                url : true
            },
            live_link2:{
                url : true
            },
            live_link3:{
                url : true
            },
            live_link4:{
                url : true
            },
        },
        messages : {
            live_link1: {
                url : '链接地址格式不正确'
            },
            live_link2:{
                url : '链接地址格式不正确'
            },
            live_link3:{
                url : '链接地址格式不正确'
            },
            live_link4:{
                url : '链接地址格式不正确'
            },
        }
    });

    $('#clearBtn').click(function(){
        if (!confirm('确认清空虚拟抢购幻灯片设置？')) {
            return false;
        }
        $.ajax({
            type:'get',
            url:'index.php?act=vr_groupbuy&op=slider_clear',
            dataType:'json',
            success:function(result){
                if(result.result){
                    alert('清空成功');
                    location.reload();
                }
            }
        });
    });

    $("#submitBtn").click(function(){
        $("#live_form").submit();
    });
});
</script>
