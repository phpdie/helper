<?php

namespace Helper;

class Data
{
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

    public static function parents($list, $current_id = 0, $id_str = 'id', $pid_str = 'pid', $with_current_id = false)
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