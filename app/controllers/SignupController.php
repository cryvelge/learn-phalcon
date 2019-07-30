<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {
        $this->view->users = Users::find(); //find方法获取所有数据
    }

    public function registerAction()
    {
        $user = new Users();
        /**
         * @var $success bool save方法返回bool值
         */
        $success = $user->save($this->request->getPost(), ['name', 'email']);
        if ($success) {
            echo '感谢注册';
        } else {//注册失败
            $messages = $user->getMessages();
            foreach ($messages as $message) {
                echo $message->getMessage() . '</br>';
            }
        }
        $this->view->disable();
    }
}