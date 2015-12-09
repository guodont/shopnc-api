$(document).ready(function(){
	//列表下拉
	$('img[nc_type="flex"]').click(function(){
		var status = $(this).attr('status');
		if(status == 'open'){
			var pr = $(this).parent('td').parent('tr');
			var id = $(this).attr('fieldid');
			var obj = $(this);
			$(this).attr('status','none');
			//ajax
			$.ajax({
				url: 'index.php?act=member_depart&op=member_depart&ajax=1&depart_parent_id='+id,
				dataType: 'json',
				success: function(data){
					var src='';
					for(var i = 0; i < data.length; i++){
						var tmp_vertline = "<img class='preimg' src='"+ADMIN_TEMPLATES_URL+"/images/vertline.gif'/>";
						src += "<tr class='"+pr.attr('class')+" row"+id+"'>";
						src += "<td class='w36'><input type='checkbox' name='check_depart_id[]' value='"+data[i].depart_id+"' class='checkitem'>";
						//图片
						if(data[i].have_child == 1){
							src += " <img fieldid='"+data[i].depart_id+"' status='open' nc_type='flex' src='"+ADMIN_TEMPLATES_URL+"/images/tv-expandable.gif' />";
						}else{
							src += " <img fieldid='"+data[i].depart_id+"' status='none' nc_type='flex' src='"+ADMIN_TEMPLATES_URL+"/images/tv-item.gif' />";
						}
						src += "</td><td class='w48 sort'>";						
						//排序
						src += " <span title='可编辑下级单位排序' ajax_branch='goods_class_sort' datatype='number' fieldid='"+data[i].depart_id+"' fieldname='depart_sort' nc_type='inline_edit' class='editable tooltip'>"+data[i].depart_sort+"</span></td>";
						//名称
						src += "<td class='w50pre name'>";
						
						
						for(var tmp_i=1; tmp_i < (data[i].deep-1); tmp_i++){
							src += tmp_vertline;
						}
						if(data[i].have_child == 1){
							src += " <img fieldid='"+data[i].depart_id+"' status='open' nc_type='flex' src='"+ADMIN_TEMPLATES_URL+"/images/tv-item1.gif' />";
						}else{
							src += " <img fieldid='"+data[i].depart_id+"' status='none' nc_type='flex' src='"+ADMIN_TEMPLATES_URL+"/images/tv-expandable1.gif' />";
						}
						src += " <span title='可编辑下级单位名称' required='1' fieldid='"+data[i].depart_id+"' ajax_branch='goods_class_name' fieldname='depart_name' nc_type='inline_edit' class='editable tooltip'>"+data[i].depart_name+"</span>";
						//新增下级
						if(data[i].deep < 3){
							src += "<a class='btn-add-nofloat marginleft' href='index.php?act=member_depart&op=member_depart_add&depart_parent_id="+data[i].depart_id+"'><span>新增下级</span></a>";
						}
						src += "</td>";
						//显示状态
						src += "<td class='align-center power-onoff'>";
						if(data[i].depart_show == 0){
							src += "<a href='JavaScript:void(0);' class='tooltip disabled' fieldvalue='0' fieldid='"+data[i].depart_id+"' ajax_branch='depart_show' fieldname='depart_show' nc_type='inline_edit' title='可编辑该单位是否显示'><img src='"+ADMIN_TEMPLATES_URL+"/images/transparent.gif'></a>"
						}else {
							src += "<a href='JavaScript:void(0);' class='tooltip enabled' fieldvalue='1' fieldid='"+data[i].depart_id+"' ajax_branch='depart_show' fieldname='depart_show' nc_type='inline_edit' title='可编辑该单位是否显示'><img src='"+ADMIN_TEMPLATES_URL+"/images/transparent.gif'></a>"
						}
						src += "</td>";
						//手机端显示状态
						src += "<td class='align-center power-onoff'>";
						if(data[i].depart_manage == 0){
							src += "<a href='JavaScript:void(0);' class='tooltip disabled' fieldvalue='0' fieldid='"+data[i].depart_id+"' ajax_branch='depart_manage' fieldname='depart_manage' nc_type='inline_edit' title='可编辑该单位是否在手机端显示'><img src='"+ADMIN_TEMPLATES_URL+"/images/transparent.gif'></a>"
						}else {
							src += "<a href='JavaScript:void(0);' class='tooltip enabled' fieldvalue='1' fieldid='"+data[i].depart_id+"' ajax_branch='depart_manage' fieldname='depart_manage' nc_type='inline_edit' title='可编辑该单位是否在手机端显示'><img src='"+ADMIN_TEMPLATES_URL+"/images/transparent.gif'></a>"
						}
						src += "</td>";
						//操作
						src += "<td class='w84'>";
						src += "<a href='index.php?act=member_depart&op=member_depart_edit&depart_id="+data[i].depart_id+"'>编辑</a>";
						src += " | <a href=\"javascript:if(confirm('删除该单位将会同时删除该单位的所有下级单位，您确定要删除吗'))window.location = 'index.php?act=member_depart&op=member_depart_del&depart_id="+data[i].depart_id+"';\">删除</a>";
						src += "</td>";
						src += "</tr>";
					}
					//插入
					pr.after(src);
					obj.attr('status','close');
					obj.attr('src',obj.attr('src').replace("tv-expandable","tv-collapsable"));
					$('img[nc_type="flex"]').unbind('click');
					$('span[nc_type="inline_edit"]').unbind('click');
					//重现初始化页面
                    $.getScript(RESOURCE_SITE_URL+"/js/flea/jquery.edit.js");
					$.getScript(RESOURCE_SITE_URL+"/js/flea/jquery.member_depart.js");
					$.getScript(RESOURCE_SITE_URL+"/js/admincp.js");
				},
				error: function(){
					alert('获取信息失败');
				}
			});
		}
		if(status == 'close'){
			$(".row"+$(this).attr('fieldid')).remove();
			$(this).attr('src',$(this).attr('src').replace("tv-collapsable","tv-expandable"));
			$(this).attr('status','open');
		}
	})
});