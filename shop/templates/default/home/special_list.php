<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.no-content { font: normal 16px/20px Arial, "microsoft yahei"; color: #999999; text-align: center; padding: 150px 0; }
/*专题活动列表*/
.special-list { }
.special-list li { clear: both; width: 1200px; margin: 10px 0 0 0; overflow: hidden; }
.special-list .special-title { font-size: 16px; font-weight: 600; line-height: 24px; padding: 0 0 6px 12px; }
.special-list .special-cover { width: 1180px; height: 245px; padding: 9px; border: solid 1px #E7E7E7 }
.special-list .special-cover img { width: 1180px; height: 245px; }
/* 翻页样式 */
.pagination { display: inline-block; margin: 0 auto; }
.pagination ul { font-size: 0; *word-spacing:-1px/*IE6、7*/;}
.pagination ul li { vertical-align: top; letter-spacing: normal; word-spacing: normal; display: inline-block; margin: 0 0 0 -1px; }
.pagination ul li { *display: inline/*IE6、7*/;*zoom:1;}
.pagination li span { font: normal 14px/20px "microsoft yahei"; color: #AAA; background-color: #FAFAFA; text-align: center; display: block; min-width: 20px; padding: 8px; border: 1px solid #E6E6E6; position: relative; z-index: 1; }
.pagination li a span, .pagination li a:visited span { color: #005AA0; text-decoration: none; background-color: #FFF; position: relative; z-index: 1; }
.pagination li a:hover span, .pagination li a:active span { color: #FFF; text-decoration: none !important; background-color: #D93600; border-color: #CA3300; position: relative; z-index: 9; cursor:pointer; }
.pagination li a:hover { text-decoration: none; }
.pagination li span.currentpage { color: #AAA; font-weight: bold; background-color: #FAFAFA; border-color: #E6E6E6; position: relative; z-index: 2; }
.nc-appbar-tabs a.compare { display: none !important; }
</style>
<div class="warp-all">
  <div class="mainbox">
    <?php if(!empty($output['special_list']) && is_array($output['special_list'])) {?>
    <ul class="special-list">
      <?php foreach($output['special_list'] as $value) {?>
      <li>
        <h3 class="special-title"> <a href="<?php echo $value['special_link'];?>" target="_blank"> <?php echo $value['special_title'];?> </a> </h3>
        <div class="special-cover"> <a href="<?php echo $value['special_link'];?>" target="_blank"> <img src="<?php echo getCMSSpecialImageUrl($value['special_image']);?>" alt="" /></a> </div>
      </li>
      <?php } ?>
    </ul>
    <div class="pagination mt10 mb10"> <?php echo $output['show_page'];?> </div>
    <?php } else { ?>
    <div class="no-content">暂无专题内容</div>
    <?php } ?>
  </div>
</div>