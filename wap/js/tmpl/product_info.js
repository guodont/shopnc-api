$(function() {
    var goods_id = GetQueryString("goods_id");
    $.ajax({
        url: ApiUrl + "/index.php?act=goods&op=goods_body",
        data: {goods_id: goods_id},
        type: "get",
        success: function(result) {
            $(".fixed-tab-pannel").html(result);
        }
    });
});