<?php

namespace app\controllers;


use PHPMailer\PHPMailer\PHPMailer;
use app\models\UserModel;

use Exception;


class DashController
{
    public $model;
    // private $model;
    public function __construct()
    {
        $this->model = (object)[];
        $this->model->users = new UserModel();
    }
    public  function index()
    {
        return view("admin/dashboard/dashboard");
    }
}