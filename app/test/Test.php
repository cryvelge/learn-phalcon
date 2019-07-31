<?php


namespace app\test;

class Test
{
    public function __construct()
    {
        echo 'class test loaded';
    }

    public function show()
    {
        echo 'use method via di';
    }
}