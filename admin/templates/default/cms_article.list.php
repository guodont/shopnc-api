<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    //行内ajax编辑
    $('span[nc_type="article_sort"]').inline_edit({act: 'cms_article',op: 'update_article_sort'});
    $('span[nc_type="article_click"]').inline_edit({act: 'cms_article',op: 'update_article_click'});

    //批量删除
    $("#btn_delete_batch").click(function() {
        var item = submit_batch(submit_delete); 
        return false;
    });

    //审核
    $('input[name="verify_state"]').click(function(){
        if ($(this).val() == 1) {
            $('tr[nctype="reason"]').hide();
        } else {
            $('tr[nctype="reason"]').show();
        }
    });
    $('#btn_verify_submit').on('click', function() {
        $('#verify_form').submit();
    });

});
//批量操作
function submit_batch(batch_op){
    /* 获取选中的项 */
    var items = '';
    $('.checkitem:checked').each(function(){
        items += this.value + ',';
    });
    if(items != '') {
        items = items.substr(0, (items.length - 1));
        batch_op(items);
    } else {
        alert('<?php echo $lang['nc_please_select_item'];?>');
        return false;
    }
}

//删除
function submit_delete(id){
    if(confirm('<?php echo $lang['nc_ensure_del'];?>')) {
        $('#list_form').attr('action','index.php?act=cms_article&op=cms_article_drop');
        $('#article_id').val(id);
        $('#list_form').submit();
    }
}

function submit_verify(id) {
    $('#verify_article_id').val(id);
    $('#dialog_verify').nc_show_dialog({title:'审核'});
}

//收回
function submit_callback(id){
    if(confirm('<?php echo $lang['cms_ensure_callback'];?>')) {
        $('#list_form').attr('action','index.php?act=cms_article&op=cms_article_callback');
        $('#article_id').val(id);
        $('#list_form').submit();
    }
}
</script>

<div class="page">
    <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_cms_article_manage'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" <?php if($menu['target']=='_blank') echo 'target="_blank"';?> ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" value="cms_article" name="act">
    <input type="hidden" value="<?php echo $_GET['op'];?>" name="op">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="article_title"><?php echo $lang['cms_text_title'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['article_title'];?>" name="article_title" class="txt"></td>
          <th><label for="article_publisher_name"><?php echo $lang['cms_text_publisher'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['article_publisher_name'];?>" name="article_publisher_name" class="txt"></td>
          <?php if($_GET['op'] == 'cms_article_list') { ?>
          <th><label for="article_state"><?php echo $lang['cms_text_state'];?></label></th>
          <td><select name="article_state">
              <option value="0"><?php echo $lang['nc_please_choose'];?></option>
              <?php if(!empty($output['article_state_list']) && is_array($output['article_state_list'])) {?>
              <?php foreach($output['article_state_list'] as $key=>$value) {?>
              <option value="<?php echo $key;?>" <?php if($key==$_GET['article_state']) { echo 'selected'; } ?> ><?php echo $value['text'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <?php } ?>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <!-- 操作说明 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"> <div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span> </div>
        </th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['cms_article_class_list_tip1'];?></li>
            <li><?php echo $lang['cms_article_class_list_tip2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="list_form" method='post'>
    <input id="article_id" name="article_id" type="hidden" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="15" class="nobg"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th></th>
          <th class="align-left"><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['cms_text_title'];?></th>
          <th class="align-left"></th>
          <th><?php echo $lang['cms_text_click_count'];?></th>
          <th class="align-center"><?php echo $lang['cms_text_artcile_commend'];?></th>
          <th class="align-center"><?php echo $lang['cms_text_artcile_commend2'];?></th>
          <th class="align-center"><?php echo $lang['cms_text_comment'];?></th>
          <th class="align-center"><?php echo $lang['cms_text_attitude'];?></th>
          <th class="align-center"><?php echo $lang['cms_text_state'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $val){ ?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" value="<?php echo $val['article_id'];?>" class="checkitem"></td>
          <td class="w48 sort"><span nc_type="article_sort" column_id="<?php echo $val['article_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable "><?php echo $val['article_sort'];?></span>
          <td class="w60 picture"><div class="size-56x56"><span class="thumb size-56x56"><i></i><img onload="javascript:DrawImage(this,56,56);" src="<?php echo getCMSArticleImageUrl($val['article_attachment_path'], $val['article_image']);?>"></span></div></td>
          <td><p><?php echo $val['article_title'];?></p>
            <p><?php echo $lang['cms_text_publisher'];?><?php echo $lang['nc_colon'];?><?php echo $val['article_publisher_name'];?></p></td>
          <td class="w48 sort"><span nc_type="article_click" column_id="<?php echo $val['article_id'];?>" title="<?php echo $lang['nc_editable'];?>" class="editable "><?php echo $val['article_click'];?></span>
          <td class="w60 align-center yes-onoff"><a href="JavaScript:void(0);" class=" <?php echo $val['article_commend_flag']? 'enabled':'disabled'?>" ajax_branch='article_commend'  nc_type="inline_edit" fieldname="article_commend_flag" fieldid="<?php echo $val['article_id']?>" fieldvalue="<?php echo $val['article_commend_flag']?'1':'0'?>" title="<?php echo $lang['editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a></td>
          <td class="w60 align-center yes-onoff"><a href="JavaScript:void(0);" class=" <?php echo $val['article_commend_image_flag']? 'enabled':'disabled'?>" ajax_branch='article_commend_image'  nc_type="inline_edit" fieldname="article_commend_image_flag" fieldid="<?php echo $val['article_id']?>" fieldvalue="<?php echo $val['article_commend_image_flag']?'1':'0'?>" title="<?php echo $lang['editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a></td>
          <td class="w60 align-center yes-onoff"><a href="JavaScript:void(0);" class=" <?php echo $val['article_comment_flag']? 'enabled':'disabled'?>" ajax_branch='article_comment'  nc_type="inline_edit" fieldname="article_comment_flag" fieldid="<?php echo $val['article_id']?>" fieldvalue="<?php echo $val['article_comment_flag']?'1':'0'?>" title="<?php echo $lang['editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a></td>
          <td class="w60 align-center yes-onoff"><a href="JavaScript:void(0);" class=" <?php echo $val['article_attitude_flag']? 'enabled':'disabled'?>" ajax_branch='article_attitude'  nc_type="inline_edit" fieldname="article_attitude_flag" fieldid="<?php echo $val['article_id']?>" fieldvalue="<?php echo $val['article_attitude_flag']?'1':'0'?>" title="<?php echo $lang['editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a></td>
          <td class="w60 align-center"><?php echo $output['article_state_list'][$val['article_state']]['text'];?></td>
          <td class="w108 align-center">
              <a href="<?php echo CMS_SITE_URL.'/index.php?act=article&op=article_detail&article_id='.$val['article_id'];?>" target="_blank"><?php echo $lang['cms_text_see'];?></a>
              <?php if($val['verify_able']) {?>
              <a href="javascript:submit_verify(<?php echo $val['article_id'];?>);">审核</a>
              <?php } ?>
              <?php if($val['callback_able']) {?>
              <a href="javascript:submit_callback(<?php echo $val['article_id'];?>);"><?php echo $lang['cms_text_op_callback'];?></a>
              <?php } ?>
              <a href="javascript:submit_delete(<?php echo $val['article_id'];?>)"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td id="batchAction" colspan="15">
              <span class="all_checkbox">
                  <label for="checkall_1"><?php echo $lang['nc_select_all'];?></label>
              </span>
              &nbsp;&nbsp;
              <a href="javascript:void(0)" class="btn" id="btn_delete_batch"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"><?php echo $output['show_page'];?></div>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<div id="dialog_verify" style="display:none;">
    <form id="verify_form" method='post' action="index.php?act=cms_article&op=cms_article_verify">
        <input id="verify_article_id" name="article_id" type="hidden" />
        <table class="table tb-type2 nobdb">
            <tbody>
                <tr class="noborder">
                    <td class="required" colspan="2"><label>审核通过:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform onoff">
                        <label title="是" class="cb-enable selected" for="rewrite_enabled"><span>是</span></label>
                        <label title="否" class="cb-disable" for="rewrite_disabled"><span>否</span></label>
                        <input type="radio" value="1" checked="checked" name="verify_state" id="rewrite_enabled">
                        <input type="radio" value="0" name="verify_state" id="rewrite_disabled"></td>
                    <td class="vatop tips">
                    </td>
                </tr>
                <tr style="display: none;" nctype="reason">
                    <td class="required" colspan="2"><label for="verify_reason">未通过理由:</label></td>
                </tr>
                <tr style="display :none;" nctype="reason" class="noborder">
          <td class="vatop rowform"><textarea id="verify_reason" name="verify_reason" cols="60" class="tarea" rows="6"></textarea></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2"><a id="btn_verify_submit" class="btn" href="javascript:void(0);"><span>提交</span></a></td>
        </tr>
      </tfoot>
    </table>
</form>
</div>
