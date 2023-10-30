<?php

require_once __DIR__ . "/../php/app.php";

use MVC\Router;
use Controller\LoginController;
use Controller\AppointmentController;
use Controller\APIController;
use Controller\AdminController;
use Controller\ServiceController;

$router = new Router();

$router->get("/", [LoginController::class, "login"]);
$router->post("/", [LoginController::class, "login"]);

$router->get("/logout", [LoginController::class, "logout"]);

$router->get("/forget", [LoginController::class, "forget"]);
$router->post("/forget", [LoginController::class, "forget"]);

$router->get("/recover", [LoginController::class, "recover"]);
$router->post("/recover", [LoginController::class, "recover"]);

$router->get("/createAccount", [LoginController::class, "createAccount"]);
$router->post("/createAccount", [LoginController::class, "createAccount"]);

$router->get("/verifyAccount", [LoginController::class, "verifyAccount"]);

$router->get("/messageRegister", [LoginController::class, "messageRegister"]);


$router->get("/appointment", [AppointmentController::class, "services"]);

$router->get("/API/services", [APIController::class, "services"]);

$router->get("/API/dates", [APIController::class, "gettingDatesAndTime"]);

$router->post("/API/appointmentsRegister", [APIController::class, "appointmentsRegister"]);

$router->get("/admin", [AdminController::class, "index"]);

$router->post("/API/deleteAppointment", [AdminController::class, "deleteAppointment"]);

$router->get("/services", [ServiceController::class, "services"]);

$router->get("/services/create", [ServiceController::class, "create"]);

$router->post("/services/create", [ServiceController::class, "create"]);

$router->get("/services/update", [ServiceController::class, "update"]);

$router->post("/services/update", [ServiceController::class, "update"]);

$router->post("/services/delete", [ServiceController::class, "delete"]);

$router->checkRutes();

?>