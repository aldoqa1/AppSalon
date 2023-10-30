<?php

namespace Model;

class AppointmentService extends ActiveRecord{
    public static $table = "appointmentsservices";
    public $columns = ["id", "serviceId", "appointmentId"];
    public $id;
    public $serviceId;
    public $appointmentId;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->serviceId = $args["serviceId"] ?? "";
        $this->appointmentId = $args["appointmentId"] ?? "";
    }


}

?>