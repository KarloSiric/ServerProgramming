<?php
// demo data provider; stands in for the DB just for this milestone
class AppModel extends Model {
  public function venues(): array {
    return [
      ['venue_id'=>1,'name'=>'Hyrule Hall','capacity'=>500],
      ['venue_id'=>2,'name'=>'Vault 101 Auditorium','capacity'=>120],
    ];
  }
  public function events(): array {
    return [
      ['event_id'=>1,'name'=>'Night City Expo','start_date'=>'2025-10-01 10:00:00','end_date'=>'2025-10-01 16:00:00','allowed_number'=>200,'venue_id'=>1],
      ['event_id'=>2,'name'=>'Aperture Science Tour','start_date'=>'2025-10-15 18:00:00','end_date'=>'2025-10-15 20:30:00','allowed_number'=>100,'venue_id'=>2],
    ];
  }
  public function registrations(): array {
    return [
      ['attendee_id'=>999,'event_id'=>1,'paid'=>1],
    ];
  }
}
