<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php require('groupbuy_head.php');?>
<div class="nch-breadcrumb-layout" style="display: block;">
  <div class="nch-breadcrumb wrapper"> <i class="icon-home"></i> <span> <a href="index.php">首页</a> </span> <span class="arrow">></span> <span>线下抢</span></div>
</div>
<div class="ncg-container">
  <div id="ncgCategory" class="ncg-category">
    <h3>抢商品</h3>
    <ul>
      <?php if(!empty($output['online'])){?>
      <?php $i = 0;?>
      <?php foreach($output['online'] as $online){?>
      <?php if($i>7) break;?>
      <li><a href="index.php?act=show_groupbuy&op=index&groupbuy_class=<?php echo $online['class_id'];?>"><?php echo $online['class_name'];?></a></li>
      <?php $i++;?>
      <?php }?>
      <?php }?>
    </ul>
    <h3>线下抢</h3>
    <ul>
      <?php if(!empty($output['class_root'])){?>
      <?php $j = 0;?>
      <?php foreach($output['class_root'] as $offline){?>
      <?php if($j>7) break;?>
      <li><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $offline['live_class_id'];?>"><?php echo $offline['live_class_name'];?></a></li>
      <?php $j++;?>
      <?php }?>
      <?php }?>
    </ul>
  </div>
  <div class="ncg-content">
    <div class="ncg-nav">
      <ul>
        <li <?php if($output['type']=='immediate'){ echo 'class="current"';}?>><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $_GET['class_id']?>&s_class_id=<?php echo $_GET['s_class_id'];?>&area_id=<?php echo $_GET['area_id'];?>&mall_id=<?php echo $_GET['mall_id'];?>&dis=<?php echo $_GET['dis'];?>&order=<?php echo $_GET['order']?>&sort=<?php echo $_GET['sort'];?>">正在进行</a></li>
        <li <?php if($output['type']=='soon'){ echo 'class="current"';}?>><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $_GET['class_id']?>&s_class_id=<?php echo $_GET['s_class_id'];?>&area_id=<?php echo $_GET['area_id'];?>&mall_id=<?php echo $_GET['mall_id'];?>&dis=<?php echo $_GET['dis'];?>&order=<?php echo $_GET['order']?>&sort=<?php echo $_GET['sort'];?>&type=soon">即将开始</a></li>
        <li <?php if($output['type']=='end'){ echo 'class="current"';}?>><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $_GET['class_id']?>&s_class_id=<?php echo $_GET['s_class_id'];?>&area_id=<?php echo $_GET['area_id'];?>&mall_id=<?php echo $_GET['mall_id'];?>&dis=<?php echo $_GET['dis'];?>&order=<?php echo $_GET['order']?>&sort=<?php echo $_GET['sort'];?>&type=end">已经结束</a></li>
      </ul>
    </div>
    <div class="ncg-screen"> 
      <!-- 分类过滤列表 -->
      <dl>
        <dt><?php echo $lang['text_class'];?>：</dt>
        <dd <?php if(empty($_GET['class_id'])){ echo 'class="selected"';}?>><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&area_id=<?php echo $_GET['area_id'];?>&mall_id=<?php echo $_GET['mall_id'];?>&dis=<?php echo $_GET['dis'];?>&order=<?php echo $_GET['order']?>&sort=<?php echo $_GET['sort'];?>&type=<?php echo $_GET['type'];?>">全部</a></dd>
        <?php if(is_array($output['class_root'])) { ?>
        <?php foreach($output['class_root'] as $groupbuy_class) { ?>
        <dd <?php if($_GET['class_id']==$groupbuy_class['live_class_id']){ echo 'class="selected"';}?>><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $groupbuy_class['live_class_id'];?>&area_id=<?php echo $_GET['area_id'];?>&mall_id=<?php echo $_GET['mall_id'];?>&dis=<?php echo $_GET['dis'];?>&order=<?php echo $_GET['order']?>&sort=<?php echo $_GET['sort'];?>&type=<?php echo $output['type'];?>"><?php echo $groupbuy_class['live_class_name'];?></a> </dd>
        <?php } ?>
        <?php } ?>
        <?php if(isset($output['class_id'])){?>
        <ul>
          <?php if(!empty($output['class_menu'][$output['class_id']])){?>
          <?php foreach($output['class_menu'][$output['class_id']] as $ck=>$cv){?>
          <li <?php if($_GET['s_class_id']==$cv['live_class_id']){ echo 'class="selected"';}?> ><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $_GET['class_id'];?>&s_class_id=<?php echo $cv['live_class_id'];?>&area_id=<?php echo $_GET['area_id'];?>&mall_id=<?php echo $_GET['mall_id'];?>&dis=<?php echo $_GET['dis'];?>&order=<?php echo $_GET['order']?>&sort=<?php echo $_GET['sort'];?>&type=<?php $output['type']?>"><?php echo $cv['live_class_name'];?></a></li>
          <?php }?>
          <?php }?>
        </ul>
        <?php }?>
      </dl>
      
      <!-- 区域过滤列表 -->
      <?php if(cookie('city_id')!=0){?>
      <dl>
        <dt>区域：</dt>
        <dd <?php if(empty($_GET['area_id'])){ echo 'class="selected"';}?>><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $_GET['class_id'];?>&s_class_id=<?php echo $_GET['s_class_id'];?>&dis=<?php echo $_GET['dis'];?>&order=<?php echo $_GET['order']?>&sort=<?php echo $_GET['sort'];?>">全部</a></dd>
        <?php if(is_array($output['area_list'])){?>
        <?php foreach($output['area_list'] as $area){?>
        <dd <?php if($_GET['area_id']==$area['live_area_id']){ echo 'class="selected"';}?>><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $_GET['class_id'];?>&s_class_id=<?php echo $_GET['s_class_id'];?>&area_id=<?php echo $area['live_area_id'];?>&dis=<?php echo $_GET['dis'];?>&order=<?php echo $_GET['order']?>&sort=<?php echo $_GET['sort'];?>&type=<?php echo $output['type'];?>"><?php echo $area['live_area_name'];?></a></dd>
        <?php }?>
        <?php }?>
        <?php if(isset($output['area_id'])){?>
        <ul>
          <?php if(!empty($output['area_list'])){?>
          <?php foreach($output['area_list'] as $mmk=>$mmv){?>
          <?php if($mmv['live_area_id']==$output['area_id']){?>
          <?php foreach($mmv[0] as $mmmk=>$mmmv){?>
          <li <?php if($_GET['mall_id']==$mmmv['live_area_id']){ echo 'class="selected"';}?> ><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $_GET['class_id'];?>&s_class_id=<?php echo $_GET['s_class_id']?>&area_id=<?php echo $_GET['area_id'];?>&mall_id=<?php echo $mmmv['live_area_id'];?>&dis=<?php echo $_GET['dis'];?>&order=<?php echo $_GET['order']?>&sort=<?php echo $_GET['sort'];?>&type=<?php echo $output['type'];?>"><?php echo $mmmv['live_area_name'];?></a></li>
          <?php }?>
          <?php }?>
          <?php }?>
          <?php }?>
        </ul>
        <?php }?>
      </dl>
      <?php }?>
      <!-- 价格过滤列表 -->
      <dl>
        <dt><?php echo $lang['text_price'];?>：</dt>
        <dd <?php if(empty($_GET['dis'])){ echo 'class="selected"';}?>><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $_GET['class_id'];?>&s_class_id=<?php echo $_GET['s_class_id'];?>&area_id=<?php echo $_GET['area_id'];?>&mall_id=<?php echo $_GET['mall_id'];?>&order=<?php echo $_GET['order']?>&sort=<?php echo $_GET['sort'];?>&type=<?php echo $output['type'];?>">全部</a></dd>
        <?php if(is_array($output['pricedis'])) { ?>
        <?php $i = 1;?>
        <?php foreach($output['pricedis'] as $pricedis) { ?>
        <dd <?php if($i==$_GET['dis']){ echo 'class="selected"';}?>><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $_GET['class_id'];?>&s_class_id=<?php echo $_GET['s_class_id'];?>&area_id=<?php echo $_GET['area_id'];?>&mall_id=<?php echo $_GET['mall_id'];?>&dis=<?php echo $i;?>&order=<?php echo $_GET['order']?>&sort=<?php echo $_GET['sort'];?>&type=<?php echo $output['type'];?>"><?php echo $pricedis;?></a> </dd>
        <?php $i++;?>
        <?php } ?>
        <?php } ?>
      </dl>
      <dl class="ncg-sortord">
        <dt>排序：</dt>
        <dd <?php if(empty($_GET['order'])){ echo 'class="selected"';}?>><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $_GET['class_id'];?>&s_class_id=<?php echo $_GET['s_class_id'];?>&area_id=<?php echo $_GET['area_id'];?>&mall_id=<?php echo $_GET['mall_id'];?>&dis=<?php echo $_GET['dis'];?>&type=<?php echo $output['type'];?>">默认</a></dd>
        <dd <?php if($_GET['order']=='sales'){ echo 'class="selected"';}?>><a <?php if($output['sort']=='asc'){ echo 'class="desc"';}else{ echo 'class="asc"';}?> href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $_GET['class_id'];?>&s_class_id=<?php echo $_GET['s_class_id'];?>&area_id=<?php echo $_GET['area_id'];?>&mall_id=<?php echo $_GET['mall_id'];?>&dis=<?php echo $_GET['dis'];?>&order=sales&sort=<?php echo $output['sort'];?>&type=<?php echo $output['type'];?>">销量<i></i></a></dd>
        <dd <?php if($_GET['order']=='price'){ echo 'class="selected"';}?>><a <?php if($output['sort']=='asc'){ echo 'class="desc"';}else{ echo 'class="asc"';}?> href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $_GET['class_id'];?>&s_class_id=<?php echo $_GET['s_class_id'];?>&area_id=<?php echo $_GET['area_id'];?>&mall_id=<?php echo $_GET['mall_id'];?>&dis=<?php echo $_GET['dis'];?>&order=price&sort=<?php echo $output['sort'];?>&type=<?php echo $output['type'];?>">价格<i></i></a></dd>
        <dd <?php if($_GET['order']=='time'){ echo 'class="selected"';}?>><a <?php if($output['sort']=='asc'){ echo 'class="desc"';}else{ echo 'class="asc"';}?> href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $_GET['class_id'];?>&s_class_id=<?php echo $_GET['s_class_id'];?>&area_id=<?php echo $_GET['area_id'];?>&mall_id=<?php echo $_GET['mall_id'];?>&dis=<?php echo $_GET['dis'];?>&order=time&sort=<?php echo $output['sort'];?>&type=<?php echo $output['type'];?>">发布时间<i></i></a></dd>
      </dl>
    </div>
    <?php if(!empty($output['groupbuy_list']) && is_array($output['groupbuy_list'])) { ?>
    <!-- 抢购活动列表 -->
    <div class="group-list">
      <ul>
        <?php foreach($output['groupbuy_list'] as $groupbuy) { ?>
        <li class="<?php echo $output['current'];?>">
          <div class="ncg-list-content">
          <a title="<?php echo $groupbuy['groupbuy_name'];?>" href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$groupbuy['groupbuy_id']));?>" class="pic-thumb" target="_blank"><img src="<?php echo lgthumb($groupbuy['groupbuy_pic'],'mid');?>" alt=""></a>
          <h3 class="title"><a title="<?php echo $groupbuy['groupbuy_name'];?>" href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$groupbuy['groupbuy_id']));?>" target="_blank"><?php echo $groupbuy['groupbuy_name'];?></a></h3>
          <div class="item-prices"> <span class="price"><i><?php echo $lang['currency'];?></i><em><?php echo $groupbuy['groupbuy_price'];?></em></span>
            <div class="dock"> <span class="limit-num"><?php echo round(($groupbuy['groupbuy_price']/$groupbuy['original_price'])*10,2);?>&nbsp;<?php echo $lang['text_zhe'];?></span> <del class="orig-price"><?php echo $groupbuy['original_price'];?></del> </div>
            <span class="sold-num"> <em><?php echo $groupbuy['buyer_num'];?></em>次<?php echo $lang['text_buy'];?> </span> <a href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$groupbuy['groupbuy_id']));?>" target="_blank" class="buy-button">我要抢</a> </div>
        </li>
        <?php } ?>
      </ul>
    </div>
    <div class="tc mt20 mb20">
      <div class="pagination"> <?php echo $output['show_page'];?> </div>
    </div>
    <?php } else { ?>
    <div class="no-content"><?php echo $lang['no_groupbuy_info'];?></div>
    <?php } ?>
  </div>
</div>
