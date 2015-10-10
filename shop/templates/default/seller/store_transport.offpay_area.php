<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>

<div class="alert alert-block mt10">
  <ul>
    <li>1、此处设置自营店铺支持货到付款的地区，注意：只有平台开启货到付款时以下设置的地区才会生效</li>
    <li>2、选择完子地区确认后，系统并未保存，需要点击页面底部的保存按钮系统才会保存设置的地区</li>
 </ul>
</div>

<style>
#table_area_box td {text-align:left;}
.area-list {display:inline-block;width:200px;padding:5px 0px;}
</style>

  <form id="area_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="act" value="store_transport" />
    <input type="hidden" name="op" value="offpay_area" />
    <input type="hidden" name="county" id="county" value="" />

    <table class="ncsc-default-table order" id="table_area_box">
      <tbody>
<?php $areas = $output['areas']; foreach ($areas['children'][0] as $provinceId) { ?>
        <tr>
          <td class="w120">
            <label>
              <input type="checkbox"<?php if (array_key_exists($provinceId, $output['province_checked_array'])) echo ' checked="checked"'; ?> value="<?php echo $provinceId; ?>" name="province[]" />
              <strong><?php echo $areas['name'][$provinceId]; ?></strong>
            </label>
          </td>
          <td>
<?php foreach ($areas['children'][$provinceId] as $cityId) { ?>
            <div class="area-list">
              <label>
                <input type="checkbox" nc_province="<?php echo $provinceId; ?>"<?php if ($output['city_checked_array'][$cityId]) echo ' checked="checked"';?> value="<?php echo $cityId; ?>" name="city[]" />
                <?php echo $areas['name'][$cityId]; ?>
              </label>
              (<span city_id="<?php echo $cityId; ?>" title="已选下级地区"><?php echo count($output['city_checked_child_array'][$cityId]); ?></span>)
              <a city_id="<?php echo $cityId; ?>" nc_title="<?php echo $areas['name'][$cityId]; ?>" province_id="<?php echo $provinceId; ?>" nc_type="edit" href="javascript:void(0);" title="选择下级地区"><i class="icon-pencil"></i></a>
            </div>
<?php } ?>
          </td>
        </tr>
<?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15">
          <div class="tc mt10 mb10">
          <a href="javascript:void(0);" class="ncsc-btn ncsc-btn-green" id="submitBtn"><span>提交保存</span></a>
          </div>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript">

var nc_a = $.parseJSON('<?php echo $output['area_array_json']; ?>');

//将系统已选择的县ID放入JS数组
var CUR_COUNTY = new Array();
<?php if (!empty($output['city_checked_child_array']) && is_array($output['city_checked_child_array'])) { ?>
<?php  foreach ($output['city_checked_child_array'] as $city_id => $county_ids) { ?>
CUR_COUNTY[<?php echo $city_id;?>] = new Array();
<?php foreach($county_ids as $k => $v) { ?>
CUR_COUNTY[<?php echo $city_id;?>][<?php echo $v;?>] = true;
<?php } ?>
<?php } ?>
<?php } ?>

$(function(){

    //省点击事件
    $('input[name="province[]"]').on('click',function(){
        if ($(this).attr('checked') == 'checked'){
            $('input[nc_province="' + $(this).val() + '"]').each(function(){
                $(this).attr('checked','checked');
                if (typeof nc_a[$(this).val()] == 'object') {
                    county_array = nc_a[$(this).val()];
                } else {
                    county_array = new Array();
                }
                CUR_COUNTY[$(this).val()] = new Array();
                for(i = 0; i < county_array.length; i++) {
                    CUR_COUNTY[$(this).val()][county_array[i][0]] = true;
                }
                count = county_array.length;
                $('span[city_id="'+$(this).val()+'"]').html(count);
            });
        }else{
            $('input[nc_province="' + $(this).val() + '"]').each(function(){
                $(this).attr('checked',false);
                CUR_COUNTY[$(this).val()] = undefined;
                $('span[city_id="'+$(this).val()+'"]').html(0);
            });
        }
    });

    //点击编辑事件
    $('a[nc_type="edit"]').on('click',function(){
            if (typeof CUR_COUNTY[$(this).attr('city_id')] == 'object'){
                cur_county = CUR_COUNTY[$(this).attr('city_id')];
            }else{
                cur_county = new Array();
            }
            var province_array = nc_a[$(this).attr('city_id')];
            if (typeof nc_a[$(this).attr('city_id')] == 'object'){
                county_array = nc_a[$(this).attr('city_id')];
            }else{
                county_array = new Array();
            }
            if (county_array.length == 0) {
                alert('下面没有子地区，无需要编辑');
                return;
            }
            county_html = '<table id="table_area_box_edit" class="table tb-type2"><tbody><tr class="noborder"><td city_id="'+$(this).attr('city_id')+'" province_id="'+$(this).attr('province_id')+'">';
            for(i = 0; i < county_array.length; i++){
                county_html += '<label style="display:inline-block;width:100px;padding:5px 10px;"><input type="checkbox"';
                if (typeof(cur_county[county_array[i][0]]) != 'undefined') {
                    county_html += ' checked ' ;
                }
                county_html += (' value="'+county_array[i][0]+'" name="county[]">' + county_array[i][1] + '</label>');
            }
            county_html += '</td></tr><tr><td style="padding:5px;"><a id="county_submit" class="ncsc-btn ncsc-btn-green" href="javascript:void(0);"><span>确认</span></a> <span style="color:#f30;">确认后，还需要点击页面底部的“提交保存”按钮完成保存操作</span></td></tr></tbody></table>';
            html_form('select_county', '选择 '+ $(this).attr('nc_title') +' 子地区', county_html, 500,1);
    });

    //选择市级事件
    $('input[name="city[]"]').on('click',function(){
        if ($(this).attr('checked')) {
            if (typeof nc_a[$(this).val()] == 'object') {
                county_array = nc_a[$(this).val()];
            } else {
                county_array = new Array();
            }
            CUR_COUNTY[$(this).val()] = new Array();
            for(i = 0; i < county_array.length; i++) {
                CUR_COUNTY[$(this).val()][county_array[i][0]] = true;
            }
            count = county_array.length;
            if ($('input[nc_province="'+$(this).attr('nc_province')+'"]').size() == $('input[nc_province="'+$(this).attr('nc_province')+'"]:checked').size()) {
                $('input[value="'+$(this).attr('nc_province')+'"]').attr('checked',true);
            } else {
                $('input[value="'+$(this).attr('nc_province')+'"]').attr('checked',false);
            }
        } else {
            CUR_COUNTY[$(this).val()] = undefined;
            count = 0;
            $('input[value="'+$(this).attr('nc_province')+'"]').attr('checked',false);
        }
        $('span[city_id="'+$(this).val()+'"]').html(count);
    });

    //弹出县编辑确认事件
    $('body').on('click','#county_submit',function(){
        cur_td = $('.dialog_content > table > tbody > tr > td');
        cur_checkbox = cur_td.find('input[type="checkbox"]');
        cur_checkbox.each(function(){
            if ($(this).attr('checked')) {
                if (typeof CUR_COUNTY[cur_td.attr('city_id')] != 'object') {
                    CUR_COUNTY[cur_td.attr('city_id')] = new Array();
                }
                CUR_COUNTY[cur_td.attr('city_id')][$(this).val()] = true;
            } else {
                if (typeof CUR_COUNTY[cur_td.attr('city_id')] == 'object') {
                    if (typeof CUR_COUNTY[cur_td.attr('city_id')][$(this).val()] != 'undefined') {
                       CUR_COUNTY[cur_td.attr('city_id')][$(this).val()] = undefined;
                    }
                }
            }
        });
        cur_new_county = cur_td.find('input[type="checkbox"]:checked').size();
        $('span[city_id="'+cur_td.attr('city_id')+'"]').html(cur_new_county);
        if (cur_checkbox.size() == cur_new_county) {
            v = true;
        } else {
            v = false;
        }
        $('input[value="'+cur_td.attr('city_id')+'"]').attr('checked',v);

        if ($('input[nc_province="'+cur_td.attr('province_id')+'"]').size() == $('input[nc_province="'+cur_td.attr('province_id')+'"]:checked').size()) {
            $('input[value="'+cur_td.attr('province_id')+'"]').attr('checked',true);
        } else {
            $('input[value="'+cur_td.attr('province_id')+'"]').attr('checked',false);
        }

        DialogManager.close('select_county');
    });

    //表单提交事件
    $("#submitBtn").click(function(){
        var county_id_str = '';
        for(var city_id in CUR_COUNTY) {
            for(var county_d in CUR_COUNTY[city_id]) {
                if (typeof(CUR_COUNTY[city_id][county_d]) != 'undefined') {
                    county_id_str += county_d + ',';
                }
            }
        }
        $("#county").val(county_id_str);
        $("#area_form").submit();
    });
});
</script>
