<?php
// EventModel.php - Modified for Lab 3 with PDO database access
class EventModelLab3 extends Model
{
    // Get all events from database using PDO with JOINs
    public function getAllEventsFromDB(): array
    {
        try {
            // SQL query with JOIN to get venue information and attendee counts
            $sql = "
                SELECT 
                    e.event_id,
                    e.name as event_name,
                    e.start_date,
                    e.end_date,
                    e.allowed_number as max_attendees,
                    v.name as venue_name,
                    v.venue_id,
                    v.capacity as venue_capacity,
                    COUNT(DISTINCT ae.attendee_id) as registered_attendees
                FROM 
                    event e
                LEFT JOIN 
                    venue v ON e.venue_id = v.venue_id
                LEFT JOIN 
                    attendee_event ae ON e.event_id = ae.event_id
                GROUP BY 
                    e.event_id, e.name, e.start_date, e.end_date, 
                    e.allowed_number, v.name, v.venue_id, v.capacity
                ORDER BY 
                    e.start_date ASC
            ";
            
            // Use the parent Model class connection
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            error_log("Database error in getAllEventsFromDB: " . $e->getMessage());
            return [];
        }
    }
    
    // Get event by ID from database
    public function getEventByIdFromDB(int $id): ?array
    {
        try {
            $sql = "
                SELECT 
                    e.event_id,
                    e.name as event_name,
                    e.start_date,
                    e.end_date,
                    e.allowed_number as max_attendees,
                    v.name as venue_name,
                    COUNT(DISTINCT ae.attendee_id) as registered_attendees
                FROM 
                    event e
                LEFT JOIN 
                    venue v ON e.venue_id = v.venue_id
                LEFT JOIN 
                    attendee_event ae ON e.event_id = ae.event_id
                WHERE 
                    e.event_id = :event_id
                GROUP BY 
                    e.event_id, e.name, e.start_date, e.end_date, 
                    e.allowed_number, v.name
            ";
            
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
            
        } catch(PDOException $e) {
            error_log("Database error in getEventByIdFromDB: " . $e->getMessage());
            return null;
        }
    }
    
    // Get attendees for a specific event
    public function getEventAttendees(int $eventId): array
    {
        try {
            $sql = "
                SELECT 
                    a.attendee_id,
                    a.first_name,
                    a.last_name,
                    a.email,
                    ae.paid
                FROM 
                    attendee a
                INNER JOIN 
                    attendee_event ae ON a.attendee_id = ae.attendee_id
                WHERE 
                    ae.event_id = :event_id
                ORDER BY 
                    a.last_name, a.first_name
            ";
            
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            error_log("Database error in getEventAttendees: " . $e->getMessage());
            return [];
        }
    }
}
