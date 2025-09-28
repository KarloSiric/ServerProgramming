<?php
declare(strict_types=1);

class EventController extends Controller
{
    public function index(): void
    {
        $model = new EventModel();
        $events = $model->getAllEvents(); // FIX: use the correct method
        $this->render('event/events.php', ['events' => $events]);
    }

    public function attendees(): void
    {
    $eventId = $_GET['id'] ?? 0;
    require VIEW_PATH . '/inc/header.php';
    require VIEW_PATH . '/event/attendees.php';
    require VIEW_PATH . '/inc/footer.php';
    } 

}
