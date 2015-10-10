/*
 * 弹出窗口
 */
(function($) {
    $.fn.show_dialog = function(options) {

        var that = $(this);
        var settings = $.extend({}, {width: 480, title: ''}, options);

        var init_dialog = function(title) {
            var _div = that;
            that.addClass("dialog_wrapper");
            that.wrapInner(function(){
                return '<div class="dialog_content">';
            });
            that.wrapInner(function(){
                return '<div class="dialog_body" style="position: relative;">';
            });
            that.find('.dialog_body').prepend('<h3 class="dialog_head" style="cursor: move;"><span class="dialog_title"><span class="dialog_title_icon">'+settings.title+'</span></span><span class="dialog_close_button">X</span></h3>');
            that.append('<div style="clear:both;"></div>');

            $(".dialog_close_button").click(function(){
                _div.hide();
            });

            that.draggable();
        };

        if(!$(this).hasClass("dialog_wrapper")) {
            init_dialog(settings.title);
        }
        settings.left = $(window).scrollLeft() + ($(window).width() - settings.width) / 2;
        settings.top  = $(window).scrollTop()  + ($(window).height() - $(this).height()) / 2;
        $(this).attr("style","display:none; z-index: 1100; position: absolute; width: "+settings.width+"px; left: "+settings.left+"px; top: "+settings.top+"px;");
        $(this).show();

    };
})(jQuery);

/*
 * 文字计数
 */
(function($) {
    $.fn.nc_text_count = function(options,submit_function) {
        var settings = $.extend({}, {max: 140}, options);
        return this.each(function() {
            $(this).after('<span nc_type="commend_count"></div>');
            var message_item = $(this).next("[nc_type='commend_count']");
            message_item.html($(this).val().length + '/' + settings.max);
            $(this).keyup({message_item:message_item}, commend_message_count);
            $(this).focusout({message_item:message_item}, commend_message_count);
        });

        function commend_message_count(event) {
            message_item = event.data.message_item;
            var message_count = $(this).val().length;
            if(message_count <= settings.max) {
                if((settings.max - message_count) > 10) {
                    message_item.attr("class", "counter");
                    message_item.html(message_count+"/"+settings.max);
                } else {
                    message_item.attr("class", "counter warning");
                    message_item.html(message_count+"/"+settings.max);
                }
            } else {
                var over_count = message_count - settings.max;
                message_item.attr("class", "counter exceeded");
                message_item.html("已超出"+parseInt(over_count, 10)+"个字");
            }
        }

    };
})(jQuery);

/*
 * 计数加减
 */
(function($) {
    $.fn.nc_count = function(options) {
        var settings = $.extend({}, { type:'+',step:1}, options);
        var old_count = parseInt($(this).text(), 10);
        if(isNaN(old_count)) {
            old_count = 0;
        }
        if(old_count >= 999) {
            $(this).html('999+');
        } else {
            var new_count = old_count;
            if(settings.type == '-') {
                new_count = old_count - settings.step;
            } else {
                new_count = old_count + settings.step;
            }
            if(new_count < 0) {
                new_count = 0;
            }
            $(this).text(new_count);
        }
        return this;
    };
})(jQuery);


/*
 * 图片延迟加载
 */
(function($) {
    $.fn.nc_lazyload_init = function() {
        this.each(function() {
            $(this).after($(this).val().replace(/src=/gi, 'data-src='));
        }).remove();
    };
})(jQuery);
/*
 * 图片延迟加载
 */
(function($) {
    $.fn.nc_lazyload = function() {
        var lazy_items = [];
        this.each(function() {
            if($(this).attr("data-src") !== undefined){
                var lazy_item = {
                    object: $(this),
                    url: $(this).attr("data-src")
                };
                lazy_items.push(lazy_item);
            }
        });

        var load_img = function() {
            var window_height = $(window).height();
            var scroll_top = $(window).scrollTop();

            $.each(lazy_items, function(i, lazy_item) {
                if(lazy_item.object) {
                    item_top = lazy_item.object.offset().top - scroll_top;
                    if(item_top >= 0 && item_top < window_height) {
                        if(lazy_item.url) {
                            lazy_item.object.attr("src",lazy_item.url);
                        }
                        lazy_item.object = null;
                    }
                }
            });
        };
        load_img();
        $(window).bind("scroll", load_img);
    };
})(jQuery);

/*
 * jQuery相册扩展
 */
;(function($) {
    $.fn.nc_gallery = function(options) {

        var defaults = {
            show_item_count: 1,
            btn_previous_page: '',
            btn_next_page: '',
            btn_previous_image: '',
            btn_next_image: '',
            animate: 100,
            start_item_count: 0,
            disable_css_class_name: 'disable',
            current_css_class_name: 'current',
            image_lazy_load: false,
            current_item_change_callback: function() {}
        };

        var settings = $.extend({}, defaults, options);

        function gallery($gallery) {

            var $items = $gallery.children();
            var items_length = $items.length;
            var current_item_count = 0;
            var max_item_count = items_length - 1;
            var min_item_count = 0;
            var item_change_step = 1;
            var current_page_start_count = 0;
            var max_page_start_count = items_length - settings.show_item_count;
            var min_page_start_count = 0; 
            var $btn_previous_page = $(settings.btn_previous_page);
            var $btn_next_page = $(settings.btn_next_page);
            var $btn_previous_image = $(settings.btn_previous_image);
            var $btn_next_image = $(settings.btn_next_image);

            var page_enable = true;
            if(settings.show_item_count > items_length) {
                settings.show_item_count = items_length;
                page_enable = false;
                $btn_previous_page.addClass(settings.disable_css_class_name);
                $btn_next_page.addClass(settings.disable_css_class_name);
                image_lazy_load(0, items_length);

                if(items_length <= 1) {
                    $btn_previous_image.addClass(settings.disable_css_class_name);
                    $btn_next_image.addClass(settings.disable_css_class_name);
                }
            }

            $gallery.wrap('<div style="width: ' + settings.width * settings.show_item_count + 'px; overflow: hidden;"></div>');
            $gallery.attr("style", 'width:' + items_length * settings.width +'px;');
            $items.attr("style", 'float: left;');

            change_current_item(settings.start_item_count);

            $items.each(function(i, item) {
                $(item).click(function() {
                    change_current_item(i);
                });
            });

            $btn_previous_page.click(function() {
                change_page_start(current_page_start_count - settings.show_item_count);
            });

            $btn_next_page.click(function() {
                change_page_start(current_page_start_count + settings.show_item_count);
            });

            $btn_previous_image.click(function() {
                change_current_item(current_item_count - item_change_step);
            });

            $btn_next_image.click(function() {
                change_current_item(current_item_count + item_change_step);
            });

            function change_page_start(page_start_count) {
                if(!page_enable) {
                    return false;
                }
                $btn_previous_page.removeClass(settings.disable_css_class_name);
                $btn_next_page.removeClass(settings.disable_css_class_name);
                if(page_start_count <= min_page_start_count) {
                    page_start_count = min_page_start_count;
                    $btn_previous_page.addClass(settings.disable_css_class_name);
                }
                if(page_start_count >= max_page_start_count) {
                    page_start_count = max_page_start_count;
                    $btn_next_page.addClass(settings.disable_css_class_name);
                }

                if(settings.image_lazy_load) {
                    image_lazy_load(page_start_count, settings.show_item_count);
                }

                current_page_start_count = page_start_count;

                var margin_left = - page_start_count * settings.width;
                $gallery.animate({
                    marginLeft: margin_left 
                }, settings.animate);
            }

            function change_current_item(next_item_count) {
                $btn_previous_image.removeClass(settings.disable_css_class_name);
                $btn_next_image.removeClass(settings.disable_css_class_name);
                if(next_item_count <= min_item_count) {
                    next_item_count = min_item_count;
                    $btn_previous_image.addClass(settings.disable_css_class_name);
                }
                if(next_item_count >= max_item_count) {
                    next_item_count = max_item_count;
                    $btn_next_image.addClass(settings.disable_css_class_name);
                }

                var $current_item = $($items.get(next_item_count));

                $items.removeClass(settings.current_css_class_name);
                $current_item.addClass(settings.current_css_class_name);

                change_page_start(next_item_count - Math.floor(settings.show_item_count / 2));
                current_item_count = next_item_count;

                settings.current_item_change_callback(current_item_count, $current_item);
            }

            function image_lazy_load(start, count) {
                for(var i = 0; i < count; i++) {
                    var $current_img = $($items.get(start + i)).find('img');
                    $current_img.attr('src', $current_img.attr('data-src'));
                }
            }
        }

        return this.each(function() {
            gallery($(this));
        });

    };
})(jQuery);

