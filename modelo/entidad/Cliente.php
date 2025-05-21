<?php
class Cliente
{
    private ?int $id;
    private string $nombre;
    private ?string $direccion;
    private ?string $telefono;
    private string $email;
    private string $contrasena;

    public function __construct(
        ?int    $id,
        string  $nombre,
        ?string $direccion,
        ?string $telefono,
        string  $email,
        string  $contrasena
    ) {
        $this->id         = $id;
        $this->nombre     = $nombre;
        $this->direccion  = $direccion;
        $this->telefono   = $telefono;
        $this->email      = $email;
        $this->contrasena = $contrasena;
    }

    // Getters
    public function getId(): ?int         { return $this->id; }
    public function getNombre(): string   { return $this->nombre; }
    public function getDireccion(): ?string{ return $this->direccion; }
    public function getTelefono(): ?string { return $this->telefono; }
    public function getEmail(): string     { return $this->email; }
    public function getContrasena(): string{ return $this->contrasena; }

    // Setters
    public function setId(?int $id): self                        { $this->id = $id; return $this; }
    public function setNombre(string $nombre): self               { $this->nombre = $nombre; return $this; }
    public function setDireccion(?string $direccion): self        { $this->direccion = $direccion; return $this; }
    public function setTelefono(?string $telefono): self          { $this->telefono = $telefono; return $this; }
    public function setEmail(string $email): self                 { $this->email = $email; return $this; }
    public function setContrasena(string $contrasena): self       { $this->contrasena = $contrasena; return $this; }
}
?>
