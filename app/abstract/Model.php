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
    private $limit;
    public function __construct()
    {
        $this->db = (new Database)->getConnection();
    }

    public function find($primaryKey)
    {
        $this->query = "SELECT {$this->fields} FROM {$this->table} WHERE {$this->primaryKey} = :primaryKey";
        return $this->execute($this->query, ['primaryKey' => $primaryKey])->fetch($this->fetchMode);
    }

    public function select(...$fields)
    {
        // Mengatur fields yang ingin diambil, bisa berupa string atau array
        $this->fields = empty($fields) ? "*" : implode(',', $fields);
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
        $this->query = "SELECT {$this->fields} FROM {$this->table}";
        return $this->execute($this->query)->fetchAll($this->fetchMode);
    }

    public function create(array $data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_map(fn($item) => ":$item", array_keys($data)));
        $this->query = "INSERT INTO {$this->table} ({$columns}) VALUES($placeholders)";
        $this->bindings = $data;
        $this->execute($this->query, $this->bindings);
        return $this->db->lastInsertId();
    }

    public function update(array $data)
    {
        $setClauses = [];
        foreach ($data as $key => $value) {
            $setClauses[] = "{$key} = :{$key}";
        }
        $setString = implode(', ', $setClauses);
        $this->query = "UPDATE {$this->table} SET {$setString} ";

        $query = "SELECT * FROM {$this->table} ";
        $bindings = [];
        if (!empty($this->wheres)) {
            $whereClauses = [];

            foreach ($this->wheres as $index => $where) {
                $prefix = $index === 0 ? "WHERE" : $where['type'];
                $placeholder = ":{$where['column']}";
                // Make sure to use the placeholder for the value in the query
                $whereClauses[] = "$prefix {$where['column']} {$where['operator']} '{$where['value']}' ";
                // Now bind the value properly
                $this->bindings[$placeholder] = $where['value'];
            }

            $this->query .= ' ' . implode(' ', $whereClauses);
            $query .= ' ' . implode(' ', $whereClauses);
        }

        $this->bindings = $data;

        $this->execute($this->query, $this->bindings);
        return $this->execute($query, $bindings)->fetch($this->fetchMode);
    }
    // public function delete($id)
    // {
    //     $this->query = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
    //     $this->bindings = ['id' => $id];
    //     return $this->execute($this->query, $this->bindings);
    // }

    public function where($column, $operator = '=', $value = null)
    {
        $this->wheres[] = [
            'type' => 'AND',
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        if ($value !== null) {
            $this->bindings[":$column"] = $value; // Menggunakan binding dengan prefix ":"
        }
        return $this;
    }

    public function orWhere($column, $operator = '=', $value = null)
    {
        $this->wheres[] = [
            'type' => 'OR',
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        $this->bindings[":$column"] = $value; // Menggunakan binding dengan prefix ":"
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->orders[] = [
            'column' => $column,
            'direction' => strtoupper($direction), // Memastikan arah pengurutan adalah uppercase
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

    private function buildQuery($type = 'SELECT')
    {
        if ($type === 'DELETE') {
            $this->query = "DELETE FROM {$this->table}";
        } else {
            $this->query = "{$type} {$this->fields} FROM {$this->table}";
        }

        if (!empty($this->joins)) {
            foreach ($this->joins as $join) {
                $this->query .= " {$join['type']} " . "{$join['table']} ON {$join['field1']} = {$join['field2']}";
            }
        }

        if (!empty($this->wheres)) {
            $whereClauses = [];
            foreach ($this->wheres as $index => $where) {
                $prefix = $index === 0 ? "WHERE" : $where['type'];
                $placeholder = ":{$where['column']}";
                $value = $where["operator"] == "IN" ? "{$where['value']}" : "'{$where['value']}'";
                $whereClauses[] = "$prefix {$where['column']} {$where['operator']} {$value} ";

                $this->bindings[$placeholder] = $where['value'];
            }

            $this->query .= ' ' . implode(' ', $whereClauses);
        }

        if (!empty($this->orders)) {
            $orderClauses = [];
            foreach ($this->orders as $order) {
                $orderClauses[] = "{$order['column']} {$order['direction']}";
            }
            $this->query .= ' ORDER BY ' . implode(', ', $orderClauses);
        }

        if (isset($this->limit)) { // Add limit if it's set
            $this->query .= " LIMIT {$this->limit}";
        }
        $this->resetQuery();
    }

    private function execute($query, $bindings = [])
    {

        $stmt = $this->db->prepare($query);
        try {

            $stmt->execute($bindings);
        } catch (\Throwable $th) {
            // dd($th);
            throw new \Exception("Database query error: " . $th->getMessage());
        }
        return $stmt;
    }

    public function exists($conditions)
    {
        $this->query = "SELECT COUNT(*) FROM {$this->table}";

        $whereClauses = [];
        foreach ($conditions as $column => $value) {
            $whereClauses[] = "{$column} = :{$column}";
            $this->bindings[":{$column}"] = $value;
        }
        $this->query .= " WHERE " . implode(" AND ", $whereClauses);
        $stmt = $this->execute($this->query, $this->bindings);
        return $stmt->fetchColumn() > 0; // Mengembalikan true jika data sudah ada
    }
    public function limit($value)
    {
        $this->limit = (int) $value; // Ensure the limit is an integer
        return $this;
    }


    public function delete()
    {
        // Build the DELETE query based on the current conditions
        $this->buildQuery('DELETE');
        return $this->execute($this->query, $this->bindings);
    }

    private function resetQuery()
    {
        $this->wheres = [];
        $this->joins = [];
        $this->orders = [];
        $this->bindings = [];
        $this->fields = "*";
    }
    public function whereIn($column, array $values)
    {
        if (empty($values)) {
            throw new InvalidArgumentException("Values for whereIn cannot be empty.");
        }

        $placeholders = [];
        foreach ($values as $index => $value) {
            $placeholder = "'{$value}'";
            $placeholders[] = $placeholder;
            $this->bindings[$placeholder] = $value;
        }
        $this->wheres[] = [
            'type' => 'AND',
            'column' => $column,
            'operator' => 'IN',
            'value' => '(' . implode(',', $placeholders) . ')',
        ];
        return $this;
    }
}
