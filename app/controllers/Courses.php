<?php
namespace App\Controllers;

use App\Libraries\Controller;

class Courses extends Controller {
    private $courseModel;
    
    public function __construct() {
        $this->courseModel = $this->model('Course');
    }

    public function show($id = '') {
        // Check if id exists
        if(empty($id)) {
            redirect('pages/index');
        }

        // Get course details
        $course = $this->courseModel->getById($id);

        // Check if course exists
        if(!$course) {
            flash('course_message', 'Course not found', 'alert alert-danger');
            redirect('pages/index');
        }

        $data = [
            'title' => $course->title,
            'course' => $course
        ];

        $this->view('courses/view', $data);
    }

    public function addReview($courseId) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!isLoggedIn()) {
                redirect('users/login');
            }

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'course_id' => $courseId,
                'user_id' => $_SESSION['user_id'],
                'rating' => trim($_POST['rating']),
                'comment' => trim($_POST['comment'])
            ];

            if($this->courseModel->addReview($data)) {
                flash('course_message', 'Review added successfully');
            } else {
                flash('course_message', 'Something went wrong', 'alert alert-danger');
            }
            redirect('courses/show/' . $courseId);
        } else {
            redirect('courses/show/' . $courseId);
        }
    }

    public function index() {
        // Get current page number from URL
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 12; // Number of courses per page
        
        // Get search parameters
        $search = [
            'keyword' => isset($_GET['keyword']) ? trim($_GET['keyword']) : '',
            'category' => isset($_GET['category']) ? (int)$_GET['category'] : '',
            'price_min' => isset($_GET['price_min']) ? (float)$_GET['price_min'] : '',
            'price_max' => isset($_GET['price_max']) ? (float)$_GET['price_max'] : '',
            'rating' => isset($_GET['rating']) ? (int)$_GET['rating'] : ''
        ];

        // Get total courses count and courses for current page
        $totalCourses = $this->courseModel->getPublishedCoursesCount($search);
        $courses = $this->courseModel->getPublishedCourses($page, $perPage, $search);
        $categories = $this->courseModel->getAllCategories();

        // Calculate pagination values
        $totalPages = ceil($totalCourses / $perPage);
        $hasNextPage = $page < $totalPages;
        $hasPrevPage = $page > 1;

        $data = [
            'title' => 'Browse Courses',
            'courses' => $courses,
            'categories' => $categories,
            'pagination' => [
                'current' => $page,
                'total' => $totalPages,
                'hasNext' => $hasNextPage,
                'hasPrev' => $hasPrevPage
            ],
            'search' => $search
        ];

        $this->view('courses/index', $data);
    }

    public function search() {
        // Get search parameters from GET request
        $search = [
            'keyword' => isset($_GET['keyword']) ? trim($_GET['keyword']) : '',
            'category' => isset($_GET['category']) ? (int)$_GET['category'] : '',
            'price_min' => isset($_GET['price_min']) ? (float)$_GET['price_min'] : '',
            'price_max' => isset($_GET['price_max']) ? (float)$_GET['price_max'] : '',
            'rating' => isset($_GET['rating']) ? (int)$_GET['rating'] : ''
        ];

        // Get courses based on search parameters
        $courses = $this->courseModel->getPublishedCourses(1, 12, $search);

        $data = [
            'courses' => $courses
        ];

        // Only return the course cards partial
        $this->view('courses/partials/course_cards', $data);
    }

    public function enroll($courseId = null) {
        // Add debugging
        if(!$courseId) {
            setFlash('error', 'Invalid course ID');
            redirect('courses');
        }

        // Check if user is logged in
        if(!isLoggedIn()) {
            setFlash('error', 'Please login to enroll in courses');
            redirect('users/login');
        }

        // Check if user is a student
        if($_SESSION['user_role'] !== 'student') {
            setFlash('error', 'Only students can enroll in courses');
            redirect('courses/show/' . $courseId);
        }

        $studentModel = $this->model('Student');
        
        // Try to enroll and add debugging
        $result = $studentModel->enrollCourse($courseId);
        if($result) {
            setFlash('success', 'Successfully enrolled in the course!');
            redirect('student/dashboard');
        } else {
            // Add more specific error messages
            $course = $this->courseModel->getById($courseId);
            if(!$course) {
                setFlash('error', 'Course not found');
            } elseif($course->status !== 'published') {
                setFlash('error', 'This course is not available for enrollment');
            } else {
                setFlash('error', 'You are already enrolled in this course or an error occurred');
            }
            redirect('courses/show/' . $courseId);
        }
    }
} 