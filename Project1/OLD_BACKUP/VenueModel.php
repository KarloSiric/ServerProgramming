<?php

/**
 * Venue Model for EventPro
 * Handles venue data and business logic
 * 
 * @author Student Implementation
 */
class VenueModel extends Model {
    
    /**
     * Hardcoded venues for demonstration
     */
    private $venues = [
        [
            'id' => 1,
            'name' => 'Convention Center',
            'type' => 'Conference Hall',
            'capacity' => 500,
            'address' => '123 Main St, Downtown',
            'amenities' => ['WiFi', 'Parking', 'Catering', 'A/V Equipment'],
            'price_per_day' => 2500.00,
            'rating' => 4.8,
            'available' => true
        ],
        [
            'id' => 2,
            'name' => 'Business Hub',
            'type' => 'Meeting Room',
            'capacity' => 50,
            'address' => '456 Corporate Blvd',
            'amenities' => ['WiFi', 'Projector', 'Whiteboard', 'Coffee'],
            'price_per_day' => 500.00,
            'rating' => 4.5,
            'available' => true
        ],
        [
            'id' => 3,
            'name' => 'Creative Space',
            'type' => 'Workshop Area',
            'capacity' => 40,
            'address' => '789 Art District',
            'amenities' => ['WiFi', 'Natural Light', 'Kitchen', 'Flexible Layout'],
            'price_per_day' => 750.00,
            'rating' => 4.9,
            'available' => true
        ],
        [
            'id' => 4,
            'name' => 'Innovation Lab',
            'type' => 'Tech Space',
            'capacity' => 100,
            'address' => '321 Tech Park',
            'amenities' => ['High-Speed WiFi', 'Monitors', 'Dev Tools', 'Parking'],
            'price_per_day' => 1200.00,
            'rating' => 4.7,
            'available' => false
        ],
        [
            'id' => 5,
            'name' => 'Grand Ballroom',
            'type' => 'Event Hall',
            'capacity' => 300,
            'address' => '555 Luxury Ave',
            'amenities' => ['Stage', 'Sound System', 'Lighting', 'Catering', 'Bar'],
            'price_per_day' => 3500.00,
            'rating' => 5.0,
            'available' => true
        ]
    ];
    
    /**
     * Gets all venues
     * @return array
     */
    public function getAllVenues() {
        return $this->venues;
    }
    
    /**
     * Gets a single venue by ID
     * @param int $id Venue ID
     * @return array|null
     */
    public function getVenueById($id) {
        foreach ($this->venues as $venue) {
            if ($venue['id'] == $id) {
                return $venue;
            }
        }
        return null;
    }
    
    /**
     * Creates a new venue
     * @param array $data Venue data
     * @return bool
     */
    public function createVenue($data) {
        // Sanitize and validate input
        $name = $this->sanitize($data['name'] ?? '');
        $type = $this->sanitize($data['type'] ?? '');
        $capacity = $this->sanitize($data['capacity'] ?? '');
        $address = $this->sanitize($data['address'] ?? '');
        $price = $this->sanitize($data['price_per_day'] ?? '');
        
        // Basic validation
        if (empty($name) || empty($type) || empty($capacity) || empty($address)) {
            return false;
        }
        
        // In a real app, this would save to database
        return true;
    }
    
    /**
     * Deletes a venue
     * @param int $id Venue ID
     * @return bool
     */
    public function deleteVenue($id) {
        // In a real app, this would delete from database
        return true;
    }
    
    /**
     * Gets available venues
     * @return array
     */
    public function getAvailableVenues() {
        $available = [];
        foreach ($this->venues as $venue) {
            if ($venue['available']) {
                $available[] = $venue;
            }
        }
        return $available;
    }
}
