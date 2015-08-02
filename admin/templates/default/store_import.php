<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>从CSV导入</h3>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="tb-type1 noborder">
  <tbody>
    <tr>
      <th>下载csv模板：</th>
      <td>
	      <ul>
	      	<li><a href="<?php echo RESOURCE_SITE_URL ?>/store_import.csv">批量导入商家模板下载</a></li>
	      </ul>
      </td>
    </tr>
  </tbody>
  </table>
  <br/>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div>
        </th>
      </tr>
      <tr>
        <td>提醒：请仔细阅读以下各注意事项：<ul>
            <li>登录密码长度不能小于6</li>
            <li>会员名称，用于登录会员中心</li>
            <li>店主卖家账号，用于登录商家中心，可与店主账号不同</li>
            <li>会员名称， 店主卖家用户名可以相同，但是各个商家的用户名称和店主卖家用户不能重复，否则会导致导入失败</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th>
  			<form method="post" action="index.php?act=store&op=store_import_csv" enctype="multipart/form-data" id="stores_form">
     		<label for="文件选择">请选择要导入的csv文件：</label><input name="csv_stores" type="file" />
    		<input type="submit" value="导入csv" name="import" />
  			</form>  
  		  </th>
  	   </tr>
  	 </thead>
  	</table>

</div>