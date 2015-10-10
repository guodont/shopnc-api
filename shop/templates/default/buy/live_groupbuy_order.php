<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncc-main">
  <div class="ncc-title">
    <h3>我的抢购</h3>
    <h5>查看抢购清单，增加减少抢购数量，进入下一步操作。</h5>
  </div>
  <form action="<?php echo urlShop('show_live_groupbuy','livegroupbuystep1');?>" method="POST" id="apply_form" name="apply_form">
    <input type="hidden" value="1" name="ifcart">
    <table class="ncc-table-style" nc_type="table_cart">
      <thead>
        <tr>
          <th colspan="3">抢购</th>
          <th class="w120">单价</th>
          <th class="w120">数量</th>
          <th class="w120">总价</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th colspan="20">
			<i class="icon-home"></i>
		  	<?php if(!empty($output['store_info']['live_store_name'])){?>
			<?php echo $output['store_info']['live_store_name']; ?>
			<?php }else{?>
			<a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$output['store_info']['store_id']));?>" target="_blank"><?php echo $output['store_info']['store_name'];?></a>
			<?php }?>
		  <span></span>
		 </th>
        </tr>
        <tr class="shop-list">
          <td class="w10"></td>
          <td class="w60">
			<a class="ncc-goods-thumb" target="_blank" href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$output['live_groupbuy']['groupbuy_id']));?>"> <img alt="<?php echo $output['live_groupbuy']['groupbuy_name'];?>" src="<?php echo lgthumb($output['live_groupbuy']['groupbuy_pic'],'small');?>"> </a>
		  </td>
          <td class="tl">
			<a target="_blank" href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$output['live_groupbuy']['groupbuy_id']));?>"><?php echo $output['live_groupbuy']['groupbuy_name'];?></a></td>
          <td><span id="deal-buy-price" price="<?php echo $output['live_groupbuy']['groupbuy_price'];?>">￥<?php echo $output['live_groupbuy']['groupbuy_price'];?></span></td>
          <td><a title="减少抢购数" class="add-substract-key tip" href="javascript:void(0)" id="reduce" >-</a>
            <input type="text" value="1" name="q_number" maxlength="4" class="text w20" id="q_number">
            <a title="增加抢购数" class="add-substract-key tip" href="javascript:void(0)" id="add">+</a>
          <td><span id="deal-buy-total">￥<?php echo $output['live_groupbuy']['groupbuy_price'];?></span></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20"><div class="ncc-all-account">总额（购买数量不能超过<?php echo $output['live_groupbuy']['buyer_limit'];?>券）￥<em id="payment"><?php echo $output['live_groupbuy']['groupbuy_price'];?></em>元</div></td>
        </tr>
      </tfoot>
    </table>
    <input type="hidden" name="groupbuy_id" value="<?php echo $output['live_groupbuy']['groupbuy_id'];?>">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncc-bottom"><a id="groupbuy_submit" href="javascript:void(0)" class="ncc-btn ncc-btn-acidblue fr"><i class="icon-pencil"></i><?php echo $lang['cart_index_input_next'].$lang['cart_index_ensure_info'];?></a></div>
  </form>
</div>
<script type="text/javascript">
	$(function(){
		$('#add').click(function(){
			var num 	= parseInt($('#q_number').val());
			var price	= $('#deal-buy-price').attr('price');
			var limit = parseInt('<?php echo $output['live_groupbuy']['buyer_limit'];?>');

			if(isNaN(num)){
				alert('<?php echo $lang['nc_groupbuy_order_fillthenumbers'];?>');
				return false;
			}
			

			
			var total_num = eval(num+1);
			if(total_num>limit){
				alert('不能超过抢购上线');
				return false;	
			}
			$('#q_number').val(num+1);
			var total_price = eval(total_num+"*"+price);

			$('#deal-buy-total').html('￥'+total_price.toFixed(2));
			$('#payment').html(total_price.toFixed(2));
		});

		$('#reduce').click(function(){
			var num	= parseInt($('#q_number').val());
			var price	= $('#deal-buy-price').attr('price');
			
			if(isNaN(num)){
				alert('<?php echo $lang['nc_groupbuy_order_fillthenumbers'];?>');
				return false;			
			}

			var total_num = eval(num-1);
			if(total_num<1){
				alert('<?php echo $lang['nc_groupbuy_order_more_than_zero'];?>');
				return false;				
			}
			$('#q_number').val(total_num);
			var total_price = eval(total_num+"*"+price);
			$('#deal-buy-total').html('￥'+total_price.toFixed(2));
			$('#payment').html(total_price.toFixed(2));
		});


		$('#q_number').blur(function(){
			var num 	= parseInt($('#q_number').val());
			var price	= parseInt($('#deal-buy-price').attr('price'));
			var limit = parseInt('<?php echo $output['live_groupbuy']['buyer_limit'];?>');

			if(isNaN(num)){
				alert('<?php echo $lang['nc_groupbuy_order_fillthenumbers'];?>');
				$('#q_number').val(1);
				return false;
			}

			if(num<1){
				alert('<?php echo $lang['nc_groupbuy_order_more_than_zero'];?>');
				$('#q_number').val(1);
				return false;				
			}

			if(num>limit){
				alert('不能超过抢购上线');
				$('#q_number').val(1);
				return false;	
			}

			$('#q_number').val(num);
			var total_price = eval(num+"*"+price);

			$('#deal-buy-total').html('￥'+total_price.toFixed(2));
			$('#payment').html(total_price.toFixed(2));
		});
		

		$('#groupbuy_submit').click(function(){
			var is_login = '<?php echo $_SESSION['is_login']?>';
			if(is_login!=1){
				alert('<?php echo $lang['nc_groupbuy_order_loginfirst'];?>');
				return false;
			}
			
			var mobile = $('#mobile').val();
			if(mobile == ''){
				alert('手机号码不能为空!');
				return false;
			}

			var limit = parseInt('<?php echo $output['live_groupbuy']['buyer_limit'];?>');
			var quantity = parseInt($('#q_number').val());

			if(quantity>limit){
				alert('<?php echo $lang['nc_groupbuy_order_cannotover'];?>');
				return false;
			}
			
			$('#apply_form').submit();
		});

	});

</script> 
