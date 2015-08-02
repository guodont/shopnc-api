<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){
        /**
         * 同步第三方应用
         **/
        $("[nc_type='share_app_switch']").unbind('click').bind("click", function(){
            if($(this).attr("checked") == "checked") {
                $(this).parent().find("[nc_type='bindbtn']").each(function(){
                    var data_str = $(this).attr('data-param');
                    eval( "data_str = "+data_str);
                    //判断是否已经绑定
                    var isbind = $(this).attr('attr_isbind');
                    if(isbind == '1'){//已经绑定
                        $(this).removeClass(data_str.apikey+'-disable');
                        $(this).addClass(data_str.apikey+'-enable');
                        $("#checkapp_"+data_str.apikey).val(data_str.apikey);
                    } else {
                        $(this).removeClass(data_str.apikey+'-enable');
                        $(this).addClass(data_str.apikey+'-disable');
                        $("#checkapp_"+data_str.apikey).val('');
                    }
                });  
            } else {
                $("[nc_type='bindbtn']").each(function(){
                    var data_str = $(this).attr('data-param');
                    eval( "data_str = "+data_str);
                    $(this).removeClass(data_str.apikey+'-enable');
                    $(this).addClass(data_str.apikey+'-disable');
                    $("#checkapp_"+data_str.apikey).val('');
                });  
            }
        });
    $("[nc_type='bindbtn']").unbind('click').bind('click',function(){
        var data_str = $(this).attr('data-param');
        eval( "data_str = "+data_str);
        //判断是否已经绑定
        var isbind = $(this).attr('attr_isbind');
        if(isbind == '1'){//已经绑定
            if($("#checkapp_"+data_str.apikey).val() == ''){
                if($("[nc_type='share_app_switch']").attr("checked") == "checked") {
                    $(this).removeClass(data_str.apikey+'-disable');
                    $(this).addClass(data_str.apikey+'-enable');
                    $("#checkapp_"+data_str.apikey).val(data_str.apikey);
                }
            }else{
                $(this).removeClass(data_str.apikey+'-enable');
                $(this).addClass(data_str.apikey+'-disable');
                $("#checkapp_"+data_str.apikey).val('');
            }
        }else{
            var html = $("#bindtooltip_module").text();
            //替换关键字
            html = html.replace(/@apikey/g,data_str.apikey);
            html = html.replace(/@apiname/g,data_str.apiname);
            html_form("bindtooltip", "<?php echo $lang['cms_share_account_link'];?>", html, 360, 0);	    
            window.open('<?php echo SHOP_SITE_URL.DS;?>api.php?act=sharebind&type='+data_str.apikey);
        }
    });
    $("#finishbtn").live('click',function(){
        var data_str = $(this).attr('data-param');
        eval( "data_str = "+data_str);
        //验证是否绑定成功
        var url = '<?php echo SHOP_SITE_URL.DS;?>index.php?act=member_sharemanage&op=checkbind&callback=?';
        $.getJSON(url, {'k':data_str.apikey}, function(data){
            DialogManager.close('bindtooltip');
            if (data.done)
            {
                $("[nc_type='appitem_"+data_str.apikey+"']").addClass('check');
                $("[nc_type='appitem_"+data_str.apikey+"']").removeClass('disable');
                $('#checkapp_'+data_str.apikey).val('1');
                $("[nc_type='appitem_"+data_str.apikey+"']").find('i').attr('attr_isbind','1');
            }
            else
            {
                showDialog(data.msg, 'notice');
            }
        });
    });
});
</script>

<div class="share-widget">
<?php if (!empty($output['app_arr'])){?>
<input nc_type="share_app_switch" name="share_app_switch" type="checkbox" class="input-checkbox"/>
<?php echo $lang['cms_share_to'];?>
<?php } else { ?>
<input nc_type="share_app_switch" name="share_app_switch" type="checkbox" class="input-checkbox" style="display:none"/>
<?php } ?>
<input name="share_app_items[]" type="hidden" value="shop" />
<?php if (!empty($output['app_arr'])){?>
<ul>
  <?php foreach ($output['app_arr'] as $key=>$val){?>
  <li> <a nc_type="bindbtn" data-param='{"apikey":"<?php echo $key;?>","apiname":"<?php echo $val['name'];?>"}' attr_isbind="<?php echo $val['isbind']?'1':'0';?>" href="javascript:void(0)" class="<?php echo $key.'-disable';?>" title="<?php echo $val['name'];?>"></a>
    <input id="checkapp_<?php echo $key;?>" name="share_app_items[]" type="hidden" value="<?php echo $val['isbind']?$key:'';?>" />
  </li>
  <?php }?>
</ul>
<textarea id="bindtooltip_module" style="display:none;">
        <div class="eject_con">
            <dl>
                <dt style="width:25%">
                <img src="<?php echo CMS_TEMPLATES_URL;?>/images/shareicon/shareicon_@apikey.png" width="40" height="40" class="mt5 mr20">
                </dt>
                <dd style="width:75%">
                <p><?php echo $lang['cms_share_tip1'];?><strong class="ml5 mr5">@apiname</strong><?php echo $lang['cms_share_tip2'];?><p>
                <p class="red"><?php echo $lang['cms_share_tip3'];?>@apiname<?php echo $lang['cms_share_tip4'];?></p>
                </dd>
            </dl>
            <dl class="bottom">
                <dt style="width:25%">&nbsp;</dt>
                <dd style="width:75%">
                <a href="javascript:void(0);" id="finishbtn" data-param='{"apikey":"@apikey"}' class="ncu-btn2 mr10"><?php echo $lang['cms_share_tip5'];?></a>
                <span><?php echo $lang['cms_share_tip6'];?>
                    <a target="_blank" href="<?php echo SHOP_SITE_URL;?>/api.php?act=sharebind&type=@apikey" class="ml5"><?php echo $lang['cms_share_tip7'];?></a>
                </span>
                </dd>
            </dl>
        </div>
    </textarea>
<?php }?>
</div>
