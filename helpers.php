<?php

function arrayChangeKey($arr,$key)
{
    $processedArr = array();
    if(is_array($arr) && !empty($arr)){
        foreach ($arr as $item)
        {
            $processedArr[$item[$key]] = $item;
        }
    }
    return $processedArr;
}