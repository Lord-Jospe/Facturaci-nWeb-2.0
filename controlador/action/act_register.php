<?php
session_start();

// 1) Solo permitimos POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../vista/register.html');
    exit();
}

// 2) Incluimos las funciones de negocio para clientes
require_once __DIR__ . '/../mdb/mdbCliente.php';

// 3) Recoger y sanear datos (coinciden con los name= de tu formulario)
$nombre     = filter_input(INPUT_POST, 'nombre',    FILTER_SANITIZE_STRING) ?: '';
$direccion  = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING) ?: '';
$telefono   = filter_input(INPUT_POST, 'telefono',  FILTER_SANITIZE_STRING) ?: '';
$email      = filter_input(INPUT_POST, 'email',     FILTER_SANITIZE_EMAIL)  ?: '';
$contrasena = $_POST['contrasena'] ?? '';
$confirm    = $_POST['confirm']    ?? '';

// 4) Validaciones
// 4.1 Campos obligatorios
if ($nombre === '' || $email === '' || $contrasena === '' || $confirm === '') {
    header('Location: ../../vista/register.html?error=empty');
    exit();
}
// 4.2 Email válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../../vista/register.html?error=invalid_email');
    exit();
}
// 4.3 Contraseñas coinciden
if ($contrasena !== $confirm) {
    header('Location: ../../vista/register.html?error=password_mismatch');
    exit();
}
// 4.4 Email no duplicado
if (emailClienteExiste($email)) {
    header('Location: ../../vista/register.html?error=email_exists');
    exit();
}

// 5) Insertamos el nuevo cliente
$nuevoId = registrarCliente($nombre, $direccion, $telefono, $email, $contrasena);
if ($nuevoId) {
    // Registro OK
    header('Location: ../../vista/login.html?msg=registered');
    exit();
} else {
    // Error Base de Datos
    header('Location: ../../vista/register.html?error=db');
    exit();
}
