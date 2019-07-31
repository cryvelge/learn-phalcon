<?php

Use Phalcon\Loader;
Use Phalcon\Di\FactoryDefault;
Use Phalcon\Mvc\View;
Use Phalcon\Mvc\Url as UrlProvider;
Use Phalcon\Mvc\Application;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Session\Adapter\Files as Session;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH.'/app');

$loader = new Loader();

//注册controllers和models目录
$loader->registerDirs(
    [
        APP_PATH.'/controllers',
        APP_PATH.'/models',
        APP_PATH.'/test',
    ]
);
$loader->registerNamespaces([
    'app\test' => APP_PATH.'/test/'
]);

$loader->register();

//创建DI
$di = new FactoryDefault;

//注册一个view服务
$di->set('view', function () {
    $view = new View();
    $view->setViewsDir(APP_PATH.'/views/');
    return $view;
});

$di->set('test', function () {
    $test = new \app\test\Test();

    return $test;
});

//注册一个base uri
$di->set('url', function () {
    $url = new UrlProvider;
    $url->setBaseUri('/myphalcon/'); //这里生成的url会在站点的根目录后面加上/myphalcon/...
    return $url;
});

//注册一个数据库服务
$di->set('db', function () {
    return new DbAdapter([
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'root',
        'dbname' => 'test',
    ]);
});

//启动session
$di->set('session', function () {
    $session = new Session();
    $session->start();
    return $session;
});

//实例化app
$application = new Application($di);

try {
    // Handle the request
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}


