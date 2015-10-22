<?php
/**
 * 交易（闲置）api
 * Created by PhpStorm.
 * User: guodont
 * Date: 15-8-4
 * Time: 上午11:02
 */

defined('InShopNC') or exit('Access Invalid!');

class trade_opControl extends apiMemberControl
{

    private $member_id;

    public function __construct()
    {
        parent::__construct();
        $this->member_id = $this->member_info['member_id'];
    }

    /**
     * POST 发布一个交易
     */
    public function createTradeOp()
    {
        /**
         * 清除前一天冗余图片数据
         */
        $model_upload = Model('flea_upload');
        $upload_array = array();
        $upload_array['store_id'] = $this->member_info['member_id'];
        $upload_array['upload_type'] = '12';
        $upload_array['item_id'] = '0';
        $upload_array['upload_time_lt'] = time() - 24 * 60 * 60;
        $model_upload->delByWhere($upload_array);
        unset($upload_array);

        if (isset($_POST)) {
            /**
             * 验证表单
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input" => $_POST["goods_name"], "require" => "true", "message" => "名称不符合要求"),
                array("input" => $_POST["goods_price"], "require" => "true", "validator" => "Double", "message" => "价格不符合要求")
            );
            $error = $obj_validate->validate();
            if ($error != '') {
                output_error($error);
            }
            /**
             * 实例化店铺商品模型
             */
            $model_store_goods = Model('flea');

            $goods_array = array();
            $goods_array['goods_name'] = $_POST['goods_name'];
            $goods_array['gc_id'] = $_POST['cate_id'];
            $goods_array['gc_name'] = $_POST['cate_name'];
            $goods_array['flea_quality'] = $_POST['sh_quality'];
            $goods_array['flea_pname'] = $_POST['flea_pname'];
            $goods_array['flea_area_id'] = $_POST['area_id'];
            $goods_array['flea_area_name'] = $_POST['area_info'];
            $goods_array['flea_pphone'] = $_POST['flea_pphone'];
            $goods_array['goods_tag'] = $_POST['goods_tag'];
            $goods_array['goods_leixing'] = $_POST['goods_type'];
            $goods_array['goods_price'] = $_POST['goods_price'];
            $goods_array['goods_store_price'] = $_POST['price'][0] != '' ? $_POST['price'][0] : $_POST['goods_store_price'];
            $goods_array['goods_show'] = '1';
            $goods_array['goods_status'] = '0';
            $goods_array['goods_commend'] = $_POST['goods_commend'];
            $goods_array['goods_body'] = $_POST['g_body'];
            $goods_array['goods_keywords'] = $_POST['seo_keywords'];
            $goods_array['goods_description'] = $_POST['seo_description'];
            $state = $model_store_goods->saveGoods($goods_array);
            if ($state) {
                /**
                 * 更新闲置物品多图
                 */
                $upload_array = array();
                $upload_array['store_id'] = $_SESSION['member_id'];
                $upload_array['item_id'] = '0';
                $upload_array['upload_type_in'] = "'12','13'";
                $upload_array['upload_id_in'] = "'" . implode("','", $_POST['goods_file_id']) . "'";
                $model_upload->updatebywhere(array('item_id' => $state), $upload_array);
                /**
                 * 商品封面图片修改
                 */
                if (!empty($_POST['goods_file_id'][0])) {
                    $image_info = $model_store_goods->getListImageGoods(array('upload_id' => intval($_POST['goods_file_id'][0])));
                    $goods_image = $image_info[0]['file_thumb'];
                    $model_store_goods->updateGoods(array('goods_image' => $goods_image), $state);
                }
                output_data(array("ok" => "创建成功，等待审核"));
            } else {
                output_error("创建失败");
            }
        }
    }

    /**
     * POST 删除闲置物品
     */
    public function deleteTradeOp()
    {
        $where = array();
        $where['goods_id'] = intval($_POST['goods_id']);
        $where['member_id'] = $this->member_info['member_id'];
        if (!empty($_POST['goods_id'])) {
            Model()->table('flea')->where($where)->delete();
            output_data("操作成功");
        } else {
            output_error("操作失败");
        }
    }

    /**
     * POST 收藏交易
     */
    public function favTradeOp()
    {
        /**
         * 读取语言包
         */
        $lang = Language::getLangContent('UTF-8');
        if (intval($_GET['fav_id']) > 0) {
            /**
             * 实例化模型
             */
            $favorites_class = Model('flea_favorites');
            //判断商品,店铺是否为当前会员
            $model_flea = Model('flea');
            $flea_info = $model_flea->listGoods(array(
                'goods_id' => intval($_GET['fav_id'])
            ));
            if ($flea_info[0]['member_id'] == $this->member_id) {
                output_error($lang['flea_favorite_no_my_product']);
                die;
            }

            //闲置物品收藏次数增加1
            $check_rss = $favorites_class->checkFavorites(intval($_GET['fav_id']), 'flea', $this->member_id);
            if (!$check_rss) {
                $condition['flea_collect_num']['value'] = 1;
                $condition['flea_collect_num']['sign'] = 'increase';
                $flea_info = $model_flea->updateGoods($condition, $_GET['fav_id']);
                $add_rs = $favorites_class->addFavorites(array('member_id' => $this->member_id, 'fav_id' => intval($_GET['fav_id']), 'fav_type' => 'flea', 'fav_time' => time()));
                if (!$add_rs) {
                    output_error("收藏失败");
                }
            }
            output_data(array("ok" => "收藏成功"));
        } else {
            output_error("收藏失败");
        }
    }

    /**
     * POST 取消收藏
     */
    public function canelFavTradeOp()
    {
        if (intval($_GET['fav_id']) > 0) {
            $favorites_class = Model('flea_favorites');
            if (!$favorites_class->delFavorites(intval($_GET['fav_id']), 'flea')) {
                output_error("取消失败");
                die;
            }
        }
        output_data(array("ok" => "取消成功"));
    }

    /**
     * GET 收藏状态
     * fav_id
     */
    public function isFav()
    {
        if (intval($_GET['fav_id']) > 0) {
            $mTrade = Model('flea_favorites');
            $status = $mTrade->checkFavorites($_GET['fav_id'],'flea',$this->member_id);
            if($status) {
                echo 1;
            }else {
                echo 0;
            }
        }
    }
}