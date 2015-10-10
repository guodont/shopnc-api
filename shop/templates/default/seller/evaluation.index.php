<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="tabmenu">
    <ul id="listpj" class="tab">
        <li class="active"><a href="<?php echo urlShop('store_evaluate', 'list');?>"><?php echo $lang['member_evaluation_frombuyer'];?></a></li>
    </ul>
</div>
<form method="get">
  <table class="search-form">
    <input type="hidden" name="act" value="store_evaluate" />
    <input type="hidden" name="op" value="list" />
    <tr>
      <td>&nbsp;</td>
      <th class="w110">商品名称</th>
      <td class="w160"><input type="text" class="text w150" name="goods_name" value="<?php echo $_GET['goods_name'];?>"/></td>
      <th class="w110">评价人</th>
      <td class="w160"><input type="text" class="text w150" name="member_name" value="<?php echo $_GET['member_name'];?>"/></td>
      <td class="w70 tc"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
    </tr>
  </table>
</form>
<table class="ncsc-default-table">
    <thead>
        <tr>
            <th class="w10"></th>
            <th class="tl">评价信息</th>
            <th class="w90"><?php echo $lang['nc_handle'];?></th>
        </tr>
    </thead>
    <tbody>
        <?php if (is_array($output['goodsevallist']) && !empty($output['goodsevallist'])) { ?>
        <?php foreach ((array)$output['goodsevallist'] as $k=>$v){?>
        <tr>
            <th></th>
            <th>
                <span class="goods-name"><a target="_blank" href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['geval_goodsid']));?>"><?php echo $v['geval_goodsname']?></a></span>
                <span>商品评价：<em class="raty" data-score="<?php echo $v['geval_scores'];?>"></em></span>
                <span>评价人：<?php echo $v['geval_frommembername'];?> <time>[<?php echo date('Y-m-d H:i:s',$v['geval_addtime']);?>]</time></span>
            </th>
            <th></th>
        </tr>
        <tr>
            <td rowspan="2"></td>
            <td class="tl">
                <strong>评价内容：</strong>
                <span><?php echo $v['geval_content'];?></span>
            </td>
            <td rowspan="2" class="nscs-table-handle vt">
                <span><a nctype="btn_show_explain_dialog" data-geval-id="<?php echo $v['geval_id'];?>" data-geval-content="<?php echo $v['geval_content'];?>" href="javascript:;" class="btn-acidblue">
                        <i class="icon-comments-alt "></i>
                        <p><?php echo $lang['member_evaluation_explain'];?></p>
                </a></span>
            </td>
        </tr>
        <tr class="bd-line" >
            <td class="tl" colspan="20">
                <div <?php echo empty($v['geval_explain'])?'style="display:none;"':''?>>
                    <strong>解释内容：</strong>
                    <span nctype="explain"><?php echo $v['geval_explain'];?></span>
                </div>
            </td>
        </tr>
        <?php }?>
        <?php } else { ?>
        <tr>
            <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
        </tr>
    </tfoot>
</table>
<div id="dialog_explain" style="display:none;">
    <div class="eject_con">
    <div id="warning" class="alert alert-error"></div>
    <form id="explain_form">
        <input type="hidden" id="geval_id">
        <dl>
            <dt>评价内容：</dt>
            <dd id="geval_content"></dd>
        </dl>
        <dl>
            <dt><i class="required">*</i>解释内容：</dt>
            <dd>
            <textarea id="geval_explain" name="geval_explain" cols="30" rows="10"></textarea>
            </dd>
        </dl>
        <div class="bottom">
            <a href="javascript:void(0);" id="btn_explain_submit" class="submit">确定</a>
        </div>
    </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.raty').raty({
        path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
            readOnly: true,
            score: function() {
                return $(this).attr('data-score');
                }
                });

    var $item = {};

    $('[nctype="btn_show_explain_dialog"]').on('click', function() {
        $item = $(this).parents('tr').next('tr').find('[nctype="explain"]');
        var geval_id = $(this).attr('data-geval-id');
        var geval_content = $(this).attr('data-geval-content');
        $('#geval_id').val(geval_id);
        $('#geval_content').text(geval_content);
        $('#geval_explain').val('');
        $('#dialog_explain').nc_show_dialog({title:'解释评价'});
        });

    $('#btn_explain_submit').on('click', function() {
        if($('#explain_form').valid()){
        	var geval_id = $('#geval_id').val();
            var geval_explain = $('#geval_explain').val();
            $.post("<?php echo urlShop('store_evaluate', 'explain_save');?>",{
                geval_id: geval_id,
                geval_explain: geval_explain 
            }, function(data) {
                if(data.result) {
                    $('#dialog_explain').hide();
                    $item.text(geval_explain);
                    $item.parent().show();
                    showSucc(data.message);
                } else {
                    showError(data.message);
                }
            }, 'json');
        }
    });

    $('#explain_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors)
           {
               $('#warning').show();
           }
           else
           {
               $('#warning').hide();
           }
        },
        rules : {
        	geval_explain : {
                required : true
            }
        },
        messages : {
        	geval_explain : {
                required : '<i class="icon-exclamation-sign"></i>解释内容不能为空'
            }
        }
    });
});
</script>
