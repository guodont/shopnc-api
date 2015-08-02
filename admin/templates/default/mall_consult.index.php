<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>平台客服</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>平台客服咨询列表</span></a></li>
        <li><a href="<?php echo urlAdmin('mall_consult', 'type_list');?>"><span>平台咨询类型</span></a></li>
        <li><a href="<?php echo urlAdmin('mall_consult', 'type_add');?>"><span>新增类型</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="act" value="mall_consult" />
    <input type="hidden" name="op" value="index" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="member_name">咨询人</label></th>
          <td><input class="txt" type="text" name="member_name" id="member_name" value="<?php echo $output['member_name'];?>" /></td>
          <td><label for="consult_type">咨询类型</label></td>
          <td>
            <select name="mctid">
              <option value="0">全部</option>
              <?php if (!empty($output['type_list'])) {?>
              <?php foreach ($output['type_list'] as $val) {?>
              <option <?php if ($output['mctid'] == $val['mct_id']) {?>selected="selected"<?php }?> value="<?php echo $val['mct_id'];?>"><?php echo $val['mct_name'];?></option>
              <?php }?>
              <?php }?>
            </select>
          </td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if($output['form_submit'] == 'ok'){?>
            <a class="btns " href="<?php echo urlAdmin('mall_consult', 'index');?>" title="<?php echo $lang['nc_cancel_search'];?>"><span><?php echo $lang['nc_cancel_search'];?></span></a>
            <?php }?>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method="post" action="<?php echo urlAdmin('mall_consult', 'del_consult_batch');?>" onsubmit="" name="form1">
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th class="align-center">咨询内容</th>
          <th class="w96 align-center">咨询人</th>
          <th class="w156 align-center">咨询时间</th>
          <th class="w96 align-center">回复状态</th>
          <th class="w72 align-center"><?php echo $lang['nc_handle'];?> </th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['consult_list'])){ ?>
        <?php foreach($output['consult_list'] as $val){?>
        <tr class="space">
          <td class="w24"><input type="checkbox" class="checkitem" name="id[]" value="<?php echo $val['mc_id'];?>" /></td>
          <td><?php echo $val['mc_content'];?></td>
          <td class="align-center"><?php echo $val['member_name'];?></td>
          <td class="align-center"><?php echo date('Y-m-d H:i:s', $val['mc_addtime']);?></td>
          <td class="align-center"><?php echo $output['state'][$val['is_reply']];?></td>
          <td>
            <a href="<?php echo urlAdmin('mall_consult', 'consult_reply', array('id' => $val['mc_id']));?>"><?php if ($val['is_reply'] == 0) {?>回复<?php } else {?>编辑<?php }?></a> | 
            <a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='<?php echo urlAdmin('mall_consult', 'del_consult', array('id' => $val['mc_id']));?>';}" class="normal" ><?php echo $lang['nc_del'];?></a>
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
        <?php if(!empty($output['consult_list'])){?>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if ($('.checkitem:checked ').length == 0) { alert('请选择需要删除的选项！');return false;}  if(confirm('<?php echo $lang['nc_ensure_del'];?>')){document.form1.submit();}"><span><?php echo $lang['nc_del'];?></span></a>
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
