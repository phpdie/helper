<?php

namespace Helper;

class Data
{
    public static function tree($list, $pid = 0, $id = 'id', $pid_str = 'pid', $children = 'children')
    {
        $arr = [];
        if (count($list) == 0) {
            return [];
        }
        foreach ($list as $item) {
            if ($item[$pid_str] == $pid) {
                $this_children = self::tree($list, $item[$id], $id, $pid_str, $children);
                $item[$children] = $this_children;
                $arr[] = $item;
            }
        }
        return $arr;
    }
}