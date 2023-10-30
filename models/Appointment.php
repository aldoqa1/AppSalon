<?php

namespace Model;

class Appointment extends ActiveRecord{
    public static $table = "appointments";
    public $columns = ["id", "date", "time", "userId"];
    public $id;
    public $date;
    public $time;
    public $userId;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->id = trim($this->id);
        $this->date = $args["date"] ?? "";
        $this->date = trim($this->date);
        $this->time = $args["time"] ?? "";
        $this->time = trim($this->time);
        $this->userId = $args["userId"] ?? "";
        $this->userId = trim($this->userId);
    }

    public static function gettingDates(){
        $query = "SELECT time, date FROM " . static::$table .";";

        $consult = self::$db->query($query);

        $results = [];

        if($consult->num_rows>0){

            while($resultFetch = $consult->fetch_assoc()){
                array_push($results,new static($resultFetch));
            }
        return $results;
        }
    }
}


?>