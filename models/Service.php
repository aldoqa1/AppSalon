<?php

namespace Model;

class Service extends ActiveRecord{
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


    public function validate(){

        if(!$this->name){
            $this->alerts["error"][] = "Not name found";
        }

        if(!$this->price){
            $this->alerts["error"][] = "Not price found";
        }else{
            if(!is_numeric($this->price)){
                $this->alerts["error"][] = "Its not a number";
            }
        }



    }

}

?>