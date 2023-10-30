<?php

namespace Model;

class API extends ActiveRecord{
    public static $table = "services";
    public $columns = ["id", "name", "price"];
    public $id;
    public $name;
    public $price;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->id = trim($this->id);
        $this->name = $args["name"] ?? "";
        $this->name = trim($this->name);
        $this->price = $args["price"] ?? "";
        $this->price = trim($this->price);
    }


}

?>