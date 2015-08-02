<?php defined('InShopNC') or exit('Access Invalid!');?>
<Script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flea/jquery.select.park.js" charset="utf-8"></Script>
<Script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flea/easySlider1.7.js" charset="utf-8"></Script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flea/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flea/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flea/jquery.flea_list.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/flea.css" rel="stylesheet" type="text/css">
<div class="content" style=" margin-top:10px;">
  <!--检索表单	-->
	<form id="condition" method="GET" action="index.php">
		<input type="hidden" name="act" value="flea_class" />
		<?php if($output['condition_out']!=""){?>
			<?php foreach($output['condition_out'] as $key=>$val){?> 
				<?php if($val){?>
					<input type="hidden" id="<?php echo $key;?>" name="<?php echo $key;?>" value="<?php echo $val;?>" />
				<?php };?>
			<?php };?>
		<?php };?>
	</form>
  <!--检索表单	-->
  <div class="size790 fn-left" style="margin-bottom:20px;">
    <div id="flea_keyword">
		<?php if($output['navigation']){?>
			<?php foreach($output['navigation'] as $key => $val){?>
				<a href="<?php echo $key;?>"><?php echo $val;?></a>&nbsp;>
			<?php };?>
		<?php };?>
		<?php echo $lang['flea_index_find_goods'];?>(<?php echo count($output['all_num']);?>)	
	</div>
    <div id="cat_select">
	  <p id="cat_num" style="display:none;"><?php echo count($output['out_class']);?></p>
      <ul id="cate" class="cat_list">
		<?php if($output['out_class']){?>
			<?php foreach($output['out_class'] as $val){?>
				<li class="fn-left">
					<a keycate="<?php echo $val['gc_id'];?>" class="blue" href="#" title="<?php echo $val['gc_name'];?>">
						<?php echo str_cut($val['gc_name'],13);?>
					</a>
				</li>
			<?php };?>
		<?php };?>
      </ul>
      <a id="j_moreCat" class="fold blue" href="#"><?php if(count($output['out_class'])>10){echo $lang['flea_show_more'];}?></a>
    </div>
    <div id="filter">
      <div class="fill_filter">
        <dl >
          <dt class="fn-left"><?php echo $lang['flea_according_old'];?></dt>
		  <dd class="fn-left">
             <ul id="quality">
				<li class="fn-left <?php if($output['condition_out']['quality_input']==""){?>current<?php }?>">
					<a keyquality="" class="blue" href="#"><?php echo $lang['flea_index_unlimit'];?></a>
				</li>
             	<li><a keyquality="10" class="blue" href="#"><?php echo $lang['flea_index_new'];?></a></li>
                <li><a keyquality="9" class="blue" href="#"><?php echo $lang['flea_index_almost_new'];?></a></li>
                <li><a keyquality="8" class="blue" href="#"><?php echo $lang['flea_index_gently_used'];?></a></li>
                <li><a keyquality="7" class="blue" href="#"><?php echo $lang['flea_index_old'];?></a></li>
             </ul>
          </dd>
        </dl>
        <div class="tips orange">  
			<span class="tips_c">
				<?php echo $lang['flea_oldnew_choose'];?>
				<a class="ico3" style="text-decoration:underline; cursor:pointer;" nc_type="dialog" dialog_id="friend_add" dialog_title="<?php echo $lang['flea_oldnew_choose'];?>" uri="index.php?act=flea_class&op=quality_inner" dialog_width="400">
					<?php echo $lang['flea_look_fineness_division'];?>
				</a>
			</span>     
        </div>
      </div>
      <div class="fill_filter">
        <dl class="city fn-left" >
			<dt class="fn-left"><?php echo $lang['flea_according_price'];?></dt>
			<dd class="fn-left">
              <ul id="price">
				<li class="fn-left <?php if($output['condition_out']['price_input']==""){?>current<?php }?>">
					<a keyprice="" class="blue" href="#"><?php echo $lang['flea_index_unlimit'];?></a>
				</li>
              	<li><a keyprice="35" class="blue">20-50<?php echo $lang['flea_index_rmb'];?></a></li>
				<li><a keyprice="75" class="blue">50-100<?php echo $lang['flea_index_rmb'];?></a></li>
                <li><a keyprice="150" class="blue">100-200<?php echo $lang['flea_index_rmb'];?></a></li>
                <li><a keyprice="350" class="blue">200-500<?php echo $lang['flea_index_rmb'];?></a></li>
                <li><a keyprice="750" class="blue">500-1000<?php echo $lang['flea_index_rmb'];?></a></li>
                <li><a keyprice="1000" class="blue">1000<?php echo $lang['flea_index_rmb'];?><?php echo $lang['flea_index_on'];?></a></li>
              </ul>
            </dd>
        </dl>
      </div>
      <div class="fill_filter_c">
		<dl class="city fn-left">
			<dt class="fn-left"><?php echo $lang['flea_according_area'];?></dt>
            
            <dd class="fn-left search_city">
              <ul id="area">
                <li class="fn-left <?php if($output['condition_out']['area_input']==""){?>current<?php }?>">
					<a keyarea="" class="blue" href="#"><?php echo $lang['flea_index_unlimit'];?></a>
				</li>
				<?php if($output['area_main']){?>
					<li>
						<a keyarea="<?php echo $output['area_main']['flea_area_id'];?>" class="blue">
							<?php echo $output['area_main']['flea_area_name'];?>>
						</a>
					</li>
				<?php };?>
				<?php if($output['out_area']){?>
					<?php foreach($output['out_area'] as $val){?>
                    <li>
						<a keyarea="<?php echo $val['flea_area_id'];?>" class="blue">
							<?php echo $val['flea_area_name'];?>
						</a>
					</li>
					<?php };?>
				<?php };?>
              </ul>
            </dd>
		</dl>
      </div>   
    </div>
    <div id="rank">
      <div class="rankbar">
        <ul class="options fn-left">
          <li id="rank_current" class="rank_default fn-left">
            <span><a href="#"><?php echo $lang['flea_default_sort']?></a></span>
          </li>
          <li id="rank_price" keyrank="<?php echo $output['condition_out']['rank_input'];?>" class="rank_default fn-left">
            <span>
				<a <?php if($output['condition_out']['rank_input']==2){?>class="up"<?php }elseif($output['condition_out']['rank_input']==1){?>class="down"<?php }?> href="#">
					<?php echo $lang['flea_index_price'];?><i class="fn-right"></i>
				</a>
			</span>
          </li>
          <li id="float_price" class="rank_price_range fn-left">
            <input type="text" size="2" value="<?php echo $output['condition_out']['start_input'];?>"/>
            <span>-</span>
            <input type="text" size="2" value="<?php echo $output['condition_out']['end_input'];?>"/>
          </li>
		  <!--浮动价格搜索-->
		  <li id="price_form">
            <input keystart="" name="start" id="start" type="text" size="2" value="<?php echo $output['condition_out']['start_input'];?>" />
            <span>-</span>
            <input keyend="" name="end" id="end" type="text" size="2" value="<?php echo $output['condition_out']['end_input'];?>" />
			<a id="price_submit" value=""/><?php echo $lang['flea_index_commit']?></a>
          </li>
		  <!--end-->
          <li class="chack_box fn-left">
            <input id="picc" keypic="" <?php if($output['condition_out']['pic_input']){?>checked value=""<?php }else{ ?>value="1"<?php }?>  name="pic_input" type="checkbox"  />
            <label for="support-img">
              <strong><?php echo $lang['flea_look_no_pic'];?></strong>
            </label>
          </li>
        </ul>
        <div class="keywords fn-right">
          <div class="key"><input id="key" keykey="" name="key" type="text" value="<?php echo $output['condition_out']['key_input'];?>"/></div>
          <span><a id="search_key" href="#"><?php echo $lang['flea_index_search'];?></a></span>        
        </div>
      </div>
    </div>
    <div id="list-content">
      <ul id="seller">
	  <?php if($output['listgoods']){?>
	  <?php foreach($output['listgoods'] as $val){?>
        <li class=" seller_goods fn-left">
          <p class="pic fn-left">
             <span class="thumb size120">
               <i></i>
               <a class="user" href="index.php?act=flea_goods&goods_id=<?php echo $val['goods_id'];?>"><img height="120" width="120" onload="javascript:DrawImage(this,120,120);" title="<?php echo $val['goods_name'];?>" src="<?php echo $val['goods_image']?UPLOAD_SITE_URL.DS.ATTACH_MALBUM.'/'.$val['member_id'].'/'.$val['goods_image']:SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>"/></a>                
             </span>
          </p>
          <div class="list fn-left">
            <h2>
				<a class="blue" href="index.php?act=flea_goods&goods_id=<?php echo $val['goods_id'];?>" title="<?php echo $val['goods_name'];?>">
					<?php echo $lang['flea_index_goods_1'];?><?php echo $val['quality'];?><?php echo $lang['flea_index_goods_2'];?><?php echo str_replace($output['condition_out']['key_input'],"<font color='red'>".$output['condition_out']['key_input']."</font>",str_cut($val['goods_name'],42));?>
				</a>
			</h2>
            <p class="details"><strong class="orange fn-left"><span style="font-size:12px;"><?php echo $lang['currency'];?></span><?php echo $val['goods_store_price'];?></strong><span class="fn-right gray"><?php echo $lang['flea_ftf_trade'];?></span></p>
				<p class="list_content">
					<?php if($val['explain']){echo str_cut($val['explain'],140);}else{?><?php echo $lang['flea_no_explain'];?><?php }?>
				</p>
            <p>
              <span class="gray fn-left"><?php echo $val['time'];?><?php echo $lang['flea_index_front'];?></span>
              <span class="scan gray fn-right"><em class="blue2"><?php echo $val['flea_collect_num'];?></em><?php echo $lang['flea_goods_collect'];?></span>
              <span class="scan gray fn-right"><em class="blue2"><?php echo $val['commentnum'];?></em><?php echo $lang['flea_goods_msg'];?></span>
              <span class="scan gray fn-right"><em class="blue2"><?php echo $val['goods_click'];?></em><?php echo $lang['flea_goods_view'];?></span>  
            </p>
          </div>
          <div class="seller fn-left">
            <div class="pic fn-left">
              <span class="thumb size50">
                <i></i>
                <a href="index.php?act=flea_class&seller_input=<?php echo $val['member_info']['member_id'];?>&pic_input=1"><img src="<?php echo getMemberAvatar($_SESSION['avatar']);?>" width="50px" height="50px"/></a>
              </span>
            </div>
            <p class="seller_name">
				<a class="blue" href="index.php?act=flea_class&seller_input=<?php echo $val['member_info']['member_id'];?>">
					<?php echo $val['member_info']['member_name'];?>
				</a>
			</p>
			<p class="gray"><?php if($val['member_info']['member_qq']){?>QQ:<span><?php echo $val['member_info']['member_qq'];}?></span></p>
            <div class="seller_num">
				<?php echo $lang['flea_index_goods'];?>:&nbsp;&nbsp;
				<a href="index.php?act=flea_class&seller_input=<?php echo $val['member_info']['member_id'];?>" class="orange">
					<?php echo $val['member_info']['num'];?>
				</a>
				<?php echo $lang['flea_index_a'];?>
			</div>
          </div>
        </li>
	  <?php };?>
	  </ul>
      <div class="pagination"> <?php echo $output['show_page']; ?> </div>
	  <?php }else{?>
		<strong class="nonegoods">
          <h3><?php echo $lang['flea_no_finds'];?></h3>
          <dl>
            <dt><?php echo $lang['fela_suggest_str'];?></dt>
            <dd><?php echo $lang['fela_suggest_str1'];?></dd>
            <dd><?php echo $lang['fela_suggest_str2'];?></dd>
          </dl>
        </strong>
	  <?php }?>
      
    </div>
  </div>
  <div class="size200 fn-right">
    <a class="sell_btn2" href="index.php?act=member_flea&op=add_goods"></a>
    <div class="sell_now">
      <h2 class="sell_title">
        <span></span>
      </h2>
      <div class="slider">
        <div id="slider">
          <ul>
			<?php if($output['pre_sale']){?>
				<?php foreach($output['pre_sale'] as $val){?>
					<li class="sell_one">
					  <div>
						<p class="pic1">
						  <span class="thumb size20">
						  <i></i>
						  <a href="index.php?act=flea_class&seller_input=<?php echo $val['member_id'];?>">
								<img src="<?php echo getMemberAvatar($_SESSION['avatar']);?>" width="25px" height="25px"/>
							</a>              
						  </span>
						</p>
						<span class="user_name fn-left">
							<a class="blue2" href="index.php?act=flea_class&seller_input=<?php echo $val['member_id'];?>">
								<?php echo $val['member_name'];?>
							</a>
						</span>
						<?php echo $lang['flea_saling'];?>             
					   </div>
					  <p class="items_title">
						<a href="index.php?act=flea_goods&goods_id=<?php echo $val['goods_id'];?>">
							<?php echo str_cut($val['goods_name'],40);?>
						</a>
					  </p>
					  <div class="items_info">
						<div class="pic2 fn-left">
						  <span class="thumb size50">
							<a href="index.php?act=flea_goods&goods_id=<?php echo $val['goods_id'];?>">
								<img height="48" width="48" onload="javascript:DrawImage(this,48,48);" title="<?php echo $val['goods_name'];?>" src="<?php echo $val['goods_image']?UPLOAD_SITE_URL.DS.ATTACH_MALBUM.'/'.$val['member_id'].'/'.$val['goods_image']:SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" />
							</a>
						  </span>
						</div>
						<p><?php echo $lang['flea_transfer_price'];?></p>
						<p class="orange"><b><?php echo $lang['currency'];?><?php echo $val['goods_store_price'];?></b></p>
					  </div>
					</li>
				<?php }?>
			<?php }?>
          </ul>
        </div>
      </div>
    </div>
    <div class="look_for">
      <h2></h2>
      <ul>
		<?php if($output['attention']){?>
			<?php foreach($output['attention'] as $val){?>
				<li>
				  <div class="pic fn-left">
					<span class="thumb size60">
					  <i></i>
					  <a href="index.php?act=flea_goods&goods_id=<?php echo $val['goods_id'];?>">
						<img height="60" width="60" onload="javascript:DrawImage(this,60,60);" title="<?php echo $val['goods_name'];?>" src="<?php echo $val['goods_image']?UPLOAD_SITE_URL.DS.ATTACH_MALBUM.'/'.$val['member_id'].'/'.$val['goods_image']:SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" />
					  </a>
					</span>
				  </div>
				  <h3 class="fn-right">
					<a href="index.php?act=flea_goods&goods_id=<?php echo $val['goods_id'];?>" >
						<?php echo str_cut($val['goods_name'],40);?>
					</a>
				  </h3>
				  <p class="price orange fn-right"><?php echo $lang['currency'];?><?php echo $val['goods_store_price'];?></p>
				  <div class="item-attrs blue2 fn-right">
                    <span class="item_fav fn-right" title="<?php echo $lang['flea_goods_collect'];?>"><?php echo $val['flea_collect_num'];?></span>
					<span class="item_click fn-right" title="<?php echo $lang['flea_goods_view'];?>"><?php echo $val['goods_click'];?></span>
					<span class="item_scan fn-right" title="<?php echo $lang['flea_goods_msg'];?>"><?php echo $val['commentnum'];?></span>
				  </div>
				</li>
			<?php }?>
		<?php }?>
      </ul>
    </div>
  </div>
</div>