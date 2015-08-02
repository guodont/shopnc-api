<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
#glist tr.item{ cursor:pointer }
#glist tr.selected{ border:#329ED1 1px solid; }
#glist .ginfo .img{ border:1px #D9D9D9 solid; margin-right:10px; }
#glist .ginfo .infoitem{ width:120px; height:30px; }
</style>
<div style="border:1px #D9D9D9 solid; padding:10px; width:98%;">
    <div style="text-align:right;">
    	<input class="txt" type="text" value="<?php echo $output['search_arr']['gname'];?>" id="gname" name="gname">
    	<a href="index.php?act=stat_marketing&op=grouplist&t=<?php echo $output['searchtime'];?>" id="glistsearchbtn" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
    </div>
    <table class="table tb-type2 nobdb">
        <tbody id="glist">
        <?php if(!empty($output['grouplist'])){ ?>
        <?php foreach ((array)$output['grouplist'] as $k=>$v){?>
          <tr nc_type="gitem" class="hover item <?php echo $k==1?'selected':''; ?>">
            <td><?php echo $v['groupbuy_name'];?></td>
            <td>抢购时间：<?php echo @date('Y-m-d',$v['start_time']).'~'.@date('Y-m-d',$v['end_time']);?></td>
            <td><?php echo $v['groupbuy_state_text'];?></td>
          </tr>
          <tr nc_type="ginfo" class="hover ginfo" style="<?php echo $k==1?'':'display:none;'; ?>">
            <td colspan="3">
            	<div class="size-106x106 left img"><span class="thumb size-106x106"><i></i><a target="_blank" href="<?php echo SHOP_SITE_URL."/index.php?act=show_groupbuy&op=groupbuy_detail&group_id=".$v['groupbuy_id'];?>"><img src="<?php echo gthumb($v['groupbuy_image'], 'small');?>" style=" max-width: 106px; max-height: 106px;"/></a></span></div>
            	<div class="left">
                	<h3><?php echo $v['goods_name'];?></h3>
                	<div class="close_float">
                		<span class="infoitem left">原价：<em class="red_common"><?php echo $v['goods_price'].$lang['currency_zh'];?></em></span>
                		<span class="infoitem left">折扣：<em class="red_common"><?php echo $v['groupbuy_rebate'];?>折</em></span>
                		<span class="infoitem left">抢购价：<em class="red_common"><?php echo $v['groupbuy_price'].$lang['currency_zh'];?></em></span>
                	</div>
                	<div class="close_float">
                		<span class="infoitem left">浏览次数：<em class="red_common"><?php echo $v['views'];?></em></span>
                		<span class="infoitem left">下单量：<em class="red_common"><?php echo $v['ordernum'];?></em></span>
                		<span class="infoitem left">购买量：<em class="red_common"><?php echo $v['goodsnum'];?></em></span>
                		<span class="infoitem left" style="width:200px;">总金额：<em class="red_common"><?php echo $v['goodsamount'].$lang['currency_zh'];?></em></span>
                		<span class="infoitem left" style="width:300px;">下单转化率：<em class="red_common"><?php echo $v['orderrate']; ?>%</em></span>
                	</div>
            	</div>
            </td>
          </tr>
        <?php } ?>
        <?php } else{ ?> 
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
        </tbody>
        <?php if(!empty($output['grouplist']) && is_array($output['grouplist'])){ ?>
        <tfoot>
          <tr class="tfoot">
            <td colspan="15" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
          </tr>
        </tfoot>
        <?php } ?>
    </table>
</div>

<script>
$(function () {
	//show info
	$("[nc_type='gitem']").click(function(){
		$("[nc_type='gitem']").removeClass('selected');
		if($(this).next('tr').css('display') == 'none'){
			$("[nc_type='ginfo']").hide();
			$(this).addClass('selected');
			$(this).next('tr').show();
		} else {
			$("[nc_type='ginfo']").hide();
		}
	});

	$('#glist').find('.demo').ajaxContent({
		event:'click', //mouseover
		loaderType:"img",
		loadingMsg:"<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif",
		target:'#glist'
	});
	$("#glistsearchbtn").mouseover(function(){
		var gname = $("#gname").val();
		$(this).attr('href','index.php?act=stat_marketing&op=grouplist&t=<?php echo $output['searchtime'];?>&gname='+gname);
		$("#glistsearchbtn").ajaxContent({
			event:'click',
			loaderType:"img",
			loadingMsg:"<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif",
			target:'#glist'
		});
	});
});
</script>