<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/flea.css"  rel="stylesheet" type="text/css" />
<script src="<?php echo RESOURCE_SITE_URL;?>/js/flea/common.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/flea/jquery.KinSlideshow.min.js" type="text/javascript"></script>
<script>
	$(function(){
		$("#KinSlideshow").KinSlideshow({
			moveStyle:"left",
			titleBar:{titleBar_height:30,titleBar_bgColor:"#FFF",titleBar_alpha:0.5},
			titleFont:{TitleFont_size:12,TitleFont_color:"#FFFFFF",TitleFont_weight:"normal"},
			btn:{btn_bgColor:"#FFFFFF",btn_bgHoverColor:"#1072aa",btn_fontColor:"#000000",btn_fontHoverColor:"#FFFFFF",btn_borderColor:"#cccccc",btn_borderHoverColor:"#1188c0",btn_borderWidth:1}
		});
	});
</script>
<div id="category">
  <div class="content">
    <ul>
      <li>
        <div class="items_pic"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/flea/cat.gif" /></div>
        <div class="cat_list">
          <p><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['shuma']['fc_index_id1']?>"><?php echo $output['shuma']['fc_index_name1'];?></a><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['shuma']['fc_index_id2']?>"><?php echo $output['shuma']['fc_index_name2'];?></a></p>
          <p><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['shuma']['fc_index_id3']?>"><?php echo $output['shuma']['fc_index_name3'];?></a><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['shuma']['fc_index_id4']?>"><?php echo $output['shuma']['fc_index_name4'];?></a></p>
        </div>
      </li>
      <li>
        <div class="items_pic"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/flea/cat2.gif" /></div>
        <div class="cat_list">
          <p><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['zhuangban']['fc_index_id1']?>"><?php echo $output['zhuangban']['fc_index_name1'];?></a><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['zhuangban']['fc_index_id2']?>"><?php echo $output['zhuangban']['fc_index_name2'];?></a></p>
          <p><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['zhuangban']['fc_index_id3']?>"><?php echo $output['zhuangban']['fc_index_name3'];?></a><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['zhuangban']['fc_index_id4']?>"><?php echo $output['zhuangban']['fc_index_name4'];?></a></p>
        </div>
      </li>
      <li>
        <div class="items_pic"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/flea/cat3.gif" /></div>
        <div class="cat_list">
          <p><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['jujia']['fc_index_id1']?>"><?php echo $output['jujia']['fc_index_name1'];?></a><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['jujia']['fc_index_id2']?>"><?php echo $output['jujia']['fc_index_name2'];?></a></p>
          <p><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['jujia']['fc_index_id3']?>"><?php echo $output['jujia']['fc_index_name3'];?></a><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['jujia']['fc_index_id4']?>"><?php echo $output['jujia']['fc_index_name4'];?></a></p>
        </div>
      </li>
      <li>
        <div class="items_pic"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/flea/cat4.gif" /></div>
        <div class="cat_list">
          <p><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['xingqu']['fc_index_id1']?>"><?php echo $output['xingqu']['fc_index_name1'];?></a><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['xingqu']['fc_index_id2']?>"><?php echo $output['xingqu']['fc_index_name2'];?></a></p>
          <p><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['xingqu']['fc_index_id3']?>"><?php echo $output['xingqu']['fc_index_name3'];?></a><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['xingqu']['fc_index_id4']?>"><?php echo $output['xingqu']['fc_index_name4'];?></a></p>
        </div>
      </li>
      <li>
        <div class="items_pic"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/flea/cat5.gif" /></div>
        <div class="cat_list">
          <p><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['muying']['fc_index_id1']?>"><?php echo $output['muying']['fc_index_name1'];?></a><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['muying']['fc_index_id2']?>"><?php echo $output['muying']['fc_index_name2'];?></a></p>
          <p><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['muying']['fc_index_id3']?>"><?php echo $output['muying']['fc_index_name3'];?></a><a target="_blank" href="index.php?act=flea_class&cate_input=<?php echo $output['muying']['fc_index_id4']?>"><?php echo $output['muying']['fc_index_name4'];?></a></p>
        </div>
      </li>
    </ul>
  </div>
</div>
<div class="flea_goods content">
  <div id="first_items">
      <div id=idContainer2 class=container>
<div id="KinSlideshow" style="visibility:hidden;">
        <?php if(!empty($output['loginpic']) && is_array($output['loginpic'])){?>
        <?php foreach($output['loginpic'] as $val){?>
        <a href="<?php if($val['url'] != ''){echo $val['url'];}else{echo 'javascript:void(0);';}?>" target="_blank"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/'.$val['pic'];?>"></a>
        <?php }?>
        <?php }?></div>
  </div>
      <div class="hotgoods">
        <h2><a class="more gray2 fn-right" href="index.php?act=flea_class"><?php echo $lang['flea_goods_more'];?></a></h2>
        <div class="hotgoods_G">
          <dl>
            <dt class="fn-left">
              <div class="pic">
                <span class="thumb size100">
                  <i></i>
                  <a title="<?php echo $output['new_flea_goods']['goods_name'];?>" target="_blank" href="index.php?act=flea_goods&goods_id=<?php echo $output['new_flea_goods']['goods_id']?>"><img height="100" width="100" onload="javascript:DrawImage(this,100,100);" src="<?php echo $output['new_flea_goods']['goods_image'] != '' ? UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$output['new_flea_goods']['member_id'].DS.$output['new_flea_goods']['goods_image'] : SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" /></a>
                </span>
              </div>
            </dt>
            <dd class="fn-left"><?php echo $lang['flea_index_goods_1'];?><?php echo checkQuality($output['new_flea_goods']['flea_quality'])?><?php echo $lang['flea_index_goods_2'];?> <?php echo $output['new_flea_goods']['goods_name']?></dd>
            <dd class="fn-left"><span class="price orange"><?php echo $output['new_flea_goods']['goods_store_price']?></span><?php echo $lang['flea_index_rmbtransfer'];?></dd>
            <dd class="fn-left"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/flea/zr.png" /></dd>
            <dd class="flea_message fn-left"><?php echo str_cut(trim(str_replace(array("\r\n","\n","\r",'&nbsp;'),' ',strip_tags($output['one_goods_title']))),150); ?></dd>
          </dl>
        </div>
    </div>
      <div class="sell">
        	<div class="collect">
              <h2></h2>
              <div class="collect_goods">
                <p class="collect_hot"><?php echo $lang['flea_mostwell_goods'];?></p>
                <div class="pic fn-left">
                  <span class="thumb size76">
                    <i></i>
                    <a title="<?php echo $output['col_flea_goods']['goods_name'];?>" href="index.php?act=flea_goods&goods_id=<?php echo $output['col_flea_goods']['goods_id']?>" target="_blank"><img height="76" width="76" onload="javascript:DrawImage(this,76,76);" src="<?php echo $output['col_flea_goods']['goods_image'] != '' ? UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$output['col_flea_goods']['member_id'].DS.$output['col_flea_goods']['goods_image'] : SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" /></a>
                  </span>
                </div>
                <div class="collect_info fn-left">
                  <p class="details"><a class="blue2" target="_blank" href="index.php?act=flea_goods&goods_id=<?php echo $output['col_flea_goods']['goods_id']?>"><?php echo $output['col_flea_goods']['goods_name']?></a></p>
                  <p><?php echo $lang['flea_all_count'];?><span><?php echo $output['col_flea_goods']['flea_collect_num']?></span><?php echo $lang['flea_many_collect'];?></p>
                  <p><?php echo $lang['flea_transfer_price'];?><span><?php echo $output['col_flea_goods']['goods_store_price']?></span><?php echo $lang['flea_index_rmb'];?></p>
                </div>
              </div>
            </div>
        <div id="buttonContainer"><a href="index.php?act=member_flea&op=add_goods" class="button big blue"></a></div>
      </div>
  </div>
  <div id="fir_items" class="fn-left">
    <h2><a href="index.php?act=flea_class" class="gray2"><?php echo $lang['flea_more_hot_goods'];?></a></h2>
    <ul>
    <?php if(!empty($output['new_flea_goods2']) && is_array($output['new_flea_goods2'])){?>
    	<?php $i=1;foreach ($output['new_flea_goods2'] as $val){?>
      <li<?php if($i==7||$i==14){echo ' class="cn"';}?>>
        <div class="pic">
          <span class="thumb size120">
            <i></i>
            <a target="_blank" title="<?php echo $val['goods_name']; ?>" href="index.php?act=flea_goods&goods_id=<?php echo $val['goods_id']?>"><img height="120" width="120" onload="javascript:DrawImage(this,120,120);" src="<?php echo $val['goods_image'] != '' ? UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$val['member_id'].DS.$val['goods_image'] : SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" /></a>
          </span>
        </div>
        <p><?php checkQuality($val['flea_quality'])?><span class="orange"><?php echo intval($val['goods_store_price'])?></span><?php echo $lang['flea_index_transfer'];?></p>
      </li>
      <?php $i++;}?>
      <?php }?>
    </ul>
  </div>
  <div class="fn-clear"></div>
  <div class="ad"><script type="text/javascript" src="<?php echo SHOP_SITE_URL;?>/index.php?act=adv&op=advshow&ap_id=1038"></script></div> 
  <div id="third_items" class="fn-left">
    <h2><a class="gray2" href="index.php?act=flea_class"><?php echo $lang['flea_more_flea_goods'];?></a></h2>
    <div class="content">
      <ul class="look_items">
      <?php if(!empty($output['new_flea_goods3']) && is_array($output['new_flea_goods3'])){?>
      <?php foreach ($output['new_flea_goods3'] as $val){?>
        <li class="fn-left">
          <div class="pic">
            <span class="thumb size125">
              <i></i>
              <a target="_blank" title="<?php echo $val['goods_name']?>" href="index.php?act=flea_goods&goods_id=<?php echo $val['goods_id']?>"><img height="125" width="125" onload="javascript:DrawImage(this,125,125);" src="<?php echo $val['goods_image'] != '' ? UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$val['member_id'].DS.$val['goods_image'] : SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" /></a>
            </span>
          </div>
          <p><?php checkQuality($val['flea_quality'])?><span class="price orange"><?php echo intval($val['goods_store_price'])?></span><?php echo $lang['flea_index_transfer'];?></p>
        </li>
        <?php }?>
        <?php }?>
      </ul>
    </div>
  </div>
  <div class="fn-clear"></div>
  <div id="fourth_items">
    <h2></h2>
    <ul>
      <li class="fn-left"><script type="text/javascript" src="<?php echo SHOP_SITE_URL;?>/index.php?act=adv&op=advshow&ap_id=1043"></script></li>
      <li class="fn-left"><script type="text/javascript" src="<?php echo SHOP_SITE_URL;?>/index.php?act=adv&op=advshow&ap_id=1044"></script></li>
      <li class="fn-left"><script type="text/javascript" src="<?php echo SHOP_SITE_URL;?>/index.php?act=adv&op=advshow&ap_id=1045"></script></li>
      <li class="last fn-left"><script type="text/javascript" src="<?php echo SHOP_SITE_URL;?>/index.php?act=adv&op=advshow&ap_id=1046"></script></li>
    </ul>
  </div>
  <div class="fn-clear"></div>
  <div id="five_items">
     <div class="scrolldoorFrame">
       <h2></h2>
			<ul class="scrollUl">
				<?php if(!empty($output['show_flea_goods_class_list']) && is_array($output['show_flea_goods_class_list'])){?>
				<?php $i=1;foreach ($output['show_flea_goods_class_list'] as $val){?>
				<li class="sd0<?php if($i==1){echo $i;}else{echo 2;}?>" id="m0<?php echo $i++;?>"><span><?php echo $val['class_name']?></span></li>
				<?php }?>
				<?php }?>
			</ul>
			<div class="bor03 cont">
				<?php if(!empty($output['show_flea_goods_class_list']) && is_array($output['show_flea_goods_class_list'])){?>
				<?php $i=1;foreach ($output['show_flea_goods_class_list'] as $val){?>
				<div id="c0<?php echo $i++;?>" class="cc">
                  <ul>
                  	<?php foreach ($val['goods'] as $v){?>
                    <li>
                      <div class="pic">
                        <span class="thumb size120">
                          <i></i>
                          <a target="_blank" title="<?php echo $v['goods_name'];?>" href="index.php?act=flea_goods&goods_id=<?php echo $v['goods_id']?>"><img height="120" width="120" onload="javascript:DrawImage(this,120,120);" src="<?php echo $v['goods_image'] != '' ? UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$v['member_id'].DS.$v['goods_image'] : SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" /></a>                        </span>                      </div>
                      <p><?php checkQuality($v['flea_quality'])?>&nbsp;&nbsp;&nbsp;<span class="price orange"><?php echo intval($v['goods_store_price'])?></span><?php echo $lang['flea_index_transfer'];?></p>
                    </li>
                    <?php }?>
                  </ul> 
				</div>
				<?php }?>
				<?php }?>
			</div>
		</div>
  </div>
</div>
<script type="text/javascript">
function scrollDoor(){
}
scrollDoor.prototype = {
	sd : function(menus,divs,openClass,closeClass){
		var _this = this;
		if(menus.length != divs.length)
		{
			return false;
		}				
		for(var i = 0 ; i < menus.length ; i++)
		{	
			_this.$(menus[i]).value = i;				
			_this.$(menus[i]).onmouseover = function(){
					
				for(var j = 0 ; j < menus.length ; j++)
				{						
					_this.$(menus[j]).className = closeClass;
					_this.$(divs[j]).style.display = "none";
				}
				_this.$(menus[this.value]).className = openClass;	
				_this.$(divs[this.value]).style.display = "block";				
			}
		}
		},
	$ : function(oid){
		if(typeof(oid) == "string")
		return document.getElementById(oid);
		return oid;
	}
}
window.onload = function(){
	var SDmodel = new scrollDoor();
	SDmodel.sd([<?php echo $output['mstr']?>],[<?php echo $output['cstr']?>],"sd01","sd02");
}




$.fn.infiniteCarousel = function () {

function repeat(str, num) {
    return new Array( num + 1 ).join( str );
}

return this.each(function () {
    var $wrapper = $('> div', this).css('overflow', 'hidden'),
        $slider = $wrapper.find('> ul'),
        $items = $slider.find('> li'),
        $single = $items.filter(':first'),
        
        singleWidth = $single.outerWidth(), 
        visible = Math.ceil($wrapper.innerWidth() / singleWidth), // note: doesn't include padding or border
        currentPage = 1,
        pages = Math.ceil($items.length / visible);            


    // 1. Pad so that 'visible' number will always be seen, otherwise create empty items
    if (($items.length % visible) != 0) {
        $slider.append(repeat('<li class="empty" />', visible - ($items.length % visible)));
        $items = $slider.find('> li');
    }

    // 2. Top and tail the list with 'visible' number of items, top has the last section, and tail has the first
    $items.filter(':first').before($items.slice(- visible).clone().addClass('cloned'));
    $items.filter(':last').after($items.slice(0, visible).clone().addClass('cloned'));
    $items = $slider.find('> li'); // reselect
    
    // 3. Set the left position to the first 'real' item
    $wrapper.scrollLeft(singleWidth * visible);
    
    // 4. paging function
    function gotoPage(page) {
        var dir = page < currentPage ? -1 : 1,
            n = Math.abs(currentPage - page),
            left = singleWidth * dir * visible * n;
        
        $wrapper.filter(':not(:animated)').animate({
            scrollLeft : '+=' + left
        }, 500, function () {
            if (page == 0) {
                $wrapper.scrollLeft(singleWidth * visible * pages);
                page = pages;
            } else if (page > pages) {
                $wrapper.scrollLeft(singleWidth * visible);
                // reset back to start position
                page = 1;
            } 

            currentPage = page;
        });                
        
        return false;
    }
    
    $wrapper.after('<a class="arrow back">&lt;</a><a class="arrow forward">&gt;</a>');
    
    // 5. Bind to the forward and back buttons
    $('a.back', this).click(function () {
        return gotoPage(currentPage - 1);                
    });
    
    $('a.forward', this).click(function () {
        return gotoPage(currentPage + 1);
    });
    
    // create a public interface to move to a specific page
    $(this).bind('goto', function (event, page) {
        gotoPage(page);
    });
});  
};

$(document).ready(function () {
$('.infiniteCarousel').infiniteCarousel();
});

</script>
