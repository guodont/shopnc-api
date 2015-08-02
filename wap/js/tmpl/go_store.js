$(function (){
    // // 图片轮播
    // function mySwipe(){
    //   // pure JS
    //   var elem = $("#mySwipe")[0];
    //   window.mySwipe = Swipe(elem, {
    //     auto: 3000,
    //     continuous: true,
    //     disableScroll: true,
    //     stopPropagation: true,
    //     callback: function(index, element) {
    //       var paginat = $(".swipe-paginat-switch");
    //       paginat.eq(index).addClass("current").siblings().removeClass("current");
    //     }
    //   });
    // }
  $("input[name=keyword]").val(escape(GetQueryString('keyword')));
  $("input[name=store_id]").val(GetQueryString('store_id'));
  
  
    $(".page-warp").click(function (){
        $(this).find(".pagew-size").toggle();
    });
  
    if($("input[name=store_id]").val()!=''){
      $.ajax({
        url:ApiUrl+"/index.php?act=store&op=goods_list&key=4&page="+pagesize+"&curpage=1"+'&store_id='+$("input[name=store_id]").val(),
        type:'get',
        dataType:'json',
        success:function(result){
          $("input[name=hasmore]").val(result.hasmore);
          if(!result.hasmore){
            $('.next-page').addClass('disabled');
          }
          
          var curpage = $("input[name=curpage]").val();//分页
          var page_total = result.page_total;
          var page_html = '';
          for(var i=1;i<=result.page_total;i++){
            if(i==curpage){
              page_html+='<option value="'+i+'" selected>'+i+'</option>';
            }else{
              page_html+='<option value="'+i+'">'+i+'</option>';
            } 
          }     
          
          $('select[name=page_list]').empty();
          $('select[name=page_list]').append(page_html);
          
          var html = template.render('home_body', result.datas);
          $("#product_list").append(html);  
        }
      });
    }else{
      $.ajax({
        url:ApiUrl+"/index.php?act=store&op=goods_list&key=4&page="+pagesize+"&curpage=1"+'&keyword='+$("input[name=keyword]").val(),
        type:'get',
        dataType:'json',
        success:function(result){
          $("input[name=hasmore]").val(result.hasmore);
          if(!result.hasmore){
            $('.next-page').addClass('disabled');
          }
          
          var curpage = $("input[name=curpage]").val();//分页
          var page_total = result.page_total;
          var page_html = '';
          for(var i=1;i<=result.page_total;i++){
            if(i==curpage){
              page_html+='<option value="'+i+'" selected>'+i+'</option>';
            }else{
              page_html+='<option value="'+i+'">'+i+'</option>';
            } 
          }     
          
          $('select[name=page_list]').empty();
          $('select[name=page_list]').append(page_html);
          
          var html = template.render('home_body', result.datas);
          $("#product_list").append(html);  
        }
      });
    }
    
    
    $("select[name=page_list]").change(function(){
    var key = parseInt($("input[name=key]").val());
    var order = parseInt($("input[name=order]").val());
    var page = parseInt($("input[name=page]").val());     
    var store_id = parseInt($("input[name=store_id]").val());
    var keyword = $("input[name=keyword]").val();
    var hasmore = $("input[name=hasmore]").val();
      
      var curpage = $('select[name=page_list]').val();
      
      if(store_id>0){
        var url = ApiUrl+"/index.php?act=store&op=goods_list&key="+key+"&order="+order+"&page="+page+"&curpage="+curpage+"&store_id="+store_id;
      }else{
        var url = ApiUrl+"/index.php?act=store&op=goods_list&key="+key+"&order="+order+"&page="+page+"&curpage="+curpage+"&keyword="+keyword;
      }
      
      $.ajax({
        url:url,
        type:'get',
        dataType:'json',
        success:function(result){
        var html = template.render('home_body', result.datas);
        $("#product_list").empty();
        $("#product_list").append(html);
        
        if(curpage>1){
          $('.pre-page').removeClass('disabled');
        }else{
          $('.pre-page').addClass('disabled');
        }
        
        if(curpage<result.page_total){
          $('.next-page').removeClass('disabled');  
        }else{
          $('.next-page').addClass('disabled');
        }
        
        $("input[name=curpage]").val(curpage);
        }
      });
      
    });
    
    
  $('.keyorder').click(function(){
    var key = parseInt($("input[name=key]").val());
    var order = parseInt($("input[name=order]").val());
    var page = parseInt($("input[name=page]").val());     
    var curpage = eval(parseInt($("input[name=curpage]").val())-1);
    var store_id = parseInt($("input[name=store_id]").val());
    var keyword = $("input[name=keyword]").val();
    var hasmore = $("input[name=hasmore]").val();

    var curkey = $(this).attr('key');//1.销量 2.浏览量 3.价格 4.最新排序
    if(curkey == key){
      if(order == 1){
        var curorder = 2;
      }else{
        var curorder = 1;
      }
    }else{
      var curorder = 1;
    } 
    
    $(this).addClass("current").siblings().removeClass("current");
    
    if(store_id>0){
      var url = ApiUrl+"/index.php?act=store&op=goods_list&key="+curkey+"&order="+curorder+"&page="+page+"&curpage=1&store_id="+store_id;
    }else{
      var url = ApiUrl+"/index.php?act=store&op=goods_list&key="+curkey+"&order="+curorder+"&page="+page+"&curpage=1&keyword="+keyword;
    }
    
    $.ajax({
      url:url,
      type:'get',
      dataType:'json',
      success:function(result){
        $("input[name=hasmore]").val(result.hasmore);
        var html = template.render('home_body', result.datas);
        $("#product_list").empty();
        $("#product_list").append(html);  
        $("input[name=key]").val(curkey);
        $("input[name=order]").val(curorder);     
      }
    });
  });
  
  $('.pre-page').click(function(){//上一页
    var key = parseInt($("input[name=key]").val());
    var order = parseInt($("input[name=order]").val());
    var page = parseInt($("input[name=page]").val());     
    var curpage = eval(parseInt($("input[name=curpage]").val())-1);
    var store_id = parseInt($("input[name=store_id]").val());
    var keyword = $("input[name=keyword]").val();

    if(curpage<1){
      return false;
    }
    
    if(store_id>=0){
      var url = ApiUrl+"/index.php?act=store&op=goods_list&key="+key+"&order="+order+"&page="+page+"&curpage="+curpage+"&store_id="+store_id;
    }else{
      var url = ApiUrl+"/index.php?act=store&op=goods_list&key="+key+"&order="+order+"&page="+page+"&curpage="+curpage+"&keyword="+keyword;
    }
    $.ajax({
      url:url,
      type:'get',
      dataType:'json',
      success:function(result){
        $("input[name=hasmore]").val(result.hasmore);
        if(curpage == 1){
          $('.next-page').removeClass('disabled');
          $('.pre-page').addClass('disabled');
        }else{
          $('.next-page').removeClass('disabled');
        }
        var html = template.render('home_body', result.datas);
        $("#product_list").empty();
        $("#product_list").append(html);    
        $("input[name=curpage]").val(curpage);
        
          var page_total = result.page_total;
          var page_html = '';
          for(var i=1;i<=result.page_total;i++){
            if(i==curpage){
              page_html+='<option value="'+i+'" selected>'+i+'</option>';
            }else{
              page_html+='<option value="'+i+'">'+i+'</option>';
            } 
          }     
          
          $('select[name=page_list]').empty();
          $('select[name=page_list]').append(page_html);
      }
    });
  });
  
  $('.next-page').click(function(){//下一页
    var hasmore = $('input[name=hasmore]').val();
    if(hasmore == 'false'){
      return false;
    }
    
    var key = parseInt($("input[name=key]").val());
    var order = parseInt($("input[name=order]").val());
    var page = parseInt($("input[name=page]").val());
    var curpage = eval(parseInt($("input[name=curpage]").val())+1);
    var store_id = parseInt($("input[name=store_id]").val());
    var keyword = $("input[name=keyword]").val();

    if(store_id>=0){
      var url = ApiUrl+"/index.php?act=store&op=goods_list&key="+key+"&order="+order+"&page="+page+"&curpage="+curpage+"&store_id="+store_id;
    }else{
      var url = ApiUrl+"/index.php?act=store&op=goods_list&key="+key+"&order="+order+"&page="+page+"&curpage="+curpage+"&keyword="+keyword;
    }   
    $.ajax({
      url:url,
      type:'get',
      dataType:'json',
      success:function(result){
        $("input[name=hasmore]").val(result.hasmore);
        if(!result.hasmore){
          $('.pre-page').removeClass('disabled');
          $('.next-page').addClass('disabled');
        }else{
          $('.pre-page').removeClass('disabled');
        }
        var html = template.render('home_body', result.datas);
        $("#product_list").empty();
        $("#product_list").append(html);
        $("input[name=curpage]").val(curpage);
        
          var page_total = result.page_total;
          var page_html = '';
          for(var i=1;i<=result.page_total;i++){
            if(i==curpage){
              page_html+='<option value="'+i+'" selected>'+i+'</option>';
            }else{
              page_html+='<option value="'+i+'">'+i+'</option>';
            } 
          }     
          $('select[name=page_list]').empty();
          $('select[name=page_list]').append(page_html);
      }
    });
  });   
//根据关键字搜索商品
    $('.search-btn').click(function(){
      var keyword = encodeURIComponent($('#keyword').val());
      location.href = WapSiteUrl+'/tmpl/product_list.html?keyword='+keyword;
    });
    var store_id = GetQueryString("store_id");
    //渲染页面
    $.ajax({
       url:ApiUrl+"/index.php?act=store&op=store_detail",
       type:"get",
       data:{store_id:store_id},
       dataType:"json",
       success:function(result){
          var data = result.datas;
          if(!data.error){
            //渲染模板
            var html = template.render('go_store', data);
            $("#product_detail_wp").html(html);
          }else {
            var html = data.error;
            $("#product_detail_wp").html(html);
          }
       }
    });
  
  
  function AddView(){//增加浏览记录
    var store_info = getcookie('store');
    var store_id = GetQueryString('store_id');
    if(store_id<1){
      return false;
    }

    if(store_info==''){
      store_info+=store_id; 
    }else{

      var storearr = store_info.split('@');
      if(contains(storearr,store_id)){
        return false;
      }
      if(storearr.length<5){
        store_info+='@'+store_id;
      }else{
        storearr.splice(0,1);
        storearr.push(store_id);
        store_info = storearr.join('@');
      }
    }

    addcookie('store',store_info);
    return false;
  }
  
  function contains(arr, str) {//检测store_id是否存入
      var i = arr.length;
      while (i--) {
             if (arr[i] === str) {
             return true;
             }   
      }   
      return false;
  }
  $.sValid.init({
        rules:{
            buynum:"digits"
        },
        messages:{
            buynum:"请输入正确的数字"
        },
        callback:function (eId,eMsg,eRules){
            if(eId.length >0){
                var errorHtml = "";
                $.map(eMsg,function (idx,item){
                    errorHtml += "<p>"+idx+"</p>";
                });
                $.sDialog({
                    skin:"red",
                    content:errorHtml,
                    okBtn:false,
                    cancelBtn:false
                });
            }
        }  
    });
});