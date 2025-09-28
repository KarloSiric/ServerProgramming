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
}
