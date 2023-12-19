<?php

namespace Helper;

class Data
{
    /** 生成树形结构列表
     * @param $list
     * @param $pid
     * @param $id_str
     * @param $pid_str
     * @param $children_str
     * @return array
     */
    public static function tree($list, $pid = 0, $id_str = 'id', $pid_str = 'pid', $children_str = 'children')
    {
        $arr = [];
        foreach ($list as $item) {
            if ($item[$pid_str] == $pid) {
                $item[$children_str] = self::tree($list, $item[$id_str], $id_str, $pid_str, $children_str);
                $arr[] = $item;
            }
        }
        return $arr;
    }

    /** 获取所有父类
     * @param $list
     * @param $current_id 当前id
     * @param $id_str
     * @param $pid_str
     * @param $with_current_id
     * @return array
     */
    public static function parents($list, $current_id, $id_str = 'id', $pid_str = 'pid', $with_current_id = false)
    {
        $arr = [];
        foreach ($list as $v) {
            if ($v[$pid_str] > 0 && $v[$id_str] == $current_id) {
                $arr[] = $v[$pid_str];
                $arr = array_merge($arr, self::parents($list, $v[$pid_str], $id_str, $pid_str));
            }
        }
        return $with_current_id ? array_merge([$current_id], $arr) : $arr;
    }

    /** 获取所有子类
     * @param $list
     * @param $current_id 当前id
     * @param $id_str
     * @param $pid_str
     * @param $with_current_id 是否包含当前id
     * @return array
     */
    public static function sons($list, $current_id = 0, $id_str = 'id', $pid_str = 'pid', $with_current_id = false)
    {
        $arr = array();
        foreach ($list as $v) {
            if ($v[$pid_str] == $current_id) {
                $arr[] = $v[$id_str];
                $arr = array_merge($arr, self::sons($list, $v[$id_str], $id_str, $pid_str));
            }
        }
        return $with_current_id ? array_merge([$current_id], $arr) : $arr;
    }
}