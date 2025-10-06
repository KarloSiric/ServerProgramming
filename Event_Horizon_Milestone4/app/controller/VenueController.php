<?php
declare(strict_types=1);

class VenueController extends Controller
{
    public function index(): void
    {
        $this->requireRole('admin');
        $model = new VenueModel();
        $venues = $model->all();
        $this->render('venue/venues.php', ['venues' => $venues]);
    }
}
