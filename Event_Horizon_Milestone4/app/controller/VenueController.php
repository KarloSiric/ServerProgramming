<?php

class VenueController extends Controller
{
    private $model;

    public function __construct()
    {
        Session::start();
        
        // Check if session expired
        if (isset($_SESSION['user']) && Session::isExpired()) {
            Session::destroy();
        }
        
        $this->model = new VenueModel();
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

        $venues = $this->model->all();
        $data = [
            'user' => $_SESSION['user'],
            'venues' => $venues
        ];
        $this->view($data);
    }
}
