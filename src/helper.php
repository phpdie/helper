<?php

if (!function_exists('_array_column')) {
    //与array_column的区别是,键名相同时会以数组的形式返回多个值,而不是一个
    function _array_column(array $array, $column_key = null, $index_key = null): array
    {
        $return = [];
        if (is_null($index_key)) {
            $index_key = $column_key;
            $column_key = null;
        }

        $column = $column_key ? explode(',', $column_key) : [];

        foreach ($array as $val) {
            if ($index_key && isset($val[$index_key])) {
                if ($column) {
                    foreach ($column as $col) {
                        if (isset($val[$col])) {
                            $return[$val[$index_key]][][$col] = $val[$col];
                        }
                    }
                } else {
                    $return[$val[$index_key]][] = $val;
                }
            }
        }
        return $return;
    }
}

if (!function_exists('_empty')) {
    //与empty的区别是,不把0或者'0'当成是空
    function _empty($val): bool
    {
        return !is_numeric($val) && empty($val);
    }
}