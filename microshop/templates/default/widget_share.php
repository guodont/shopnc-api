<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="share-widget">
<?php if (!empty($output['app_arr'])){?>
<input nc_type="share_app_switch" name="share_app_switch" type="checkbox" class="input-checkbox"/>
<span class="title"><?php echo $lang['microshop_share_to'];?><i></i></span>
<?php } else { ?>
<input nc_type="share_app_switch" name="share_app_switch" type="checkbox" class="input-checkbox" style="display:none"/>
<?php } ?>
<input name="share_app_items[]" type="hidden" value="shop" />
<?php if (!empty($output['app_arr'])){?>
<ul>
<?php foreach ($output['app_arr'] as $key=>$val){?>
<li>
<a nc_type="bindbtn" data-param='{"apikey":"<?php echo $key;?>","apiname":"<?php echo $val['name'];?>"}' attr_isbind="<?php echo $val['isbind']?'1':'0';?>" href="javascript:void(0)" class="<?php echo $key.'-disable';?>" title="<?php echo $val['name'];?>"></a>
<input id="checkapp_<?php echo $key;?>" name="share_app_items[]" type="hidden" value="<?php echo $val['isbind']?$key:'';?>" />
</li>
<?php }?>
</ul>
<textarea id="bindtooltip_module" style="display:none;">
        <div class="eject_con">
            <dl>
                <dt style="width:25%">
                <img src="<?php echo MICROSHOP_TEMPLATES_URL;?>/images/shareicon/shareicon_@apikey.png" width="40" height="40" class="mt5 mr20">
                </dt>
                <dd style="width:75%">
                <p><?php echo $lang['microshop_share_tip1'];?><strong class="ml5 mr5">@apiname</strong><?php echo $lang['microshop_share_tip2'];?><p>
                <p class="red"><?php echo $lang['microshop_share_tip3'];?>@apiname<?php echo $lang['microshop_share_tip4'];?></p>
                </dd>
            </dl>
            <dl class="bottom">
                <dt style="width:25%">&nbsp;</dt>
                <dd style="width:75%">
                <a href="javascript:void(0);" id="finishbtn" data-param='{"apikey":"@apikey"}' class="ncu-btn2 mr10"><?php echo $lang['microshop_share_tip5'];?></a>
                <span><?php echo $lang['microshop_share_tip6'];?>
                    <a target="_blank" href="<?php echo SHOP_SITE_URL;?>/api.php?act=sharebind&type=@apikey" class="ml5"><?php echo $lang['microshop_share_tip7'];?></a>
                </span>
                </dd>
            </dl>
        </div>
    </textarea>
<?php }?>
</div>
