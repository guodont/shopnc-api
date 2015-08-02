<?php
/**
 * 任务计划 - 邮件发动送
 *
 * 建议10分钟触发一次
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class mailControl {
    private $_num = 50; // 每次发送消息数量
    /**
     * 初始化对象
     */
    public function __construct(){
        register_shutdown_function(array($this,"shutdown"));
    }

    /**
     * 发送消息
     */
    public function indexOp() {
        $model_storemsgcron = Model('mail_cron');
        $cron_array = $model_storemsgcron->getMailCronList(array(), $this->_num);
        if (!empty($cron_array)) {
            $email = new Email();
            $mail_array = array();
            foreach ($cron_array as $val) {
                $return = $email->send_sys_email($val['mail'],$val['subject'],$val['contnet']);
                if ($return) {
                    // 记录需要删除的id
                    $mail_array[] = $val['mail_id'];
                }
            }
            // 删除已发送的记录
            $model_storemsgcron->delMailCron(array('mail_id' => array('in', $mail_array)));
        }
    }

    /**
     * 执行完成提示信息
     *
     */
    public function shutdown(){
        exit("success at ".date('Y-m-d H:i:s',TIMESTAMP)."\n");
    }
}