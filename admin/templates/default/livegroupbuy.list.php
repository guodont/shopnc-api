<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
function submit_delete_batch(type){
    /* 获取选中的项 */
    var items = '';
    $('.checkitem:checked').each(function(){
        items += this.value + ',';
    });

    if(items != '') {
        items = items.substr(0, (items.length - 1));
        submit_delete(items,type);
    }  
    else {
        alert('<?php echo $lang['nc_please_select_item'];?>');
    }
}
function submit_delete(id){
    if(confirm('确认删除该抢购?')) {
        $('#list_form').attr('method','post');
       	$('#list_form').attr('action','index.php?act=live_groupbuy&op=del_groupbuy');
        
        $('#groupbuy_id').val(id);
        $('#list_form').submit();
    }
}

function groupbuy(type,url){
	if(type == 'refuse'){
		if(confirm('确认拒绝抢购申请?')){
			location.href = url;
		}
	}else if(type == 'pass'){
		if(confirm('确认通过抢购申请?')){
			location.href = url;
		}
	}else if(type == 'cancel'){
		if(confirm('确认取消该抢购?')){
			location.href = url;
		}	
	}
}

</script>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>线下抢活动</h3>
      <ul class="tab-base">
        <li><a href="javascript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="formSearch">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
		  <th><label for="groupbuy_state"><?php echo $lang['live_groupbuy_groupbuy_state'];?></label></th>
		  <td>
			  <select name='groupbuy_state'>
			    <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
				<option value="1" <?php if($output['groupbuy_state']==1){ echo 'selected';}?>><?php echo $lang['live_groupbuy_soon_start'];?></option>
				<option value="2" <?php if($output['groupbuy_state']==2){ echo 'selected';}?>><?php echo $lang['live_groupbuy_now'];?></option>
				<option value="3" <?php if($output['groupbuy_state']==3){ echo 'selected';}?>><?php echo $lang['live_groupbuy_already_end'];?></option>
			  </select>
		  </td>
		  <th><label><?php echo $lang['live_groupbuy_groupbuy_audit'];?></label></th>
		  <td>
		  	<select name="audit">
		  		<option value=""><?php echo $lang['nc_please_choose'];?>...</option>
		  		<option value="1" <?php if($output['is_audit']==1){ echo 'selected';}?>>待审核</option>
		  		<option value="2" <?php if($output['is_audit']==2){ echo 'selected';}?>>通过</option>
		  		<option value="3" <?php if($output['is_audit']==3){ echo 'selected';}?>>拒绝</option>
		  	</select>
		  </td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query']; ?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <!-- 操作说明 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg">
	        <div class="title">
	            <h5><?php echo $lang['nc_prompts'];?></h5>
	            <span class="arrow"></span>
	        </div>
        </th>
      </tr>
      <tr>
        <td>
		  <ul>
            <li>可以对商家发布的抢购活动进行审核，审核通过会员可以进行抢购，审核拒绝商家需要重新编辑</li>
			<li>可以对抢购活动进行“取消”操作，操作成功，会员则不可以抢购该活动</li>
			<li>可以按照抢购状态和审核状态进行查询</li>
          </ul>
		</td>
      </tr>
    </tbody>
  </table>
  <form id="list_form" method='post'>
    <input id="groupbuy_id" name="groupbuy_id" type="hidden" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="15" class="nobg"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th class="w200" colspan="2"><?php echo $lang['live_groupbuy_groupbuy_name'];?></th>
		  <th class="w120">开始时间</th>
		  <th class="w120">结束时间</th>
		  <th class="w48"><?php echo $lang['live_groupbuy_groupbuy_original_price'];?></th>
		  <th class="w48"><?php echo $lang['live_groupbuy_groupbuy_price'];?></th>
          <th class="w48"><?php echo $lang['live_groupbuy_groupbuy_buyer_count'];?></th>
		  <th class="w48">抢购上线</th>
		  <th class="w48"><?php echo $lang['live_groupbuy_groupbuy_buyer_num'];?></th>
		  <th class="w48"><?php echo $lang['live_groupbuy_groupbuy_audit'];?></th>
		  <th class="w48">推荐</th>
		  <th class="w48"><?php echo $lang['live_groupbuy_groupbuy_state'];?></th>
		  <th class="w120 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $val){ ?>
        <tr class="hover edit">
          <td class="w60 picture">
          	<div class="size-56x56"><span class="thumb size-56x56"><i></i>
          	<a target="_blank" href="<?php echo SHOP_SITE_URL."/index.php?act=show_live_groupbuy&op=groupbuy_detail&groupbuy_id=".$val['groupbuy_id'];?>"><img src="<?php echo lgthumb($val['groupbuy_pic'], 'small');?>" style=" max-width: 56px; max-height: 56px;"/></a></span></div>
          </td>
          <td class="group">
            <p><a target="_blank" href="<?php echo SHOP_SITE_URL."/index.php?act=show_live_groupbuy&op=groupbuy_detail&groupbuy_id=".$val['groupbuy_id'];?>"><?php echo $val['groupbuy_name'];?></a></p>
            <p class="store">店铺名称:<a target="_blank" href="<?php echo urlShop('show_store','index', array('store_id'=>$val['store_id']));?>" title="<?php echo $val['store_name'];?>"><?php echo $val['store_name'];?></a></p>
          </td>
		  <td><?php echo date("Y-m-d",$val['start_time']);?></td>
		  <td><?php echo date("Y-m-d",$val['end_time']);?></td>
		  <td><?php echo $val['original_price'];?></td>
		  <td><?php echo $val['groupbuy_price'];?></td>
		  <td><?php echo $val['buyer_count'];?></td>
		  <td><?php echo $val['buyer_limit'];?></td>
		  <td><?php echo $val['buyer_num'];?></td>
		  <td>
		  	<?php if($val['is_audit'] == 1){?>
		  	<?php echo '待审核';?>
		  	<?php }elseif($val['is_audit'] == 2){?>
		  	<?php echo '通过';?>
		  	<?php }else{?>
		  	<?php echo '拒绝';?>
		  	<?php }?>
		  </td>
		  <td class="yes-onoff align-center"><?php if($val['is_hot'] == '0'){ ?>
            <a href="JavaScript:void(0);" class=" disabled" ajax_branch='recommended' nc_type="inline_edit" fieldname="recommended" fieldid="<?php echo $val['groupbuy_id']?>" fieldvalue="0" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else { ?>
            <a href="JavaScript:void(0);" class=" enabled" ajax_branch='recommended' nc_type="inline_edit" fieldname="recommended" fieldid="<?php echo $val['groupbuy_id']?>" fieldvalue="1" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>
		  <td>		 
		  <?php if($val['is_open']==2){?>
		    已取消
		  <?php }else{?>
	  		<?php if($val['start_time']>time()){?>
			<?php echo '即将开始';?>
			<?php }elseif(($val['start_time']<=time()) && ($val['end_time']>time())){?>
			<?php echo '正在进行';?>
			<?php }elseif($val['end_time']<time()){?>
			<?php echo '已经结束';?>
			<?php }?>		  
		  <?php }?>
		  </td>
		  <td class='align-center'>
		  	<?php if($val['is_audit']==1){?>
		  	<a href="javascript:;" onclick="javascript:groupbuy('pass','index.php?act=live_groupbuy&op=audit&groupbuy_id=<?php echo $val['groupbuy_id'];?>&is_audit=2');">通过</a>&nbsp;|&nbsp;
		  	<a href="javascript:;" onclick="javascript:groupbuy('refuse','index.php?act=live_groupbuy&op=audit&groupbuy_id=<?php echo $val['groupbuy_id'];?>&is_audit=3');">拒绝</a>
		  	<?php }elseif($val['is_audit']==2){?>
				<?php if($val['is_open']==1){?>
				<a href="javascript:;" onclick="javascript:groupbuy('cancel','index.php?act=live_groupbuy&op=cancel&groupbuy_id=<?php echo $val['groupbuy_id'];?>');" >取消</a>
				<?php }?>
		  	<?php }?>
		  </td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="13"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td><!--  <input type="checkbox" class="checkall" id="checkall_1"> --></td>
          <td id="batchAction" colspan="15">
          <!-- 
          	<span class="all_checkbox"><label for="checkall_1"><?php echo $lang['nc_select_all'];?></label></span>
           	&nbsp;<a href="javascript:void(0)" class="btn" onclick="submit_delete_batch('recommend');"><span><?php echo $lang['nc_recommend'];?></span></a>
           	&nbsp;<a href="javascript:void(0)" class="btn" onclick="submit_delete_batch('not_recommend');"><span><?php echo $lang['nc_not_recommend'];?></span></a>
           -->  
           <div class="pagination"><?php echo $output['show_page'];?></div></td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
