<ul class="tab pngFix">
  <?php if(is_array($output['member_menu']) and !empty($output['member_menu'])) { 
			foreach ($output['member_menu'] as $key => $val) {
				if($val['menu_key'] == $output['menu_key']) {
					echo '<li class="active"><a '.(isset($val['target'])?"target=".$val['target']:"").' href="'.$val['menu_url'].'">'.$val['menu_name'].'</a></li>';
				} else {
					echo '<li class="normal"><a '.(isset($val['target'])?"target=".$val['target']:"").' href="'.$val['menu_url'].'">'.$val['menu_name'].'</a></li>';
				}
			}
        }
        ?>
</ul>
