<?php

declare(strict_types=1);

class AttendeeModel extends Model
{
  public function byEvent(int $eventId): array
  {
    $sql = "SELECT 
                    a.attendee_id, 
                    a.first_name, 
                    a.last_name, 
                    a.email,
                    ae.paid
                FROM attendee_event ae
                JOIN attendee a ON a.attendee_id = ae.attendee_id
                WHERE ae.event_id = :id
                ORDER BY a.last_name, a.first_name";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $eventId]);
    return $stmt->fetchAll();
  }
}
