<?php
declare(strict_types=1);

class VenueModel extends Model
{
    public function all(): array
    {
        $sql = "SELECT venue_id, name, capacity FROM venue ORDER BY name";
        return $this->db->query($sql)->fetchAll();
    }
}
