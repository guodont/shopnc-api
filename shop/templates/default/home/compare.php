<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/layout.css" rel="stylesheet" type="text/css">
<div class="nch-container mt10 mb10">
  <div class="nch-compare-title">基本信息对比</div>
  <?php if($output['compare_list']){ ?>
  <table class="nch-compare-table">
    <?php foreach($output['compare_list'] as $k=>$v){ ?>
    <!-- 显示商品图片及名称 -->
    <?php if ($v['key'] == 'goodsinfo'){?>
    <tr id="comparetr_<?php echo $k; ?>" class="goods_tr">
      <th><?php echo $v['name'];?></th>
      <?php for ($i=0;$i<$output['maxnum'];$i++){?>
      <?php if ($v[$i]){//如果存在，则显示图片和名称?>
      <td><dl class="goods-info">
          <dt class="goods-pic"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$v[$i]['goods_id']));?>" target="_blank"><img src="<?php echo cthumb($v[$i]['goods_image'], 240,$v[$i]['store_id']);?>"></a></dt>
          <dd class="goods-name"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$v[$i]['goods_id']));?>" target="_blank"><?php echo $v[$i]['goods_name'];?></a></dd>
          <?php if ($i>0){?>
          <dd class="del" onclick="javascript:delCompare(<?php echo $v[$i]['goods_id'];?>,'info');"><i class="icon-trash"></i>删除</dd>
          <?php }?>
        </dl></td>
      <?php } else {//如果不存在，则显示‘暂无对比项’ ?>
      <td><div class="no-compare">
          <h3>暂无对比项</h3>
          <a href="<?php echo urlShop('search','index',array('cate_id'=> $output['cate_id']));?>" title="<?php echo $v['gc_name']; ?>" target="_blank">添加</a></div></td>
      <?php }?>
      <?php }?>
    </tr>
    <?php } ?>
    <!-- 显示商品价格 -->
    <?php if ($v['key'] == 'goodsprice'){?>
    <tr id="comparetr_<?php echo $k; ?>">
      <th><?php echo $v['name'];?></th>
      <?php for ($i=0;$i<$output['maxnum'];$i++){?>
      <td><div class="goods-price"><?php echo $v[$i]?$lang['currency'].$v[$i]:'';?>&nbsp;</div></td>
      <?php }?>
    </tr>
    <?php } ?>
    <!-- 显示品牌 -->
    <?php if ($v['key'] == 'brand'){?>
    <tr id="comparetr_<?php echo $k; ?>">
      <th><?php echo $v['name'];?></th>
      <?php for ($i=0;$i<$output['maxnum'];$i++){?>
      <td><?php echo is_array($v[$i])?$v[$i]['brand_name']:$v[$i];?>&nbsp;</td>
      <?php }?>
    </tr>
    <?php } ?>
    <!-- 显示普通文字项 -->
    <?php if (!$v['key']){?>
    <tr id="comparetr_<?php echo $k; ?>">
      <th><?php echo $v['name'];?>
        <input type="hidden" name="isdiff[]" value="<?php echo $k;?>|<?php echo $v['isdiff'];?>" /></th>
      <?php for ($i=0;$i<$output['maxnum'];$i++){?>
      <td><?php echo $v[$i];?>&nbsp;</td>
      <?php }?>
    </tr>
    <?php } ?>
    <?php } ?>
  </table>
  <div class="nch-compare-bottom"> <a href="javascript:void(0);" nc_type="comparediff" data-param='{"type":"light"}'><i class="icon-indent-right"></i>高亮显示不同项</a> <a href="javascript:void(0);" nc_type="comparediff" data-param='{"type":"cancel"}' style="display: none;"><i class="icon-indent-left"></i>取消高亮不同项</a> <a href="javascript:void(0);" nc_type="comparesame" data-param='{"type":"hide"}'><i class="icon-resize-small"></i>隐藏相同项</a> <a href="javascript:void(0);" nc_type="comparesame" data-param='{"type":"show"}' style="display: none;"><i class="icon-resize-full"></i>显示相同项</a> <a href="javascript:void(0);" class="delall" onclick="javascript:delCompare('all','info');"><i class="icon-remove-sign"></i>清空对比栏</a></div>
  <?php } else {?>
  <table class="nch-compare-table">
    <tbody>
      <tr>
        <td class="nch-compare-null"><p> <i class="icon-search"></i>对比栏暂无对比商品，先添加对比商品再来进行详细比较吧！</p></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
</div>
<script type="text/javascript">
        /* 当鼠标移到表格上是，当前一行背景变色 */
      $(document).ready(function(){
            $(".nch-compare-table tr td").mouseover(function(){
                $(this).parent().find("td").css("background-color","#F5F5F5");
				$(this).parent().find("th").css("background-color","#F5F5F5");
            });
      })
      /* 当鼠标在表格上移动时，离开的那一行背景恢复 */
      $(document).ready(function(){
            $(".nch-compare-table tr td").mouseout(function(){
                var bgc = $(this).parent().attr("bg");
                $(this).parent().find("td").css("background-color","#FFFFFF");
				$(this).parent().find("th").css("background-color","#FFFFFF");
            });
      })
      
$(function(){
	//高亮显示和取消高亮不同项
	$("[nc_type='comparediff']").click(function(){
		//处理参数
		var data_str = '';
		eval('data_str =' + $(this).attr('data-param'));
		var type = data_str.type;
		$("[nc_type='comparediff']").show();
		$(this).hide();
		$("[name='isdiff[]']").each(function(){
			var itemval = $(this).val();
			if(itemval){
				itemval = itemval.split("|");
				if(type == 'light'){
					itemval[1] == 1?$("#comparetr_"+itemval[0]).addClass('diffrow'):'';
				} else {
					itemval[1] == 1?$("#comparetr_"+itemval[0]).removeClass('diffrow'):'';
				}				
			}
		});
	});
	//隐藏和显示相同项
	$("[nc_type='comparesame']").click(function(){
		//处理参数
		var data_str = '';
		eval('data_str =' + $(this).attr('data-param'));
		var type = data_str.type;
		$("[nc_type='comparesame']").show();
		$(this).hide();
		$("[name='isdiff[]']").each(function(){
			var itemval = $(this).val();
			if(itemval){
				itemval = itemval.split("|");
				if(type == 'show'){
					itemval[1] == 0?$("#comparetr_"+itemval[0]).show():'';
				} else {
					itemval[1] == 0?$("#comparetr_"+itemval[0]).hide():'';
				}				
			}
		});
	});
});
</script>