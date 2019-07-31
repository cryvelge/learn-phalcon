<?php

use Phalcon\Mvc\Model;

/**
 * Class Users
 * @property $id
 * @property $name
 * @property $email
 */
class Users extends Model
{
    public $id;
    public $name;
    public $email;

    public function initialize()
    {
        echo '<b>User Model Initalize</b>';
    }

    public function afterFetch()
    {
        echo  '<br> 实例化了一个'. static::class;
    }

}