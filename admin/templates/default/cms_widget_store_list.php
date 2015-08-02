<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['store_list']) && is_array($output['store_list'])){ ?>
<div class="store-select-box">
    <div class="arrow"></div>
    <ul id="store_search_list" class="store-search-list">
        <?php foreach($output['store_list'] as $value){ ?>
        <li>
        <dl class="store-info">
            <dt class="store-name">
            <a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$value['store_id']));?>"  >
                <?php echo $value['store_name'];?>
            </a>
            </dt>
            <dd class="store-logo">
            <a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$value['store_id']));?>"  >
                <img src="<?php echo getStoreLogo($value['store_avatar']);?>" />
            </a>
            </dd>
            <dd class="member-name">店主：<?php echo $value['member_name'];?></dd>
            <dd nctype="btn_store_select" class="handle-button" title="<?php echo $lang['cms_text_add'];?>"></dd>
        </dl>
        </li>
        <?php } ?>
    </ul>
    <div class="pagination"><?php echo $output['show_page'];?></div>
</div>
<?php }else { ?>
<div class="no-record"><?php echo $lang['no_record'];?></div>
<?php } ?>
