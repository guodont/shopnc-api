<?php
/**
 * 圈子公共方法
 *
 * 公共方法
 *
 */
defined('InShopNC') or exit('Access Invalid!');

/**
 * 返回模板文件所在完整目录
 *
 * @param string $tplpath 模板文件名（不含扩展名）
 * @return string
 */
function circle_template($tplpath){
	return BASE_PATH.'/templates/'.TPL_NAME.'/'.$tplpath.'.php';
}

function getRefUrl() {
	return urlencode('http://'.$_SERVER['HTTP_HOST'].request_uri());
}

/**
 * 成员身份
 */
function memberIdentity($identity){
	switch (intval($identity)){
		case 1:
			return '<em class="c">'.L('circle_manager').'</em>';
			break;
		case 2:
			return '<em class="a">'.L('circle_administrate').'</em>';
			break;
		case 3:
		default:
			break;
	}
}

/**
 * 根据会员id生成部分附件路径
 */
function themePartPath($id){
	$a = $id%20;
	$b = $id%10;
	return $a.'/'.$b.'/'.$id;
}
/**
 * Inform Url link
 */
function spellInformUrl($param){
	if($param['reply_id'] == 0) return $url = 'index.php?act=theme&op=theme_detail&c_id='.$param['circle_id'].'&t_id='.$param['theme_id'];
	
	$where = array();
	$where['circle_id']	= $param['circle_id'];
	$where['theme_id']	= $param['theme_id'];
	$where['reply_id']	= array('elt', $param['reply_id']);
	$count = Model()->table('circle_threply')->where($where)->count();
	$page = ceil($count/15);
	return $url = 'index.php?act=theme&op=theme_detail&c_id='.$param['circle_id'].'&t_id='.$param['theme_id'].'&curpage='.$page.'#f'.$param['reply_id'];
}
/**
 * Replace the UBB tag
 * 
 * @param string $ubb
 * @param int $video_sign
 * @return string
 */
function replaceUBBTag($ubb, $video_sign = 1){
	if($video_sign){
		$flash_sign = preg_match("/\[FLASH\](.*)\[\/FLASH\]/iU", $ubb);
	}
	$ubb = str_replace(array(
			'[B]', '[/B]', '[I]', '[/I]', '[U]', '[/U]', '[/FONT]', '[/FONT-SIZE]', '[/FONT-COLOR]'
	), array(
			'', '', '', '', '', '', '', '', ''
	), preg_replace(array(
			"/\[URL=(.*)\](.*)\[\/URL\]/iU",
			"/\[FONT=([A-Za-z ]*)\]/iU",
			"/\[FONT-SIZE=([0-9]*)\]/iU",
			"/\[FONT-COLOR=([A-Za-z0-9]*)\]/iU",
			"/\[SMILIER=([A-Za-z_]*)\/\]/iU",
			"/\[IMG\](.*)\[\/IMG\]/iU",
			"/\[FLASH\](.*)\[\/FLASH\]/iU",
			"<img class='pi' src=\"$1\"/>",
	), array(
			'['.L('nc_link').']',
			"",
			"",
			"",
			"",
			'['.L('nc_img').']',
			($video_sign == 1?'':'['.L('nc_video').']'),
			""
	), $ubb));
	
	if($video_sign && !empty($flash_sign)){
		$ubb .= "<span nctype=\"theme_read\"><img src=\"".CIRCLE_SITE_URL.'/templates/'.TPL_CIRCLE_NAME."/images/default_play.gif\"></span>";
	}
	return $ubb;
}
/**
 * tidy theme goods information
 * 
 * @param array $array
 * @param string $key
 * @param int $deep 1 one-dimensional array 2 two dimension array
 * @param string $type
 * @return array
 */
function tidyThemeGoods($array, $key, $deep=1, $type= 60){
	if (is_array($array)){
		$tmp = array();
		foreach ($array as 	$v) {
			if($v['thg_type'] == 0){
				$v['image']		= thumb($v, $type);
				$v['thg_url']	= urlShop('goods', 'index', array('goods_id'=>$v['goods_id']));
			}else{
				$v['image']	= $v['goods_image'];
			}
			if ($deep === 1){
				$tmp[$v[$key]] = $v;
			}elseif($deep === 2){
				$tmp[$v[$key]][] = $v;
			}
		}
		return $tmp;
	}else{
		return $array;
	}
}
/**
 * The editor
 * 
 * @param string $cname		The content of the editor 'id' and the 'name' of the name
 * @param string $content	The editor content
 * @param string $type		The toolbar type
 * @param array  $affix		The affix content
 * @param string $gname		The name of the goods content
 * @param array  $goods		The goods content
 * @param array  $readperm	Optional permissions array
 * @param int    $rpvalue	Has chosen the permissions
 */
function showMiniEditor($cname, $content = '', $type = 'all', $affix = array(), $gname = '', $goods = array(), $readperm = array(), $rpvalue = 0){
	switch ($type){
		case 'manage':
			$items = array('font', 'size', 'line', 'bold', 'italic', 'underline', 'color', 'line', 'url', 'flash', 'image', 'line', 'smilier');
			$return = '$__content.$__maffix.$__goods.$__readperm';
			break;
		case 'quickReply':
			$items = array('font', 'size', 'line', 'bold', 'italic', 'underline', 'color', 'line', 'url', 'flash', 'line', 'smilier');
			$return = '$__content';
			break;
		case 'hQuickReply':
			$items = array('font', 'size', 'line', 'bold', 'italic', 'underline', 'color', 'line', 'url', 'flash', 'line', 'smilier', 'highReply');
			$return = '$__content';
			break;
		default:
			$items = array('font', 'size', 'line', 'bold', 'italic', 'underline', 'color', 'line', 'affix', 'line', 'url', 'flash', 'image', 'goods', 'line', 'smilier');
			$return = '$__content.$__affix.$__goods.$__readperm';
			break;
	}
	
	// toolbar items
	$_line	= "<span class=\"line\"></span>";
	$_font	= "<a href=\"javascript:void(0);\" nctype=\"font-family\" class=\"font-family\">".L('nc_font')."
					<div class=\"ubb-layer font-family-layer\">
						<div class=\"arrow\"></div>
						<span class=\"ff01\" data-param=\"Microsoft YaHei\">".L('nc_Microsoft_YaHei')."</span><span class=\"ff02\" data-param=\"simsun\">".L('nc_simsun')."</span><span class=\"ff03\" data-param=\"simhei\">".L('nc_simhei')."</span><span class=\"ff04\" data-param=\"Arial\">Arial</span><span class=\"ff05\" data-param=\"Verdana\">Verdana</span><span class=\"ff06\" data-param=\"Helvetica\">Helvetica</span><span class=\"ff07\" data-param=\"Tahoma\">Tahoma</span>
					</div>
				</a>";
	$_size	= "<a href=\"javascript:void(0);\" nctype=\"font-size\" class=\"font-size\">".L('nc_font_size')."
					<div class=\"ubb-layer font-size-layer\">
						<div class=\"arrow\"></div>
						<span class=\"s12\">12px</span><span class=\"s14\">14px</span><span class=\"s16\">16px</span><span class=\"s18\">18px</span><span class=\"s20\">20px</span><span class=\"s22\">22px</span><span class=\"s24\">24px</span>
					</div>
	            </a>";
	$_bold	= "<a href=\"javascript:void(0);\" nctype=\"b\" title=\"".L('nc_font_bold')."\"><i class=\"font-b\"></i></a>";
	$_italic= "<a href=\"javascript:void(0);\" nctype=\"i\" title=\"".L('nc_font_italic')."\"><i class=\"font-i\"></i></a>";
	$_underline	= "<a href=\"javascript:void(0);\" nctype=\"u\" title=\"".L('nc_font_underline')."\"><i class=\"font-u\"></i></a>";
	$_color	= "<a href=\"javascript:void(0);\" nctype=\"color\" title=\"".L('nc_font_color')."\" class=\"font-color-handle\"><i class=\"font-color\"></i>
					<div class=\"ubb-layer font-color-layer\">
						<div class=\"arrow\"></div>
						<span class=\"c-000000\"></span><span class=\"c-A0522D\"></span><span class=\"c-556B2F\"></span><span class=\"c-006400\"></span><span class=\"c-483D8B\"></span><span class=\"c-000080\"></span><span class=\"c-4B0082\"></span><span class=\"c-2F4F4F\"></span> <span class=\"c-8B0000\"></span><span class=\"c-FF8C00\"></span><span class=\"c-808000\"></span><span class=\"c-008000\"></span><span class=\"c-008080\"></span><span class=\"c-0000FF\"></span><span class=\"c-708090\"></span><span class=\"c-696969\"></span><span class=\"c-FF0000\"></span><span class=\"c-F4A460\"></span><span class=\"c-9ACD32\"></span><span class=\"c-2E8B57\"></span><span class=\"c-48D1CC\"></span><span class=\"c-4169E1\"></span><span class=\"c-800080\"></span><span class=\"c-808080\"></span><span class=\"c-FF00FF\"></span><span class=\"c-FFA500\"></span><span class=\"c-FFFF00\"></span><span class=\"c-00FF00\"></span><span class=\"c-00FFFF\"></span><span class=\"c-00BFFF\"></span><span class=\"c-9932CC\"></span><span class=\"c-C0C0C0\"></span><span class=\"c-FFC0CB\"></span><span class=\"c-F5DEB3\"></span><span class=\"c-FFFACD\"></span><span class=\"c-98FB98\"></span><span class=\"c-AFEEEE\"></span><span class=\"c-ADD8E6\"></span><span class=\"c-DDA0DD\"></span>
					</div>
				</a>";
	$_affix	= "<div class=\"upload-btn\" title=\"".L('nc_upload_image_affix')."\">
					<span><i class=\"upload-img\"></i>
						<div class=\"upload-button\">".L('nc_upload_affix')."</div>
					</span>
					<input type=\"file\" name=\"test_file\" id=\"test_file\" multiple=\"multiple\"  file_id=\"0\" class=\"upload-file\" size=\"1\" hidefocus=\"true\" maxlength=\"0\" style=\"cursor: pointer;\" />
					<input id=\"submit_button\" style=\"display:none\" type=\"button\" value=\"&nbsp;\" onClick=\"submit_form($(this))\" />
				</div>";
	$_url	= "<a href=\"javascript:void(0);\" nctype=\"url\" title=\"".L('nc_insert_link_address')."\" class=\"mr5 url-handle\"><i class=\"url\"></i>".L('nc_line')."
					<div class=\"ubb-layer url-layer\" style=\"display: none;\">
						<div class=\"arrow\"></div>
						<label>".L('nc_link_content')."</label>
						<input name=\"content\" type=\"text\" class=\"text w180\" />
						<label>".L('nc_link_address')."</label>
						<input name=\"url\" type=\"text\" class=\"text w180\" placeholder=\"http://\" />
						<input name=\"".L('nc_submit')."\" type=\"submit\" class=\"button\" value=\"".L('nc_submit')."\"/>
					</div>
				</a>";
	$_flash	= "<a href=\"javascript:void(0);\" nctype=\"flase\" title=\"".L('nc_video_address')."\" class=\"mr5 flash-handle\"><i class=\"flash\"></i>".L('nc_video')."
					<div class=\"ubb-layer flash-layer\" style=\"display: none;\">
						<div class=\"arrow\"></div>
						<label>".L('nc_video_address')."</label>
						<input name=\"flash\" type=\"text\" class=\"text w180\" placeholder=\"http://\" />
						<input name=\"".L('nc_submit')."\" type=\"submit\" class=\"button\" value=\"".L('nc_submit')."\"/>
					</div>
				</a>";
	$_image	= "<a href=\"javascript:void(0);\" nctype=\"uploadImage\" title=\"".L('nc_insert_network_image')."\" class=\"mr5\"><i class=\"url-img\"></i>".L('nc_image')."</a>";
	$_smilier	= "<a href=\"javascript:void(0);\" nctype=\"smilier\" title=\"".L('nc_insert_smilier')."\" class=\"smilier-handle\"><i class=\"smilier\"></i>".L('nc_smilier')."
						<div class=\"ubb-layer smilier-layer\">
							<div class=\"arrow\"></div>
							<span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_aini.png\" data-param=\"d_aini\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_baibai.png\" data-param=\"d_baibai\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_beishang.png\" data-param=\"d_beishang\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_bishi.png\" data-param=\"d_bishi\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_bizui.png\" data-param=\"d_bizui\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_chanzui.png\" data-param=\"d_chanzui\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_chijing.png\" data-param=\"d_chijing\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_dahaqi.png\" data-param=\"d_dahaqi\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_dalian.png\" data-param=\"d_dalian\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_ding.png\" data-param=\"d_ding\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_ganmao.png\" data-param=\"d_ganmao\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_guzhang.png\" data-param=\"d_guzhang\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_haha.png\" data-param=\"d_haha\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_haixiu.png\" data-param=\"d_haixiu\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_han.png\" data-param=\"d_han\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_hehe.png\" data-param=\"d_hehe\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_heixian.png\" data-param=\"d_heixian\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_heng.png\" data-param=\"d_heng\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_huaxin.png\" data-param=\"d_huaxin\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_jiyan.png\" data-param=\"d_jiyan\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_keai.png\" data-param=\"d_keai\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_kelian.png\" data-param=\"d_kelian\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_ku.png\" data-param=\"d_ku\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_kun.png\" data-param=\"d_kun\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_landelini.png\" data-param=\"d_landelini\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_lei.png\" data-param=\"d_lei\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_nu.png\" data-param=\"d_nu\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_numa.png\" data-param=\"d_numa\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_qian.png\" data-param=\"d_qian\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_qinqin.png\" data-param=\"d_qinqin\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_shayan.png\" data-param=\"d_shayan\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_shengbing.png\" data-param=\"d_shengbing\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_shiwang.png\" data-param=\"d_shiwang\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_shuai.png\" data-param=\"d_shuai\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_shuijiao.png\" data-param=\"d_shuijiao\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_sikao.png\" data-param=\"d_sikao\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_taikaixin.png\" data-param=\"d_taikaixin\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_touxiao.png\" data-param=\"d_touxiao\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_tu.png\" data-param=\"d_tu\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_wabishi.png\" data-param=\"d_wabishi\"></span><span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_weiqu.png\" data-param=\"d_weiqu\"></span><span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_xiaoku.png\" data-param=\"d_xiaoku\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_xixi.png\" data-param=\"d_xixi\"></span><span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_xu.png\" data-param=\"d_xu\"></span><span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_yinxian.png\" data-param=\"d_yinxian\"></span><span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_yiwen.png\" data-param=\"d_yiwen\"></span><span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_youhengheng.png\" data-param=\"d_youhengheng\"></span><span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_yun.png\" data-param=\"d_yun\"></span><span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_zhuakuang.png\" data-param=\"d_zhuakuang\"></span> <span><img src=\"".CIRCLE_TEMPLATES_URL."/images/smilier/d_zuohengheng.png\" data-param=\"d_zuohengheng\"></span>
						</div>
					</a>";
	$_highReply= "<a href=\"javascript:void(0);\" nctype=\"highReply\" class=\"high-reply\"><i class=\"high\"></i>".L('nc_advanced_reply')."</a>";
	
	// Spell the editor contents
	$__content = '';
	$__content .= "<div class=\"content\">
			<div class=\"ubb-bar\">";
	foreach ($items as $val){
		$val = '_'.$val;
		$__content .= $$val;
	}
	$__content .= "</div>
			<div class=\"textarea\">
				<textarea id=\"".$cname."\" name=\"".$cname."\">".$content."</textarea>
			</div>
			<div class=\"smilier\"></div>
		</div>";
	
	
	// The attachment part
	$__affix = '';
	$__affix .= "<div class=\"affix\">
	          <h3><i></i>".L('nc_relevance_adjunct')."</h3>
	          <div class=\"help\" nctype=\"affix\" ".(empty($affix)?"":"style=\"display: none;\"").">
	            <p>".L('nc_relevance_adjunct_help_one')."</p>
	            <p>".L('nc_relevance_adjunct_help_two')."</p>
	          </div>
	          <div id=\"scrollbar\">
	          <ul>";
	if(!empty($affix)){
		foreach($affix as $val){
			$__affix .=  "<li>
	              <p><img src=\"".themeImageUrl($val['affix_filethumb'])."\"> </p>
	              <div class=\"handle\"> <a data-param=\"".themeImageUrl($val['affix_filename'])."\" nctype=\"affix_insert\" href=\"javascript:void(0);\"><i class=\"c\"></i>".L('nc_insert')."</a> <a data-param=\"".$val['affix_id']."\" nctype=\"affix_delete\" href=\"javascript:void(0);\"><i class=\"d\"></i>".L('nc_delete')."</a> </div>
	            </li>";
		}
	}
	$__affix .= "</ul>
	          </div>
	        </div>";
	
	$__maffix = str_replace("nctype=\"affix_delete\"", "nctype=\"maffix_delete\"", $__affix);
	
	// After insert part of goods
	$__goods = '';
	$__goods .= "<div class=\"insert-goods\" ".(empty($goods)?"style=\"display:none;\"":"").">
	          <h3><i></i>".L('nc_select_insert_goods,nc_colon')."</h3>";
	if(!empty($goods)){
		foreach($goods as $val){
	    	$__goods .= "<dl>
	            <dt class=\"goods-name\">".$val['goods_name']."</dt>
	            <dd class=\"goods-pic\"><a href=\"javascript:void(0);\"><img src=\"".$val['image']."\"></a></dd>
	            <dd class=\"goods-price\"><em>".$val['goods_price']."</em></dd>
	            <dd class=\"goods-del\">".L('nc_delete')."</dd>
	            <input type=\"hidden\" value=\"".$val['goods_id']."\" name=\"".$gname."[".$val['themegoods_id']."][id]\">
	            <input type=\"hidden\" value=\"".$val['goods_name']."\" name=\"".$gname."[".$val['themegoods_id']."][name]\">
	            <input type=\"hidden\" value=\"".$val['goods_price']."\" name=\"".$gname."[".$val['themegoods_id']."][price]\">
	            <input type=\"hidden\" value=\"".$val['goods_image']."\" name=\"".$gname."[".$val['themegoods_id']."][image]\">
	            <input type=\"hidden\" value=\"".$val['store_id']."\" name=\"".$gname."[".$val['themegoods_id']."][storeid]\">
	            <input type=\"hidden\" value=\"".$val['thg_type']."\" name=\"".$gname."[".$val['themegoods_id']."][type]\">
	            <input type=\"hidden\" value=\"".$val['thg_url']."\" name=\"".$gname."[".$val['themegoods_id']."][uri]\">
	          </dl>";
		}
	}
	$__goods .= "</div>";
	
	// Part read permissions
	$__readperm = '';
	if(!empty($readperm)){
		$__readperm .= "<div class=\"readperm\"><span>".L('nc_read_perm,nc_colon')."</span><span><select name=\"readperm\">";
		foreach($readperm as $key=>$val){
			$__readperm .= "<option value=\"".$key."\" ".(($rpvalue == $key)?"selected=\"selected\"":"").">".$val."&nbsp;lv".$key."</option>";
		}
		$__readperm .= "</select></span></div>";
	}
	
	eval('$return = '.$return.';');
	return $return;
}


/**
 * Recently two voters
 */
function recentlyTwoVoters($str){
	$str = explode(' ', $str, 3);
	$rs = '';
	if(isset($str[0]) && !empty($str[0])) $rs .= $str[0];
	if(isset($str[1]) && !empty($str[1])) $rs .= ', '.$str[1];
	return $rs;
}

/**
 * member rank html
 */
function memberLevelHtml($param){
	return "<div class=\"member-rank member-rank-".$param['cm_level']."\" title=\"".L('circle_level_introduction_page')."\"><a href=\"".CIRCLE_SITE_URL."/index.php?act=group&op=level_intr&c_id=".$param['circle_id']."\" target=\"_blank\">".($param['cm_levelname'] == ''?L('circle_violation'):$param['cm_levelname'])."</a><i></i><em>".$param['cm_level']."</em></div>";
}
/**
 * 文本过滤
 * @param $param string $subject
 * @return string
 */
function circleCenterCensor($subject){
	$replacement = '***';
	if(C('circle_wordfilter') == '') return $subject;
	$find = explode(',', C('circle_wordfilter'));
	foreach ($find as $val){
		if(preg_match('/^\/(.+?)\/$/', $val, $a)){
			$subject = preg_replace($val, $replacement, $subject);
		}else{
			$val = preg_replace("/\\\{(\d+)\\\}/", ".{0,\\1}", preg_quote($val, '/'));
			$subject = preg_replace("/".$val."/", $replacement, $subject);
		}
	}
	return $subject;
}