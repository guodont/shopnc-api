 $(document).ready(function(){
 //图片上传
    $("#article_image_upload").fileupload({
        dataType: 'json',
            url: "index.php?act=publish&op=article_image_upload",
            add: function(e,data) {
                $.each(data.files, function (index, file) {
                    var image_content = '<li id=' + file.name.replace(/\./g, '_') + '>';
					image_content += '<div class="picture">';
					image_content += '<a href="Javascript:void(0);">';
                    image_content += '<img src="'+ LOADING_IMAGE +'" alt="" />';
					image_content += '</a></div>';
					image_content += '<div class="handle">';
					image_content += '<span class="upload-state">正在上传：' + file.name + '</span>';
					image_content += '</div>';
                    image_content += '</li>';
                    $("#article_image_list").append(image_content);
                });
                data.submit();
            },
            done: function (e,data) {
                result = data.result;
                var $image_box = $('#' + result.origin_file_name.replace(/\./g, '_'));
                if(result.status == "success") {
                    $image_box.find('img').attr('src', result.file_url);

                    var $image_handle = $image_box.find('.handle');

					var image_handle = '<a nctype="btn_insert_article_image">插入</a>';
                    image_handle += '<a nctype="btn_set_article_image" image_name="'+result.file_name+'">封面</a>';
                    image_handle += '<a nctype="btn_drop_article_image" image_name="'+result.file_name+'">删除</a>';
                    $image_handle.html(image_handle);

                    var image_hidden = '<input name="article_image_all[]" type="hidden" value="'+result.file_name + ',' + result.file_path +'" />';
                    $image_handle.after(image_hidden);

                    $image_box.attr('id', '');
                } else {
                    $image_box.remove();
                    showError(result.error);
                }
            }
    });

    //图片列表上移
    $("#btn_image_list_up").click(function(){
        var position = $("#article_image_list").position();
        var list_height = $("#article_image_list").height();
        if((list_height + position.top) > 447) {
            var newtop = position.top - 121;
            $("#article_image_list").css("top", newtop);
        }
    });

    //图片列表下移
    $("#btn_image_list_down").click(function(){
        var position = $("#article_image_list").position();
        if(position.top < 0) {
            var newtop = position.top + 103;
            $("#article_image_list").css("top", newtop);
        }
    });

    //设封面图
    $("[nctype='btn_set_article_image']").live("click",function(){
        var article_image = $("<div />").append($(this).parent().parent().find("img").clone()).html();
        $("#div_article_image").html(article_image);
        $("#article_image").val($(this).attr("image_name"));
    });

    //插入编辑器
    $("[nctype='btn_insert_article_image']").live("click",function(){
        var html = KE.html();
        html += "<p>"+$("<div />").append($(this).parent().parent().find("img").clone()).html()+"</p>"; 
        KE.html(html);
    });

    //图片删除
    $("[nctype='btn_drop_article_image']").live("click",function(){
        var image_object = $(this).parent().parent();
        var image_name = $(this).attr("image_name");
        $.getJSON("index.php?act=publish&op=article_image_drop", { image_name: image_name }, function(result){
            if(result.status == "success") {
                image_object.remove();
            } else {
                showError(result.error);
            }
        });
    });

    //标签操作
    $("[nctype='cms_tag']").live("click",function(){
        var current_css = $(this).attr("class");
        if(current_css == "btn-cms-tag") {
            $(this).attr("class","btn-cms-tag-selected");
        } else {
            $(this).attr("class","btn-cms-tag");
        }
        var cms_tag_selected = '';
        $(".btn-cms-tag-selected").each(function(){
            cms_tag_selected += $(this).attr("tag_id") + ",";
        });
        $("#article_tag").val(cms_tag_selected.substring(0, cms_tag_selected.length-1));
    });

    //添加商品按钮文字
    $("[name='goods_search_type']").click(function(){
        var search_type = $("[name='goods_search_type']:checked").val();
        if(search_type == 'goods_url') {
            $("#btn_goods_search").val("添加");
        } else {
            $("#btn_goods_search").val("搜索");
        }
    });

    //商品搜索
    $("#btn_goods_search").click(function(){
        if($("#article_goods_list li").length < 3) { 
            var search_type = $("[name='goods_search_type']:checked").val();
            var search_keyword = $("#goods_search_keyword").val();
            $("#goods_search_keyword").val("");
            if(search_keyword != "") {
                if(search_type == "goods_url") {
                    var url = encodeURIComponent(search_keyword);
                    $.getJSON("index.php?act=api&op=goods_info_by_url", { url: url}, function(data){
                        if(data.result == "true") {
                            var temp = '<li nctype="btn_goods_select"><dl>'; 
                            temp += '<dt class="name"><a href="'+data.url+'" target="_blank">'+data.title+'</a></dt>';
                            temp += '<dd class="image"><img title="'+data.title+'" src="'+data.image+'" /></dd>';
                            temp += '<dd class="price">价格：<em>'+data.price+'</em></dd>';
                            temp += '</dl><i>选择删除相关商品</i>';
                            temp += '<input name="article_goods_url[]" value="'+data.url+'" type="hidden" />';
                            temp += '<input name="article_goods_title[]" value="'+data.title+'" type="hidden" />';
                            temp += '<input name="article_goods_image[]" value="'+data.image+'" type="hidden" />';
                            temp += '<input name="article_goods_price[]" value="'+data.price+'" type="hidden" />';
                            temp += '<input name="article_goods_type[]" value="'+data.type+'" type="hidden" />';
                            temp += '</li>';
                            $("#article_goods_list").append(temp);
                        } else {
                            alert(data.message);
                        }
                    });
                } else {
                    $("#div_goods_select").load("index.php?act=api&op=goods_list&search_type="+search_type+"&search_keyword="+search_keyword);
                }
            }
        }
    });

    //商品选择翻页
    $("#div_goods_select .demo").live('click',function(e){
        $("#div_goods_select").load($(this).attr('href'));
        return false;
    });

    //商品添加
    $("#goods_search_list [nctype='btn_goods_select']").live("click",function(){
        if($("#article_goods_list li").length < 3) { 
            var temp = '<li nctype="btn_goods_select">'+$(this).html();
            temp += '<input name="article_goods_url[]" value="'+$(this).attr("goods_url")+'" type="hidden" />';
            temp += '<input name="article_goods_title[]" value="'+$(this).attr("goods_title")+'" type="hidden" />';
            temp += '<input name="article_goods_image[]" value="'+$(this).attr("goods_image")+'" type="hidden" />';
            temp += '<input name="article_goods_price[]" value="'+$(this).attr("goods_price")+'" type="hidden" />';
            temp += '<input name="article_goods_type[]" value="'+$(this).attr("goods_type")+'" type="hidden" />';
            temp += '</li>';
            $("#article_goods_list").append(temp);
        }
    });

    //商品删除
    $("#article_goods_list [nctype='btn_goods_select']").live("click",function(){
        $(this).remove();
    });

    //文章搜索
    $("#btn_article_search").click(function(){
        var search_type = $("[name='article_search_type']:checked").val();
        var search_keyword = $("#article_search_keyword").val();
        if(search_keyword != "") {
            $("#div_article_select").load("index.php?act=api&op=article_list&search_type="+search_type+"&search_keyword="+search_keyword);
        }
    });

    //文章选择翻页
    $("#div_article_select .demo").live('click',function(e){
        $("#div_article_select").load($(this).attr('href'));
        return false;
    });

    //文章添加
    $("#article_search_list [nctype='btn_article_select']").live("click",function(){
        var temp = $("<div />").append($(this).clone()).html();
        $("#article_link_list").append(temp);
        $("#article_link_list").last("li").find("i").text("选择删除相关文章");
        refresh_article_link();
    });

    //文章删除
    $("#article_link_list [nctype='btn_article_select']").live("click",function(){
        $(this).remove();
        refresh_article_link();
    });

    function refresh_article_link() {
        var cms_article_selected = '';
        $("#article_link_list [nctype='btn_article_select']").each(function(){
            cms_article_selected += $(this).attr("article_id") + ",";
        });
        $("#article_link").val(cms_article_selected.substring(0, cms_article_selected.length-1));
    } 


});
