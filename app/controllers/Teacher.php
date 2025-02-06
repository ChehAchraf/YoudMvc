<?php
namespace App\Controllers;

use App\Libraries\Controller;

class Teacher extends Controller {
    private $teacherModel;
    private $courseModel;

    public function __construct() {
        // Check if user is logged in and is teacher
        if(!isLoggedIn() || $_SESSION['user_role'] !== 'teacher') {
            redirect('users/login');
        }

        $this->teacherModel = $this->model('Teacher');
        $this->courseModel = $this->model('Course');
    }

    public function dashboard() {
        // Get teacher's statistics and data
        $teacherId = $_SESSION['user_id'];
        $stats = $this->teacherModel->getTeacherStats($teacherId);
        $courses = $this->teacherModel->getTeacherCourses($teacherId);
        $recentEnrollments = $this->teacherModel->getRecentEnrollments($teacherId);

        $data = [
            'title' => 'Teacher Dashboard',
            'stats' => $stats,
            'courses' => $courses,
            'recent_enrollments' => $recentEnrollments
        ];

        $this->view('teacher/dashboard', $data);
    }

    public function courses($action = '', $id = '') {
        $teacherId = $_SESSION['user_id'];

        switch($action) {
            case 'edit':
                if(!$id) {
                    redirect('teacher/courses');
                }

                if($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    
                    $data = [
                        'id' => $id,
                        'title' => trim($_POST['title']),
                        'description' => trim($_POST['description']),
                        'category_id' => trim($_POST['category_id']),
                        'price' => trim($_POST['price']),
                        'instructor_id' => $teacherId
                    ];

                    if($this->courseModel->update($id, $data)) {
                        flash('teacher_message', 'Course updated successfully');
                    } else {
                        flash('teacher_message', 'Error updating course', 'alert alert-danger');
                    }
                    redirect('teacher/courses');
                }
                break;

            case 'create':
                if($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    // Process course creation
                    $data = [
                        'title' => trim($_POST['title']),
                        'description' => trim($_POST['description']),
                        'category_id' => trim($_POST['category_id']),
                        'price' => trim($_POST['price']),
                        'instructor_id' => $teacherId,
                        'content_type' => trim($_POST['content_type']),
                        'video_url' => isset($_POST['video_url']) ? trim($_POST['video_url']) : ''
                    ];

                    if($this->courseModel->create($data)) {
                        flash('teacher_message', 'Course created successfully');
                        redirect('teacher/courses');
                    } else {
                        flash('teacher_message', 'Error creating course', 'alert alert-danger');
                        redirect('teacher/courses');
                    }
                }
                break;

            default:
                $courses = $this->teacherModel->getTeacherCourses($teacherId);
                $categories = $this->courseModel->getAllCategories();
                $data = [
                    'title' => 'Manage Courses',
                    'courses' => $courses,
                    'categories' => $categories
                ];
                $this->view('teacher/courses', $data);
                break;
        }
    }

    public function students() {
        $teacherId = $_SESSION['user_id'];
        $students = $this->teacherModel->getEnrolledStudents($teacherId);
        
        $data = [
            'title' => 'My Students',
            'students' => $students
        ];

        $this->view('teacher/students', $data);
    }

    public function earnings() {
        $teacherId = $_SESSION['user_id'];
        $earnings = $this->teacherModel->getEarningsData($teacherId);
        
        $data = [
            'title' => 'Earnings',
            'earnings' => $earnings
        ];

        $this->view('teacher/earnings', $data);
    }
} 