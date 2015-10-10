<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['promotion_xianshi'];?></h3>
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
  <div class="fixed-empty"></div>
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
            <li><?php echo $lang['xianshi_name'].':'.$output['xianshi_info']['xianshi_name'];?></li>
            <li>
            <?php echo $lang['start_time'].':'.date('Y-m-d H:i',$output['xianshi_info']['start_time']).' '.$lang['end_time'].':'.date('Y-m-d H:i',$output['xianshi_info']['end_time']).'  '.'购买下限:'.$output['xianshi_info']['lower_limit'].'  '.$lang['nc_state'].':'.$output['xianshi_info']['xianshi_state_text'];?>
            </li>
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
        <th width="50"></th>
        <th class="align-left"><span><?php echo $lang['goods_name'];?></span></th>
        <th class="align-center" width="120"><span><?php echo $lang['goods_store_price'];?></span></th>
        <th class="align-center" width="120"><span>折扣价格</span></th>
        <th class="align-center" width="120"><span>折扣率</span></th>
        <?php if($output['xianshi_info']['editable']) { ?>
        <th class="align-center" width="120"><span>推荐</span></th>
        <?php } ?>
          </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $val){ ?>
        <tr class="hover">
            <td valign="middle" class="align2">
                <a href="<?php echo $val['goods_url'];?>" target="_blank">
                    <img src="<?php echo $val['image_url'];?>" onload="javascript:DrawImage(this,50,50);" />
                </a>
            </td>
            <td class="align-left">
                <a href="<?php echo $val['goods_url'];?>" target="_blank">
                    <span><?php echo $val['goods_name']; ?></span>
                </a>
            </td>
            <td class="align-center"><span><?php echo $val['goods_price'];?></span></td>
            <td class="align-center"><span><?php echo $val['xianshi_price'];?></span></td>
            <td class="align-center"><span><?php echo $val['xianshi_discount'];?></span></td>
            <?php if($output['xianshi_info']['editable']) { ?>
            <td class="yes-onoff align-center">
                <?php if($val['xianshi_recommend']){ ?>
                <a href="JavaScript:void(0);" class=" enabled" ajax_branch='recommend' nc_type="inline_edit" fieldname="xianshi_recommend" fieldid="<?php echo $val['xianshi_goods_id']?>" fieldvalue="1" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
                <?php }else { ?>
                <a href="JavaScript:void(0);" class=" disabled" ajax_branch='recommend' nc_type="inline_edit" fieldname="xianshi_recommend" fieldid="<?php echo $val['xianshi_goods_id']?>" fieldvalue="0" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
                <?php } ?>
            </td>
            <?php } ?>
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
          <td colspan="16">
              <div class="pagination"> <?php echo $output['show_page'];?> </div>
      </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
