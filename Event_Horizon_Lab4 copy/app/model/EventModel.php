<?php

declare(strict_types=1);

class EventModel extends Model
{
  public function getAllEvents(): array
  {
    $sql = "SELECT e.event_id,
                       e.name AS name,
                       e.start_date,
                       e.end_date,
                       e.allowed_number,
                       v.name AS venue_name,
                       COUNT(ae.attendee_id) AS attendee_count
                FROM event e
                JOIN venue v ON e.venue_id = v.venue_id
                LEFT JOIN attendee_event ae ON e.event_id = ae.event_id
                GROUP BY e.event_id, e.name, e.start_date, e.end_date, e.allowed_number, v.name
                ORDER BY e.start_date ASC";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
  }

  public function find(int $id): ?array
  {
    $sql = "SELECT e.event_id, e.name, e.start_date, e.end_date, e.allowed_number, e.venue_id
                FROM event e WHERE e.event_id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    return $row ?: null;
  }

  public function create(array $e): int
  {
    $sql = "INSERT INTO event(name,start_date,end_date,allowed_number,venue_id)
                VALUES(:name,:start,:end,:allowed,:venue)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':name'    => $e['name'],
      ':start'   => $e['start_date'],
      ':end'     => $e['end_date'],
      ':allowed' => (int)$e['allowed_number'],
      ':venue'   => (int)$e['venue_id'],
    ]);
    return (int)$this->db->lastInsertId();
  }

  public function update(int $id, array $e): void
  {
    $sql = "UPDATE event
                   SET name=:name, start_date=:start, end_date=:end,
                       allowed_number=:allowed, venue_id=:venue
                 WHERE event_id=:id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':name'    => $e['name'],
      ':start'   => $e['start_date'],
      ':end'     => $e['end_date'],
      ':allowed' => (int)$e['allowed_number'],
      ':venue'   => (int)$e['venue_id'],
      ':id'      => $id,
    ]);
  }

  public function delete(int $id): void
  {
    $this->db->beginTransaction();
    try {
      $stmt = $this->db->prepare("DELETE FROM attendee_event WHERE event_id = :id");
      $stmt->execute([':id' => $id]);

      $stmt = $this->db->prepare("DELETE FROM event WHERE event_id = :id");
      $stmt->execute([':id' => $id]);

      $this->db->commit();
    } catch (Throwable $e) {
      $this->db->rollBack();
      throw $e;
    }
  }
}
