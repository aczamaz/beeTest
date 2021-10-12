<?php
namespace App\Models;

class BaseModel 
{
    public $query;
    public function start()
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=bee', 'root', 'root', array(
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ));
        $this->query = new \Envms\FluentPDO\Query($pdo);
        return $this->query;
    }
}