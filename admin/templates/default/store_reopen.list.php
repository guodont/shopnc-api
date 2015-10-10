<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=store&op=store" ><span><?php echo $lang['manage'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_joinin" ><span><?php echo $lang['pending'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current" ><span>续签申请</span></a></li>
        <li><a href="index.php?act=store&op=store_bind_class_applay_list" ><span>经营类目申请</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" value="store" name="act">
    <input type="hidden" value="reopen_list" name="op">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label><?php echo $lang['store_name'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['store_name'];?>" name="store_name" id="store_name" class="txt"></td>
          <th><label><?php echo $lang['store_name'];?>ID</label></th>
          <td><input type="text" value="<?php echo $_GET['store_id'];?>" name="store_id" id="store_id" class="txt"></td>
          <th>申请状态</th>
          <td>
          <select name="re_state">
          <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
          <option <?php if ($_GET['re_state'] == '0') echo 'selected';?> value="0">待付款</option>
          <option <?php if ($_GET['re_state'] == '1') echo 'selected';?> value="1">待审核</option>
          <option <?php if ($_GET['re_state'] == '2') echo 'selected';?> value="2">已审核</option>
          </select>
          </td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
        </tr>
        </tbody>
    </table>
</form>
<table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li>此处可以对商家续签申请进行  查看/审核/删除 操作</li>
            <li>审核后，系统会自动将店铺的到期时间向后延续，店铺等级不会自动变更，如果新签约的店铺等级发生变更，请手动更改店铺等级</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="store_form" name="store_form">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th>店铺/ID</th>
          <th>申请时间</th>
          <th>收费标准(元/年)</th>
          <th>续签时长(年)</th>
          <th>付款金额(年)</th>
          <th>续签起止有效期</th>
          <th>状态</th>
          <th>付款凭证</th>
          <th>付款备注</th>
          <th><?php echo $lang['operation'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['reopen_list']) && is_array($output['reopen_list'])){ ?>
        <?php foreach($output['reopen_list'] as $k => $val){ ?>
        <tr class="hover edit">
          <td><?php echo $val['re_store_name'];?>/<?php echo $val['re_store_id'];?></td>
          <td><?php echo date('Y-m-d',$val['re_create_time']); ?></td>
          <td><?php echo $val['re_grade_price']; ?> ( <?php echo $val['re_grade_name'];?> )</td>
          <td><?php echo $val['re_year']?></td>
          <td><?php echo $val['re_pay_amount'] == 0 ? '免费' : $val['re_pay_amount'];?></td>
          <td>
          <?php if ($val['re_start_time'] != '') {?>
          <?php echo date('Y-m-d',$val['re_start_time']).' ~ '.date('Y-m-d',$val['re_end_time']);?>
          <?php  } ?>
          </td>
          <td><?php echo str_replace(array('0','1','2'),array('待付款','待审核','通过审核'),$val['re_state']);?></td>
          <td>
          <?php if ($val['re_pay_cert'] != '') {?>
          <a nctype="nyroModal" href="<?php echo getStoreJoininImageUrl($val['re_pay_cert']);?>">查看</a>
          <?php } ?>
          </td>
          <td><?php echo $val['re_pay_cert_explain'];?></td>
          <td>
          <?php if ($val['re_state'] == '1') {?>
          <a href="javascript:if(confirm('审核后，系统会自动将店铺的到期时间向后延续\n店铺等级不会自动变更，如果新签约的店铺等级发生变更，请手动更改店铺等级\n确认审核吗？'))window.location = 'index.php?act=store&op=reopen_check&re_id=<?php echo $val['re_id'];?>';">审核</a>
          <?php } ?>
          <?php echo $val['re_state'] == '1' ? ' | ' : null;?>
         <?php if ($val['re_state'] != '2') {?>
         <a href="javascript:if(confirm('确认删除吗？'))window.location = 'index.php?act=store&op=reopen_del&re_id=<?php echo $val['re_id'];?>&re_store_id=<?php echo $val['re_store_id'];?>';"><?php echo $lang['nc_del'];?></a>
          <?php } ?>
          </td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td></td>
          <td colspan="15">
              <?php if(!empty($output['reopen_list']) && is_array($output['reopen_list'])){ ?>
              <div class="pagination"><?php echo $output['page'];?></div>
              <?php } ?>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript">
    $(document).ready(function(){
        $('a[nctype="nyroModal"]').nyroModal();
    });
</script>