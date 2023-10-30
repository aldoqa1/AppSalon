<?php

namespace Controller;
use MVC\Router;
use Model\User;
use PHPMailer\PHPMailer\PHPMailer;

class LoginController{

    public static function login(Router $router){

        $alerts = [];

        session_start();
        if($_SESSION){
            header("Location: /appointment");
        }


        if($_GET){
            if(sanitizar($_GET["result"]==1)){
                $get = new User();
                $get->setAlert("success", "Your password has been changed successfully");
                $alerts=$get->getAlerts();
            }

        }


        if($_SERVER["REQUEST_METHOD"]=="POST"){

            if($_SESSION){
                header("Location: /appointment");
            }


            $auth = new User($_POST);

            $auth->verifyAuth();

            $alerts = $auth->getAlerts();


            if(empty($alerts)){
                $user = User::find("email", $auth->email);

                if($user->email==""){

                $user->setAlert("error", "User wasnt found");

                }else{

                    $result = $user->verifyPassword($auth->password);

                    if($result){
                        session_start();
                        $_SESSION["id"] = $user->id;
                        $_SESSION["email"] = $user->email;
                        $_SESSION["admin"] = $user->admin ?? 1;
                        $_SESSION["name"] = $user->name;
                        $_SESSION["lastname"] = $user->lastname;
                        $_SESSION["login"] = true;


                        if($_SESSION["admin"]==1){
                            header("Location: /admin");
                        }else{
                            header("Location: /appointment");
                        }


                    }

                }


                $alerts = $user->getAlerts();

            }
        }



        $router->render("auth/login", ["alerts" => $alerts]);
    }

    public static function logout(Router $router){

        session_start();
        $_SESSION = [];
        header("Location: /");

    }

    public static function forget(Router $router){

        $alerts = [];
        $show = true;

        session_start();
        if($_SESSION){
            header("Location: /appointment");
        }


        if($_SERVER["REQUEST_METHOD"]=="POST"){

            $data = new User($_POST);

            $data->validateEmail();

            $alerts = $data->getAlerts();


            if(empty($alerts)){
                $user = User::find("email", $data->email);

                if($user->email=="" || $user->confirmed!=1){

                $user->setAlert("error", "User wasnt found or account isnt confirmed");

                $alerts = $user->getAlerts();

                }else{

                    $show = false;
                    $user->createToken();
                    $user->saveProperty("token");
                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->Host = $_ENV["EMAIL_HOST"];
                    $mail->SMTPAuth = true;
                    $mail->Port = $_ENV["EMAIL_PORT"];
                    $mail->Username = $_ENV["EMAIL_USER"];
                    $mail->Password = $_ENV["EMAIL_PASS"];
                    $mail->setFrom($user->email);
                    $mail->addAddress($_ENV["EMAIL_ADDRESS"], "appsalon");
                    $mail->Subject = "Recover your password";
                    $name = sanitizar($user->name);
                    $mail->isHTML(TRUE);
                    $mail->CharSet = "UTF-8";
                    $content = "<html> <h1>Hi $name </h1><p>Welcome to appsalon, recover your password clicking here <a href='" . $_ENV["URL_APP"] . "/recover?token=$user->token'>Click here</a></p> <p>If you didnt make this request, you can ignore this email</p> </html>";
                    $mail->Body = $content;
                    $mail->send();
                    $user->setAlert("success", "Check on your email");
                    $alerts = $user->getAlerts();
                }

            }

        }
        $router->render("auth/forget", ["alerts" => $alerts, "show" => $show]);
    }

    public static function recover(Router $router){

        session_start();
        if($_SESSION){
            header("Location: /appointment");
        }

        $alerts = [];
        $show = false;
        if(isset($_GET["token"])){
            $token = sanitizar($_GET["token"]);
        }else{
            $token = 0;
        }

        $user = user::find("token", $token);

        if($user->email){
            $show = true;

            if($_SERVER["REQUEST_METHOD"]=="POST"){

                $data = new User($_POST);

                $data->validatePassword();

                $alerts = $data->getAlerts();

                if(empty($alerts)){

                    $show = false;
                    $user->token = null;

                    $password = $user->hashPassword($data->password);
                    $user->password = $password;
                    $user->saveProperty("password");
                    $user->saveProperty("token");

                    header("Location: /?result=1");
                }
            }

        }else{
            $user->setAlert("error", "Recovering code wasnt found");
            $alerts = $user->getAlerts();
        }









        $router->render("auth/recover", ["alerts" => $alerts, "show" => $show]);
    }

    public static function createAccount(Router $router){
        session_start();
        if($_SESSION){
            header("Location: /appointment");
        }

        $alerts = [];
        $user = new User();

        if($_SERVER["REQUEST_METHOD"]=="POST"){

            $user->sincronize($_POST);

            $user->validateInputData();

            $alerts = $user->getAlerts();

            if(empty($alerts)){

                $user->validateNewAccount();

                $alerts = $user->getAlerts();

                if(empty($alerts)){

                    $user->createToken();
                    $result = $user->save();

                    if($result){

                        $mail = new PHPMailer();
                        $mail->isSMTP();
                        $mail->Host = $_ENV["EMAIL_HOST"];
                        $mail->SMTPAuth = true;
                        $mail->Port = $_ENV["EMAIL_HOST"];
                        $mail->Username = $_ENV["EMAIL_USER"];
                        $mail->Password = $_ENV["EMAIL_PASS"];
                        $mail->setFrom($user->email);
                        $mail->addAddress($_ENV["EMAIL_ADDRESS"], "appsalon");
                        $mail->Subject = "Confim your account";
                        $name = sanitizar($user->name);
                        $mail->isHTML(TRUE);
                        $mail->CharSet = "UTF-8";
                        $content = "<html> <h1>Hi $name </h1><p>Welcome to appsalon, confirm your email clicking here <a href='" . $_ENV["URL_APP"] . "/verifyAccount?token=$user->token'>Click here</a></p> <p>If you didnt register, you can ignore this email</p> </html>";
                        $mail->Body = $content;
                        $mail->send();

                        header("Location: /messageRegister?result=1");
                    }else{
                        header("Location: /messageRegister?result=0");
                    }

                }

            }
        }

        $router->render("auth/createAccount", ["alerts" =>  $alerts, "user" => $user]);
    }

    public static function verifyAccount(Router $router){
        session_start();
        if($_SESSION){
            header("Location: /appointment");
        }

        if(isset($_GET["token"])){
            $token = sanitizar($_GET["token"]);
        }else{
            $token = 0;
        }

        $user = user::find("token", $token);

        $user->verifyToken();

        $alerts = $user->getAlerts();

        $router->render("auth/verifyAccount", ["alerts" => $alerts]);
    }

    public static function messageRegister(Router $router){
        session_start();
        if($_SESSION){
            header("Location: /appointment");
        }

        if(isset($_GET["result"])){
            $result = sanitizar($_GET["result"]);
        }else{
            $result = 0;
        }
        $router->render("auth/messageRegister", ["result"=>$result]);
    }

}


?>