<?php
include "Model.php";
class ModelCustomer extends Model
{
    function get()
    {
        return $this->select("select * from customer");
    }
}