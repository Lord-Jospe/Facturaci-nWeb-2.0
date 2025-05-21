<?php
require_once __DIR__ . '/../../modelo/dao/ClienteDAO.php';
require_once __DIR__ . '/../../modelo/entidad/Cliente.php';

/**
 * Comprueba si ya existe un cliente con este email.
 */
function emailClienteExiste(string $email): bool {
    $dao = new ClienteDAO();
    return $dao->buscarClientePorEmail($email) !== null;
}

/**
 * Registra un nuevo cliente y devuelve su ID o null si falló.
 */
function registrarCliente(
    string  $nombre,
    ?string $direccion,
    ?string $telefono,
    string  $email,
    string  $contrasena
): ?int {
    $dao = new ClienteDAO();
    $cliente = new Cliente(
        null,
        $nombre,
        $direccion,
        $telefono,
        $email,
        $contrasena
    );
    return $dao->insertarCliente($cliente) ?: null;
}
