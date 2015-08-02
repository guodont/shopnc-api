<table class="table tb-type2 order mtw">
  <thead class="thead">
    <tr class="space">
      <th><?php echo $lang['final_handle_detail'];?></th>
    </tr></thead>
    <tbody>
    <tr>
      <th><?php echo $lang['final_handle_message'];?></th>
    </tr>
    <tr class="noborder">
      <td><?php echo $output['complain_info']['final_handle_message'];?></td>
    </tr>
    <tr>
      <th><?php echo $lang['final_handle_datetime'];?></th>
    </tr>
    <tr class="noborder">
      <td><?php echo date('Y-m-d H:i:s',$output['complain_info']['final_handle_datetime']);?></td>
    </tr>
  </tbody>
    <tfoot>
      <tr class="tfoot">
        <td><a href="JavaScript:void(0);" class="btn" onclick="history.go(-1)"><span><?php echo $lang['nc_back'];?></span></a></td>
      </tr>
    </tfoot>
</table>
