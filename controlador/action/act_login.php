<?php
session_start();

// Solo permitimos acceso vía POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../vista/login.html');
    exit();
}

// Incluimos nuestro puente al DAO
require_once __DIR__ . '/../mdb/mdbUsuario.php';

// Recogemos y saneamos los datos
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL) ?: '';
$password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW) ?: '';

// Validar que no estén vacíos
if ($username === '' || $password === '') {
    header('Location: ../../vista/login.html?error=empty');
    exit();
}

// Intentamos autenticar
$usuario = autenticarUsuario($username, $password);
if (!$usuario) {
    // Credenciales inválidas
    header('Location: ../../vista/login.html?error=invalid');
    exit();
}

// Usuario válido: guardamos en sesión
$_SESSION['ID_USUARIO']     = $usuario->getId();
$_SESSION['NOMBRE_USUARIO'] = $usuario->getNombre();
$_SESSION['TIPO_USUARIO']   = $usuario->getRole();  // 'administrador', 'cajero' o 'cliente'

// Redirigimos al panel de bienvenida
header('Location: ../../vista/bienvenido.php');
exit();
