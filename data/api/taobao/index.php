<?php
class taobao_item {
	public function __construct(){
        require('TopClient.php');
        require('RequestCheckUtil.php');		
	}
    public function fetch($url) {

        $id = $this->get_id($url);
        if (empty($id)) {
            return false;
        }
        $tb_top = new TopClient;
        $tb_top->appkey = C('taobao_app_key');
        $tb_top->secretKey = C('taobao_secret_key');
        $req = $this->load_api('ItemGetRequest');
        $req->setFields('detail_url,title,pic_url,price,item_img');
        $req->setNumIid($id);
        $resp = $tb_top->execute($req);
        if (!isset($resp->item)) {
            return false;
        }
        $item = (array) $resp->item;
        return $item;
    }

    public function get_id($url) {
        $id = 0;
        $parse = parse_url($url);
        if (isset($parse['query'])) {
            parse_str($parse['query'], $params);
            if (isset($params['id'])) {
                $id = $params['id'];
            } elseif (isset($params['item_id'])) {
                $id = $params['item_id'];
            } elseif (isset($params['default_item_id'])) {
                $id = $params['default_item_id'];
            }
        }
        return $id;
    }

	public function load_api($api_name)	{
		require_once('request/'.$api_name.'.php');
		return new $api_name;
	}
}
