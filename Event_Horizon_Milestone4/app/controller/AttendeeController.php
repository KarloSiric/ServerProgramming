<?php

class AttendeeController extends Controller
{
    public function __construct()
    {
        Session::start();
        
        // Check if session expired
        if (isset($_SESSION['user']) && Session::isExpired()) {
            Session::destroy();
        }
    }

    public function dashboard()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . PROJECT_URL . '/user/login');
            exit;
        }

        $data = ['user' => $_SESSION['user']];
        $this->view($data);
    }
}
