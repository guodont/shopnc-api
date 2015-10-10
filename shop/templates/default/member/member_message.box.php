<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <ul class="tab">
      <?php if(is_array($output['member_menu']) and !empty($output['member_menu'])) {
	foreach ($output['member_menu'] as $key => $val) {
		$classname = 'normal';
		if($val['menu_key'] == $output['menu_key']) {
			$classname = 'active';
		}
		if ($val['menu_key'] == 'message'){
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'(<span style="color: red;">'.$output['newcommon'].'</span>)</a></li>';
		}elseif ($val['menu_key'] == 'system'){
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'(<span style="color: red;">'.$output['newsystem'].'</span>)</a></li>';
		}elseif ($val['menu_key'] == 'close'){
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'(<span style="color: red;">'.$output['newpersonal'].'</span>)</a></li>';
		}else{
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'</a></li>';
		}
	}
}?>
    </ul>
    <?php if ($output['isallowsend']){?>
    <a href="index.php?act=member_message&op=sendmsg" class="ncm-btn ncm-btn-orange" title="<?php echo $lang['home_message_send_message'];?>"><i class="icon-envelope-alt"></i><?php echo $lang['home_message_send_message'];?></a>
    <?php }?>
  </div>
  <table class="ncm-default-table">
    <thead>
      <tr>
        <th class="w30"></th>
        <th class="w100 tl"><?php
                if ($output['drop_type'] == 'msg_seller'){
                	echo $lang['home_message_storename'];
                }else {
                	echo $lang['home_message_sender'];
                }?></th>
        <th class="tl"><?php echo $lang['home_message_content'];?></th>
        <th class="w300"><?php echo $lang['home_message_last_update'];?></th>
        <th class="w110"><?php echo $lang['home_message_command'];?></th>
      </tr>
      <?php if (!empty($output['message_array'])) { ?>
      <tr>
        <td colspan="20"><input type="checkbox" id="all" class="checkall"/>
        <label for="all"><?php echo $lang['home_message_select_all'];?></label>
          <?php if ($output['drop_type'] == 'msg_list'){?>
          <a href="javascript:void(0)" class="ncm-btn-mini" uri="index.php?act=member_message&op=dropcommonmsg&drop_type=<?php echo $output['drop_type']; ?>" name="message_id" confirm="<?php echo $lang['home_message_delete_confirm'];?>?" nc_type="batchbutton"><i class="icon-trash"></i><?php echo $lang['home_message_delete'];?></a>
          <?php }?>
          <?php if ($output['drop_type'] == 'msg_system' || $output['drop_type'] == 'msg_seller'){?>
          <a href="javascript:void(0)" class="ncm-btn-mini" uri="index.php?act=member_message&op=dropbatchmsg&drop_type=<?php echo $output['drop_type']; ?>" name="message_id" confirm="<?php echo $lang['home_message_delete_confirm'];?>?" nc_type="batchbutton"><?php echo $lang['home_message_delete'];?></a>
          <?php }?>
          <?php }?></td>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($output['message_array'])) { ?>
      <?php foreach($output['message_array'] as $k => $v){ ?>
      <tr class="bd-line">
        <td class="tc"><input type="checkbox" class="checkitem" value="<?php echo $v['message_id']; ?>"/></td>
        <td class="tl"><?php echo $v['from_member_name']; ?></td>
        <td class="link2<?php if($v['message_open'] == 0){?> font_bold<?php }?> tl"><?php echo parsesmiles($v['message_body']); ?></td>
        <td><?php echo @date("Y-m-d H:i:s",$v['message_update_time']); ?></td>
        <td class="ncm-table-handle"><?php if ($output['drop_type'] == 'msg_list'){?>
          <span><a href="index.php?act=member_message&op=showmsgcommon&drop_type=<?php echo $output['drop_type']; ?>&message_id=<?php echo $v['message_id']; ?><?php if($v['message_parent_id']>0) echo '#'.$v['message_id']; ?>" class="btn-blue"><i class="icon-edit"></i>
          <p><?php echo $lang['home_message_view_detail'];?></p>
          </a></span> <span><a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['home_message_delete_confirm'];?>?', 'index.php?act=member_message&op=dropcommonmsg&drop_type=<?php echo $output['drop_type']; ?>&message_id=<?php echo $v['message_id']; ?>');" class="btn-red"><i class="icon-trash"></i>
          <p><?php echo $lang['home_message_delete'];?></p>
          </a></span>
          <?php }?>
          <?php if ($output['drop_type'] == 'msg_system' || $output['drop_type'] == 'msg_seller'){?>
          <span><a href="index.php?act=member_message&op=showmsgbatch&drop_type=<?php echo $output['drop_type']; ?>&message_id=<?php echo $v['message_id']; ?><?php if($v['message_parent_id']>0) echo '#'.$v['message_id']; ?>" class="btn-acidblue"><i class="icon-eye-open"></i>
          <p><?php echo $lang['home_message_view_detail'];?></p>
          </a></span><span><a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['home_message_delete_confirm'];?>?', 'index.php?act=member_message&op=dropbatchmsg&drop_type=<?php echo $output['drop_type']; ?>&message_id=<?php echo $v['message_id']; ?>');" class="btn-red"><i class="icon-trash"></i>
          <p><?php echo $lang['home_message_delete'];?></p>
          </a></span>
          <?php }?></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php if (!empty($output['message_array'])) { ?>      
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
