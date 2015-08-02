<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
    $(document).ready(function(){
        //取消限时折扣
        $('[nctype="btn_cancel"]').on('click', function() {
            if(confirm('<?php echo $lang['nc_ensure_cancel'];?>')) {
                var action = "<?php echo urlAdmin('promotion_mansong', 'mansong_cancel');?>";
                $('#submit_form').attr('action', action);
                $('#mansong_id').val($(this).attr('data-mansong-id'));
                $('#submit_form').submit();
            }
        })

        //删除限时折扣
        $('[nctype="btn_del"]').on('click', function() {
            if(confirm('<?php echo $lang['nc_ensure_del'];?>')) {
                var action = "<?php echo urlAdmin('promotion_mansong', 'mansong_del');?>";
                $('#submit_form').attr('action', action);
                $('#mansong_id').val($(this).attr('data-mansong-id'));
                $('#submit_form').submit();
            }
        })
    });
</script>

<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['promotion_mansong'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
      </ul>
    </div>
  </div>
  <!--  搜索 -->
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="promotion_mansong">
    <input type="hidden" name="op" value="mansong_list">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="mansong_name"><?php echo $lang['mansong_name'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['mansong_name'];?>" name="mansong_name" id="mansong_name" class="txt" style="width:100px;"></td>
          <th><label for="store_name"><?php echo $lang['store_name'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['store_name'];?>" name="store_name" id="store_name" class="txt" style="width:100px;"></td>
          <th><label for=""><?php echo $lang['nc_state'];?></label></th>
          <td>
              <select name="state">
                  <?php if(is_array($output['mansong_state_array'])) { ?>
                  <?php foreach($output['mansong_state_array'] as $key=>$val) { ?>
                  <option value="<?php echo $key;?>" <?php if(intval($key) === intval($_GET['state'])) echo 'selected';?>><?php echo $val;?></option>
                  <?php } ?>
                  <?php } ?>
              </select>
          </td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <!-- 帮助 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['mansong_list_help1'];?></li>
            <li><?php echo $lang['mansong_list_help2'];?></li>
            <li><?php echo $lang['mansong_list_help3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <!-- 列表 -->
  <form id="list_form" method="post">
    <input type="hidden" id="object_id" name="object_id"  />
    <table class="table tb-type2">
      <thead>
          <tr class="thead">
              <th class="align-left"><span><?php echo $lang['mansong_name'];?></span></th>
              <th class="align-left" width="240"><span><?php echo $lang['store_name'];?></span></th>
              <th class="align-center" width="100"><span><?php echo $lang['start_time'];?></span></th>
              <th class="align-center" width="100"><span><?php echo $lang['end_time'];?></span></th>
              <th class="align-center" width="80"><span><?php echo $lang['nc_state'];?></span></th>
              <th class="align-center" width="120"><span><?php echo $lang['nc_handle'];?></span></th>
          </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $val){ ?>
        <tr class="hover">
            <td class="align-left"><span><?php echo $val['mansong_name'];?></span></td>
            <td class="align-left"><a href="<?php echo urlShop('show_store','index', array('store_id'=>$val['store_id']));?>"><span><?php echo $val['store_name'];?></span></a>
<?php if (isset($output['flippedOwnShopIds'][$val['store_id']])) { ?>
            <span class="ownshop">[自营]</span>
<?php } ?>
            </td>
            <td class="align-center"><span><?php echo date("Y-m-d",$val['start_time']);?></span></td>
            <td class="align-center"><span><?php echo date("Y-m-d",$val['end_time']);?></span></td>
            <td class="align-center"><span><?php echo $val['mansong_state_text'];?></span></td>

            <td class="nowrap align-center">
                <!-- 详细按钮 -->
                <a href="index.php?act=promotion_mansong&op=mansong_detail&mansong_id=<?php echo $val['mansong_id'];?>"><?php echo $lang['nc_detail'];?></a>
                <?php if($val['editable']) { ?>
                <a nctype="btn_cancel" data-mansong-id="<?php echo $val['mansong_id'];?>" href="javascript:;"><?php echo $lang['nc_cancel'];?></a>
                <?php } ?>
                <a nctype="btn_del" data-mansong-id="<?php echo $val['mansong_id'];?>" href="javascript:;"><?php echo $lang['nc_del'];?></a>
            </td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="16"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td><?php if(!empty($output['list']) && is_array($output['list'])){ ?>
            <?php } ?></td>
          <td colspan="16"></label>
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<form id="submit_form" action="" method="post" >
    <input type="hidden" id="mansong_id" name="mansong_id" value="">
</form>
