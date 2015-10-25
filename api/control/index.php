<?php
/**
 * cms首页
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */


defined('InShopNC') or exit('Access Invalid!');

class indexControl extends apiHomeControl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 首页
     */
    public function indexOp()
    {
        $model_mb_special = Model('mb_special');
        $data = $model_mb_special->getMbSpecialIndex();
        $this->_output_special($data, $_GET['type']);
    }

    /**
     * 专题
     */
    public function specialOp()
    {
        $model_mb_special = Model('mb_special');
        $data = $model_mb_special->getMbSpecialItemUsableListByID($_GET['special_id']);
        $this->_output_special($data, $_GET['type'], $_GET['special_id']);
    }

    /**
     * 输出专题
     */
    private function _output_special($data, $type = 'json', $special_id = 0)
    {
        $model_special = Model('mb_special');
        if ($_GET['type'] == 'html') {
            $html_path = $model_special->getMbSpecialHtmlPath($special_id);
            if (!is_file($html_path)) {
                ob_start();
                Tpl::output('list', $data);
                Tpl::showpage('mb_special');
                file_put_contents($html_path, ob_get_clean());
            }
            header('Location: ' . $model_special->getMbSpecialHtmlUrl($special_id));
            die;
        } else {
            output_data($data);
        }
    }

    /**
     * android客户端版本号
     */
    public function apk_versionOp()
    {
        $version = C('mobile_apk_version');
        $url = C('mobile_apk');
        $msg = "圈圈有新版本";
//        $msg = C('updateMessage');
        if (empty($version)) {
            $version = '';
        }
        if (empty($url)) {
            $url = '';
        }
        if (empty($msg)) {
            $msg = '';
        }

        json_encode(array('url' => $url,'versionCode' => $version,'updateMessage' =>$msg ));
    }
}
