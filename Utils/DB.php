<?php

class RAW
{
    private $data;
    public function __construct($string)
    {
        $this->data = $string;
    }

    public function get()
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

    public function __construct()
    {
        try {
            $config = include APP_PATH . "/Config/database.php";
            $this->driver = new mysqli($config["host"], $config["user"], $config["password"], $config["name"]);
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

    public function __destruct()
    {
        if ($this->driver !== null) {
            $this->driver->close();
            $this->driver = null;
        }
    }

    public function reset()
    {
        $this->query = "";
        $this->select = "*";
        $this->data = [];
        $this->where = [];
        $this->joins = [];
        $this->orders = [];
        $this->limit = "";
    }

    public function multiple_assoc($query)
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

    public function table($table)
    {
        $this->table = $table;
    }


    public function primaryKey($pk)
    {
        $this->primaryKey = $pk;
    }
    public function data($data)
    {
        $this->data = $data;
    }
    public function limit($f, $l = "")
    {
        $this->limit = $f;

        if (!empty($l)) {
            $this->limit .= ", " . $l;
        }
    }

    public function join($rtable, $lparam, $rparam, $type = "inner")
    {
        $this->joins[] = "\n {$type} JOIN {$rtable} ON $lparam = $rparam";
    }

    public function query($query, $last_id = false)
    {
        try {
            $result = $this->driver->query($query);
            return $last_id ? $this->driver->insert_id : $result;
        } catch (\Throwable $th) {
            http_response_code(500);
            die(json_encode([
                "message" => $th->getMessage(),
                "query" => $this->query,
            ]));
        }
    }

    public function select($select)
    {
        if (gettype($select) == "array") {
            $this->select = implode(" , ", $select);
        } elseif (gettype($select) == "string") {
            $this->select = $select;
        }
    }

    public function where($where, $or = false)
    {
        if (gettype($where) == "array") {
            $this->where[] = implode($or ? " OR " : " AND ", $where);
        } elseif (gettype($where) == "string") {
            $this->where[] = $where;
        }
    }

    public function orderBy($order)
    {
        if (gettype($order) == "array") {
            $this->orders[] = implode(" , ", $order);
        } elseif (gettype($order) == "string") {
            $this->orders[] = $order;
        }
    }

    public static function RAW($data)
    {
        return new RAW($data);
    }

    public function lastQuery()
    {
        return $this->query;
    }
    public function start()
    {
        $this->driver->autocommit(FALSE);
        return $this->driver->begin_transaction();
    }
    public function commit()
    {
        if (!$this->driver->commit()) {
            echo "Commit transaction failed";
            exit();
        }

        return true;
    }
    public function rollback()
    {
        return $this->driver->rollback();
    }

    public function get()
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

        $result = $this->query($this->query);
        return $this->multiple_assoc($result);
    }
    public function first()
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
        $this->query .= "\n LIMIT 1";

        $result = $this->query($this->query);
        return $result->fetch_assoc();
    }

    public function insert()
    {
        $this->query = "INSERT INTO $this->table ";
        if (count($this->data) > 0) {
            $keys = [];
            $values = [];
            foreach ($this->data as $key => $value) {
                $keys[] = $key;
                $values[] = $value instanceof RAW ? $value->get() : "'" . strip_tags($value) . "'";
            }

            $this->query .= "(" . implode(" , ", $keys) . ") VALUES(" . implode(",", $values) . ")";
        }
        return $this->query($this->query, true);
    }
    public function update()
    {
        $this->query = "UPDATE $this->table SET ";
        if (count($this->data) > 0) {
            $arr = [];
            foreach ($this->data as $key => $value) {
                $val = $value instanceof RAW ? $value->get() : "'" . strip_tags($value) . "'";
                $arr[] = "{$key} = {$val}";
            }
            $this->query .= implode(" , ", $arr);
        }
        if (count($this->where) > 0) {
            $this->query .= "\n WHERE " . implode(" AND ", $this->where);
        }
        return $this->query($this->query);
    }
}