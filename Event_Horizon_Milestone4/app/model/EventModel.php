<?php

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

  public function getVenues(): array
  {
    $sql = "SELECT venue_id, name, capacity FROM venue ORDER BY name";
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
    // Get the next available event_id
    $sql = "SELECT COALESCE(MAX(event_id), 0) + 1 AS next_id FROM event";
    $stmt = $this->db->query($sql);
    $nextId = (int)$stmt->fetchColumn();

    // Insert with explicit event_id
    $sql = "INSERT INTO event(event_id, name, start_date, end_date, allowed_number, venue_id)
                VALUES(:id, :name, :start, :end, :allowed, :venue)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':id'      => $nextId,
      ':name'    => $e['name'],
      ':start'   => $e['start_date'],
      ':end'     => $e['end_date'],
      ':allowed' => (int)$e['allowed_number'],
      ':venue'   => (int)$e['venue_id'],
    ]);
    return $nextId;
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

  // Get all event IDs that a user is registered for
  public function getUserRegisteredEvents(int $userId): array
  {
    $sql = "SELECT event_id FROM attendee_event WHERE attendee_id = :uid";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':uid' => $userId]);
    return array_column($stmt->fetchAll(), 'event_id');
  }

  // Register a user for an event
  public function registerUserForEvent(int $userId, int $eventId): bool
  {
    // Check if already registered
    $sql = "SELECT COUNT(*) FROM attendee_event WHERE attendee_id = :uid AND event_id = :eid";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':uid' => $userId, ':eid' => $eventId]);
    
    if ($stmt->fetchColumn() > 0) {
      return false; // Already registered
    }

    // Check if event is full
    $sql = "SELECT e.allowed_number, COUNT(ae.attendee_id) as current_count
            FROM event e
            LEFT JOIN attendee_event ae ON e.event_id = ae.event_id
            WHERE e.event_id = :eid
            GROUP BY e.event_id, e.allowed_number";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':eid' => $eventId]);
    $eventInfo = $stmt->fetch();

    if ($eventInfo && $eventInfo['current_count'] >= $eventInfo['allowed_number']) {
      return false; // Event is full
    }

    // Register user
    $sql = "INSERT INTO attendee_event (attendee_id, event_id, paid) VALUES (:uid, :eid, 0)";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([':uid' => $userId, ':eid' => $eventId]);
  }

  // Unregister a user from an event
  public function unregisterUserFromEvent(int $userId, int $eventId): bool
  {
    $sql = "DELETE FROM attendee_event WHERE attendee_id = :uid AND event_id = :eid";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([':uid' => $userId, ':eid' => $eventId]);
  }
}
