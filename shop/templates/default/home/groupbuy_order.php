<?php defined('InShopNC') or exit('Access Invalid!');?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="ncg-buyer">
    <thead>
        <tr>
            <th width="25%"><?php echo $lang['text_buyer'];?></th>
            <th width="15%"><?php echo $lang['text_buy_count'];?></th>
            <th width="15%"><?php echo $lang['text_unit_price'];?></th>
            <th><?php echo $lang['text_buy_time'];?></th>
        </tr>
    </thead>
    <?php if(!empty($output['order_goods_list']) && is_array($output['order_goods_list'])) { ?>
    <tbody>
        <?php foreach($output['order_goods_list'] as $order) { ?>
        <tr>
            <td>
                <a href="index.php?act=member_snshome&mid=<?php echo $order['buyer_id'];?>" target="_blank">
                    <?php echo $order['buyer_name'] ? $order['buyer_name'] : $output['order_list'][$order['order_id']]['buyer_name']; ?>
                </a>
                </td>
            <td><?php echo $order['goods_num'];?></td>
            <td><?php echo $lang['currency'].$order['goods_price'];?></td>
            <td><?php echo $order['add_time'] ? date('Y-m-d H:i:s', $order['add_time']) : date('Y-m-d H:i:s', $output['order_list'][$order['order_id']]['add_time']);?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="10">
                <div class="pagination"> <?php echo $output['show_page'];?> </div>
            </td>
        </tr>
    </tfoot>
    <?php } else { ?>
    <tbody>
        <tr><td colspan="20"><p class="no-buyer">暂无人购买</p></td></tr>
    </tbody>
    <?php } ?>
</table>
<script type="text/javascript">
$(document).ready(function(){
    $('#groupbuy_order').find('.demo').ajaxContent({
        event:'click',
        loaderType:"img",
        loadingMsg:"<?php echo SHOP_TEMPLATES_URL;?>/images/transparent.gif",
        target:'#groupbuy_order'
    });
});
</script>

