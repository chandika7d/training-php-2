<?php
include "./Config/database.php";

class RAW
{
    private $data;
    function __construct($string)
    {
        $this->data = $string;
    }

    function get()
    {
        return $this->data;
    }
}
class DB
{
    protected $table = "";
    protected $primaryKey = "id";
    private $driver = null;
    private $query = "";
    private $select = "*";
    private $data = [];
    private $where = [];
    private $joins = [];
    private $orders = [];
    private $limit = "";

    function __construct()
    {
        try {
            $this->driver = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        } catch (\Throwable $th) {
            if ($th->getCode() == 1045) {
                http_response_code(500);
                die(json_encode([
                    "message" => "Database Access Denied",
                ]));
            }
            die(json_encode([
                "message" => "Database Connection Error",
            ]));
        }
    }

    function __destruct()
    {
        if ($this->driver !== null) {
            $this->driver->close();
            $this->driver = null;
        }
    }

    function reset()
    {
        $this->query = "";
        $this->select = "*";
        $this->data = [];
        $this->where = [];
        $this->joins = [];
        $this->orders = [];
        $this->limit = "";
    }

    function multiple_assoc($query)
    {
        $rows = [];
        if (!$query) {
            return false;
        }

        while ($array = $query->fetch_assoc()) {
            $rows[] = $array;
        }

        return $rows;
    }

    function table($table)
    {
        $this->table = $table;
    }


    function primaryKey($pk)
    {
        $this->primaryKey = $pk;
    }
    function data($data)
    {
        $this->data = $data;
    }
    function limit($f, $l = "")
    {
        $this->limit = $f;

        if (!empty($l)) {
            $this->limit .= ", " . $l;
        }
    }

    function join($rtable, $lparam, $rparam, $type = "inner")
    {
        $this->joins[] = "\n {$type} JOIN {$rtable} ON $lparam = $rparam";
    }

    function query($query, $last_id = false)
    {
        try {
            $result = $this->driver->query($query);
            return $last_id ? $this->driver->insert_id : $result;
        } catch (\Throwable $th) {
            http_response_code(500);
            die(json_encode([
                "message" => $th->getMessage(),
            ]));
        }
    }

    function select($select)
    {
        if (gettype($select) == "array") {
            $this->select = implode(" , ", $select);
        } elseif (gettype($select) == "string") {
            $this->select = $select;
        }
    }

    function where($where, $or = false)
    {
        if (gettype($where) == "array") {
            $this->where[] = implode($or ? " OR " : " AND ", $where);
        } elseif (gettype($where) == "string") {
            $this->where[] = $where;
        }
    }

    function orderBy($order)
    {
        if (gettype($order) == "array") {
            $this->orders[] = implode(" , ", $order);
        } elseif (gettype($order) == "string") {
            $this->orders[] = $order;
        }
    }

    static function RAW($data)
    {
        return new RAW($data);
    }

    function selectQuery()
    {
        $this->query = "SELECT $this->select from $this->table";
        if (count($this->joins) > 0) {
            $this->query .= implode("\n", $this->joins);
        }
        if (count($this->where) > 0) {
            $this->query .= "\n WHERE " . implode(" AND ", $this->where);
        }
        if (count($this->orders) > 0) {
            $this->query .= "\n ORDER BY " . implode(",", $this->orders);
        }
        if (!empty($this->limit)) {
            $this->query .= "\n LIMIT $this->limit";
        }
    }
    function insertQuery()
    {
        $this->query = "INSERT INTO $this->table ";
        if (count($this->data) > 0) {
            $keys = [];
            $values = [];
            foreach ($this->data as $key => $value) {
                $keys[] = $key;
                $values[] = $value instanceof RAW ? $value->get() : "'{$value}'";
            }

            $this->query .= "(" . implode(" , ", $keys) . ") VALUES(" . implode(",", $values) . ")";
        }
    }

    function lastQuery()
    {
        return $this->query;
    }
    function start()
    {
        $this->driver->autocommit(FALSE);
        return $this->driver->begin_transaction();
    }
    function commit()
    {
        if (!$this->driver->commit()) {
            echo "Commit transaction failed";
            exit();
        }

        return true;
    }
    function rollback()
    {
        return $this->driver->rollback();
    }

    function get()
    {
        $this->selectQuery();
        $result = $this->query($this->query);
        return $this->multiple_assoc($result);
    }

    function insert()
    {
        $this->insertQuery();
        return $this->query($this->query, true);
    }
}