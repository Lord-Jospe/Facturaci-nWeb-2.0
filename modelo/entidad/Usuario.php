<?php
class Usuario
{
    private int $id;
    private string $nombre;
    private string $username;
    private string $role;        // 'administrador' | 'cajero' | 'cliente'
    private ?string $passwordHash; // Hash o contraseña (no siempre la usamos)

    public function __construct(
        int     $id,
        string  $nombre,
        string  $username,
        string  $role,
        ?string $passwordHash = null
    ) {
        $this->id           = $id;
        $this->nombre       = $nombre;
        $this->username     = $username;
        $this->role         = $role;
        $this->passwordHash = $passwordHash;
    }

    // Getters
    public function getId(): int           { return $this->id; }
    public function getNombre(): string    { return $this->nombre; }
    public function getUsername(): string  { return $this->username; }
    public function getRole(): string      { return $this->role; }
    public function getPasswordHash(): ?string { return $this->passwordHash; }
}
?>
