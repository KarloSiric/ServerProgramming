<?php
declare(strict_types=1);

class UserModel extends Model
{
    public function authenticate(string $email, string $password): ?array
    {
        $sql = "SELECT a.attendee_id,
                       a.email,
                       a.password,
                       a.first_name,
                       a.last_name,
                       r.name AS role_name
                FROM attendee a
                JOIN role r ON a.role_id = r.role_id
                WHERE a.email = :email
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['password'])) {
            return $row;
        }

        return null;
    }
}
