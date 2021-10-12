<?php
namespace App\Models;

class BaseModel 
{
    public $query;
    public function start()
    {
        $pdo = new \PDO("mysql:host=".$_ENV['DB_HOST'].";dbname=".$_ENV['DB_NAME']."", $_ENV['DB_LOGIN'], $_ENV['DB_PASSOWRD'], array(
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ));
        $this->query = new \Envms\FluentPDO\Query($pdo);
        return $this->query;
    }
}