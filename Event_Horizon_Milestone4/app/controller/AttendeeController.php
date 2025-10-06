<?php
declare(strict_types=1);

class AttendeeController extends Controller
{
    public function dashboard(): void
    {
        $this->requireLogin();
        $this->render('attendee/dashboard.php', [
            'user' => $_SESSION['user']
        ]);
    }
}
