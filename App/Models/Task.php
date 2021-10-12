<?php
namespace App\Models;

class Task extends BaseModel 
{
    public function addTask($values)
    {
        $query = $this->start()->insertInto('tasks')->values($values)->execute();
        return $query;
    }
    public function getTasks($page = 1)
    {
        $pageSize = 3;
        $count = $this->start()->from('tasks')->count();
        $tasks = $this->start()->from('tasks')->offset(($page - 1) * $pageSize)->limit($pageSize)->fetchAll();
        $result = [
            'count' => $count,
            'tasks' => $tasks
        ];
        return $result;
    }
    public function done($taskId)
    {
        $set = array('status' => 1);
        $query = $this->start()->update('tasks')->set($set)->where('id', $taskId)->execute();
        return $query;
    }
    public function getTask($taskId)
    {
        return $this->start()->from('tasks')->where('id',$taskId)->fetch();
    }
    public function updateTask($taskId,$values)
    {
        $query = $this->start()->update('tasks')->set($values)->where('id', $taskId)->execute();
        return $query;
    }
}