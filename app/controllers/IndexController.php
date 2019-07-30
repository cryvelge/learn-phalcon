<?php

use Phalcon\Mvc\Controller;
class IndexController extends Controller
{
    public function indexAction()
    {
//        echo '<h1>Hello</h1>';
        $this->view->users = Users::find(); //find方法获取所有数据

    }
}