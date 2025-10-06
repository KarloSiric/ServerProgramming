<?php

declare(strict_types=1);

class EventController extends Controller
{
  public function index(): void
  {
    $model = new EventModel();
    $events = $model->getAllEvents();
    $this->render('event/events.php', ['events' => $events]);
  }

  // ----- admin-only CRUD -----
  public function create(): void
  {
    $this->requireRole('admin');
    $venues = (new VenueModel())->all();
    $this->render('event/event-form.php', ['venues' => $venues]);
  }

  public function store(): void
  {
    $this->requireRole('admin');
    $payload = [
      'name'           => trim($_POST['name'] ?? ''),
      'start_date'     => date('Y-m-d H:i:s', strtotime($_POST['start_date'] ?? '')),
      'end_date'       => date('Y-m-d H:i:s', strtotime($_POST['end_date'] ?? '')),
      'allowed_number' => (int)($_POST['allowed_number'] ?? 0),
      'venue_id'       => (int)($_POST['venue_id'] ?? 0),
    ];
    (new EventModel())->create($payload);
    $this->redirect('event', 'index');
  }

  public function edit(): void
  {
    $this->requireRole('admin');
    $id = (int)($_GET['id'] ?? 0);
    $model = new EventModel();
    $event = $model->find($id);
    if (!$event) {
      $this->render('event/events.php', ['events' => []]);
      return;
    }
    $venues = (new VenueModel())->all();
    $this->render('event/event-form.php', ['event' => $event, 'venues' => $venues]);
  }

  public function update(): void
  {
    $this->requireRole('admin');
    $id = (int)($_POST['id'] ?? 0);
    $payload = [
      'name'           => trim($_POST['name'] ?? ''),
      'start_date'     => date('Y-m-d H:i:s', strtotime($_POST['start_date'] ?? '')),
      'end_date'       => date('Y-m-d H:i:s', strtotime($_POST['end_date'] ?? '')),
      'allowed_number' => (int)($_POST['allowed_number'] ?? 0),
      'venue_id'       => (int)($_POST['venue_id'] ?? 0),
    ];
    (new EventModel())->update($id, $payload);
    $this->redirect('event', 'index');
  }

  public function destroy(): void
  {
    $this->requireRole('admin');
    $id = (int)($_POST['id'] ?? 0);
    (new EventModel())->delete($id);
    $this->redirect('event', 'index');
  }

  public function attendees(): void
  {
    // If you want this page restricted, leave this line.
    // If you want attendees to view it too, change to $this->requireLogin();
    $this->requireRole('admin');

    $eventId = (int)($_GET['id'] ?? 0);
    if ($eventId <= 0) {
      $this->redirect('event', 'index');
      return;
    }

    $event = (new EventModel())->find($eventId);
    if (!$event) {
      $this->redirect('event', 'index');
      return;
    }

    $attendees = (new AttendeeModel())->byEvent($eventId);

    $this->render('event/attendees.php', [
      'event'     => $event,
      'attendees' => $attendees,
      'eventId'   => $eventId,
    ]);
  }
}
