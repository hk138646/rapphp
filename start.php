<?php
error_reporting(E_ALL& ~E_NOTICE& ~E_WARNING);
define('RAP_VERSION', '2.0.1beta');
define('DS', DIRECTORY_SEPARATOR);
ini_set("display_errors", "On");

define('APP_DIR', 'app');
defined('ROOT_PATH') or define('ROOT_PATH', getcwd() . DS);
defined('APP_PATH') or define('APP_PATH',ROOT_PATH.APP_DIR.DS);
defined('RUNTIME') or define('RUNTIME', ROOT_PATH ."runtime".DS);

// 环境常量
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);
define('IS_WIN', strpos(PHP_OS, 'WIN') !== false);
define('IS_SWOOLE_HTTP', IS_CLI&&$argv[1]=='http');
$loader = require ROOT_PATH . '/vendor/autoload.php';
$loader->setPsr4(APP_DIR."\\", APP_DIR);
$loader->setPsr4("rap\\aop\\build\\", RUNTIME.'aop');

//swoole 模式
if(IS_CLI){
    if(IS_SWOOLE_HTTP){
        \rap\ioc\Ioc::bind(\rap\web\Application::class,\rap\RapApplication::class);
        \rap\ioc\Ioc::get(\rap\web\Application::class)->console(["index.php",'aop']);
        \rap\ioc\Ioc::clear();
    }
    \rap\ioc\Ioc::bind(\rap\web\Application::class,\rap\RapApplication::class);
    \rap\ioc\Ioc::get(\rap\web\Application::class)->console($argv);
}else{
    //正常模式
    \rap\ioc\Ioc::bind(\rap\web\Application::class,\rap\RapApplication::class);
    $response=new \rap\web\Response();
    $request=new \rap\web\Request($response);
    \rap\ioc\Ioc::get(\rap\web\Application::class)->start($request,$response);
}