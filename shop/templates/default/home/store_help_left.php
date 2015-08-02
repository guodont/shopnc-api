<?php defined('InShopNC') or exit('Access Invalid!');?>
    <div class="content">
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <?php foreach($output['list'] as $key => $val){ ?>
      <dl show_id="<?php echo $val['type_id'];?>">
        <dt onclick="show_list('<?php echo $val['type_id'];?>');">
            <i class="<?php echo $val['type_id']==$output['type_id'] ? 'show':'hide';?>"></i><?php echo $val['type_name'];?></dt>
        <dd style="display: <?php echo $val['type_id']==$output['type_id'] ? 'block':'none';?>;">
          <ul>
            <?php if(!empty($val['help_list']) && is_array($val['help_list'])){ ?>
            <?php foreach($val['help_list'] as $k => $v){ ?>
            <li>
                <i class="<?php echo $v['help_id']==$output['help_id'] ? 'current':'';?>"></i>
                <?php if(empty($v['help_url'])){ ?>
                <a href="<?php echo urlShop('show_help', 'index', array('t_id' => $v['type_id'],'help_id' => $v['help_id']));?>"><?php echo $v['help_title'];?></a>
                <?php }else { ?>
                <a href="<?php echo $v['help_url'];?>"><?php echo $v['help_title'];?></a>
                <?php } ?>
                </li>
            <?php } ?>
            <?php } ?>
          </ul>
        </dd>
      </dl>
      <?php } ?>
      <?php } ?>
    </div>
    <div class="title">
      <h3>平台联系方式</h3>
    </div>
    <div class="content">
        <ul>
          <?php
			if(is_array($output['phone_array']) && !empty($output['phone_array'])) {
				foreach($output['phone_array'] as $key => $val) {
			?>
          <li><?php echo '电话'.($key+1).$lang['nc_colon'];?><?php echo $val;?></li>
          <?php
				}
			}
			 ?>
          <li><?php echo '邮箱'.$lang['nc_colon'];?><?php echo C('site_email');?></li>
        </ul>
    </div>