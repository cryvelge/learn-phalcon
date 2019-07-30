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
}