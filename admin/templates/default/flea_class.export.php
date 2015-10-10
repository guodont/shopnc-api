<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>闲置分类</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=flea_class&op=goods_class"><span>管理</span></a></li>
        <li><a href="index.php?act=flea_class&op=goods_class_add" ><span>新增</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>导出</span></a></li>
        <li><a href="index.php?act=flea_class&op=goods_class_import"><span>导入</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
    <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5>操作提示</h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li>导出内容为商品分类信息的.csv文件</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="if_convert" value="1" />
    <table class="table tb-type2">
    <thead>
        <tr class="thead">
          <th>导出您的商品分类数据?</th>
      </tr></thead>
      <tfoot><tr class="tfoot">
        <td><a href="JavaScript:document.form1.submit();" class="btn"><span>导出</span></a></td>
      </tr></tfoot>
    </table>
  </form>
</div>
