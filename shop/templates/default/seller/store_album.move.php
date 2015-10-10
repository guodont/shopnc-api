<div class="eject_con">
  <div id="warning"></div>
  <?php if(!empty($output['class_list'])){?>
  <form id="category_form" method="post" target="_parent" onsubmit="ajaxpost('category_form','','','onerror')" action="index.php?act=store_album&op=album_pic_move">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="id" value="<?php echo $output['id']?>" />
    <dl>
      <dt><?php echo $lang['album_plist_move_album_change'].$lang['nc_colon'];?></dt>
      <dd>
        <select name="cid" class="w100">
          <?php foreach ($output['class_list'] as $v){?>
          <option value="<?php echo $v['aclass_id']?>" class="w100" ><?php echo $v['aclass_name']?></option>
          <?php }?>
        </select>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border">
        <input type="submit" class="submit" value="<?php echo $lang['album_plist_move_album_begin'];?>" />
      </label>
    </div>
  </form>
  <?php }else{?>
  <h2><?php echo $lang['album_plist_move_album_only_one'];?><?php echo $lang['album_class_add'];?><?php echo $lang['album_plist_move_album_only_two'];?> </h2>
  <?php }?>
</div>
