<?php

namespace Controller;
use MVC\Router;
use Model\Service;

class ServiceController{

    public static function services(Router $router){
        $alerts = [];
        $nameUser = '';
        $isAuth = isAuth();
        $isAdmin = isAdmin();

        if($isAdmin && $isAuth){
            $nameUser = $_SESSION["name"] . " " . $_SESSION["lastname"];
            $services = Service::findAll();

            if($_SERVER["REQUEST_METHOD"]=="POST"){



            }


        }

        $router->render("services/services", ["nameUser" => $nameUser, "alerts" => $alerts, "services" => $services]);
    }

    public static function update(Router $router){

        $alerts = [];
        $nameUser = '';
        $isAuth = isAuth();
        $isAdmin = isAdmin();

        if($isAdmin && $isAuth){

            $id = sanitizar($_GET["id"]);

            $service = Service::find("id", $id);

            $nameUser = $_SESSION["name"] . " " . $_SESSION["lastname"];

            if($service->id){

                if($_SERVER["REQUEST_METHOD"]=="POST"){

                    $service->sincronize($_POST);

                    $service->validate();

                    $alerts = $service->getAlerts();

                    if(empty($alerts)){
                        $result = $service->save();

                        if($result){
                            header("Location: /admin?result=4");
                        }else{
                            $service->setAlert("error", "Service couldnt be uploaded");
                        }
                        $alerts = $service->getAlerts();
                        $service = new Service();
                    }
                }

            }else{
            header("Location: /appointment");
            }

            $router->render("services/update", ["nameUser" => $nameUser, "alerts" => $alerts, "service" => $service]);

        }


    }

    public static function create(Router $router){
        $alerts = [];
        $nameUser = '';
        $isAuth = isAuth();
        $isAdmin = isAdmin();

        if($isAdmin && $isAuth){

            $service = new Service();
            $nameUser = $_SESSION["name"] . " " . $_SESSION["lastname"];

            if($_SERVER["REQUEST_METHOD"]=="POST"){

                $service->sincronize($_POST);

                $service->validate();

                $alerts = $service->getAlerts();

                if(empty($alerts)){
                    $result = $service->save();

                    if($result){
                        header("Location: /admin?result=1");
                    }else{
                        $service->setAlert("error", "Service couldnt be registered");
                    }
                    $alerts = $service->getAlerts();
                    $service = new Service();
                }
            }

            $router->render("services/create", ["nameUser" => $nameUser, "alerts" => $alerts, "service" => $service]);
        }

    }

    public static function delete(){
        $isAuth = isAuth();
        $isAdmin = isAdmin();

        if($_SERVER["REQUEST_METHOD"]=="POST"){

            if($isAdmin && $isAuth){

                $id = sanitizar($_POST["id"]);

                $service = Service::find("id", $id);

                if($service->id){
                    $result = $service->delete();
                }

                if($result){
                    header("Location: /admin?result=2");
                }else{
                    header("Location: /admin?result=3");
                }


            }


            $alerts = $service->getAlerts();
            $service = new Service();


        }else{
            echo "Error 404";
        }

    }
}
