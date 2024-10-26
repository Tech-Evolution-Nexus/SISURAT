<?php

namespace app\interface;

use app\services\Database;
use PDO;

abstract class Model
{
    protected $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function query($query)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function execute($query, $data)
    {
        $stmt = $this->db->prepare($query);
        return   $stmt->execute($data);
    }

  
    public function singleQuery($query)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
