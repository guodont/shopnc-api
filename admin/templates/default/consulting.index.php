<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['consulting_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('consulting', 'setting');?>"><span>设置</span></a></li>
        <li><a href="<?php echo urlAdmin('consulting', 'type_list');?>"><span>咨询类型</span></a></li>
        <li><a href="<?php echo urlAdmin('consulting', 'type_add');?>"><span>新增类型</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="act" value="consulting" />
    <input type="hidden" name="op" value="consulting" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="member_name"><?php echo $lang['consulting_index_sender'];?></label></th>
          <td><input class="txt" type="text" name="member_name" id="member_name" value="<?php echo $output['member_name'];?>" /></td>
          <th><label for="consult_content"> <?php echo $lang['consulting_index_content'];?></label></th>
          <td><input class="txt" type="text" name="consult_content" id="consult_content" value="<?php echo $output['consult_content'];?>" /></td>
          <td><label for="consult_type">咨询类型</label></td>
          <td>
            <select name="ctid">
              <option value="0">全部</option>
              <?php if (!empty($output['consult_type'])) {?>
              <?php foreach ($output['consult_type'] as $val) {?>
              <option <?php if ($output['ctid'] == $val['ct_id']) {?>selected="selected"<?php }?> value="<?php echo $val['ct_id'];?>"><?php echo $val['ct_name'];?></option>
              <?php }?>
              <?php }?>
            </select>
          </td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if($output['form_submit'] == 'ok'){?>
            <a class="btns " href="index.php?act=consulting&op=consulting" title="<?php echo $lang['nc_cancel_search'];?>"><span><?php echo $lang['nc_cancel_search'];?></span></a>
            <?php }?>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['consulting_index_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" action="index.php?act=consulting&op=delete" onsubmit="return checkForm() && confirm('<?php echo $lang['nc_ensure_del'];?>');" name="form1">
    <table class="table tb-type2">
      <tbody>
        <?php if(is_array($output['consult_list']) and count($output['consult_list'])>0){ ?>
        <?php foreach($output['consult_list'] as $k=>$consult){?>
        <tr class="space">
          <th class="w24"><input type="checkbox" class="checkitem" name="consult_id[]" value="<?php echo $consult['consult_id'];?>" /></th>
          <th>
          	<strong><?php echo $lang['consulting_index_object'];?>:&nbsp;</strong>
          	<span><a target="_blank" href="<?php echo SHOP_SITE_URL."/index.php?act=goods&goods_id=".$consult['goods_id'].'&id='.$consult['store_id'];?>"><?php echo $consult['goods_name'];?></a></span>
          </th>
          <th><strong><?php echo $lang['consulting_index_store_name'];?>:</strong>&nbsp;<a href="<?php echo urlShop('show_store','index', array('store_id'=>$consult['store_id']));?>" class="normal" ><?php echo $consult['store_name'];?></a></th>
          <th><strong><?php echo $lang['nc_handle'];?>:</strong>&nbsp;<a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='<?php echo urlencode('index.php?act=consulting&op=delete&consult_id='.$consult['consult_id']);?>';}" class="normal" ><?php echo $lang['nc_del'];?></a></th>
        </tr>
        <tr>
          <td colspan="12"><fieldset class="w mtn">
              <legend><span><strong><?php echo $lang['consulting_index_sender'];?>:</strong>&nbsp;
              <?php if(empty($consult['member_id']) or $consult['member_id'] == '0'){ echo $lang['consulting_index_guest'];}else{echo $consult['member_name'];}?>
              </span>&nbsp;&nbsp;&nbsp;&nbsp;<span><strong><?php echo $lang['consulting_index_time'];?>:</strong>&nbsp;<?php echo date("Y-m-d H:i:s",$consult['consult_addtime']);?></span></legend>
              <div class="formelement" id="hutia_<?php echo $k;?>"><?php echo $consult['consult_content'];?></div>
            </fieldset>
            <fieldset class="d mtm mbw">
              <legend><strong><?php echo $lang['consulting_index_reply'];?>:</strong></legend>
              <div class="formelement" id="hutia2_<?php echo $k;?>">
                <?php if($consult['consult_reply'] != ''){?>
                <?php echo $consult['consult_reply'];?>
                <?php }else{?>
                <?php echo $lang['consulting_index_no_reply'];?>
                <?php }?>
              </div>
            </fieldset>
         </td>
        </tr>
        <?php }?>
        <?php }else{?>
        <tr class="no_data">
          <td colspan="20"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php }?>
      </tbody>
      <tfoot>
        <?php if(is_array($output['consult_list']) and count($output['consult_list'])>0){?>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"><?php echo $output['show_page'];?></div></td>
        </tr>
        <?php }?>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
function checkForm(){
	flag = false;
	$.each($("input[name='consult_id[]']"),function(i,n){
		if($(n).attr('checked')){
			flag = true;
			return false;
		}
	});
	if(!flag)alert('<?php echo $lang['consulting_del_choose'];?>');
	return flag;
}
</script>
<script>
(function(){
  $('.w').each(function(i){
  var o = document.getElementById("hutia_"+i);
  var s = o.innerHTML;
  var p = document.createElement("span");
  var n = document.createElement("a");
  p.innerHTML = s.substring(0,50);
  n.innerHTML = s.length > 50 ? "<?php echo $lang['consulting_index_unfold'];?>" : "";
  n.href = "###";
  n.onclick = function(){
    if (n.innerHTML == "<?php echo $lang['consulting_index_unfold'];?>"){
      n.innerHTML = "<?php echo $lang['consulting_index_retract'];?>";
      p.innerHTML = s;
    }else{
      n.innerHTML = "<?php echo $lang['consulting_index_unfold'];?>";
      p.innerHTML = s.substring(0,50);
    }
  }
  o.innerHTML = "";
  o.appendChild(p);
  o.appendChild(n);
  });
})();
(function(){
	  $('.d').each(function(i){
	  var o = document.getElementById("hutia2_"+i);
	  var s = o.innerHTML;
	  var p = document.createElement("span");
	  var n = document.createElement("a");
	  p.innerHTML = s.substring(0,50);
	  n.innerHTML = s.length > 50 ? "<?php echo $lang['consulting_index_unfold'];?>" : "";
	  n.href = "###";
	  n.onclick = function(){
	    if (n.innerHTML == "<?php echo $lang['consulting_index_unfold'];?>"){
	      n.innerHTML = "<?php echo $lang['consulting_index_retract'];?>";
	      p.innerHTML = s;
	    }else{
	      n.innerHTML = "<?php echo $lang['consulting_index_unfold'];?>";
	      p.innerHTML = s.substring(0,50);
	    }
	  }
	  o.innerHTML = "";
	  o.appendChild(p);
	  o.appendChild(n);
	  });
	})();
  </script>
