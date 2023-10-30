<?php

//Imprime valor de $variable y termina el codigo
function impresion($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function sanitizar($html) : string {
    $sanitizar = htmlspecialchars($html);
    return $sanitizar;
}

function isAuth(){
    session_start();
    if(!$_SESSION['login']){
       header("Location: /");
       return false;
    }
    return true;
}

function isAdmin(){
    if(!$_SESSION['admin']){
       header("Location: /appointment");
       return false;
    }
    return true;
}

?>