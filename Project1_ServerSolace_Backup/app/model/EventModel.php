<?php
// EventModel.php - EventHorizon event data
class EventModel extends Model
{
    private array $events = [
        1 => [
            'id' => 1,
            'name' => 'React Summit 2024',
            'description' => 'The biggest React conference of the year featuring the latest in React ecosystem, performance optimization, and emerging patterns.',
            'date' => '2025-03-15',
            'time' => '9:00 AM',
            'end_time' => '6:00 PM',
            'type' => 'conference',
            'venue_id' => 1,
            'venue_name' => 'San Francisco Convention Center',
            'venue_capacity' => 500,
            'price' => 299,
            'registration_count' => 342,
            'organizer' => 'React Foundation',
            'status' => 'upcoming'
        ],
        2 => [
            'id' => 2,
            'name' => 'Advanced TypeScript Workshop',
            'description' => 'Deep dive into advanced TypeScript patterns, generics, and type-level programming for real-world applications.',
            'date' => '2025-03-22',
            'time' => '10:00 AM',
            'end_time' => '4:00 PM',
            'type' => 'workshop',
            'venue_id' => 2,
            'venue_name' => 'Tech Hub Downtown',
            'venue_capacity' => 30,
            'price' => 149,
            'registration_count' => 28,
            'organizer' => 'TypeScript Guild',
            'status' => 'upcoming'
        ],
        3 => [
            'id' => 3,
            'name' => 'Tech Leaders Networking Event',
            'description' => 'Connect with fellow tech leaders, share insights, and build meaningful professional relationships in the tech industry.',
            'date' => '2025-03-28',
            'time' => '6:00 PM',
            'end_time' => '9:00 PM', 
            'type' => 'networking',
            'venue_id' => 3,
            'venue_name' => 'Rooftop Lounge, Innovation District',
            'venue_capacity' => 100,
            'price' => 75,
            'registration_count' => 67,
            'organizer' => 'TechLeaders Network',
            'status' => 'upcoming'
        ],
        4 => [
            'id' => 4,
            'name' => 'AI & Machine Learning Conference',
            'description' => 'Explore the latest developments in AI and ML with industry experts and cutting-edge research presentations.',
            'date' => '2025-04-05',
            'time' => '9:00 AM',
            'end_time' => '5:00 PM',
            'type' => 'conference',
            'venue_id' => 4,
            'venue_name' => 'Innovation Center',
            'venue_capacity' => 300,
            'price' => 399,
            'registration_count' => 245,
            'organizer' => 'AI Research Institute',
            'status' => 'upcoming'
        ],
        5 => [
            'id' => 5,
            'name' => 'Web Performance Optimization Workshop',
            'description' => 'Learn advanced techniques for optimizing web application performance, from loading times to runtime efficiency.',
            'date' => '2025-04-12',
            'time' => '1:00 PM',
            'end_time' => '5:00 PM',
            'type' => 'workshop',
            'venue_id' => 5,
            'venue_name' => 'DevSpace Co-working',
            'venue_capacity' => 25,
            'price' => 99,
            'registration_count' => 22,
            'organizer' => 'Performance Guild',
            'status' => 'upcoming'
        ]
    ];
    
    public function getAllEvents(): array
    {
        return array_values($this->events);
    }
    
    public function getEventById(int $id): ?array
    {
        return $this->events[$id] ?? null;
    }
    
    public function createEvent(string $name, string $description, string $date, int $venueId, array $extraData = []): bool
    {
        $newId = max(array_keys($this->events)) + 1;
        
        $venueModel = new VenueModel();
        $venue = $venueModel->getVenueById($venueId);
        
        if (!$venue) {
            return false;
        }
        
        $this->events[$newId] = [
            'id' => $newId,
            'name' => $name,
            'description' => $description,
            'date' => $date,
            'time' => $extraData['time'] ?? '9:00 AM',
            'end_time' => $extraData['end_time'] ?? '5:00 PM',
            'type' => $extraData['type'] ?? 'conference',
            'venue_id' => $venueId,
            'venue_name' => $venue['name'],
            'venue_capacity' => $venue['capacity'],
            'price' => $extraData['price'] ?? 199,
            'registration_count' => 0,
            'organizer' => $extraData['organizer'] ?? 'Event Organizer',
            'status' => 'upcoming'
        ];
        
        return true;
    }
    
    public function getUpcomingEvents(): array
    {
        $today = date('Y-m-d');
        return array_filter($this->events, fn($event) => $event['date'] >= $today);
    }
    
    public function getEventsByType(string $type): array
    {
        return array_filter($this->events, fn($event) => 
            strtolower($event['type']) === strtolower($type)
        );
    }
    
    public function getEventStats(): array
    {
        $total = count($this->events);
        $upcoming = count($this->getUpcomingEvents());
        $totalRegistrations = array_sum(array_column($this->events, 'registration_count'));
        
        $types = array_count_values(array_column($this->events, 'type'));
        
        return [
            'total_events' => $total,
            'upcoming_events' => $upcoming,
            'total_registrations' => $totalRegistrations,
            'event_types' => $types,
        ];
    }
}
