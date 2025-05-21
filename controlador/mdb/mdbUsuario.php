<?php
require_once __DIR__ . '/../../modelo/dao/UsuarioDAO.php';
require_once __DIR__ . '/../../modelo/entidad/Usuario.php';

/**
 * Autentica un usuario (administrador, cajero o cliente).
 * @param string $username
 * @param string $password
 * @return Usuario|null
 */
function autenticarUsuario(string $username, string $password): ?Usuario {
    $dao = new UsuarioDAO();
    return $dao->autenticarUsuario($username, $password);
}

/**
 * Busca un usuario por su ID.
 * @param int $id
 * @return Usuario|null
 */
function buscarUsuarioPorId(int $id): ?Usuario {
    $dao = new UsuarioDAO();
    return $dao->buscarUsuarioPorId($id);
}

/**
 * Busca un usuario por su username.
 * @param string $username
 * @return Usuario|null
 */
function buscarUsuarioPorUsername(string $username): ?Usuario {
    $dao = new UsuarioDAO();
    return $dao->buscarUsuarioPorUsername($username);
}

/**
 * Recupera todos los usuarios.
 * @return Usuario[]
 */
function leerUsuarios(): array {
    $dao = new UsuarioDAO();
    return $dao->leerUsuarios();
}

/**
 * Inserta un nuevo usuario en la BD.
 * @param Usuario $usuario
 * @return int ID generado
 */
function insertarUsuario(Usuario $usuario): int {
    $dao = new UsuarioDAO();
    return $dao->insertarUsuario($usuario);
}

/**
 * Actualiza un usuario existente.
 * @param Usuario $usuario
 * @return int N° de filas afectadas
 */
function modificarUsuario(Usuario $usuario): int {
    $dao = new UsuarioDAO();
    return $dao->modificarUsuario($usuario);
}

/**
 * Elimina un usuario por su ID.
 * @param int $id
 * @return int N° de filas afectadas
 */
function borrarUsuario(int $id): int {
    $dao = new UsuarioDAO();
    return $dao->borrarUsuario($id);
}
