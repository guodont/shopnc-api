<?php defined('InShopNC') or exit('Access Invalid!');?>
  <table class="table tb-type2 nobdb">
  	<thead class="thead">
		<tr class="space">
			<th colspan="15">店铺热卖TOP榜</th>
		</tr>
		<tr class="thead sortbar-array">
			<th class="align-center">序号</th>
            <th class="align-center">店铺名称</th>
            <th class="align-center"><?php echo $output['sort_text'];?></th>
        </tr>
    </thead>
    <tbody id="datatable">
    <?php if(!empty($output['statlist'])){ ?>
        <?php foreach ((array)$output['statlist'] as $k=>$v){?>
          <tr class="hover">
          	<td><?php echo $v['sort'];?></td>
          	<td><?php echo $v['store_name'];?></td>
          	<td><?php echo $v[$output['stat_field']];?></td>
          </tr>
        <?php } ?>
    <?php } else {?>
        <tr class="no_data">
        	<td colspan="11"><?php echo $lang['no_record']; ?></td>
        </tr>
    <?php }?>
    </tbody>
  </table>
  
  <div class="h36"></div>
  
  <!-- 飙升榜 -->
  <table class="table tb-type2 nobdb">
    <thead class="thead">
    	<tr class="space">
			<th colspan="15">店铺热卖飙升榜</th>
		</tr>
      <tr class="thead sortbar-array">
        <th class="align-center">序号</th>
        <th class="align-center">店铺名称</th>
        <th class="align-center"><?php echo $output['sort_text'];?></th>
        <th class="align-center">升降幅度</th>
      </tr>
    </thead>
    <tbody id="datatable">
    <?php if(!empty($output['soaring_statlist'])){ ?>
        <?php foreach ((array)$output['soaring_statlist'] as $k=>$v){?>
          <tr class="hover">
          	<td><?php echo $v['sort'];?></td>
          	<td><?php echo $v['store_name'];?></td>
          	<td><?php echo $v[$output['stat_field']];?></td>
          	<td><?php echo $v['hb'];?>%</td>
          </tr>
        <?php } ?>
    <?php } else {?>
        <tr class="no_data">
        	<td colspan="11"><?php echo $lang['no_record']; ?></td>
        </tr>
    <?php }?>
    </tbody>
  </table>