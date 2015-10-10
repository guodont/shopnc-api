<?php
/**
 * 系统后台公共方法
 *
 * 包括系统后台父类
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class SystemControl{

	/**
	 * 管理员资料 name id group
	 */
	protected $admin_info;

	/**
	 * 权限内容
	 */
	protected $permission;
	protected function __construct(){
		Language::read('common,layout');
		/**
		 * 验证用户是否登录
		 * $admin_info 管理员资料 name id
		 */
		$this->admin_info = $this->systemLogin();
		if ($this->admin_info['id'] != 1){
			// 验证权限
			$this->checkPermission();
		}
		//转码  防止GBK下用ajax调用时传汉字数据出现乱码
		if (($_GET['branch']!='' || $_GET['op']=='ajax') && strtoupper(CHARSET) == 'GBK'){
			$_GET = Language::getGBK($_GET);
		}
	}

	/**
	 * 取得当前管理员信息
	 *
	 * @param
	 * @return 数组类型的返回结果
	 */
	protected final function getAdminInfo(){
		return $this->admin_info;
	}

	/**
	 * 系统后台登录验证
	 *
	 * @param
	 * @return array 数组类型的返回结果
	 */
	protected final function systemLogin(){
		//取得cookie内容，解密，和系统匹配
		$user = unserialize(decrypt(cookie('sys_key'),MD5_KEY));
		if (!key_exists('gid',(array)$user) || !isset($user['sp']) || (empty($user['name']) || empty($user['id']))){
			@header('Location: index.php?act=login&op=login');exit;
		}else {
			$this->systemSetKey($user);
		}
		return $user;
	}

	/**
	 * 系统后台 会员登录后 将会员验证内容写入对应cookie中
	 *
	 * @param string $name 用户名
	 * @param int $id 用户ID
	 * @return bool 布尔类型的返回结果
	 */
	protected final function systemSetKey($user){
		setNcCookie('sys_key',encrypt(serialize($user),MD5_KEY),3600,'',null);
	}

	/**
	 * 验证当前管理员权限是否可以进行操作
	 *
	 * @param string $link_nav
	 * @return
	 */
	protected final function checkPermission($link_nav = null){
		if ($this->admin_info['sp'] == 1) return true;

		$act = $_GET['act']?$_GET['act']:$_POST['act'];
		$op = $_GET['op']?$_GET['op']:$_POST['op'];
		if (empty($this->permission)){
			$gadmin = Model('gadmin')->getby_gid($this->admin_info['gid']);
			$permission = decrypt($gadmin['limits'],MD5_KEY.md5($gadmin['gname']));
			$this->permission = $permission = explode('|',$permission);
		}else{
			$permission = $this->permission;
		}
		//显示隐藏小导航，成功与否都直接返回
		if (is_array($link_nav)){
			if (!in_array("{$link_nav['act']}.{$link_nav['op']}",$permission) && !in_array($link_nav['act'],$permission)){
				return false;
			}else{
				return true;
			}
		}

		//以下几项不需要验证
		$tmp = array('index','dashboard','login','common','cms_base');
		if (in_array($act,$tmp)) return true;
		if (in_array($act,$permission) || in_array("$act.$op",$permission)){
			return true;
		}else{
			$extlimit = array('ajax','export_step1');
			if (in_array($op,$extlimit) && (in_array($act,$permission) || strpos(serialize($permission),'"'.$act.'.'))){
				return true;
			}
			//带前缀的都通过
			foreach ($permission as $v) {
				if (!empty($v) && strpos("$act.$op",$v.'_') !== false) {
					return true;break;
				}
			}
		}
		showMessage(Language::get('nc_assign_right'),'','html','succ',0);
	}

	/**
	 * 取得后台菜单
	 *
	 * @param string $permission
	 * @return
	 */
	protected final function getNav($permission = '',&$top_nav,&$left_nav,&$map_nav){

		$act = $_GET['act']?$_GET['act']:$_POST['act'];
		$op = $_GET['op']?$_GET['op']:$_POST['op'];
		if ($this->admin_info['sp'] != 1 && empty($this->permission)){
			$gadmin = Model('gadmin')->getby_gid($this->admin_info['gid']);
			$permission = decrypt($gadmin['limits'],MD5_KEY.md5($gadmin['gname']));
			$this->permission = $permission = explode('|',$permission);
		}
		Language::read('common');
		$lang = Language::getLangContent();
		$array = require(BASE_PATH.'/include/menu.php');
		$array = $this->parseMenu($array);
		//管理地图
		$map_nav = $array['left'];
		unset($map_nav[0]);

		$model_nav = "<li><a class=\"link actived\" id=\"nav__nav_\" href=\"javascript:;\" onclick=\"openItem('_args_');\"><span>_text_</span></a></li>\n";
		$top_nav = '';

		//顶部菜单
		foreach ($array['top'] as $k=>$v) {
			$v['nav'] = $v['args'];
			$top_nav .= str_ireplace(array('_args_','_text_','_nav_'),$v,$model_nav);
		}
		$top_nav = str_ireplace("\n<li><a class=\"link actived\"","\n<li><a class=\"link\"",$top_nav);

		//左侧菜单
		$model_nav = "
          <ul id=\"sort__nav_\">
            <li>
              <dl>
                <dd>
                  <ol>
                    list_body
                  </ol>
                </dd>
              </dl>
            </li>
          </ul>\n";
		$left_nav = '';
		foreach ($array['left'] as $k=>$v) {
			$left_nav .= str_ireplace(array('_nav_'),array($v['nav']),$model_nav);
			$model_list = "<li nc_type='_pkey_'><a href=\"JavaScript:void(0);\" name=\"item__opact_\" id=\"item__opact_\" onclick=\"openItem('_args_');\">_text_</a></li>";
			$tmp_list = '';

			$current_parent = '';//当前父级key

			foreach ($v['list'] as $key=>$value) {
				$model_list_parent = '';
				$args = explode(',',$value['args']);
				if ($admin_array['admin_is_super'] != 1){
					if (!@in_array($args[1],$permission)){
						//continue;
					}
				}

				if (!empty($value['parent'])){
					if (empty($current_parent) || $current_parent != $value['parent']){
						$model_list_parent = "<li nc_type='parentli' dataparam='{$value['parent']}'><dt>{$value['parenttext']}</dt><dd style='display:block;'></dd></li>";
					}
					$current_parent = $value['parent'];
				}

				$value['op'] = $args[0];
				$value['act'] = $args[1];
				//$tmp_list .= str_ireplace(array('_args_','_text_','_op_'),$value,$model_list);
				$tmp_list .= str_ireplace(array('_args_','_text_','_opact_','_pkey_'),array($value['args'],$value['text'],$value['op'].$value['act'],$value['parent']),$model_list_parent.$model_list);
			}

			$left_nav = str_replace('list_body',$tmp_list,$left_nav);

		}
	}

	/**
	 * 过滤掉无权查看的菜单
	 *
	 * @param array $menu
	 * @return array
	 */
	private final function parseMenu($menu = array()){
		if ($this->admin_info['sp'] == 1) return $menu;
		foreach ($menu['left'] as $k=>$v) {
			foreach ($v['list'] as $xk=>$xv) {
				$tmp = explode(',',$xv['args']);
				//以下几项不需要验证
				$except = array('index','dashboard','login','common');
				if (in_array($tmp[1],$except)) continue;
				if (!in_array($tmp[1],$this->permission) && !in_array($tmp[1].'.'.$tmp[0],$this->permission)){
					unset($menu['left'][$k]['list'][$xk]);
				}
			}
			if (empty($menu['left'][$k]['list'])) {
				unset($menu['top'][$k]);unset($menu['left'][$k]);
			}
		}
		return $menu;
	}

	/**
	 * 取得顶部小导航
	 *
	 * @param array $links
	 * @param 当前页 $actived
	 */
	protected final function sublink($links = array(), $actived = '', $file='index.php'){
		$linkstr = '';
		foreach ($links as $k=>$v) {
			parse_str($v['url'],$array);
			if (!$this->checkPermission($array)) continue;
			$href = ($array['op'] == $actived ? null : "href=\"{$file}?{$v['url']}\"");
			$class = ($array['op'] == $actived ? "class=\"current\"" : null);
			$lang = L($v['lang']);
			$linkstr .= sprintf('<li><a %s %s><span>%s</span></a></li>',$href,$class,$lang);
		}
		return "<ul class=\"tab-base\">{$linkstr}</ul>";
	}

	/**
	 * 记录系统日志
	 *
	 * @param $lang 日志语言包
	 * @param $state 1成功0失败null不出现成功失败提示
	 * @param $admin_name
	 * @param $admin_id
	 */
	protected final function log($lang = '', $state = 1, $admin_name = '', $admin_id = 0){
		if (!C('sys_log') || !is_string($lang)) return;
		if ($admin_name == ''){
			$admin = unserialize(decrypt(cookie('sys_key'),MD5_KEY));
			$admin_name = $admin['name'];
			$admin_id = $admin['id'];
		}
		$data = array();
		if (is_null($state)){
			$state = null;
		}else{
//			$state = $state ? L('nc_succ') : L('nc_fail');
			$state = $state ? '' : L('nc_fail');
		}
		$data['content'] 	= $lang.$state;
		$data['admin_name'] = $admin_name;
		$data['createtime'] = TIMESTAMP;
		$data['admin_id'] 	= $admin_id;
		$data['ip']			= getIp();
		$data['url']		= $_REQUEST['act'].'&'.$_REQUEST['op'];
		return Model('admin_log')->insert($data);
	}

	/**
	 * 添加到任务队列
	 *
	 * @param array $goods_array
	 * @param boolean $ifdel 是否删除以原记录
	 */
	protected function addcron($data = array(), $ifdel = false) {
	    $model_cron = Model('cron');
	    if (isset($data[0])) { // 批量插入
	        $where = array();
	        foreach ($data as $k => $v) {
	            if (isset($v['content'])) {
	                $data[$k]['content'] = serialize($v['content']);
	            }
	            // 删除原纪录条件
	            if ($ifdel) {
	                $where[] = '(type = ' . $data['type'] . ' and exeid = ' . $data['exeid'] . ')';
	            }
	        }
	        // 删除原纪录
	        if ($ifdel) {
	            $model_cron->delCron(implode(',', $where));
	        }
	        $model_cron->addCronAll($data);
	    } else { // 单条插入
	        if (isset($data['content'])) {
	            $data['content'] = serialize($data['content']);
	        }
	        // 删除原纪录
	        if ($ifdel) {
                $model_cron->delCron(array('type' => $data['type'], 'exeid' => $data['exeid']));
	        }
	        $model_cron->addCron($data);
	    }
	}
}
