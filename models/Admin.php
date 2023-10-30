<?php

namespace Model;

class Admin extends ActiveRecord{
    public static $table = "admin";
    public $columns = ["id", "time", "userId", "name", "email", "phone", "serviceName"];
    public $id;
    public $time;
    public $userId;
    public $name;
    public $email;
    public $phone;
    public $serviceName;
    public $price;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->id = trim($this->id);
        $this->time = $args["time"] ?? "";
        $this->time = trim($this->time);
        $this->userId = $args["userId"] ?? "";
        $this->userId = trim($this->userId);
        $this->name = $args["name"] ?? "";
        $this->name = trim($this->name);
        $this->email = $args["email"] ?? "";
        $this->email = trim($this->email);
        $this->phone = $args["phone"] ?? "";
        $this->phone = trim($this->phone);
        $this->serviceName = $args["serviceName"] ?? "";
        $this->serviceName = trim($this->serviceName);
        $this->price = $args["price"] ?? "";
        $this->price = trim($this->price);
    }

    public static function SQLComplex($date){

        $results = [];

        $date = self::$db->escape_string($date);

        $query = "SELECT appointments.id, appointments.time, appointments.userId, concat(users.name,' ',users.lastname) as name, users.email, users.phone, services.name as serviceName, services.price ";
        $query .="FROM appointmentsservices ";
        $query .="LEFT OUTER JOIN appointments ";
        $query .="ON appointmentsservices.appointmentId = appointments.id ";
        $query .="LEFT OUTER JOIN users ";
        $query .="ON appointments.userId=users.id ";
        $query .="LEFT OUTER JOIN services ";
        $query .="ON appointmentsservices.serviceId = services.id ";
        $query .="WHERE appointments.date = '$date';";

        $consult = self::$db->query($query);

        if($consult->num_rows>0){

            while($resultFetch = $consult->fetch_assoc()){
                array_push($results,new static($resultFetch));
            }

            return $results;
        }else{

            return $results;
        }




        return $consult;
    }


}

?>