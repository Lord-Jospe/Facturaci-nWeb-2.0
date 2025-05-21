<?php
require_once 'DataSource.php';
require_once __DIR__ . '/../entidad/Usuario.php';

class UsuarioDAO {

    /**
     * Intenta autenticar un usuario (admin/cajero) o un cliente.
     * Devuelve un Usuario con role = 'administrador', 'cajero' o 'cliente'.
     */
    public function autenticarUsuario(string $username, string $password): ?Usuario {
        $ds = new DataSource();
        $sql = "
            (
              SELECT 
                u.id,
                u.nombre,
                u.username AS user,
                r.nombre   AS role,
                u.password_hash AS pass
              FROM usuarios u
              JOIN roles r ON u.role_id = r.id
              WHERE u.username      = :username
                AND u.password_hash = :hash
            )
            UNION
            (
              SELECT
                c.id,
                c.nombre,
                c.email    AS user,
                'cliente'  AS role,
                c.contrasena AS pass
              FROM clientes c
              WHERE c.email      = :username
                AND c.contrasena = :plain
            )
            LIMIT 1
        ";

        $rows = $ds->ejecutarConsulta($sql, [
            ':username' => $username,
            ':hash'     => md5($password),
            ':plain'    => $password
        ]);

        if (count($rows) === 1) {
            $r = $rows[0];
            return new Usuario(
                (int)   $r['id'],          // id
                (string)$r['nombre'],      // nombre
                (string)$r['user'],        // username/email
                (string)$r['role'],        // role
                (string)$r['pass']         // passwordHash
            );
        }
        return null;
    }

    /**
     * Busca un usuario por su username.
     */
    public function buscarUsuarioPorUsername(string $username): ?Usuario {
        $ds = new DataSource();
        $sql = "
            SELECT u.id, u.nombre, u.username, r.nombre AS role, u.password_hash
              FROM usuarios u
              JOIN roles r ON u.role_id = r.id
             WHERE u.username = :username
             LIMIT 1
        ";
        $rows = $ds->ejecutarConsulta($sql, [':username' => $username]);
        if (count($rows) === 1) {
            $r = $rows[0];
            return new Usuario(
                (int)   $r['id'],            // id
                (string)$r['nombre'],        // nombre
                (string)$r['username'],      // username
                (string)$r['role'],          // role
                (string)$r['password_hash']  // passwordHash
            );
        }
        return null;
    }

    /**
     * Busca un usuario por su ID.
     */
    public function buscarUsuarioPorId(int $id): ?Usuario {
        $ds = new DataSource();
        $sql = "
            SELECT u.id, u.nombre, u.username, r.nombre AS role, u.password_hash
              FROM usuarios u
              JOIN roles r ON u.role_id = r.id
             WHERE u.id = :id
             LIMIT 1
        ";
        $rows = $ds->ejecutarConsulta($sql, [':id' => $id]);
        if (count($rows) === 1) {
            $r = $rows[0];
            return new Usuario(
                (int)   $r['id'],            // id
                (string)$r['nombre'],        // nombre
                (string)$r['username'],      // username
                (string)$r['role'],          // role
                (string)$r['password_hash']  // passwordHash
            );
        }
        return null;
    }

    /**
     * Devuelve todos los usuarios.
     * @return Usuario[]
     */
    public function leerUsuarios(): array {
        $ds = new DataSource();
        $sql = "
            SELECT u.id, u.nombre, u.username, r.nombre AS role, u.password_hash
              FROM usuarios u
              JOIN roles r ON u.role_id = r.id
        ";
        $rows = $ds->ejecutarConsulta($sql);
        $usuarios = [];
        foreach ($rows as $r) {
            $usuarios[] = new Usuario(
                (int)   $r['id'],            // id
                (string)$r['nombre'],        // nombre
                (string)$r['username'],      // username
                (string)$r['role'],          // role
                (string)$r['password_hash']  // passwordHash
            );
        }
        return $usuarios;
    }

    /**
     * Inserta un nuevo usuario. El password debe estar en texto plano;
     * se guarda como MD5.
     * @return int Nuevo ID
     */
    public function insertarUsuario(Usuario $usuario): int {
        $ds = new DataSource();
        $sql = "
            INSERT INTO usuarios (nombre, username, password_hash, role_id)
            VALUES (:nombre, :username, :hash,
                (SELECT id FROM roles WHERE nombre = :role LIMIT 1)
            )
        ";
        $params = [
            ':nombre'   => $usuario->getNombre(),
            ':username' => $usuario->getUsername(),
            ':hash'     => md5($usuario->getPasswordHash()),
            ':role'     => $usuario->getRole()
        ];
        $ds->ejecutarActualizacion($sql, $params);
        $nuevoId = $ds->getLastInsertId();
        $usuario->setId((int)$nuevoId);
        return (int)$nuevoId;
    }

    /**
     * Actualiza un usuario.
     * @return int Filas afectadas
     */
    public function modificarUsuario(Usuario $usuario): int {
        $ds = new DataSource();
        $sql = "
            UPDATE usuarios
               SET nombre        = :nombre,
                   username      = :username,
                   password_hash = :hash,
                   role_id       = (SELECT id FROM roles WHERE nombre = :role LIMIT 1)
             WHERE id = :id
        ";
        $params = [
            ':nombre'   => $usuario->getNombre(),
            ':username' => $usuario->getUsername(),
            ':hash'     => md5($usuario->getPasswordHash()),
            ':role'     => $usuario->getRole(),
            ':id'       => $usuario->getId()
        ];
        return $ds->ejecutarActualizacion($sql, $params);
    }

    /**
     * Elimina un usuario por su ID.
     * @return int Filas afectadas
     */
    public function borrarUsuario(int $id): int {
        $ds = new DataSource();
        return $ds->ejecutarActualizacion(
            "DELETE FROM usuarios WHERE id = :id",
            [':id' => $id]
        );
    }
}
?>
