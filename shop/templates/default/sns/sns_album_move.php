<div class="eject_con">
  <div id="warning"></div>
  <?php if(!empty($output['class_list'])){?>
  <form id="category_form" method="post" target="_parent" onsubmit="ajaxpost('category_form','','','onerror')" action="index.php?act=sns_album&op=album_pic_move">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="id" value="<?php echo $output['id']?>" />
    <dl>
      <dt><?php echo $lang['album_plist_move_album_change'].$lang['nc_colon'];?></dt>
      <dd>
        <select name="cid" class="w100">
          <?php foreach ($output['class_list'] as $v){?>
          <option value="<?php echo $v['ac_id']?>" class="w100" ><?php echo $v['ac_name']?></option>
          <?php }?>
        </select>
      </dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" value="<?php echo $lang['album_plist_move_album_begin'];?>" />
      </dd>
    </dl>
  </form>
  <?php }else{?>
  <h2><?php echo $lang['album_plist_move_album_only_one'];?><?php echo $lang['album_class_add'];?><?php echo $lang['album_plist_move_album_only_two'];?> </h2>
  <?php }?>
</div>
