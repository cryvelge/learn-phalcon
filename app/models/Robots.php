<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Uniqueness;

class Robots extends Model
{
    public $id;

    public $name;

    /**
     * 在实例化这个模型时会执行此方法
     */
    public function initialize()
    {
        /**
         * 一对多关联关系
         * 第一个参数是当前表的关系字段
         * 第二个是关联模型的名称
         * 第三个是关联表中的关系字段
         */
        $this->hasMany("id", "RobotsParts", "robots_id");

        /**
         * 多对多关系
         */
        $this->hasManyToMany(
            'id', //当前表的关系字段
            'RobotsParts', //中间表的模型
            'robots_id', 'parts_id', //中间表的关联字段
            'Parts', //关联表模型
            'id' //关联表的关系字段
        );
    }

    /**
     * 会在插入/更新时自动验证
     * @return bool
     */
    public function validation()
    {
        $validator = new Validation();
//        $validator->add("type", new InclusionIn([
//            "domian" => [
//                'Mechanical',
//                'Virtual',
//            ],
//        ]));
        $validator->add('name', new Uniqueness([
            'message' => 'robot name must be unique',
        ]));
        return $this->validate($validator);
    }

    public function onValidationFails()
    {
        foreach ($this->getMessages() as $message) {
            echo $message;
        }
    }
}