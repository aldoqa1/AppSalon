<?php

namespace MVC;

class Router{

    public $getRutes = [];
    public $postRutes = [];
    public $privateRutes = [];

    public function get($url, $function){
        $this->getRutes[$url] = $function;
    }

    public function post($url, $function){
        $this->postRutes[$url] = $function;
    }

    public function checkRutes(){

        //$currentRute = $_SERVER["PATH_INFO"] ?? "/";
        $currentRute =  strtok($_SERVER["REQUEST_URI"], "?") ?? "/";
        $method = $_SERVER["REQUEST_METHOD"];

        if($method=="GET"){
            $function = $this->getRutes[$currentRute] ?? null;
        }else{
            $function = $this->postRutes[$currentRute] ?? null;
        }

        if(!$function){
            echo "Error 404";
            exit;
        }else{
            call_user_func($function, $this);
        }
    }

    public function render($view, $variables){

        foreach($variables as $key => $value){
            $$key = $value;
        }

        ob_start();

        include __DIR__ . "/views/$view.php";

        $content = ob_get_clean();

        include __DIR__ . "/views/layout.php";

    }
}

?>