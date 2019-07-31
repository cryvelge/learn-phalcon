<?php

use Phalcon\Mvc\Controller;
use app\test\Test;
use Phalcon\Di;

class IndexController extends Controller
{
    public function initialize()
    {
        $this->session->set('name', 'cry');
        echo 'initialize successfully';
    }

    public function onConstruct()
    {
        echo 'excuted</br>';
    }

    public function indexAction()
    {

        echo '<h1>Hello</h1>'.$this->session->get('name').'<br>';
//        Di::getDefault()->get('test')->show();
          $this->di->get('test')->show();
//        $this->view->users = Users::find("id = 1"); //find方法获取所有数据
        echo '<br>' . Users::findFirstById(1)->email . '<br>';

        $users = Users::find([
            "name like '%大%'",
            'order' => 'id DESC'
            ]);
        foreach ($users as $user) {
            echo  $user->id. '-' .$user->name.'<br>';
        }

        $user = Users::query()
            ->where("name = ':name:'")
            ->bind(['name' => 123])
            ->execute();

        //更新
        $user = Users::findFirst(1);

        echo '更新前:'. $user->name;

        $user->name = 'cry';

        $user->save();

        echo '更新后:' . $user->name;

        //数据库关联测试
        $robots = Robots::findFirst(1);
        //多对多
//        echo $robots->parts->name;

            foreach ($robots->parts as $part) {
                echo "<br>机器名字:{$robots->name}-机器它的部件:{$part->name}";
                echo $part->name;
                echo $robots->name;

        }
    }

    //某个action的钩子 必须叫这个
    public function afterExecuteRoute($dispatcher)
    {
        if ($dispatcher->getActionName() === 'index') {
            echo 'indexAction executed';
        }
    }

    public function testAction()
    {
        $robot = Robots::findFirst("name = '1234'");
        $robot->name = '123';
        $robot->save();
    }

    public function getcacheAction()
    {
        $robot = Robots::findFirst(3);
        $robot_cache = Robots::findFirst([
//            'id = 3' ,
            'cache' => ['key' => 'my-cache', 'lifetime' => 30],
        ]);

        $robot->name = 9529;
        $robot->save();
        echo "未缓存:$robot->name<br>";
        echo "缓存:$robot_cache->name<br>";

    }
}