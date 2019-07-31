<?php

Use Phalcon\Loader;
Use Phalcon\Di\FactoryDefault;
Use Phalcon\Mvc\View;
Use Phalcon\Mvc\Url as UrlProvider;
Use Phalcon\Mvc\Application;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Cache\Frontend\Data as FrontendData;
use Phalcon\Cache\Backend\Redis as BackendRedis;
use Phalcon\Mvc\Dispatcher as MvcDisPatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventManager;

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
//注册命名空间
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

//注册模型缓存服务
$di->set('modelsCache', function () {
    $frontCache = new FrontendData(['lifetime' => 30]);
    $backendCache = new BackendRedis($frontCache, ["host" => 'localhost', "port" => 6379, 'auth' => 123456]);
    return $backendCache;
});

//注册分发并为其绑定一个事件监听器
$di->set('dispatcher', function () {
    $eventsManager = new EventManager();
    $eventsManager->attach('dispatch', function (Event $event, $dispatcher) {
        //
    });
    $dispatcher = new MvcDisPatcher();
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
}, true);

//实例化app
$application = new Application($di);

try {
    // Handle the request
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}


