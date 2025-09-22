<?php

/**
 * Event Model for EventPro
 * Handles event data and business logic
 * 
 * @author Student Implementation
 */
class EventModel extends Model {
    
    /**
     * Hardcoded events for demonstration
     */
    private $events = [
        [
            'id' => 1,
            'title' => 'Tech Conference 2024',
            'date' => '2024-12-15',
            'time' => '09:00',
            'location' => 'Convention Center',
            'description' => 'Annual technology conference featuring the latest innovations',
            'attendees' => 150,
            'max_attendees' => 200,
            'status' => 'upcoming',
            'organizer' => 'organizer',
            'price' => 99.00
        ],
        [
            'id' => 2,
            'title' => 'Marketing Workshop',
            'date' => '2024-12-08',
            'time' => '14:00',
            'location' => 'Business Hub',
            'description' => 'Learn the latest digital marketing strategies',
            'attendees' => 45,
            'max_attendees' => 50,
            'status' => 'upcoming',
            'organizer' => 'john',
            'price' => 49.00
        ],
        [
            'id' => 3,
            'title' => 'Design Meetup',
            'date' => '2024-11-28',
            'time' => '18:30',
            'location' => 'Creative Space',
            'description' => 'Monthly meetup for designers and creatives',
            'attendees' => 32,
            'max_attendees' => 40,
            'status' => 'completed',
            'organizer' => 'organizer',
            'price' => 0.00
        ],
        [
            'id' => 4,
            'title' => 'Startup Pitch Night',
            'date' => '2024-12-20',
            'time' => '19:00',
            'location' => 'Innovation Lab',
            'description' => 'Watch startups pitch to investors',
            'attendees' => 75,
            'max_attendees' => 100,
            'status' => 'upcoming',
            'organizer' => 'john',
            'price' => 15.00
        ]
    ];
    
    /**
     * Gets all events based on user role
     * @param string $role User's role
     * @param string $username Username
     * @return array
     */
    public function getAllEvents($role, $username) {
        if ($role === 'admin') {
            // Admin sees all events
            return $this->events;
        } elseif ($role === 'organizer') {
            // Organizer sees only their events
            $userEvents = [];
            foreach ($this->events as $event) {
                if ($event['organizer'] === $username) {
                    $userEvents[] = $event;
                }
            }
            return $userEvents;
        } else {
            // Attendees see all public events
            return $this->events;
        }
    }
    
    /**
     * Gets a single event by ID
     * @param int $id Event ID
     * @return array|null
     */
    public function getEventById($id) {
        foreach ($this->events as $event) {
            if ($event['id'] == $id) {
                return $event;
            }
        }
        return null;
    }
    
    /**
     * Creates a new event
     * @param array $data Event data
     * @return bool
     */
    public function createEvent($data) {
        // Sanitize and validate input
        $title = $this->sanitize($data['title'] ?? '');
        $date = $this->sanitize($data['date'] ?? '');
        $time = $this->sanitize($data['time'] ?? '');
        $location = $this->sanitize($data['location'] ?? '');
        $description = $this->sanitize($data['description'] ?? '');
        $max_attendees = $this->sanitize($data['max_attendees'] ?? '50');
        $price = $this->sanitize($data['price'] ?? '0');
        
        // Basic validation
        if (empty($title) || empty($date) || empty($time) || empty($location)) {
            return false;
        }
        
        // In a real app, this would save to database
        return true;
    }
    
    /**
     * Deletes an event
     * @param int $id Event ID
     * @return bool
     */
    public function deleteEvent($id) {
        // In a real app, this would delete from database
        return true;
    }
    
    /**
     * Gets event statistics
     * @return array
     */
    public function getEventStats() {
        $total = count($this->events);
        $upcoming = 0;
        $completed = 0;
        $totalAttendees = 0;
        
        foreach ($this->events as $event) {
            if ($event['status'] === 'upcoming') {
                $upcoming++;
            } else {
                $completed++;
            }
            $totalAttendees += $event['attendees'];
        }
        
        return [
            'total' => $total,
            'upcoming' => $upcoming,
            'completed' => $completed,
            'attendees' => $totalAttendees
        ];
    }
}
