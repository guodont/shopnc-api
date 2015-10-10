<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function() {
    var personal_count = Math.ceil($("#indexPersonal li").length / 4);
    var control_html = '<div id="indexPersonalControl" nctype="cms_index_not_save">';
    for(var i = 1; i <= personal_count; i++) {
        control_html += '<a href="###" class="" data-count="'+ i +'"></a>';
    }
    control_html += "</div>";
    $("#indexPersonal").after(control_html);
    //个人秀滚动
    $('#indexPersonal').jcarousel({
        initCallback: mycarousel_initCallback,
            itemLoadCallback: mycarousel_LoadCallback,
            auto:5,
            scroll:4,
            wrap:'last',
            buttonNextHTML: null,
            buttonPrevHTML: null
    });
    function mycarousel_LoadCallback(carousel, state) {
        $("#indexPersonalControl a").each(function() {
            if($(this).attr("data-count") * 4 - 3 == carousel.first) {
                $(this).attr("class", "current");
            } else {
                $(this).attr("class", "");
            }
        });
    };
    function mycarousel_initCallback(carousel) {
        $('#indexPersonalControl a').live('click', function() {
            carousel.scroll(jQuery.jcarousel.intval($(this).attr("data-count")) * 4 - 3);
            return false;
        });
    };

    //店铺
    $("[nc_type='index_store']").each(function() {
        var overall = $(this).find("li.overall");
        var simple = $(this).find("li.simple");
        overall.hide();
        overall.first().show();
        simple.first().hide();
        simple.mouseover(function(){
            simple.show();
            overall.hide();
            $(this).prev("li.overall").show();
            $(this).hide();
        });
    });

});
</script>

<div class="cms-index-module-micro">
  <div id="micro_content" nctype="object_module_edit"> <?php echo html_entity_decode($module_content['micro_content']);?>
  </div>
    <?php if($output['edit_flag']) { ?>
  <div class="cms-index-module-handle"><a id="btn_module_micro_edit" href="JavaScript:void(0);" class="tip-r" title="<?php echo $lang['cms_index_module_micro_edit'];?>"><?php echo $lang['cms_index_module_micro_edit'];?></a></div>
  <?php } ?>
</div>
