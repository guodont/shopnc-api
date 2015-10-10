<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="ncm-evaluation-store">
    <div class="title">店铺信息</div>
    <div class="store-name"> <?php echo $output['store_info']['store_name']; ?> </div>
    <div class="store-info">
<?php if (!$output['store_info']['is_own_shop']) { ?>
        <dl class="all-rate">
            <dt>综合评分：</dt>
            <dd>
            <div class="rating"><span style="width: <?php echo $output['store_info']['store_credit_percent'];?>%"></span></div>
            <em><?php echo $output['store_info']['store_credit_average'];?></em>分</dd>
        </dl>
        <div class="detail-rate">
            <h5><strong><?php echo $lang['member_evaluation_storeevalstat'];?></strong>与行业相比</h5>
            <ul>
                <?php  foreach ($output['store_info']['store_credit'] as $value) {?>
                <li><span><?php echo $value['text'];?></span><span class="credit"><?php echo $value['credit'];?> 分</span> <span class="<?php echo $value['percent_class'];?>"><i></i><?php echo $value['percent_text'];?><em><?php echo $value['percent'];?></em></span> </li>
                <?php } ?>
            </ul>
        </div>
<?php } ?>
        <?php if(defined('CHAT_SITE_URL') || !empty($output['store_info']['store_qq']) || !empty($output['store_info']['store_ww'])){?>
        <dl class="messenger">
            <dt>联系方式：</dt>
            <dd><span member_id="<?php echo $output['store_info']['member_id'];?>"></span>
            <?php if(!empty($output['store_info']['store_qq'])){?>
            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $output['store_info']['store_qq'];?>&site=qq&menu=yes" title="QQ: <?php echo $output['store_info']['store_qq'];?>"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $output['store_info']['store_qq'];?>:52" style=" vertical-align: middle;"/></a>
            <?php }?>
            <?php if(!empty($output['store_info']['store_ww'])){?>
            <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&amp;uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=1&charset=<?php echo CHARSET;?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" alt="<?php echo $lang['nc_message_me'];?>" style=" vertical-align: middle;"/></a>
            <?php }?>
            </dd>
        </dl>
        <?php } ?>
        <?php if(!empty($output['store_info']['store_phone'])){?>
        <dl class="messenger">
            <dt>店铺电话：</dt>
            <dd><?php echo $output['store_info']['store_phone'];?></dd>
        </dl>
        <?php } ?>
        <dl class="no-border">
            <dt>公司名称：</dt>
            <dd><?php echo $output['store_info']['store_company_name'];?></dd>
        </dl>
        <dl >
            <dt>所&nbsp;&nbsp;在&nbsp;&nbsp;地：</dt>
            <dd><?php echo $output['store_info']['area_info'];?></dd>
        </dl>
    </div>
</div>
