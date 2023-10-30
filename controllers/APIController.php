<?php

namespace Controller;

use Model\ActiveRecord;
use Model\API;
use Model\Appointment;
use Model\AppointmentService;

class APIController extends ActiveRecord{

    public static function services(){
        $isAuth = isAuth();
        if($isAuth){
            $api = API::findAll();
            echo json_encode($api);
        }
    }

    public static function appointmentsRegister(){

        $isAuth = isAuth();

        if($isAuth){

            $appointment = new Appointment($_POST);

            //guardando datos y obteniendo si se registro o no
            $result = $appointment->save();

            //enviando datos a js
            echo json_encode($result);

            if($result){

                $appointmentId = $appointment->lastCreated();

                $services = explode(",",$_POST["services"]);

                foreach($services as $service){

                    $array = [
                    "serviceId" => $service,
                    "appointmentId" => $appointmentId];

                    $appointmentService = new AppointmentService($array);
                    $appointmentService->save();

                }



            }
        }




    }

    public static function gettingDatesAndTime(){

        $isAuth = isAuth();
        if($isAuth){
            $api = Appointment::gettingDates();
            echo json_encode($api);
        }
    }
}
