<?php
require_once "Model.php";
class ModelLocation extends Model
{
    protected $table = "location";

    public function get()
    {
        $this->db->reset();
        return $this->db->get();
    }
    public function getById($id)
    {
        $this->db->reset();
        $this->db->where("{$this->table}.{$this->primaryKey} = '{$id}'");
        return $this->db->first();
    }

    public function create($data)
    {
        $this->db->data($data);
        $id = $this->db->insert();
        if ($id) return $this->getById($id);
        else return false;
    }

    public function update($id, array $data)
    {
        $this->db->data($data);
        $this->db->where("{$this->primaryKey} = '$id'");
        if ($this->db->update()) return $this->getById($id);
        else return false;
    }
}