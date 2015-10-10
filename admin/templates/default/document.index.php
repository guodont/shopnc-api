<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['document_index_document'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
    <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['document_index_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th><?php echo $lang['document_index_title'];?></th>
        <th class="align-center"><?php echo $lang['document_edit_time'];?></th>
        <th><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['doc_list']) && is_array($output['doc_list'])){ ?>
      <?php foreach($output['doc_list'] as $k => $v){ ?>
      <tr class="hover">
        <td ><?php echo $v['doc_title']; ?></td>
        <td class="w25pre align-center"><?php echo date('Y-m-d H:i:s',$v['doc_time']); ?></td>
        <td class="w96"><a href="index.php?act=document&op=edit&doc_id=<?php echo $v['doc_id']; ?>"><?php echo $lang['nc_edit'];?></a></td>
      </tr>
      <?php } ?>
      <?php }else { ?>
      <tr class="no_data">
        <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
