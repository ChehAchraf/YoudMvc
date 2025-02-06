<?php
namespace App\Controllers;

use App\Libraries\Controller;

class Student extends Controller {
    private $studentModel;

    public function __construct() {
        if(!isLoggedIn() || $_SESSION['user_role'] !== 'student') {
            redirect('users/login');
        }
        $this->studentModel = $this->model('Student');
    }

    public function profile() {
        $profile = $this->studentModel->getStudentProfile($_SESSION['user_id']);

        if(!$profile) {
            redirect('pages/error');
        }

        $data = [
            'title' => 'My Profile',
            'profile' => $profile
        ];

        $this->view('student/profile', $data);
    }

    public function dashboard() {
        if(!isLoggedIn() || $_SESSION['user_role'] !== 'student') {
            redirect('users/login');
        }

        $profile = $this->studentModel->getStudentProfile($_SESSION['user_id']);

        $data = [
            'title' => 'Student Dashboard',
            'profile' => $profile
        ];

        $this->view('student/dashboard', $data);
    }
} 