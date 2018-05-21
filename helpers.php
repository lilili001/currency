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
//获取当前货币code : USD
function getCurrentCurrency(){
    return   json_decode( setting('currency::current-currency') )[0];
}