<?php
/**
 * 积分及积分日志管理
 *
 *
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');

class points2Model extends Model
{

    public function __construct()
    {
        parent::__construct('points');
    }

    /**
     * 积分日志列表
     *
     * @param array $condition 条件数组
     * @param array $page 分页
     * @param array $field 查询字段
     * @param array $page 分页
     */
    public function getPointsLogList($condition, $page = 0, $field = '*')
    {
        return $this->table('points_log')->where($condition)->field($field)->page($page)->order('pl_id desc')->select();
    }

    /**
     * 积分日志详细信息
     *
     * @param array $condition 条件数组
     * @param array $field 查询字段
     */
    public function getPointsInfo($condition, $field = '*')
    {
        //得到条件语句
        $condition_str = $this->getCondition($condition);
        $array = array();
        $array['table'] = 'points_log';
        $array['where'] = $condition_str;
        $array['field'] = $field;
        $list = Db::select($array);
        return $list[0];
    }

    /**
     * 将条件数组组合为SQL语句的条件部分
     *
     * @param    array $condition_array
     * @return    string
     */
    private function getCondition($condition_array)
    {
        $condition_sql = '';
        //积分日志会员编号
        if ($condition_array['pl_memberid']) {
            $condition_sql .= " and `points_log`.pl_memberid = '{$condition_array['pl_memberid']}'";
        }
        //操作阶段
        if ($condition_array['pl_stage']) {
            $condition_sql .= " and `points_log`.pl_stage = '{$condition_array['pl_stage']}'";
        }
        //会员名称
        if ($condition_array['pl_membername_like']) {
            $condition_sql .= " and `points_log`.pl_membername like '%{$condition_array['pl_membername_like']}%'";
        }
        //管理员名称
        if ($condition_array['pl_adminname_like']) {
            $condition_sql .= " and `points_log`.pl_adminname like '%{$condition_array['pl_adminname_like']}%'";
        }
        //添加时间
        if ($condition_array['saddtime']) {
            $condition_sql .= " and `points_log`.pl_addtime >= '{$condition_array['saddtime']}'";
        }
        if ($condition_array['eaddtime']) {
            $condition_sql .= " and `points_log`.pl_addtime <= '{$condition_array['eaddtime']}'";
        }
        //描述
        if ($condition_array['pl_desc_like']) {
            $condition_sql .= " and `points_log`.pl_desc like '%{$condition_array['pl_desc_like']}%'";
        }
        return $condition_sql;
    }
}
