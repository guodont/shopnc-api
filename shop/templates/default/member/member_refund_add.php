<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncm-flow-layout">
  <div class="ncm-flow-container">
    <div class="title">
      <h3>申请退款服务类型：</h3>
      <div class="refund-type-box">
        <div class="refund-type-text" data-value="1">仅退款</div>
        <i></i>
        <ul class="refund-type-option">
          <li data-option="1" class="seleced">仅退款</li>
          <li data-option="2">退货退款</li>
        </ul>
      </div>
    </div>
    <div class="alert">
      <h4>操作提示：</h4>
      <ul>
        <li>1. 若您未收到货，或已收到货且与商家达成一致不退货仅退款时，请选择<em>“仅退款”</em>选项。</li>
        <li>2. 若为商品问题，或者不想要了且与商家达成一致退货，请选择<em>“退货退款”</em>选项，退货后请保留物流底单。</li>
        <li>3. 若提出申请后，商家拒绝退款或退货，可再次提交申请或选择<em>“商品投诉”</em>，请求商城客服人员介入。</li>
        <li>4. 成功完成退款/退货；经过商城审核后，会将退款金额以<em>“预存款”</em>的形式返还到您的余额账户中（充值卡部分只能退回到充值卡余额）。</li>
      </ul>
    </div>
    <div id="saleRefund" show_id="1">
      <div class="ncm-flow-step">
        <dl class="step-first current">
          <dt>买家申请退款</dt>
          <dd class="bg"></dd>
        </dl>
        <dl class="">
          <dt>商家处理退款申请</dt>
          <dd class="bg"> </dd>
        </dl>
        <dl class="">
          <dt>平台审核，退款完成</dt>
          <dd class="bg"> </dd>
        </dl>
      </div>
      <div class="ncm-default-form">
        <form id="post_form1" enctype="multipart/form-data" method="post" action="index.php?act=member_refund&op=add_refund&order_id=<?php echo $output['order']['order_id']; ?>&goods_id=<?php echo $output['goods']['rec_id']; ?>">
          <input type="hidden" name="form_submit" value="ok" />
          <input type="hidden" name="refund_type" value="1" />
          <h3>请填写退款申请</h3>
          <dl>
            <dt><i class="required">*</i>退款原因：</dt>
            <dd>
              <select class="select w150" name="reason_id">
                <option value="">请选择退款原因</option>
                <?php if (is_array($output['reason_list']) && !empty($output['reason_list'])) { ?>
                <?php foreach ($output['reason_list'] as $key => $val) { ?>
                <option value="<?php echo $val['reason_id'];?>"><?php echo $val['reason_info'];?></option>
                <?php } ?>
                <?php } ?>
                <option value="0">其他</option>
              </select>
              <span class="error"></span> </dd>
          </dl>
          <dl>
            <dt><i class="required">*</i>需要退款金额：</dt>
            <dd>
              <input type="text" class="text w50" name="refund_amount" value="<?php echo $output['goods']['goods_pay_price']; ?>" /><em class="add-on"><i class="icon-renminbi"></i></em>（最多 <strong class="green" title="可退金额由系统根据订单商品实际成交额和已退款金额自动计算得出"><?php echo $output['goods']['goods_pay_price']; ?></strong> 元） <span class="error"></span>
              <p class="hint"><?php echo '退款金额不能超过可退金额。';?></p>
            </dd>
          </dl>
          <dl>
            <dt><i class="required">*</i>退款说明：</dt>
            <dd>
              <textarea name="buyer_message" rows="3" class="textarea w400"></textarea>
              <br />
              <span class="error"></span> </dd>
          </dl>
          <dl>
            <dt>上传凭证：</dt>
            <dd>
              <p>
                <input name="refund_pic1" type="file" />
                <span class="error"></span> </p>
              <p>
                <input name="refund_pic2" type="file" />
                <span class="error"></span> </p>
              <p>
                <input name="refund_pic3" type="file" />
                <span class="error"></span> </p>
            </dd>
          </dl>
          <div class="bottom">
            <label class="submit-border">
              <input type="submit" class="submit" value="确认提交" />
            </label>
            <a href="javascript:history.go(-1);" class="ncm-btn ml10">取消并返回</a> </div>
        </form>
      </div>
    </div>
    <div id="saleRefundReturn" show_id="2" style="display: none;">
      <div class="ncm-flow-step">
        <dl class="step-first current">
          <dt>买家申请退货</dt>
          <dd class="bg"></dd>
        </dl>
        <dl class="">
          <dt>商家处理退货申请</dt>
          <dd class="bg"> </dd>
        </dl>
        <dl class="">
          <dt>买家退货给商家</dt>
          <dd class="bg"> </dd>
        </dl>
        <dl class="">
          <dt>确认收货，平台审核</dt>
          <dd class="bg"> </dd>
        </dl>
      </div>
      <div class=" ncm-default-form">
        <div id="warning"></div>
        <form id="post_form2" method="post" enctype="multipart/form-data" action="index.php?act=member_refund&op=add_refund&order_id=<?php echo $output['order']['order_id']; ?>&goods_id=<?php echo $output['goods']['rec_id']; ?>">
          <input type="hidden" name="form_submit" value="ok" />
          <input type="hidden" name="refund_type" value="2" />
          <h3>请填写退货退款申请</h3>
          <dl>
            <dt><i class="required">*</i>退货退款原因：</dt>
            <dd>
              <select class="select w150" name="reason_id">
                <option value="">请选择退货退款原因</option>
                <?php if (is_array($output['reason_list']) && !empty($output['reason_list'])) { ?>
                <?php foreach ($output['reason_list'] as $key => $val) { ?>
                <option value="<?php echo $val['reason_id'];?>"><?php echo $val['reason_info'];?></option>
                <?php } ?>
                <?php } ?>
                <option value="0">其他</option>
              </select>
              <span class="error"></span> </dd>
          </dl>
          <dl>
            <dt><i class="required">*</i><?php echo $lang['refund_order_refund'].$lang['nc_colon'];?></dt>
            <dd>
              <input type="text" class="text w50" name="refund_amount" value="<?php echo $output['goods']['goods_pay_price']; ?>" />
              <em class="add-on"><i class="icon-renminbi"></i></em> （最多 <strong class="green" title="可退金额由系统根据订单商品实际成交额和已退款金额自动计算得出。"><?php echo $output['goods']['goods_pay_price']; ?></strong> 元） <span class="error"></span>
              <p class="hint"><?php echo '退款金额不能超过可退金额。';?></p>
            </dd>
          </dl>
          <dl>
            <dt><i class="required">*</i><?php echo $lang['return_order_return'].$lang['nc_colon'];?></dt>
            <dd>
              <input type="text" class="text w50" name="goods_num" value="<?php echo $output['goods']['goods_num']; ?>" />
              <span class="error"></span> </dd>
          </dl>
          <dl>
            <dt><i class="required">*</i>退货退款说明：</dt>
            <dd>
              <textarea name="buyer_message" rows="3" class="textarea w400"></textarea>
              <br />
              <span class="error"></span> </dd>
          </dl>
          <dl>
            <dt>上传凭证：</dt>
            <dd>
              <p>
                <input name="refund_pic1" type="file" />
                <span class="error"></span> </p>
              <p>
                <input name="refund_pic2" type="file" />
                <span class="error"></span> </p>
              <p>
                <input name="refund_pic3" type="file" />
                <span class="error"></span> </p>
            </dd>
          </dl>
          <div class="bottom">
            <label class="submit-border">
              <input type="submit" class="submit" value="确认提交" />
            </label>
            <a href="javascript:history.go(-1);" class="ncm-btn ml10">取消并返回</a> </div>
        </form>
      </div>
    </div>
  </div>
  <?php require template('member/member_refund_right');?>
</div>
<script>
$(function(){
    /*
     * 模拟网页中所有的下拉列表select
     */
    function selectModel(){
        var $box = $('div.refund-type-box');
        var $option = $('ul.refund-type-option', $box);
        var $txt = $('div.refund-type-text', $box);
        var speed = 10;
        /*
         * 单击某个下拉列表时，显示当前下拉列表的下拉列表框
         * 并隐藏页面中其他下拉列表
         */
        $txt.click(function(e) {
                $option.not($(this).siblings('ul.refund-type-option')).slideUp(speed, function(){
                    int($(this));
                });
                $(this).siblings('ul.refund-type-option').slideToggle(speed, function(){
                    int($(this));
                });
                return false;
            });
        //点击选择，关闭其他下拉
        /*
         * 为每个下拉列表框中的选项设置默认选中标识 data-selected
         * 点击下拉列表框中的选项时，将选项的 data-option 属性的属性值赋给下拉列表的 data-value 属性，并改变默认选中标识 data-selected
         * 为选项添加 mouseover 事件
         */
        $option.find('li').each(function(index, element) {
                if($(this).hasClass('seleced')){
                    $(this).addClass('data-selected');
                }
            })
            .mousedown(function(){
                var seleced = $(this).attr('data-option');
                $("div[show_id]").hide();
                $("div[show_id='"+seleced+"']").show();
                $(this).parent().siblings('div.refund-type-text').text($(this).text())
                    .attr('data-value', seleced);

                $option.slideUp(speed, function(){
                    int($(this));
                });
                $(this).addClass('seleced data-selected').siblings('li').removeClass('seleced data-selected');
                return false;
            })
            .mouseover(function(){
                $(this).addClass('seleced').siblings('li').removeClass('seleced');
            });
        //点击文档，隐藏所有下拉
        $(document).click(function(e) {
            $option.slideUp(speed, function(){
                int($(this));
            });
        });
        //初始化默认选择
        function int(obj){
            obj.find('li.data-selected').addClass('seleced').siblings('li').removeClass('seleced');
        }
    }

    selectModel();
})
</script>
<script type="text/javascript">
$(function(){
    $('#post_form1').validate({
		errorPlacement: function(error, element){
			error.appendTo(element.nextAll('span.error'));
        },
		submitHandler:function(form){
			ajaxpost('post_form1', '', '', 'onerror')
		},
        rules : {
            reason_id : {
                required   : true
            },
            refund_amount : {
                required   : true,
                number   : true,
                min:0.01,
                max:<?php echo $output['goods']['goods_pay_price']; ?>
            },
            buyer_message : {
                required   : true
            },
            refund_pic1 : {
                accept : 'jpg|jpeg|gif|png'
            },
            refund_pic2 : {
                accept : 'jpg|jpeg|gif|png'
            },
            refund_pic3 : {
                accept : 'jpg|jpeg|gif|png'
            }
        },
        messages : {
            reason_id  : {
                required  : '<i class="icon-exclamation-sign"></i><?php echo '请选择退款原因';?>'
            },
            refund_amount  : {
                required  : '<i class="icon-exclamation-sign"></i><?php echo $lang['refund_pay_refund'];?> <?php echo $output['goods']['goods_pay_price']; ?>',
                number   : '<i class="icon-exclamation-sign"></i><?php echo $lang['refund_pay_refund'];?> <?php echo $output['goods']['goods_pay_price']; ?>',
                min   : '<i class="icon-exclamation-sign"></i><?php echo $lang['refund_pay_min'];?> 0.01',
	            max   : '<i class="icon-exclamation-sign"></i><?php echo $lang['refund_pay_refund'];?> <?php echo $output['goods']['goods_pay_price']; ?>'
            },
            buyer_message  : {
                required   : '<i class="icon-exclamation-sign"></i>请填写退款说明'
            },
            refund_pic1: {
                accept : '<i class="icon-exclamation-sign"></i>图片必须是jpg/jpeg/gif/png格式'
            },
            refund_pic2: {
                accept : '<i class="icon-exclamation-sign"></i>图片必须是jpg/jpeg/gif/png格式'
            },
            refund_pic3: {
                accept : '<i class="icon-exclamation-sign"></i>图片必须是jpg/jpeg/gif/png格式'
            }
        }
    });
    $('#post_form2').validate({
		errorPlacement: function(error, element){
			error.appendTo(element.nextAll('span.error'));
        },
		submitHandler:function(form){
			ajaxpost('post_form2', '', '', 'onerror')
		},
        rules : {
            reason_id : {
                required   : true
            },
            refund_amount : {
                required   : true,
                number   : true,
                min:0.01,
                max:<?php echo $output['goods']['goods_pay_price']; ?>
            },
            goods_num : {
                required   : true,
                digits   : true,
                min:1,
                max:<?php echo $output['goods']['goods_num']; ?>
            },
            buyer_message : {
                required   : true
            },
            refund_pic1 : {
                accept : 'jpg|jpeg|gif|png'
            },
            refund_pic2 : {
                accept : 'jpg|jpeg|gif|png'
            },
            refund_pic3 : {
                accept : 'jpg|jpeg|gif|png'
            }
        },
        messages : {
            reason_id  : {
                required  : '<i class="icon-exclamation-sign"></i><?php echo '请选择退货退款原因';?>'
            },
            refund_amount  : {
                required  : '<i class="icon-exclamation-sign"></i><?php echo $lang['refund_pay_refund'];?> <?php echo $output['goods']['goods_pay_price']; ?>',
                number   : '<i class="icon-exclamation-sign"></i><?php echo $lang['refund_pay_refund'];?> <?php echo $output['goods']['goods_pay_price']; ?>',
                min   : '<i class="icon-exclamation-sign"></i><?php echo $lang['refund_pay_min'];?> 0.01',
	            max   : '<i class="icon-exclamation-sign"></i><?php echo $lang['refund_pay_refund'];?> <?php echo $output['goods']['goods_pay_price']; ?>'
            },
            goods_num  : {
                required  : '<i class="icon-exclamation-sign"></i><?php echo $lang['return_add_return'];?> <?php echo $output['goods']['goods_num']; ?>',
                digits   : '<i class="icon-exclamation-sign"></i><?php echo $lang['return_add_return'];?> <?php echo $output['goods']['goods_num']; ?>',
                min   : '<i class="icon-exclamation-sign"></i><?php echo $lang['return_number_min'];?> 1',
	            max   : '<i class="icon-exclamation-sign"></i><?php echo $lang['return_number_max'];?> <?php echo $output['goods']['goods_num']; ?>'
            },
            buyer_message  : {
                required   : '<i class="icon-exclamation-sign"></i>请填写退货退款说明'
            },
            refund_pic1: {
                accept : '<i class="icon-exclamation-sign"></i>图片必须是jpg/jpeg/gif/png格式'
            },
            refund_pic2: {
                accept : '<i class="icon-exclamation-sign"></i>图片必须是jpg/jpeg/gif/png格式'
            },
            refund_pic3: {
                accept : '<i class="icon-exclamation-sign"></i>图片必须是jpg/jpeg/gif/png格式'
            }
        }
    });
});
</script>