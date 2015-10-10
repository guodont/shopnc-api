<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con">
  <div id="ms-warning"></div>
  <form id="fsadd_form" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=friendship_add&c_id=<?php echo $output['c_id'];?>" method="post" class="base-form-style">
    <input type="hidden" value="ok" name="form_submit">
    <dl>
      <dt><?php echo $lang['circle_name'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" name="name" class="w200 text"  />
        <a href="javascript:void(0);" nctype="fsadd_search"><?php echo $lang['nc_search'];?></a> </dd>
      <dd>
        <select name="cid" nctype="fsadd_select">
          <option value='0'><?php echo $lang['nc_common_pselect'];?></option>
        </select>
        <input type="hidden" name="cname" id="cname" value="" />
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['fcircle_sort'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" name="sort" class="w50 text" value="255" />
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['circle_tclass_sort'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="radio" name="status" value="1" checked="checked" />
        <?php echo $lang['nc_show'];?>&nbsp;
        <input type="radio" name="status" value="0" />
        <?php echo $lang['nc_hide'];?> </dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd><a class="submit-btn" nctype="submit-btn" href="Javascript: void(0)"><?php echo $lang['nc_submit'];?></a></dd>
    </dl>
  </form>
</div>
<script type="text/javascript">
var c_id = <?php echo $output['c_id'];?>;
$(function(){
	$('a[nctype="submit-btn"]').click(function(){
		$('#fsadd_form').submit();
	});

    $('#fsadd_form').validate({
        errorLabelContainer: $('#ms-warning'),
        invalidHandler: function(form, validator) {
               $('#ms-warning').show();
        },
    	submitHandler:function(form){
    		ajaxpost('fsadd_form', '<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=friendship_add&c_id='+c_id, '', 'onerror');
    	},
        rules : {
        	cid : {
            	min : 1
        	},
            sort : {
                required : true,
                digits : true,
                max : 255
            }
        },
        messages : {
        	cid : {
            	min : '<?php echo $lang['fcircle_please_choose'];?>'
        	},
            sort  : {
                required : '<?php echo $lang['fcircle_sort_not_null'];?>',
                digits : '<?php echo $lang['circle_tclass_sort_is_digits'];?>',
                max : '<?php echo $lang['circle_tclass_sort_max'];?>'
            }
        }
    });

	$('a[nctype="fsadd_search"]').click(function(){
		var name = $('input[name="name"]').val();
		$.getJSON(CIRCLE_SITE_URL+'/index.php?act=manage&op=search_circle&c_id='+c_id+'&name='+name, function(data){
			if(data){
				var select = $('select[nctype="fsadd_select"]');
				select.html('<option value=\'0\'><?php echo $lang['nc_common_pselect'];?></option>');
				$.each(data, function(e, d){
					$('<option value="'+d.circle_id+'">'+d.circle_name+'</option>').appendTo(select);
				});
				select.parent('dd').show();
			}
		});
    });

	$('select[nctype="fsadd_select"]').change(function(){
		var val = parseInt($(this).val());
		if(val == 0){
			$('#cname').val('');
		}else{
			var html = $(this).find('option:selected').html();
			$('#cname').val(html);
		}
	});
});
</script> 