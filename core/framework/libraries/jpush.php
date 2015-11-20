<?php
/**
 * JPush 封装
 */
defined('InShopNC') or exit('Access Invalid!');
Base::autoload('vendor/autoload');
use JPush\Model as M;
use JPush\JPushClient;
use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;

class JPush
{

    private $app_key;
    private $master_secret;
    private $extras;

    /**
     * 参数初始化
     * @param $appKey
     * @param $appSecret
     * @param string $format
     */
    public function __construct()
    {
        $pushConf = C('push');
        $this->app_key = $pushConf['app_key'];
        $this->master_secret = $pushConf['master_secret'];
    }

    /**
     * 推送消息到所有客户端
     * @param $content
     * @param $title
     * @param $extras
     */
    public function pushMessageToAll($content, $title, $extras)
    {

        $client = new JPushClient($this->app_key, $this->master_secret);
        try {
            $result = $client->push()
                ->setPlatform(M\all)
                ->setAudience(M\all)
                ->setNotification(M\notification(M\android($content, $title, 3, $extras)))
                ->send();
        } catch (APIRequestException $e) {
        } catch (APIConnectionException $e) {
        }
    }


    /**
     * 根据别名推送消息
     * @param $content
     * @param $title
     * @param $extras
     * @param $alias array
     */
    public function pushMessageByAlias($content, $title, $extras, $alias)
    {
        $client = new JPushClient($this->app_key, $this->master_secret);
        try {
            $result = $client->push()
                ->setPlatform(M\all)
                ->setAudience(M\audience(
                    M\alias($alias)))
                ->setNotification(M\notification(M\android($content, $title, 3, $extras)))
                ->send();
        } catch (APIRequestException $e) {
        } catch (APIConnectionException $e) {
        }
    }

    /**
     *
     * 根据Tag推送消息
     * @param $content
     * @param $title
     * @param $extras
     * @param $tags
     */
    public function pushMessageByTags($content, $title, $extras, $tags)
    {
        $client = new JPushClient($this->app_key, $this->master_secret);
        try {
            $result = $client->push()
                ->setPlatform(M\all)
                ->setAudience(M\audience(
                    M\tag($tags)))
                ->setNotification(M\notification(M\android($content, $title, 3, $extras)))
                ->send();
        } catch (APIRequestException $e) {
        } catch (APIConnectionException $e) {
        }
    }
}