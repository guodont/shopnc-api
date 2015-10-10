/*
 * 微商城弹出窗口
 */
(function($) {
    $.fn.microshop_form = function(options) {
        var settings = $.extend({}, {title: ''}, options);
        var _div = $(this);
        $(this).addClass("dialog_wrapper");
        $(this).wrapInner(function(){
            return '<div class="dialog_content" style="background: #FFFFFF;margin: 0px; padding: 0px;">';
        });
        $(this).wrapInner(function(){
            return '<div class="dialog_body" style="position: relative;">';
        });
        $(this).find('.dialog_body').prepend('<h3 class="dialog_head" style="cursor: move;"><span class="dialog_title"><span class="dialog_title_icon">'+settings.title+'</span></span><span class="dialog_close_button" style="position: absolute; cursor: pointer;">X</span></h3>');
        $(this).append('<div style="clear:both;"></div>');

        $(".dialog_close_button").click(function(){
            _div.hide();
        });
    }
})(jQuery);

(function($) {
    $.fn.microshop_form_show = function(options) {
        var settings = $.extend({}, {width: 480}, options);
        settings.left = $(window).scrollLeft() + ($(window).width() - settings.width) / 2;
        settings.top  = $(window).scrollTop()  + ($(window).height() - $(this).height()) / 2;
        $(this).attr("style","display:none; z-index: 1100; position: absolute; width: "+settings.width+"px; left: "+settings.left+"px; top: "+settings.top+"px;");
        $(this).show();
    }
})(jQuery);


/*
 * 微商城消息发布
 */
(function($) {
    $.fn.microshop_publish = function(options,submit_function) {
        var settings = $.extend({}, {max: 140,button_item:'#btn_publish_comment',allow_null:'false'}, options);
        $(this).after('<span id="_comment_count" nc_type="commend_count" class="commend_count"></div>');
        settings.message_item = $(this).next("[nc_type='commend_count']");
        var message_object = $(this);
        return this.each(function() {
            $(settings.message_item).html("0/"+settings.max);
            $(this).keyup(commend_message_count);
            $(this).focusout(commend_message_count);
            if(settings.button_item != '') {
                $(settings.button_item).click(commend_message_submit);
            }
        });

        function commend_message_count() {
            var message_count = $(message_object).val().length;
            if(message_count <= settings.max) {
                settings.message_item.css("color","");
                settings.message_item.html(message_count+"/"+settings.max);
            } else {
                var over_count = message_count - settings.max;
                settings.message_item.css("color","red");
                settings.message_item.html("已超出"+parseInt(over_count)+"个字");
            }
        }

        function commend_message_submit() {
            var message_count = $(message_object).val().length;
            if(message_count <= settings.max && (message_count > 0 || settings.allow_null == 'true')) {
                $(settings.button_item).attr("disabled","disabled");
                submit_function();
                $(message_object).val('');
                settings.message_item.html("0/"+settings.max);
                $(settings.button_item).removeAttr("disabled");
            }
        }
    }
})(jQuery);

/*
 * 微商城计数加减
 */
(function($) {
    $.fn.microshop_count = function(options) {
        var settings = $.extend({}, { type:'+',step:1}, options);
        var old_count = parseInt($(this).html());
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
            $(this).html(new_count);
        }
        return this;
    }
})(jQuery);

/*
 * 微商城喜欢
 */
(function($) {
    $.fn.microshop_like = function(options) {
        var settings = $.extend({}, { type:null,count_target:'' }, options);
        if( settings.type == null ) return false;
        return this.each(function() {
            $(this).parent().parent().append("<div class='like_tooltips' style='display:none;'></div>");
            $(this).click(submit_like);
        });
        function submit_like() {
            var item = $(this);
            $.getJSON("index.php?act=like&op=like_save", { type: settings.type, like_id: item.attr("like_id") }, function(json){
                if(json.result == "true") {
                    if(settings.count_target == '') {
                        item.find("em").microshop_count({type:"+"});
                    } else {
                        settings.count_target.microshop_count({type:"+"});
                    }
                }
                $(".like_tooltips").hide();
                var tooltips = item.parent().parent().find(".like_tooltips");
                tooltips.html(json.message).show();
                setTimeout(function(){tooltips.hide()},2000);
            });
        }
    }
})(jQuery);


/*
 * 表情处理
 */
(function($) {
    $.fn.smilies = function(options) {
        var settings = $.extend({}, {smilies_input: '#comment_message'}, options);
        settings.smilies_div = "#_smilies_div"
        $(document).click(function(){
            $(settings.smilies_div).html(''); 
            $(settings.smilies_div).hide();
        });
        $(this).after('<div id="_smilies_div" class="smilies-module"></div>');
        var smilies_array = new Array();
        var STATICURL = 'resource/js/smilies/';
        smilies_array[1] = [['1', ':smile:', 'smile.gif', '28', '28', '28','微笑'], ['2', ':sad:', 'sad.gif', '28', '28', '28','难过'], ['3', ':biggrin:', 'biggrin.gif', '28', '28', '28','呲牙'], ['4', ':cry:', 'cry.gif', '28', '28', '28','大哭'], ['5', ':huffy:', 'huffy.gif', '28', '28', '28','发怒'], ['6', ':shocked:', 'shocked.gif', '28', '28', '28','惊讶'], ['7', ':tongue:', 'tongue.gif', '28', '28', '28','调皮'], ['8', ':shy:', 'shy.gif', '28', '28', '28','害羞'], ['9', ':titter:', 'titter.gif', '28', '28', '28','偷笑'], ['10', ':sweat:', 'sweat.gif', '28', '28', '28','流汗'], ['11', ':mad:', 'mad.gif', '28', '28', '28','抓狂'], ['12', ':lol:', 'lol.gif', '28', '28', '28','阴险'], ['13', ':loveliness:', 'loveliness.gif', '28', '28', '28','可爱'], ['14', ':funk:', 'funk.gif', '28', '28', '28','惊恐'], ['15', ':curse:', 'curse.gif', '28', '28', '28','咒骂'], ['16', ':dizzy:', 'dizzy.gif', '28', '28', '28','晕'], ['17', ':shutup:', 'shutup.gif', '28', '28', '28','闭嘴'], ['18', ':sleepy:', 'sleepy.gif', '28', '28', '28','睡'], ['19', ':hug:', 'hug.gif', '28', '28', '28','拥抱'], ['20', ':victory:', 'victory.gif', '28', '28', '28','胜利'], ['21', ':sun:', 'sun.gif', '28', '28', '28','太阳'],['22', ':moon:', 'moon.gif', '28', '28', '28','月亮'], ['23', ':kiss:', 'kiss.gif', '28', '28', '28','示爱'], ['24', ':handshake:', 'handshake.gif', '28', '28', '28','握手']];
        $(settings.smilies_div).position({
            of: $("body"),
            at: "left bottom",
            offset: "10 10"
        });

        this.each(function() {
            $(this).live('click',function(){
                //光标处插入代码功能
                smiliesshowdiv(this);        
                return false;
            });
        });

        //显示和隐藏表情模块
        function smiliesshowdiv(btnobj){
            if($(settings.smilies_div).css("display")=='none'){
                if($(settings.smilies_div).html() == ''){
                    smilies_show( 8, 'e_');
                }
                $(settings.smilies_div).show();
                smiliesposition(btnobj);
            }else{
                $(settings.smilies_div).hide();
            }
        }
        //弹出层位置控制
        function smiliesposition(btnobj){
            $(settings.smilies_div).position({
                of: btnobj,
                at: "left bottom",
                offset: "105 57"
            });
        }
        function smilies_show(smcols, seditorkey) {
            if(seditorkey && !$("#"+seditorkey + 'sml_menu')[0]) {
                var div = document.createElement("div");
                div.id = seditorkey + 'sml_menu';
                div.className = 'sllt';
                $(settings.smilies_div).append(div);
                var div = document.createElement("div");
                div.id = "_smilies_content" 
                    div.style.overflow = 'hidden';
                $("#"+seditorkey + 'sml_menu').append(div);
            }
            smilies_onload(smcols, seditorkey);
            //image绑定操作函数
            $("#_smilies_content").find("td").bind('click',function(){
                insertsmilie(this);
            });
        }

        function insertsmilie(smilieone){
            var code = $(smilieone).attr('codetext');
            insertAtCaret(code);
            $(settings.smilies_input).focus();
            $(settings.smilies_div).html('');
            $(settings.smilies_div).hide();
        }

        function insertAtCaret(textFeildValue){  
            var textObj = $(settings.smilies_input).get(0);  
            if(document.all && textObj.createTextRange && textObj.caretPos){  
                var caretPos=textObj.caretPos;  
                caretPos.text = caretPos.text.charAt(caretPos.text.length-1) == '' ?  
                    textFeildValue+'' : textFeildValue;  
            }  
            else if(textObj.setSelectionRange){  
                var rangeStart=textObj.selectionStart;  
                var rangeEnd=textObj.selectionEnd;  
                var tempStr1=textObj.value.substring(0,rangeStart);  
                var tempStr2=textObj.value.substring(rangeEnd);  
                textObj.value=tempStr1+textFeildValue+tempStr2;  
                textObj.focus();  
                var len=textFeildValue.length;  
                textObj.setSelectionRange(rangeStart+len,rangeStart+len);  
                textObj.blur();  
            }  
            else {  
                textObj.value+=textFeildValue;  
            }  
        }  

        function smilies_onload(smcols, seditorkey) {
            seditorkey = !seditorkey ? '' : seditorkey;
            $("#_smilies_content").html('<div id="_smilies_content_data"></div><div class="sllt-p" id="_smilies_content_page"></div>');
            smilies_switch(smcols, seditorkey);
        }

        function smilies_switch(smcols, seditorkey) {
            var page = 1;
            if(!smilies_array || !smilies_array[page]) return;
            smiliesdata = '<table id="_smilies_content_table" cellpadding="0" cellspacing="0"><tr>';
            j = k = 0;
            img = [];
            for(i in smilies_array[page]) {
                if(j >= smcols) {
                    smiliesdata += '<tr>';
                    j = 0;
                }
                var s = smilies_array[page][i];
                smilieimg = STATICURL + 'images/' + s[2];
                img[k] = new Image();
                img[k].src = smilieimg;
                smiliesdata += s && s[0] ? '<td id="' + seditorkey + 'smilie_' + s[0] + '_td" codetext="'+s[1]+'"><img id="smilie_' + s[0] + '" width="' + s[3] +'" height="' + s[4] +'" src="' + smilieimg + '" alt="' + s[1] + '" title="'+s[6]+'" />' : '<td>';
                j++; k++;
            }
            smiliesdata += '</table>';
            $('#_smilies_content_data').html(smiliesdata);
        }

    }
})(jQuery);

/*
 * 微商城图片延迟加载
 */
(function($) {
    $.fn.microshop_lazyload = function() {
        var lazy_items = [];
        this.each(function() {
            var lazy_item = {
                object: $(this),
                url: $(this).attr("data-src")
            }
            lazy_items.push(lazy_item);
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
        }
        load_img();
        $(window).bind("scroll", load_img);
    }
})(jQuery);


