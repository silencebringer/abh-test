<?php

namespace App\Connections;

abstract class Connection
{
    protected static $connection;

    abstract public static function connection();
}