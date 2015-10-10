<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>平台客服</h3>
      <ul class="tab-base">
        <li><a href="<?php echo urlAdmin('mall_consult', 'index');?>"><span>平台客服咨询列表</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>平台咨询类型</span></a></li>
        <li><a href="<?php echo urlAdmin('mall_consult', 'type_add');?>"><span>新增类型</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
          <li>买家联系平台客服时所需要选择的类型。</li>
          <li>提交咨询时，咨询类型必须选择，请不要全部删除。</li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <?php if(!empty($output['type_list'])){ ?>
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th class="w48 sort">排序</th>
          <th>咨询类型名称</th>
          <th class="w96 align-center">操作</th>
        </tr>
      </thead>
      <?php foreach($output['type_list'] as $value){ ?>
      <tbody>
        <tr>
          <td><input type="checkbox" class="checkitem" value="<?php echo $value['mct_id'];?>" name="del_id[]" /></td>
          <td><?php echo $value['mct_sort'];?></td>
          <td><?php echo $value['mct_name'];?></td>
          <td class="align-center"><a href="<?php echo urlAdmin('mall_consult', 'type_edit', array('mct_id' => $value['mct_id']));?>">编辑</a>&nbsp;|&nbsp;<a href="<?php echo urlAdmin('mall_consult', 'type_del', array('mct_id' => $value['mct_id']));?>">删除</a></td>
        </tr>
      </tbody>
      <?php }?>
      <?php }else{?>
      <tbody>
        <tr class="no_data">
          <td colspan="20"><?php echo $lang['nc_no_record'];?></td>
        </tr>
      </tbody>
      <?php }?>
      <tfoot>
        <?php if(!empty($output['type_list'])){?>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><span><?php echo $lang['nc_del'];?></span></a>
          </td>
        </tr>
        <?php }?>
      </tfoot>
    </table>
  </form>
</div>

