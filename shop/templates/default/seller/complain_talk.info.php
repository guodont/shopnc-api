
<h3><?php echo $lang['talk_detail'];?></h3>
<dl>
  <dt><?php echo $lang['talk_list'].$lang['nc_colon'];?></dt>
  <dd>
    <div id="div_talk" class="div_talk"> </div>
  </dd>
</dl>
<?php if(intval($output['complain_info']['complain_state']) !== 99) { ?>
<dl>
  <dt><?php echo $lang['talk_send'].$lang['nc_colon'];?></dt>
  <dd>
    <textarea id="complain_talk" class="w400"></textarea>
  </dd>
</dl>
<div class="bottom">
  <label class="submit-border"> <a id="btn_publish" class="submit"><?php echo $lang['talk_send'];?></a> </label>
  <label class="submit-border"> <a id="btn_refresh" class="submit"><?php echo $lang['talk_refresh'];?></a> </label>
  <label class="submit-border"> <a id="btn_handle" class="submit"><?php echo $lang['handle_submit'];?></a> </label>
</div>
<?php } ?>
<form action="index.php?act=store_complain&op=apply_handle" method="post" id="handle_form">
  <input name="input_complain_id" type="hidden" value="<?php echo $output['complain_info']['complain_id'];?>" />
</form>
<script type="text/javascript">
$(document).ready(function(){
    get_complain_talk();
    $("#btn_publish").click(function(){
        if($("#complain_talk").val()=='') {
            alert("<?php echo $lang['talk_null'];?>");
        }
        else {
            publish_complain_talk();
        }
    });
    $("#btn_refresh").click(function(){
        get_complain_talk();
    });
    $("#btn_handle").click(function(){
        if(confirm("<?php echo $lang['handle_confirm_message'];?>")) {
            $("#handle_form").submit();
        }
    });
});
function get_complain_talk() {
    $("#div_talk").empty();
    $.ajax({
        type:'POST',
        url:'index.php?act=store_complain&op=get_complain_talk',
        cache:false,
        data:"complain_id=<?php echo $output['complain_info']['complain_id'];?>",
        dataType:'json',
        error:function(){
                $("#div_talk").append("<p class='admin'>"+"<?php echo $lang['talk_none'];?>"+"</p>");
        },
        success:function(talk_list){
            if(talk_list.length >= 1) {
                for(var i = 0; i < talk_list.length; i++)
                {
                    $("#div_talk").append("<p class='"+talk_list[i].css+"'>"+talk_list[i].talk+"</p>");
                }
            }
            else {
                $("#div_talk").append("<p class='admin'>"+"<?php echo $lang['talk_none'];?>"+"</p>");
            }
        }
	});
}
function publish_complain_talk() {
        $.ajax({
            type:'POST',
                url:'index.php?act=store_complain&op=publish_complain_talk',
                cache:false,
                data:"complain_id=<?php echo $output['complain_info']['complain_id'];?>&complain_talk="+encodeURIComponent($("#complain_talk").val()),
                dataType:'json',
                error:function(){
                    alert("<?php echo $lang['talk_send_fail'];?>");
                },
                success:function(talk_list){
                    if(talk_list == 'success') {
                        $("#complain_talk").val('');
                        get_complain_talk();
                        alert("<?php echo $lang['talk_send_success'];?>");
                    }
                    else {
                        alert("<?php echo $lang['talk_send_fail'];?>");
                    }
                }
        });
}
</script>