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
        foreach ($_POST as $key => $value)
            $_POST[$key] = htmlspecialchars($value);
        foreach ($_GET as $key => $value)
            $_GET[$key] = htmlspecialchars($value);
    }
    private function generatePagination($page,$count)
    {
        $result = [];
        $pageCount = ceil($count / 3);
        for($i = 1; $i < $pageCount+1; $i++)
        {
            $url = $this->getUrlForLinks($i, $_GET['sort']);
            $pageItem = [ 'label'=> $i,'url'=>"/". $url ]; 
            if($page == $i)
                $pageItem['active'] = true;
            $result[] = $pageItem;
        }
        array_unshift($result, ['label' => 'Previous', 'url' => ($page == 1) ? '#' : ('/' . $this->getUrlForLinks($page - 1, $_GET['sort']))]);
        array_push($result,['label' => 'Next','url'=> ($page == $pageCount)?'#': ('/' . $this->getUrlForLinks($page + 1, $_GET['sort']))]);
        return $result;
    }
    private function generateUrl()
    {
        $pageUrl = "";
        $sortParams = explode("_", $_GET['sort']);
        if ($_GET['page'] || $_GET['sort']) {
            $data = [
                'page' => $_GET['page'] ?? null,
                'sort' => $_GET['sort'] ? $sortParams[0] . "_" . $sortParams[1] : null
            ];
            $pageUrl = "?" . http_build_query($data);
        }
        return $pageUrl;
    }

    public function index()
    {
        $page = $_GET['page'] ?? 1;
        $task = new Task();
        $sortParams = explode("_", $_GET['sort']);
        $orderBy = "$sortParams[0] $sortParams[1]";
        $result = $task->getTasks($page, strtoupper($orderBy));
        $pageUrl = $this->generateUrl();
        foreach ($result['tasks'] as &$task)
        {
            $task['editUrl'] = "/edit-task/" . $task['id'] ."/". $pageUrl;
            $task['doneUrl'] = "/done-task/". $task['id'] ."/". $pageUrl;
        }
        $sort = [
            'login'=>'login_asc',
            'email' => 'email_asc',
            'status'=> 'status_asc'
        ];
        if($_GET['sort'])
        {
            if($sortParams[1] == 'asc')
                $sortParams[1] = 'desc';
            else
                $sortParams[1] = 'asc';
        }
        $sort[$sortParams[0]] = $sortParams[0]."_".$sortParams[1];  
        foreach ($sort as $key => &$value)
        {
            $paramSort = explode("_", $value);
                $data = [
                    'page' => $_GET['page'] ?? null,
                    'sort' => $paramSort[0] . "_" . $paramSort[1]
                ];
                $pageUrl = "?" . http_build_query($data);
                $sort[$key] = $pageUrl;
        }
        $this->render('index', [
                'table' => $result['tasks'],
                'pagination' => $this->generatePagination($page, $result['count']),
                'isLogin' => $this->fields['isLogin'],
                'sort' => $sort
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
            session_start();
            setcookie('addedTask', true, time() + 60 * 60 * 24 * 30, '/');
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
    public function getUrlForLinks($page = null,$sort=null)
    {
        $data = [
            'page' => $page??$_GET['page'],
            'sort' => $sort??$_GET['sort']
        ];
        return "?" . http_build_query($data);
    }
    public function done($taskId)
    {
        $task = new Task();
        $task->done($taskId);
        Header("Location:/". $this->getUrlForLinks($_GET['page'], $_GET['sort']));
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
        if(empty($this->fields['isLogin']))
        {
            Header("Location:/login/");
            exit();
        }
        $values = [
            'login' => $_POST['login'],
            'email' => $_POST['email'],
            'description' => $_POST['description'],
            'changed' => 1
        ];
        $task = new Task();
        $result = $task->updateTask($taskId, $values);
        if ($result) {
            Header("Location:/" . $this->getUrlForLinks($_GET['page'], $_GET['sort']));
            exit();
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