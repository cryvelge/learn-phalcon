<?php

use Phalcon\Mvc\Model;

class RobotsParts extends Model
{
    public $id;

    public $robots_id;

    public $parts_id;

    public function Initialize()
    {
        /**
         * 多对一
         * 参数还是
         * 第一个是当前表
         * 第二个是关联模型名
         * 第三个是关联表的字段
         */
        $this->belongsTo('robots_id', 'Robots', 'id');
        $this->belongsTo('parts_id', 'Parts', 'id');
    }
}