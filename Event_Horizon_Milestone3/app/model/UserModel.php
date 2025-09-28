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

  public function register(array $d): int
  {
    // role_id 2 = attendee
    $sql = "INSERT INTO attendee(first_name,last_name,email,username,password,role_id)
            VALUES(:fn,:ln,:email,:un,:pw,2)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':fn'    => $d['first_name'],
      ':ln'    => $d['last_name'],
      ':email' => $d['email'],
      ':un'    => $d['username'],
      ':pw'    => password_hash($d['password'], PASSWORD_DEFAULT),
    ]);
    return (int)$this->db->lastInsertId();
  }
}
