<?php
namespace App\Controllers;

use App\Models\Task;

class TableController extends BaseController
{
    public $fields = [
        'actionUrl' => '/add-task/',
        'titleForm' => 'Add Task',
        'method' => 'POST',
        'button' => 'add',
        'login' => null,
        'email' => null,
        'description' => null
    ];
    public function getEditDate($taskID)
    {
        if ($_GET['page'])
            $pageUrl = "?page=" . $_GET['page'];
        return [
            'actionUrl' => '/edit-task/' . $taskID . "/". $pageUrl,
            'titleForm' => 'Edit Task',
            'button' => 'edit'
        ];
    }
    public function __construct()
    {
        session_start();
        $this->fields['isLogin'] = $_SESSION['isLogin'] ?? null;
    }
    private function generatePagination($page,$count)
    {
        $result = [];
        $pageCount = ceil($count / 3);
        for($i = 1; $i < $pageCount+1; $i++)
        {
            $pageItem = [ 'label'=> $i,'url'=>"/?page=$i" ]; 
            if($page == $i)
                $pageItem['active'] = true;
            $result[] = $pageItem;
        }
        array_unshift($result, ['label' => 'Previous', 'url' => ($page == 1) ? '#' : ('/?page=' . ($page - 1))]);
        array_push($result,['label' => 'Next','url'=> ($page == $pageCount)?'#':('/?page='. ($page + 1))]);
        return $result;
    }
    public function index()
    {
        $page = $_GET['page'] ?? 1;
        $task = new Task();
        $result = $task->getTasks($page);
        $pageUrl = "";
        if($_GET['page'])
            $pageUrl = "?page=" . $_GET['page'];
        foreach ($result['tasks'] as &$task)
        {
            $task['editUrl'] = "/edit-task/" . $task['id'] ."/". $pageUrl;
            $task['doneUrl'] = "/done-task/". $task['id'] ."/". $pageUrl;
        }

        $this->render('index', [
                'table' => $result['tasks'],
                'pagination' => $this->generatePagination($page, $result['count']),
                'isLogin' => $this->fields['isLogin']
            ]
        );
    }
    public function addTaskForm()
    {
        $this->render(
            'task',
            $this->fields
        );
    }
    public function addTask()
    {
        $values = [
            'login'=> $_POST['login'],
            'email'=> $_POST['email'],
            'description' => $_POST['description'],
            'status' => 0,
            'changed' => 0
        ];
        $task = new Task();
        $result = $task->addTask($values);
        if($result)
        {
            Header("Location:/");
        }
        else
        {
            $this->fields['login'] = $_POST['login'] ?? false;
            $this->fields['email'] = $_POST['email'] ?? false;
            $this->fields['description'] = $_POST['description'] ?? false;
            $this->render(
                'task',
                $this->fields
            );
        }
    }
    public function done($taskId)
    {
        $task = new Task();
        $task->done($taskId);
        $url = ($_GET['page'])?('/?page='. $_GET['page']):'/';
        Header("Location:". $url);
    }
    public function editTaskForm($taskId)
    {
        $task = new Task();
        $taskItem = $task->getTask($taskId);
        $this->fields = array_merge($this->fields, $taskItem);
        $form =$this->getEditDate($taskItem['id']);
        $this->fields = array_merge($this->fields, $form);
        $this->fields['isLogin'] = $_SESSION['isLogin'] ?? null;
        $this->render(
            'task',
            $this->fields
        );
    }
    public function editTask($taskId)
    {
        $values = [
            'login' => $_POST['login'],
            'email' => $_POST['email'],
            'description' => $_POST['description'],
            'changed' => 1
        ];
        $task = new Task();
        $result = $task->updateTask($taskId, $values);
        if ($result) {
            $url = ($_GET['page']) ? ('/?page=' . $_GET['page']) : '/';
            Header("Location:$url");
        } else {
            $form = $this->getEditDate($taskId);
            $this->fields = array_merge($this->fields, $form);
            $this->fields['login'] = $_POST['login'] ?? false;
            $this->fields['email'] = $_POST['email'] ?? false;
            $this->fields['description'] = $_POST['description'] ?? false;
            $this->render(
                'task',
                $this->fields
            );
        }
    }
};