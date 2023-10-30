<?php

namespace Controller;

use Model\ActiveRecord;
use Model\API;
use Model\Admin;
use Model\Appointment;
use Model\AppointmentService;
use MVC\Router;

class AdminController extends ActiveRecord{

    public static function index(Router $router){

        date_default_timezone_set('America/Los_Angeles');

        $alerts = [];

        $isAuth = isAuth();
        $isAdmin = isAdmin();

        $hasResults = null;
        $results = null;
        $date = null;

        if($isAdmin && $isAuth){

            if(isset($_GET["result"])){

                if(sanitizar($_GET["result"]==1)){
                    $alerts["success"][] = "Service has been registered";
                }
                if(sanitizar($_GET["result"]==2)){
                    $alerts["success"][] = "Service has been deleted";
                }
                if(sanitizar($_GET["result"]==3)){
                    $alerts["error"][] = "Service couldnt have been deleted";
                }
                if(sanitizar($_GET["result"]==4)){
                    $alerts["success"][] = "Service has been updated";
                }

            }

            $nameUser = $_SESSION["name"] . " " . $_SESSION["lastname"];

            if(isset($_GET["date"])){
                $date = sanitizar($_GET["date"]);
                $dateArray = explode("-", $date);

                if(checkdate($dateArray[1],$dateArray[2],$dateArray[0])){
                    $date = date($date);
                }else{
                    $date = date("Y-m-d");
                }


            }else{
                $date = date("Y-m-d");
            }

            $results = Admin::SQLComplex($date);

            if($results){
                $hasResults = true;
            }else{
                $hasResults = false;
            }
        }
        $script = "<script src='/build/js/admin.js'></script>";
        $router->render("admin/index", ["nameUser" => $nameUser,
        "alerts" => $alerts,
        "hasResults" => $hasResults,
        "results" => $results,
        "date" => $date,
        "script" => $script]);
    }

    public static function deleteAppointment(){

            $isAuth = isAuth();

            $isAdmin = isAdmin();

        if($_SERVER["REQUEST_METHOD"]=="POST"){

            if($isAdmin && $isAuth){

                $id = sanitizar($_POST["id"]);


                $appointment = Appointment::find("id", $id);

                if($appointment->id){
                    $appointment->delete();
                }

                header("Location: " . $_SERVER["HTTP_REFERER"]);

            }

        }else{
            echo "Error 404";
        }


    }
}
