<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>友情连接</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=link&op=link_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" value="link" name="act">
    <input type="hidden" value="link" name="op">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><?php echo $lang['link_index_title'];?></th>
          <td><input type="text" value="<?php echo $output['search_link_title']?>" name="search_link_title" class="txt"></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if($output['search_link_title'] != ''){?>
            <a href="index.php?act=link&op=link" class="btns tooltip" title="<?php echo $lang['nc_cancel_search'];?>"><span>撤销检索</span></a>
            <?php }?>
            <a href="JavaScript:void(0);" onclick="window.location.href='index.php?act=link&op=link'" class="btns tooltip" title="<?php echo $lang['link_all']; ?>"><span>全部</span></a> <a href="JavaScript:void(0);" onclick="window.location.href='index.php?act=link&op=link&type=0'" class="btns tooltip" title="<?php echo $lang['link_pic']; ?>"><span>图片连接</span></a> <a href="JavaScript:void(0);" onclick="window.location.href='index.php?act=link&op=link&type=1'" class="btns tooltip" title="<?php echo $lang['link_word']; ?>"><span>文字连接</span></a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li>通过合作伙伴管理你可以，编辑、查看、删除合作伙伴信息</li>
            <li>在搜索处点击图片则表示将搜索图片标识仅为图片的相关信息，点击文字则表示将搜索图片标识仅为文字的相关信息，点击全部则搜索所有相关信息</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_link">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th>&nbsp;</th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th>合作伙伴</th>
          <th>图片标识</th>
          <th>连接</th>
          <th class="align-center">操作</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['link_list']) && is_array($output['link_list'])){ ?>
        <?php foreach($output['link_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" name="del_id[]" value="<?php echo $v['link_id'];?>" class="checkitem"></td>
          <td class="w48 sort"><span class="tooltip editable" title="<?php echo $lang['nc_editable'];?>" ajax_branch='link_sort' datatype="number" fieldid="<?php echo $v['link_id'];?>" fieldname="link_sort" nc_type="inline_edit"><?php echo $v['link_sort'];?></span></td>
          <td><?php echo $v['link_title'];?></td>
          <td class="picture"><?php 
				if($v['link_pic'] != ''){
					echo "<div class='size-88x31'><span class='thumb size-88x31'><i></i><img width=\"88\" height=\"31\" src='".$v['link_pic']."' onload='javascript:DrawImage(this,88,31);' /></span></div>";
				}else{
					echo $v['link_title'];
				}
				?></td>
          <td><?php echo $v['link_url'];?></td>
          <td class="w96 align-center"><a href="index.php?act=link&op=link_edit&link_id=<?php echo $v['link_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>'))window.location = 'index.php?act=link&op=link_del&link_id=<?php echo $v['link_id'];?>';"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['link_list']) && is_array($output['link_list'])){ ?>
        <tr class="tfoot" id="dataFuncs">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16" id="batchAction"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp; <a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#form_link').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.edit.js" charset="utf-8"></script>