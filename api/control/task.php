<?php
/**
 * Created by PhpStorm.
 * User: guodont
 * Date: 15/9/8
 * Time: 下午3:12
 */
defined('InShopNC') or exit('Access Invalid!');
class taskControl extends taskMemberControl{

    public function __construct(){
        parent::__construct();
    }

    /**
     * GET 用户任务列表
     * type 任务类型 1:未完成 3:已完成 4:回收站 默认:所有任务（完成／未完成）
     * date 创建日期
     */
    public function tasksOp(){
        $condition = array();
        //判断类型
        if(!empty($_GET['type'])){
            $condition['article_state'] = $_GET['type'];
        }else{
            $condition['article_state'] = array('in',array(self::TASK_STATE_FINISHED, self::TASK_STATE_DRAFT)) ;
        }

        //构造日期条件
        if(!empty($_GET['date'])){
            $date = intval($_GET['date']);
            $start = mktime(0,0,0,date("m",$date),date("d",$date),date("Y",$date));
            $end = mktime(23,59,59,date("m",$date),date("d",$date),date("Y",$date));
            $condition['article_publish_time'] = array('egt',$start,'elt',$end);
        }

//        var_dump($condition);
        $this->get_task_list($condition);
    }

    /**
     * POST 添加一条任务
     */
    public function createTaskOp(){
        $this->saveTask();
    }

    /**
     * GET 查看任务
     */
    public function taskOp(){
        if(!empty($_GET['task_id'])&&$_GET['task_id']>0){
            $task_id = intval($_GET['task_id']);
            $condition['article_id'] = $task_id;
            $model_task = Model('cms_article');
            $fields = "article_id,article_title,article_content,article_tag,article_state,article_publish_time";
            $task = $model_task->where($condition)->field($fields)->find();
            if(!empty($task)){
                output_data(array('task'=>$task));
            }else{
                output_error("操作失败");
            }
        }else{
            output_error("参数错误");
        }
    }

    /**
     * POST 编辑任务
     */
    public function updateTaskOp(){
        $this->saveTask();
    }

    /**
     * POST 完成一条任务
     */
    public function finishTaskOp(){
        $this->changeTaskStatus(self::TASK_STATE_FINISHED);
    }

    /**
     * POST 删除一条任务
     */
    public function deleteTaskOp(){
        $this->changeTaskStatus(self::TASK_STATE_RECYCLE);
    }

    /**
     * 获得任务列表
     */
    private function get_task_list($condition = array()) {
        if(!empty($_GET['keyword'])) {
            $condition['article_title'] = array('like', '%'.$_GET['keyword'].'%');
        }
        $condition['article_publisher_id'] = $this->member_info['member_id'];
        $model_task = Model('cms_article');
        $page_count = $model_task->gettotalpage();
        $fields = "article_id,article_title,article_content,article_tag,article_state,article_publish_time";
        $task_list = $model_task->getList($condition, $this->page , 'article_id desc' ,$fields);
        if(!empty($task_list)){
            output_data(array('tasks'=>$task_list),mobile_page($page_count));
        }else{
            output_error("没有任务");
        }
    }



    /**
     * 更改任务状态
     */
    public function changeTaskStatus($status){

        if(isset($_POST['task_id'])){
            $task_id = intval($_POST['task_id']);
            $model_task = Model('cms_article');
            $result = $model_task->modify(array('article_state'=>$status),array('article_id'=>$task_id));
            if($result){
                output_data(array('ok'=>"操作成功"));
            }else{
                output_error("操作失败");
            }
        }else{
            output_error("未指定任务id");
        }
    }

    /**
     * 保存任务
     */
    public function saveTask(){
        if(empty($_POST['task_title'])) {
            output_error("标题不能为空");die;
        }
        //插入文章
        $param = array();
        $param['article_title'] = trim($_POST['task_title']);
        $param['article_author'] = $this->member_info['member_name'];
        $param['article_content'] = trim($_POST['task_content']);
        if(empty($_POST['task_id'])) {
            $param['article_publisher_name'] = $this->member_info['member_name'];
            $param['article_publisher_id'] = $this->member_info['member_id'];
            $param['article_sort'] = 255;
        }
        $param['article_commend_flag'] = 0;
        $param['article_tag'] = trim($_POST['task_tag']);

        //发布时间
        if(!empty($_POST['task_publish_time'])) {
            $param['article_publish_time'] = strtotime($_POST['task_publish_time']);
        } else {
            $param['article_publish_time'] = time();
        }
        $param['article_modify_time'] = time();

        //任务状态
        $param['article_state'] = self::TASK_STATE_DRAFT;

        $model_task = Model('cms_article');
        $model_tag_relation = Model('cms_tag_relation');
        if(!empty($_POST['task_id'])) {
            $task_id = intval($_POST['task_id']);
            $task_auth = $this->check_task_auth($task_id);
            if($task_auth) {
                $model_task->modify($param,array('article_id'=>$task_id));
                $model_tag_relation->drop(array('relation_type'=>1,'relation_object_id'=>$task_id));
            } else {
                output_error("操作非法");die;
            }
        } else {
            $task_id = $model_task->save($param);
        }

        //插入文章标签
        if(!empty($_POST['task_tag'])) {
            $tag_list = explode(',', $_POST['task_tag']);
            $param = array();
            $param['relation_type'] = 1;
            $param['relation_object_id'] = $task_id;
            $params = array();
            foreach ($tag_list as $value) {
                $param['relation_tag_id'] = $value;
                $params[] = $param;
            }
            $model_tag_relation->saveAll($params);
        }

        if($task_id) {
            output_data("操作成功");
        } else {
            output_error("操作失败");
        }
    }

    protected function check_task_auth($task_id) {
        if($task_id > 0) {
            $model_task = Model('cms_article');
            $task_detail = $model_task->getOne(array('article_id'=>$task_id));
            if(!empty($task_detail)) {
                if( $task_detail['article_publisher_id'] == $this->member_info['member_id']) {
                    return $task_detail;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
}