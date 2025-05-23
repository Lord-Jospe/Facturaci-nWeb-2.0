<?php
        session_start();
        require_once (__DIR__."/../mdb/mdbUsuario.php");
        $ruta ="#";
        $msg = "Usuario y/o contraseña no válido.";
        $usuario = null;

        //username and password sent from js
        $username = filter_input(INPUT_POST,'user');
        $password = filter_input(INPUT_POST,'pass');

        $usuario = autenticarUsuario($username, $password);

        if($usuario != null){ // Puede iniciar sesión
                $_SESSION['ID_USUARIO'] = $usuario->getId();
                $_SESSION['NOMBRE_USUARIO'] = $usuario->getNombre();

                $ruta = "./index.php";

            $msg = "Puede iniciar sesión satisfatoriamente";
        }else{ // No puede iniciar sesión
                //$ruta = "./login.html";
        }

        

  // RESPONDER XML, JSON

        //Respuesta en JSON
        $resultado = [
                "msg" => $msg,
                "type" => ($usuario)?"success":"error",
                "ruta" => $ruta
            ]; //Vector PHP


        echo json_encode($resultado); // Convirtiendo en jSon

?>
