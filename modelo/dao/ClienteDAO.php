<?php
require_once 'DataSource.php';
require_once __DIR__ . '/../entidad/Cliente.php';

class ClienteDAO {

    /**
     * Intenta autenticar un cliente por email y contraseña (texto plano).
     * @return Cliente|null
     */
    public function autenticarCliente(string $email, string $password): ?Cliente {
        $ds = new DataSource();
        $sql = "
            SELECT id, nombre, direccion, telefono, email, contrasena
            FROM clientes
            WHERE email       = :email
              AND contrasena  = :pass
            LIMIT 1
        ";
        $rows = $ds->ejecutarConsulta($sql, [
            ':email' => $email,
            ':pass'  => $password
        ]);
        if (count($rows) === 1) {
            $r = $rows[0];
            return new Cliente(
                (int)   $r['id'],
                $r['nombre'],
                $r['direccion'],
                $r['telefono'],
                $r['email'],
                $r['contrasena']
            );
        }
        return null;
    }

    /**
     * Busca un cliente por su email.
     * @return Cliente|null
     */
    public function buscarClientePorEmail(string $email): ?Cliente {
        $ds = new DataSource();
        $sql = "
            SELECT id, nombre, direccion, telefono, email, contrasena
            FROM clientes
            WHERE email = :email
            LIMIT 1
        ";
        $rows = $ds->ejecutarConsulta($sql, [':email' => $email]);
        if (count($rows) === 1) {
            $r = $rows[0];
            return new Cliente(
                (int)   $r['id'],
                $r['nombre'],
                $r['direccion'],
                $r['telefono'],
                $r['email'],
                $r['contrasena']
            );
        }
        return null;
    }

    /**
     * Busca un cliente por su ID.
     * @return Cliente|null
     */
    public function buscarClientePorId(int $id): ?Cliente {
        $ds = new DataSource();
        $sql = "
            SELECT id, nombre, direccion, telefono, email, contrasena
            FROM clientes
            WHERE id = :id
            LIMIT 1
        ";
        $rows = $ds->ejecutarConsulta($sql, [':id' => $id]);
        if (count($rows) === 1) {
            $r = $rows[0];
            return new Cliente(
                (int)   $r['id'],
                $r['nombre'],
                $r['direccion'],
                $r['telefono'],
                $r['email'],
                $r['contrasena']
            );
        }
        return null;
    }

    /**
     * Devuelve todos los clientes.
     * @return Cliente[]
     */
    public function leerClientes(): array {
        $ds = new DataSource();
        $sql = "SELECT id, nombre, direccion, telefono, email, contrasena FROM clientes";
        $rows = $ds->ejecutarConsulta($sql);
        $clientes = [];
        foreach ($rows as $r) {
            $clientes[] = new Cliente(
                (int)   $r['id'],
                $r['nombre'],
                $r['direccion'],
                $r['telefono'],
                $r['email'],
                $r['contrasena']
            );
        }
        return $clientes;
    }

    /**
     * Inserta un nuevo cliente (con contraseña en texto plano).
     * @return int ID generado
     */
    public function insertarCliente(Cliente $cliente): int {
        $ds = new DataSource();
        $sql = "
            INSERT INTO clientes (nombre, direccion, telefono, email, contrasena)
            VALUES (:nombre, :direccion, :telefono, :email, :contrasena)
        ";
        $params = [
            ':nombre'     => $cliente->getNombre(),
            ':direccion'  => $cliente->getDireccion(),
            ':telefono'   => $cliente->getTelefono(),
            ':email'      => $cliente->getEmail(),
            ':contrasena' => $cliente->getContrasena()
        ];
        $ds->ejecutarActualizacion($sql, $params);
        $newId = $ds->getLastInsertId();
        $cliente->setId((int)$newId);
        return (int)$newId;
    }

    /**
     * Actualiza los datos de un cliente.
     * @return int Filas afectadas
     */
    public function modificarCliente(Cliente $cliente): int {
        $ds = new DataSource();
        $sql = "
            UPDATE clientes
               SET nombre     = :nombre,
                   direccion  = :direccion,
                   telefono   = :telefono,
                   email      = :email,
                   contrasena = :contrasena
             WHERE id = :id
        ";
        $params = [
            ':nombre'     => $cliente->getNombre(),
            ':direccion'  => $cliente->getDireccion(),
            ':telefono'   => $cliente->getTelefono(),
            ':email'      => $cliente->getEmail(),
            ':contrasena' => $cliente->getContrasena(),
            ':id'         => $cliente->getId()
        ];
        return $ds->ejecutarActualizacion($sql, $params);
    }

    /**
     * Elimina un cliente por su ID.
     * @return int Filas afectadas
     */
    public function borrarCliente(int $id): int {
        $ds = new DataSource();
        return $ds->ejecutarActualizacion(
            "DELETE FROM clientes WHERE id = :id",
            [':id' => $id]
        );
    }
}
