<?php

namespace Model;

class ActiveRecord{

    public static $db;

    public static $table = "";

    public $alerts;

    public $columns = [];

    public $id;
    public $name;
    public $lastname;
    public $email;
    public $password;
    public $phone;
    public $admin;
    public $confirmed;
    public $token;

    public function __construct() {

    }

    public static function setDB($database){
        self::$db = $database;
    }

    public function getAlerts(){
        return $this->alerts;
    }

    public function sincronize($args){

        foreach($args as $key => $value){
            if(($key!=NULL) && isset($this->$key)){
                $this->$key = trim($value);
            }
        }
    }

    public function save(){

        if($this->id){
            $result = $this->saveUpdate();
        }else{
            $result = $this->saveCreate();

        }

        return $result;

    }

    public function sanitizeAttributes(){

        $attributes = [];


        foreach($this->columns as $column){
            if( $this->$column){
                $attributes[$column] =  self::$db->escape_string($this->$column);

            }
        }
        return $attributes;
    }

    public function setAlert($type, $value){
        $type = sanitizar($type);
        $value = sanitizar($value);
        $this->alerts[$type][] = $value;

    }

    public static function find($type, $valor){
        $type = self::$db->escape_string($type);
        $valor = self::$db->escape_string($valor);
        $query = "SELECT * FROM " . static::$table . " WHERE $type = '$valor' LIMIT 1;";

        $consult = self::$db->query($query)->fetch_assoc();

        return new static($consult);

    }

    public static function findAll(){
        $query = "SELECT * FROM " . static::$table .";";

        $consult = self::$db->query($query);

            $results = [];

        if($consult->num_rows>0){

            while($resultFetch = $consult->fetch_assoc()){
                array_push($results,new static($resultFetch));
            }

            return $results;
        }else{

            return $results;
        }
    }


    protected function saveCreate(){

        $attributes = $this->sanitizeAttributes();

        $keys = join(', ', array_keys($attributes));
        $values = join('\', \'', array_values($attributes));

        $query = "INSERT INTO ". static::$table . " ($keys) VALUES ('$values');";

        return self::$db->query($query);
        //return [self::$db->query($query), $query];
    }

    public function lastCreated(){
        return self::$db->insert_id;
    }

    public function delete(){
        $query = "DELETE FROM " . static::$table . " WHERE id = $this->id";
        return static::$db->query($query);
    }

    protected function saveUpdate(){

        $attributes = $this->sanitizeAttributes();

        $updateValues = "";

        foreach($attributes as $key => $value){
            if($key!="id"){
                $updateValues.= " $key = '$value',";
            }

        }

        $updateValues = substr($updateValues, 0, -1);

        $query = "UPDATE " . static::$table ." SET$updateValues WHERE id = $this->id;";

        return self::$db->query($query);
    }



}

?>