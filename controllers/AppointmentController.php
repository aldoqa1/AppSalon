<?php

namespace Controller;
use MVC\Router;
use Model\Appointment;

class AppointmentController{

    public static function services(Router $router){
        $alerts = [];
        $result = isAuth();

        if($result){

            $appointments = Appointment::findAll();

            foreach($appointments as $appointment){
                $array = explode(":",$appointment->time);

            }

            $nameUser = $_SESSION["name"] . " " . $_SESSION["lastname"];
            $idUser = $_SESSION["id"];
            $script = "<script src='/build/js/appointment.js'></script><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            $router->render("/appointment/appointment", ["alerts" => $alerts, "nameUser" => $nameUser, "script" => $script, "idUser" => $idUser]);
        }

    }
}
