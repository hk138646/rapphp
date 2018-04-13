<?php

/**
 * 格式化输出 json 调试用
 * @param $value
 */

/**
 * 重定向
 * @param $url
 * @return string
 */
function redirect($url){
    return 'redirect:'.$url;
}

function body($body){
    return 'body:'.$body;
}

function cache($key,$value = '',$expire=0){
    if($value==''){
        return  \rap\cache\Cache::getCache()->get($key,'');
    }elseif (is_null($value)) {
        // 删除缓存
        return \rap\cache\Cache::getCache()->remove($key);
    }else{
        return  \rap\cache\Cache::getCache()->set($key,$value,$expire);
    }
}

function exception($msg,$code){
    throw new \rap\exception\MsgException($msg,$code);
}








