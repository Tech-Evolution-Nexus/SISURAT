<?php

namespace app\controllers;

use app\services\Database as ServicesDatabase;
use services\Database;
use PDO;

class AboutController
{
    public  function about()
    {
        return view("admin/setting/tentangAplikasi");
    }
}
