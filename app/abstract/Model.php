<?php

namespace app\abstract;

use app\services\Database;
use InvalidArgumentException;
use PDO;

class Model
{
    private $db;
    protected $table;
    protected $fillable = [];
    protected $primaryKey = "id";
    private $query = "";
    private $wheres = [];
    private $joins = [];
    private $bindings = [];
    private $orders = [];
    private $fields = "*";
    private $fetchMode = PDO::FETCH_OBJ;

    public function __construct()
    {
        $this->db = (new Database)->getConnection();
    }

    public function find($primaryKey)
    {
        $this->query = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :primaryKey";
        return $this->execute($this->query, ['primaryKey' => $primaryKey]);
    }

    public function select($fields)
    {
        $this->fields = $fields;
        return $this;
    }
    public function findOrFail($primaryKey)
    {
        $result = $this->find($primaryKey);
        if (!$result) {
            throw new InvalidArgumentException("Record not found.");
        }
        return $result;
    }

    public function all()
    {
        $this->query = "SELECT * FROM {$this->table}";
        return $this->execute($this->query)->fetchAll($this->fetchMode);
    }
    public function create($data)
    {;
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_map(fn($item) => ":$item", $this->fillable));
        $this->query = "INSERT INTO {$this->table} ({$columns}) VALUES($placeholders)";
        $this->bindings = array_combine(array_map(fn($item) => "$item", $this->fillable), $data);
        $this->execute($this->query, $this->bindings);
        return $this->db->lastInsertId();
    }
    public function update($id, $data)
    {
        // Buat klausa SET
        $setClauses = [];
        foreach ($data as $key => $value) {
            $setClauses[] = "{$key} = :{$key}"; // Gunakan binding dengan prefix ":"
        }
        $setString = implode(', ', $setClauses);
        $this->query = "UPDATE {$this->table} SET {$setString} WHERE {$this->primaryKey} = :id";
        $this->bindings = array_merge($data, ['id' => $id]); // Menambahkan binding untuk ID
        $this->execute($this->query, $this->bindings);
        return $data;
    }





    public function where($column, $operator = '=', $value = null)
    {
        $this->wheres[] = [
            'type' => 'AND',
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        $this->bindings[] = $value;
        return $this;
    }
    public function orderBy($column, $direction = 'ASC' | 'DESC')
    {
        $this->orders[] = [
            'column' => $column,
            'direction' => $direction,
        ];
        return $this;
    }
    public function join($table, $field1, $field2)
    {
        $this->joins[] = [
            'type' => 'JOIN',
            'table' => $table,
            'field1' => $field1,
            'field2' => $field2
        ];

        return $this;
    }

    public function whereOr($column, $operator = '=', $value = null)
    {
        $this->wheres[] = [
            'type' => 'JOIN',
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        $this->bindings[] = $value;
        return $this;
    }

    public function get()
    {
        $this->buildQuery();
        return $this->execute($this->query, $this->bindings)->fetchAll($this->fetchMode);
    }
    public function first()
    {
        $this->buildQuery();

        return $this->execute($this->query, $this->bindings)->fetch($this->fetchMode);
    }

    private function buildQuery()
    {
        $this->query = "SELECT {$this->fields} FROM {$this->table}";

        if (!empty($this->joins)) {
            foreach ($this->joins as $join) {
                $this->query .= " {$join['type']} " . "{$join['table']} ON {$join['field1']} = {$join['field2']}";
            }
        }
        if (!empty($this->wheres)) {
            $whereClauses = [];
            foreach ($this->wheres as $index => $where) {
                $prefix = $index === 0 ? "WHERE" : $where['type'];
                $whereClauses[] = "$prefix {$where['column']} {$where['operator']} ?";
            }
            $this->query .= ' ' . implode(' ', $whereClauses);
        }
        if (!empty($this->orders)) {
            $orderClauses = [];
            foreach ($this->orders as $join) {
                $orderClauses[] = "{$join['column']} {$join['direction']}";
            }
            $this->query .= ' ORDER BY ' . implode(', ', $orderClauses);
        }

        $this->wheres = [];
        $this->fields = "*";
    }

    private function execute($query, $bindings = [])
    {
        $stmt = $this->db->prepare($query);
        try {

            $stmt->execute($bindings);
        } catch (\Throwable $th) {
            dd($this->bindings);
        }
        $this->bindings = [];
        return $stmt;
    }
}
