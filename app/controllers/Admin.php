<?php
namespace App\Controllers;

use App\Libraries\Controller;

class Admin extends Controller {
    private $adminModel;
    private $courseModel;
    private $categoryModel;

    public function __construct() {
        // Check if user is logged in and is admin
        if(!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
            redirect('users/login');
        }

        $this->adminModel = $this->model('Admin');
        $this->courseModel = $this->model('Course');
        $this->categoryModel = $this->model('Category');
    }

    public function dashboard() {
        // Get statistics
        $stats = $this->adminModel->getPlatformStats();
        $pendingTeachers = $this->adminModel->getPendingTeachers();
        $pendingCourses = $this->adminModel->getPendingCourses();
        $recentUsers = $this->adminModel->getRecentUsers(5);

        $data = [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
            'pending_teachers' => $pendingTeachers,
            'pending_courses' => $pendingCourses,
            'recent_users' => $recentUsers
        ];

        $this->view('admin/dashboard', $data);
    }

    public function users($action = '', $id = '') {
        switch($action) {
            case 'approve':
                if($this->adminModel->updateUserStatus($id, 'approved')) {
                    flash('admin_message', 'User approved successfully');
                }
                redirect('admin/users');
                break;
            
            case 'block':
                if($this->adminModel->updateUserStatus($id, 'blocked')) {
                    flash('admin_message', 'User blocked successfully');
                }
                redirect('admin/users');
                break;

            default:
                $users = $this->adminModel->getAllUsers();
                $data = [
                    'title' => 'Manage Users',
                    'users' => $users
                ];
                $this->view('admin/users', $data);
                break;
        }
    }

    public function courses($action = '', $id = '') {
        // Check if user is admin
        if(!isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
            redirect('users/login');
        }

        switch($action) {
            case 'updateStatus':
                if($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $data = [
                        'id' => $id,
                        'status' => $_POST['status']
                    ];

                    if($this->courseModel->updateStatus($data)) {
                        flash('admin_message', 'Course status updated successfully');
                    } else {
                        flash('admin_message', 'Failed to update course status', 'alert alert-danger');
                    }
                    redirect('admin/courses');
                }
                break;

            default:
                // Get all courses with their details
                $courses = $this->courseModel->getAllCoursesWithDetails();
                $data = [
                    'title' => 'Manage Courses',
                    'courses' => $courses
                ];
                $this->view('admin/courses', $data);
                break;
        }
    }

    public function categories() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'name_err' => ''
            ];

            if(empty($data['name'])) {
                $data['name_err'] = 'Please enter category name';
            }

            if(empty($data['name_err'])) {
                if($this->categoryModel->create($data)) {
                    flash('admin_message', 'Category added successfully');
                    redirect('admin/categories');
                }
            }
        }

        $categories = $this->categoryModel->getAll();
        $data = [
            'title' => 'Manage Categories',
            'categories' => $categories
        ];
        $this->view('admin/categories', $data);
    }
} 