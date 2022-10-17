<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\TasksModel;
use App\Libraries\TasksLib;

class Cron extends ResourceController
{

    public function overdueTasks(){
        $TasksLib = new TasksLib();
        $TasksLib->overdueTasks();
    }

    public function inWorkTasks(){
        $TasksLib = new TasksLib();
        $TasksLib->inWorkTasks();
    }


}
