<?php

namespace Helper;

class Data
{
    public static function tree($list, $pid = 0, $id_str = 'id', $pid_str = 'pid', $children_str = 'children'): array
    {
        $arr = [];
        if (count($list) == 0) {
            return [];
        }
        foreach ($list as $item) {
            if ($item[$pid_str] == $pid) {
                $this_children = self::tree($list, $item[$id_str], $id_str, $pid_str, $children_str);
                $item[$children_str] = $this_children;
                $arr[] = $item;
            }
        }
        return $arr;
    }
}