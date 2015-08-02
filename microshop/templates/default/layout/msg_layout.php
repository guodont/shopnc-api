<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php require MICROSHOP_BASE_TPL_PATH.'/layout/top.php';?>
<div id="microshop-content">
    <div class="wrap-shadow">
        <div class="wrap-all" >
            <?php if($output['msg_type'] == 'error'){ ?>
            <p class="msg defeated">
            <?php }else { ?>
            <p class="msg success">
            <?php } ?>
            <span>
                <?php require_once($tpl_file);?>
            </span> </p>
        </div>
    </div>
<script type="text/javascript">
<?php if (!empty($output['url'])){
?>
    window.setTimeout("javascript:location.href='<?php echo $output['url'];?>'", <?php echo $time;?>);
<?php
}else{
?>
    window.setTimeout("javascript:history.back()", <?php echo $time;?>);
<?php
}?>
    </script>
    <?php require_once($tpl_file);?>
</div>
<?php require MICROSHOP_BASE_TPL_PATH.'/layout/footer.php';?>
