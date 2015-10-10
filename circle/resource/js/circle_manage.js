$(function(){
    /* 全选 */
    $('.checkall').click(function(){
        var _self = this;
        $('.checkitem').each(function(){
            if (!this.disabled)
            {
                $(this).attr('checked', _self.checked);
            }
        });
        $('.checkall').attr('checked', this.checked);
    });

    /* 批量操作按钮 */
    $('a[nctype="batchbutton"]').click(function(){
        /* 是否有选择 */
        if($('.checkitem:checked').length == 0){    //没有选择
            return false;
        }
        var _uri = $(this).attr('uri');
        var _name = $(this).attr('name');
        var handleResult = function(uri,name) {
        	
	         /* 获取选中的项 */
	        var items = '';
	        $('.checkitem:checked').each(function(){
	            items += this.value + ',';
	        });
	        items = items.substr(0, (items.length - 1));
	        ajaxget(uri + '&' + name + '=' + items);
	        return false;
        }
        if($(this).attr('confirm')){
        	showDialog($(this).attr('confirm'), 'confirm', '', function(){handleResult(_uri,_name)});
        	return false;
        }
		handleResult(_uri,_name);
    });
});

// 导航下拉菜单
	var timeout         = 500;
	var closetimer		= 0;
	var ddmenuitem      = 0;

	function jsddm_open()
	{	jsddm_canceltimer();
		jsddm_close();
		ddmenuitem = $(this).find('.tabs-child-menu').eq(0).css('visibility', 'visible');}

	function jsddm_close()
	{	if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');}

	function jsddm_timer()
	{	closetimer = window.setTimeout(jsddm_close, timeout);}

	function jsddm_canceltimer()
	{	if(closetimer)
		{	window.clearTimeout(closetimer);
			closetimer = null;}}

	$(document).ready(function()
	{	$('#jsddm > li.selected').bind('mouseover', jsddm_open);
		$('#jsddm > li.selected').bind('mouseout',  jsddm_timer);});