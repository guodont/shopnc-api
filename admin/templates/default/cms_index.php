<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.module-state-show { background-color: #FFF; }
.module-state-hide { background-color: #CCC; }

</style>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/template.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    //页面模块列表
    <?php if(!empty($output['list']) && is_array($output['list'])) {?>
    var page_module_list = $.parseJSON('<?php echo json_encode($output['list']);?>');
    var page_view_html = '';
    $.each(page_module_list, function(index, page_module) {
        page_view_html += runder_page_view(page_module); 
    });
    $('#page_view').html(page_view_html);
    <?php } else { ?>
    $('#page_view').html(runder_page_view());
    <?php } ?>

    //模块列表
    <?php if(!empty($output['module_list']) && is_array($output['module_list'])) {?>
    var module_list = $.parseJSON('<?php echo json_encode($output['module_list']);?>');
    var module_list_standard_html = '';
    var module_list_custom_html = '';
    $.each(module_list, function(index, module_item) {
        if(module_item.module_class == 2) {
            module_list_custom_html += template.render('module_list_template', module_item);
        } else {
            module_list_standard_html += template.render('module_list_template', module_item);
        }
    });
    $('#template_module_list_standard').html(module_list_standard_html);
    $('#template_module_list_custom').html(module_list_custom_html);
    <?php } ?>

	//自定义滚定条
    var screen_height = $(window).height() - 148;
    $('#page_view_content').css('height', screen_height);
	$('#page_view_content').perfectScrollbar();
    $('#template_module_list_content').css('height', screen_height);
	$('#template_module_list_content').perfectScrollbar();

    function runder_page_view(page_module) {
        if(page_module) {
            if(parseInt(page_module.module_state, 10) === 1) {
                page_module.module_state_css = 'module-state-show';
                page_module.module_state_operate = 'btn_hide_page_module';
                page_module.module_state_operate_text = '关闭';
            } else {
                page_module.module_state_css = 'module-state-hide';
                page_module.module_state_operate = 'btn_show_page_module';
                page_module.module_state_operate_text = '启用';
            }
            if(parseInt(page_module.module_view, 10) === 1) {
                page_module.module_css = '';
                page_module.module_view_text = '折叠';
            } else {
                page_module.module_css = 'page-module-mini';
                page_module.module_view_text = '展开';
            }
            return template.render('page_view_template', page_module);
        } else {
            return template.render('page_view_null', {});
        }
    }

    $('#template_module_list').on('click', '[nctype="btn_add_page_module"]', function() {
        var $btn_add = $(this);
        var page_module = {};
        page_module.module_title = $btn_add.attr('data-module-title');
        page_module.module_name = $btn_add.attr('data-module-name');
        page_module.module_type = $btn_add.attr('data-module-type');
        $.post("index.php?act=cms_index&op=add_page_module", { module_title: page_module.module_title, module_name: page_module.module_name, module_type: page_module.module_type }, function(data) {
            if(data.result) {
                page_module.module_state = 1;
                page_module.module_id = data.module_id;
                page_module.module_style = data.module_style;
                page_module.module_view = data.module_view;
                $("#page_view").find('.page-module-null').remove();
                var new_page_module = runder_page_view(page_module);
                $(new_page_module).appendTo("#page_view").hide().fadeIn('slow');

                $('.page-module').last().find('span[nc_type="module_title"]').inline_edit_confirm({act: 'cms_index', op:'update_page_module_title'});
                $('#page_view_content').scrollTop($('#page_view').height());
            } else {
                showError(data.message);
            }
        },'json')
    });

    //模块删除按钮样式
    $('#template_module_list').on(
    {
        mouseenter: function() {
            $(this).parent('div').addClass('template-module-drop');
        },
        mouseleave: function() {
            $(this).parent('div').removeClass('template-module-drop');
        }
    }, '[nctype="btn_drop_module"]');

    //模块删除
    $('#template_module_list').on('click', '[nctype="btn_drop_module"]', function() {
        var $btn_drop = $(this);
        if(confirm('确认删除?')) {
            var module_id = $(this).attr('data-module-id');
            $.post("index.php?act=cms_index&op=drop_module", { module_id: module_id }, function(data) {
                if(data.result) {
                    $btn_drop.parent('div').remove();
                    $('#page_view_content').find('[data-module-name="' + data.module_name + '"]').remove();
                    if($("#page_view").children().length <= 0) {
                        $('#page_view').html(runder_page_view());
                    }
                } else {
                    showError(data.message);
                }
            }, 'json');
        }
    });

    //启用页面模块
    $('#page_view').on('click', "[nctype='btn_show_page_module']", function() {
        var $btn = $(this);
        var module_id = $btn.attr('data-module-id');
        $.post("index.php?act=cms_index&op=update_page_module_show", { module_id: module_id }, function(data) {
            if(data.result) {
                var $page_module = $btn.parents('.page-module');
                $page_module.removeClass('module-state-hide');
                $page_module.addClass('module-state-show');
                $btn.attr('nctype', 'btn_hide_page_module');
                $btn.text('关闭');
            } else {
                showError(data.message);
            }
        },'json')
    });

    //启用页面模块
    $('#page_view').on('click', "[nctype='btn_hide_page_module']", function() {
        var $btn = $(this);
        var module_id = $btn.attr('data-module-id');
        $.post("index.php?act=cms_index&op=update_page_module_hide", { module_id: module_id }, function(data) {
            if(data.result) {
                var $page_module = $btn.parents('.page-module');
                $page_module.removeClass('module-state-show');
                $page_module.addClass('module-state-hide');
                $btn.attr('nctype', 'btn_show_page_module');
                $btn.text('启用');
            } else {
                showError(data.message);
            }
        },'json')
    });

    //删除页面模块
    $('#page_view').on('click', "[nctype='btn_drop_page_module']", function() {
        if(confirm('确认删除')) {
            var $btn_drop = $(this);
            var module_id = $btn_drop.attr('data-module-id');
            $.post("index.php?act=cms_index&op=drop_page_module", { module_id: module_id }, function(data) {
                if(data.result) {
                    var $page_module = $btn_drop.parents('.page-module');
                    $page_module.fadeOut('slow', function() {
                        $page_module.remove();
                        if($("#page_view").children().length <= 0) {
                            $('#page_view').html(runder_page_view());
                        }
                    });
                } else {
                    showError(data.message);
                }
            }, 'json')
        }
    });

    //模块拖拽排序
    $("#page_view").sortable({ 
        update: function(event, ui) {
            var page_module_id_string = '';
            $page_module_list = $('#page_view').find('.page-module');
            $page_module_list.each(function(index, page_module) {
                page_module_id_string += $(page_module).attr('data-module-id') + ',';
            });
            $.post("index.php?act=cms_index&op=update_page_module_index", {page_module_id_string: page_module_id_string}, function(data) {
                if(!data.result) {
                    showError(data.message);
                }
            }, 'json');
        }
    });

    $('span[nc_type="module_title"]').inline_edit_confirm({act: 'cms_index', op:'update_page_module_title'});

    //生成首页
    $("#btn_index_build").click(function() {
        $.getJSON('index.php?act=cms_index&op=cms_index_build', function(data) {
            if(data.result) {
                showSucc(data.message);
            } else {
                showError(data.message);
            }
        });
    });

    $('#btn_add_module').click(function() {
        $module_frame_list = $('#module_frame_list');
        $module_assembly_list = $('#module_assembly_list');
        if($module_frame_list.html() === '') {
            $.getJSON('index.php?act=cms_index&op=get_module_frame_list', function(data) {
                if(data.frame_list) {
                    var template_data = {};
                    template_data.list = data.frame_list;
                    $module_frame_list.html(template.render('module_frame_list_template', template_data));
                }
                if(data.assembly_list) {
                    var template_data = {};
                    template_data.list = data.assembly_list;
                    $module_assembly_list.html(template.render('module_assembly_list_template', template_data));
                }
            });
        }
        $('#module_frame_edit').hide();
        $('#module_frame_list').fadeIn();
        $('#dialog_add_module').nc_show_dialog({
            width: 640,
            title: '添加自定义模块'
        });
    });

    $('#module_frame_list').on('click', '[nctype="btn_select_module_frame"]', function() {
        var frame_structure = $.parseJSON($(this).attr('data-frame-structure'));
        var data = {};
        data.list = frame_structure;
        $('#module_frame').html(template.render('module_frame_template', data));
        $('#input_frame_name').val($(this).attr('data-frame-name'));
        $('#module_frame_list').hide();
        $('#module_frame_edit').fadeIn();
    });

    $('#btn_show_module_frame_list').on('click', function() {
        $('#module_frame_edit').hide();
        $('#module_frame_list').fadeIn();
    });

    $current_module_frame = null;
    $('#module_frame').on('click', '[nctype="btn_select_module_frame_block"]', function() {
        $('[nctype="btn_select_module_frame_block"]').removeClass('module-frame-current').addClass('module-frame-normal');
        $(this).addClass('module-frame-current').removeClass('module-frame-normal');
        $current_module_frame = $(this);
    });

    $('#module_assembly_list').on('click', '[nctype="btn_select_module_assembly"]', function() {
        if($current_module_frame) {
            var assembly_name = $(this).attr('data-assembly-name');
            $current_module_frame.html('<span class="module-assembly-' + assembly_name + '"></span>');
            $current_module_frame.removeClass('module-frame-current');
            $current_module_frame.addClass('module-frame-normal');
            $current_module_frame.attr('data-module-assembly', assembly_name);
            $current_module_frame = null;
        } else {
            showError('请选择框架位置');
        }
    });

    $('#module_frame').on('click', '#btn_toggle_module_display_title', function() {
        var current = $(this).attr('data-module-title-state');
        var $div_title = $(this).parent('.cms-module-frame-title');
        if(current === 'enable') {
            $(this).attr('data-module-title-state', 'disable');
            $div_title.find('span').text('隐藏标题');
            $div_title.removeClass('module-title-enable');
            $div_title.addClass('module-title-disable');
        } else {
            $(this).attr('data-module-title-state', 'enable');
            $div_title.find('span').text('显示标题');
            $div_title.removeClass('module-title-disable');
            $div_title.addClass('module-title-enable');
        }
    });

    $('#btn_save_module').click(function() {
        var frame_name = $('#input_frame_name').val();
        var module_title = $('#input_module_title').val();
        var module_display_title_state = $('#btn_toggle_module_display_title').attr('data-module-title-state');
        var frame_block = {};
        $('[nctype="btn_select_module_frame_block"]').each(function(index, item) {
            frame_block[$(item).attr('data-block-name')] = $(item).attr('data-module-assembly');
        });
        $.post("index.php?act=cms_index&op=save_module", {module_title: module_title, frame_name: frame_name, frame_block: frame_block, module_display_title_state: module_display_title_state}, function(data) {
            if(data.result) {
                var new_module = template.render('module_list_template', data.module_item);
                $(new_module).appendTo("#template_module_list_custom").hide().fadeIn('slow');
                $('#template_module_list_content').scrollTop($('.template-module-list').height());
            } else {
                showError(data.message);
            }
        }, 'json');
        $('#dialog_add_module').hide();
    });

    //主题选择
    $('#page_view').on('click', "[nctype='btn_module_style_change']", function() {
        $(this).parents('.handle').find('.module-style-change').show();
    });

    //取消主题选择
    $('#page_view').on('click', "[nctype='btn_module_style_change_cancel']", function() {
        $(this).parents('.module-style-change').hide();
    });

    //主题修改
    $('#page_view').on('click', "[nctype='btn_module_style_select']", function() {
        var $btn = $(this);
        var module_id = $btn.attr('data-module-id'); 
        var module_style = $btn.attr('data-module-style'); 
        $.post("index.php?act=cms_index&op=update_page_module_style", {module_id: module_id, module_style: module_style}, function(data) {
            if(data.result) {
                var $page_module = $btn.parents('.page-module');
                $page_module[0].className = $page_module[0].className.replace(/\module-style-style\d/g, '');
                $page_module.addClass('module-style-' + module_style);
                $btn.parents('.module-style-change').hide();
            } else {
                showError(data.message);
            }
        }, 'json');

    });

    //后台显示样式修改
    $('#page_view').on('click', "[nctype='btn_module_view_change']", function() {
        var $btn = $(this);
        var module_id = $btn.attr('data-module-id'); 
        var $page_module = $btn.parents('.page-module');
        var module_view;
        if($page_module.hasClass('page-module-mini')) {
            $page_module.removeClass('page-module-mini');
            module_view = 1;
            $btn.attr('title', '折叠');
        } else {
            $page_module.addClass('page-module-mini');
            module_view = 2;
            $btn.attr('title', '展开');
        }
        $.post("index.php?act=cms_index&op=update_page_module_view", {module_id: module_id, module_view: module_view}, function(data) {
            if(!data.result) {
                showError(data.message);
            }
        }, 'json');
    });

    //显示标准模块
    $('#btn_show_module_standard').click(function() {
        $(this).addClass('current');
        $('#btn_show_module_custom').removeClass('current');
        $('#template_module_list_standard').show();
        $('#template_module_list_custom_content').hide();
    });
 
    //显示自定义模块
    $('#btn_show_module_custom').click(function() {
        $(this).addClass('current');
        $('#btn_show_module_standard').removeClass('current');
        $('#template_module_list_standard').hide();
        $('#template_module_list_custom_content').show();
    });
});
</script>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_cms_index_manage'];?></h3>
      <ul class="tab-base">
        <?php foreach($output['menu'] as $menu) { if($menu['menu_type'] == 'text') { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
      </div>
  </div>
  <div class="fixed-empty"></div>
  <div class="cms-edit-bg-line">
  <div style=" background-color: #FFF; padding: 0 0 8px 0; margin-bottom: 12px; border-bottom: solid 1px #BCE6F8">
  <a class="btn" href="index.php?act=cms_index&op=cms_index_preview" target="_blank"><span>预览</span></a> 
  <a class="btn" id="btn_index_build" href="Javascript: void(0)"><span><?php echo $lang['cms_index_build'];?></span></a> 
  <a class="btn" href="<?php echo CMS_SITE_URL;?>" target="_blank"><span><?php echo $lang['cms_index_go'];?></span></a></div>
 
  <div id="page_view_content" class="page-view-content">
      <div id="page_view" class="page-view"></div>
  </div>
  <div class="module_panel">
      <a id="btn_show_module_standard" class="current" href="JavaScript:;">标准模块</a>
      <a id="btn_show_module_custom" class="" href="JavaScript:;">自定义模块</a>
  </div>
  <div id="template_module_list_content" class="template-module-list-content">
      <div class="template-module-list">
          <div id="template_module_list">
              <div id="template_module_list_standard"></div>
              <div id="template_module_list_custom_content" style="display:none;">
                  <div id="template_module_list_custom"></div>
                  <a id="btn_add_module" class="btn-add-module" href="JavaScript:;"><i></i>添加自定义模块</a>
              </div>
          </div>
      </div>
      <div class="clear"></div>
  </div>
</div>
</div>
<div id="dialog_add_module" style="display:none;">
    <div id="module_frame_list" class="module-frame-list"></div>
    <div class="clear"></div>
    <div id="module_frame_edit" style="display:none;">
        <div id="module_frame" class="module-frame-content"></div>
        <div id="module_assembly_list" class="module-assembly-list"></div>
        <form id="from_new_module" class="module-frame-btns">
            <input id="input_frame_name" type="hidden" />
            <a id="btn_show_module_frame_list" href="JavaScript:;" class="btn"><span>重新选择框架</span></a>
            <a id="btn_save_module" href="JavaScript:;" class="btn"><span>保存</span></a>
        </form>
        <div class="clear"></div>
    </div>
</div>
<!-- 页面模块模板 -->
<script id="page_view_template" type="text/html">
<div id="page_module_<%=module_id%>" data-module-id="<%=module_id%>" data-module-name="<%=module_name%>" class="page-module <%=module_css%> <%=module_state_css%> module-css-<%=module_type%> module-style-<%=module_style%>">
    <div class="title">
    <span nc_type="module_title" column_id="<%=module_id%>" title="<?php echo $lang['nc_editable'];?>"><i></i><%=module_title%></span>
    </div>
    <div class="handle">
    <div class="module-style-change" style="display:none;">
    <ul>
        <li nctype="btn_module_style_select" data-module-id="<%=module_id%>" data-module-style="style1" class="style1">style1</li>
        <li nctype="btn_module_style_select" data-module-id="<%=module_id%>" data-module-style="style2" class="style2">style2</li>
        <li nctype="btn_module_style_select" data-module-id="<%=module_id%>" data-module-style="style3" class="style3">style3</li>
        <li nctype="btn_module_style_select" data-module-id="<%=module_id%>" data-module-style="style4" class="style4">style4</li>
        <li nctype="btn_module_style_select" data-module-id="<%=module_id%>" data-module-style="style5" class="style5">style5</li>
        <li nctype="btn_module_style_select" data-module-id="<%=module_id%>" data-module-style="style6" class="style6">style6</li>
        <li nctype="btn_module_style_select" data-module-id="<%=module_id%>" data-module-style="style7" class="style7">style7</li>
        <li nctype="btn_module_style_select" data-module-id="<%=module_id%>" data-module-style="style8" class="style8">style8</li>
    </ul>
    <a nctype="btn_module_style_change_cancel" href="JavaScript:;" class="cancel" title="取消">取消</a>
    </div>
    <a nctype="btn_module_style_change" href="JavaScript:;" class="style" title="主题">主题</a>
    <a href="index.php?act=cms_index&op=module_edit&module_id=<%=module_id%>" class="edit" title="<?php echo $lang['nc_edit'];?>"></a>
        <a nctype="<%=module_state_operate%>" data-module-id="<%=module_id%>" class="onoff" href="JavaScript:;" title="<%=module_state_operate_text%>"></a>
        <a nctype="btn_drop_page_module" data-module-id="<%=module_id%>" class="del" href="JavaScript:;" title="删除"></a>
        <a nctype="btn_module_view_change" data-module-id="<%=module_id%>" class="move" href="JavaScript:;" title="<%=module_view_text%>"></a>
    </div>
</div>
</script>
<script id="page_view_null" type="text/html">
<div class="page-module-null">页面没有添加模块</div>
</script>
<!-- 模块模板 -->
<script id="module_list_template" type="text/html">
<div class="template-module module-css-<%=module_type%>" >
    <span><%=module_title%></span>
  <a nctype="btn_add_page_module" class="add" data-module-title="<%=module_title%>" data-module-name="<%=module_name%>" data-module-type="<%=module_type%>" href="JavaScript:;">添加</a>
  <%if(module_class == 2) {%>
  <a nctype="btn_drop_module" class="delete" data-module-id="<%=module_id%>" href="JavaScript:;">删除</a>
  <%}%>
</div>
</script>
<!-- 模块框架列表模板 -->
<script id="module_frame_list_template" type="text/html">
<%for(i = 0; i < list.length; i ++) {%>
    <div nctype="btn_select_module_frame" data-frame-name="<%=list[i].frame_name%>" href="JavaScript:;" data-frame-structure='<%=list[i].frame_structure%>' class="module-frame frame-css-<%=list[i].frame_name%>" >
    <%=list[i].frame_title%>
</div>
<%}%>
</script>
<!-- 模块框架模板 -->
<script id="module_frame_template" type="text/html">
<div class="cms-module-frame">
    <div class="cms-module-name"><input id="input_module_title" type="text" value="自定义模块" /></div>
    <div class="cms-module-frame-title module-title-enable">
    <span>隐藏标题</span>
    <a id="btn_toggle_module_display_title" data-module-title-state="enable" href="Javascript:;"></a>
    </div>
    <%for(var block in list) {%>
    <%if(!list[block].child) {%>
    <div nctype="btn_select_module_frame_block" data-block-name="<%=block%>" class="cms-module-frame-<%=list[block].name%> module-frame-normal"></div>
    <%} else {%>
    <div class="cms-module-frame-<%=list[block].name%>">
        <%for(var block_child in list[block].child) {%>
        <div nctype="btn_select_module_frame_block" data-block-name="<%=block_child%>" class="cms-module-frame-<%=list[block].child[block_child].name%> module-frame-normal"></div>
        <%}%>
    </div>
    <%}%>
    <%}%>
    <div class="clear"></div>
</div>
</script>
<!-- 模块组件模板 -->
<script id="module_assembly_list_template" type="text/html">
<%for(i = 0; i < list.length; i ++) {%>
    <div nctype="btn_select_module_assembly" data-assembly-name="<%=list[i].assembly_name%>" class="module-assembly assembly-css-<%=list[i].assembly_name%>" >
    <i></i>
    <%=list[i].assembly_title%>
</div>
<%}%>
</script>
