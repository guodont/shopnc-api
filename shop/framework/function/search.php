<?php
defined('InShopNC') or exit('Access Invalid!');

/**
 * 删除地址参数
 *
 * @param array $param
 */
function dropParam($param) {
    $purl = getParam();
    if (!empty($param)) {
        foreach ($param as $val) {
            $purl['param'][$val]= 0;
        }
    }
    return urlShop($purl['act'], $purl['op'], $purl['param']);
}

/**
 * 替换地址参数
 *
 * @param array $param
 */
function replaceParam($param) {
    $purl = getParam();
    if (!empty($param)) {
        foreach ($param as $key => $val) {
            $purl['param'][$key] = $val;
        }
    }

    return urlShop($purl['act'], $purl['op'], $purl['param']);
}

/**
 * 替换并删除地址参数
 *
 * @param array $param
 */
function replaceAndDropParam($paramToReplace, $paramToDrop) {
    $purl = getParam();
    if (!empty($paramToReplace)) {
        foreach ($paramToReplace as $key => $val) {
            $purl['param'][$key] = $val;
        }
    }
    if (!empty($paramToDrop)) {
        foreach ($paramToDrop as $val) {
            $purl['param'][$val]= 0;
        }
    }

    return urlShop($purl['act'], $purl['op'], $purl['param']);
}

/**
 * 删除部分地址参数
 *
 * @param array $param
 */
function removeParam($param) {
    $purl = getParam();
    if (!empty($param)) {
        foreach ($param as $key => $val) {
            if (!isset($purl['param'][$key])) {
                continue;
            }
            $tpl_params = explode('_', $purl['param'][$key]);
            foreach ($tpl_params as $k=>$v) {
                if ($val == $v) {
                    unset($tpl_params[$k]);
                }
            }
            if (empty($tpl_params)) {
                $purl['param'][$key] = 0;
            } else {
                $purl['param'][$key] = implode('_', $tpl_params);
            }
        }
    }
    return urlShop($purl['act'], $purl['op'], $purl['param']);
}

function getParam() {
    $param = $_GET;
    $purl = array();
    $purl['act'] = $param['act'];
    unset($param['act']);
    $purl['op'] = $param['op'];
    unset($param['op']); unset($param['curpage']);
    $purl['param'] = $param;
    return $purl;
}
