<?php
abstract class Model
{
    protected PDO $db;
    public function __construct()
    {
        $cfg = @parse_ini_file(CONFIG_PATH . '/config.ini', true);
        $h = $cfg['database']['host'] ?? '127.0.0.1';
        $n = $cfg['database']['name'] ?? 'KarloDB';
        $u = $cfg['database']['user'] ?? 'root';
        $p = $cfg['database']['pass'] ?? '';
        $this->db = new PDO("mysql:host=$h;dbname=$n;charset=utf8mb4", $u, (string)$p, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
}
