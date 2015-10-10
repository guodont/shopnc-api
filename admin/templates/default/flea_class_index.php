<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>首页分类设置</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>设置信息</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="flea_site_name">数码:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="shuma_cid1">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['shuma']['fc_index_id1']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
			</select>
			<span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="shuma_cname1" value="<?php echo $output['shuma']['fc_index_name1']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="shuma_cid2">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['shuma']['fc_index_id2']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="shuma_cname2" value="<?php echo $output['shuma']['fc_index_name2']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="shuma_cid3">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['shuma']['fc_index_id3']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="shuma_cname3" value="<?php echo $output['shuma']['fc_index_name3']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="shuma_cid4">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['shuma']['fc_index_id4']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="shuma_cname4" value="<?php echo $output['shuma']['fc_index_name4']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="flea_site_title">装扮:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="zhuangban_cid1">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['zhuangban']['fc_index_id1']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="zhuangban_cname1" value="<?php echo $output['zhuangban']['fc_index_name1']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="zhuangban_cid2">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['zhuangban']['fc_index_id2']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="zhuangban_cname2" value="<?php echo $output['zhuangban']['fc_index_name2']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="zhuangban_cid3">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['zhuangban']['fc_index_id3']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="zhuangban_cname3" value="<?php echo $output['zhuangban']['fc_index_name3']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="zhuangban_cid4">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['zhuangban']['fc_index_id4']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="zhuangban_cname4" value="<?php echo $output['zhuangban']['fc_index_name4']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="flea_site_description">居家:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="jujia_cid1">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['jujia']['fc_index_id1']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="jujia_cname1" value="<?php echo $output['jujia']['fc_index_name1']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="jujia_cid2">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['jujia']['fc_index_id2']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="jujia_cname2" value="<?php echo $output['jujia']['fc_index_name2']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="jujia_cid3">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['jujia']['fc_index_id3']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="jujia_cname3" value="<?php echo $output['jujia']['fc_index_name3']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="jujia_cid4">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['jujia']['fc_index_id4']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="jujia_cname4" value="<?php echo $output['jujia']['fc_index_name4']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr>
          <td colspan="2" class="required">装扮:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="xingqu_cid1">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['xingqu']['fc_index_id1']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="xingqu_cname1" value="<?php echo $output['xingqu']['fc_index_name1']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="xingqu_cid2">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['xingqu']['fc_index_id2']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="xingqu_cname2" value="<?php echo $output['xingqu']['fc_index_name2']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="xingqu_cid3">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['xingqu']['fc_index_id3']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="xingqu_cname3" value="<?php echo $output['xingqu']['fc_index_name3']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="xingqu_cid4">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['xingqu']['fc_index_id4']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="xingqu_cname4" value="<?php echo $output['xingqu']['fc_index_name4']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="flea_hot_search">母婴:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="muying_cid1">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['muying']['fc_index_id1']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="muying_cname1" value="<?php echo $output['muying']['fc_index_name1']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="muying_cid2">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['muying']['fc_index_id2']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="muying_cname2" value="<?php echo $output['muying']['fc_index_name2']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="muying_cid3">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['muying']['fc_index_id3']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="muying_cname3" value="<?php echo $output['muying']['fc_index_name3']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" style="width: 600px">
			<select name="muying_cid4">
	                <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
	                <?php foreach($output['goods_class'] as $val) { ?>
	                <option value="<?php echo $val['gc_id']; ?>"<?php if ($output['muying']['fc_index_id4']==$val['gc_id'])echo ' selected="selected"';?>><?php echo $val['gc_name']; ?></option>
	                <?php } ?>
	              </select>
	              <span style="padding:0 3px;"><?php echo $lang['flea_index_class_setting_as'];?>:</span><input type="text" name="muying_cname4" value="<?php echo $output['muying']['fc_index_name4']?>" style="width: 250px" />
          </td>
          <td class="vatop tips"><span class="vatop rowform">页首分类名称可修改为"显示为XXX"，若不填则显示原分类名称</span></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
