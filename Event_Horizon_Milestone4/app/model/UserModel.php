<?php
declare(strict_types=1);

class UserModel extends Model
{
    /**
     * Authenticate by USERNAME (not email) — per requirement.
     */
    public function authenticate(string $username, string $password): ?array
    {
        $sql = "SELECT a.attendee_id, a.username, a.email, a.password, r.name AS role_name
                FROM attendee a
                JOIN role r ON r.role_id = a.role_id
                WHERE a.username = :un LIMIT 1";
        $st = $this->db->prepare($sql);
        $st->execute([':un' => $username]);
        $row = $st->fetch();
        if ($row && password_verify($password, (string)$row['password'])) {
            return [
                'id'        => (int)$row['attendee_id'],
                'username'  => $row['username'],
                'email'     => $row['email'],
                'role_name' => $row['role_name'],
            ];
        }
        return null;
    }

    public function register(array $d): int
    {
        $sql = "INSERT INTO attendee(first_name,last_name,email,username,password,role_id)
                VALUES(:fn,:ln,:email,:un,:pw,2)"; // role 2 => attendee
        $st = $this->db->prepare($sql);
        $st->execute([
            ':fn' => $d['first_name'], ':ln' => $d['last_name'], ':email' => $d['email'],
            ':un' => $d['username'], ':pw' => password_hash($d['password'], PASSWORD_DEFAULT),
        ]);
        return (int)$this->db->lastInsertId();
    }
}
