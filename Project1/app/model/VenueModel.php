<?php
// VenueModel.php - EventHorizon venue management
class VenueModel extends Model
{
    private array $venues = [
        1 => [
            'id' => 1,
            'name' => 'San Francisco Convention Center',
            'address' => '747 Howard St, San Francisco, CA 94103',
            'capacity' => 500,
            'amenities' => ['AV Equipment', 'WiFi', 'Catering', 'Parking']
        ],
        2 => [
            'id' => 2,
            'name' => 'Tech Hub Downtown',
            'address' => '123 Tech Street, San Francisco, CA 94105',
            'capacity' => 30,
            'amenities' => ['WiFi', 'Whiteboards', 'Coffee']
        ],
        3 => [
            'id' => 3,
            'name' => 'Rooftop Lounge, Innovation District',
            'address' => '456 Innovation Blvd, San Francisco, CA 94107',
            'capacity' => 100,
            'amenities' => ['Outdoor Space', 'Bar', 'City Views']
        ],
        4 => [
            'id' => 4,
            'name' => 'Innovation Center',
            'address' => '789 Future Ave, San Francisco, CA 94110',
            'capacity' => 300,
            'amenities' => ['AV Equipment', 'WiFi', 'Laboratory Space']
        ],
        5 => [
            'id' => 5,
            'name' => 'DevSpace Co-working',
            'address' => '321 Developer Way, San Francisco, CA 94112',
            'capacity' => 25,
            'amenities' => ['WiFi', 'Standing Desks', 'Coffee']
        ]
    ];
    
    public function getAllVenues(): array
    {
        return array_values($this->venues);
    }
    
    public function getVenueById(int $id): ?array
    {
        return $this->venues[$id] ?? null;
    }
    
    public function getVenueStats(): array
    {
        $total = count($this->venues);
        $totalCapacity = array_sum(array_column($this->venues, 'capacity'));
        $avgCapacity = $totalCapacity / $total;
        
        return [
            'total_venues' => $total,
            'total_capacity' => $totalCapacity,
            'average_capacity' => round($avgCapacity),
            'largest_venue' => max(array_column($this->venues, 'capacity')),
        ];
    }
}
