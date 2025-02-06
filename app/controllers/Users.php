<?php
namespace App\Controllers;

use App\Libraries\Controller;
use App\Models\Auth;

class Users extends Controller {
    private $userModel;
    private $authModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = $this->model('Auth');
        $this->authModel = $this->model('Auth');
    }

    public function register() {
        // Check if logged in
        if(isset($_SESSION['user_id'])) {
            redirect('');
        }

        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'role' => trim($_POST['role']),
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate Email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                // Check email
                if($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }

            // Validate Name
            if(empty($data['first_name'])) {
                $data['first_name_err'] = 'Please enter first name';
            }
            if(empty($data['last_name'])) {
                $data['last_name_err'] = 'Please enter last name';
            }

            // Validate Password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            // Validate Confirm Password
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['first_name_err']) && 
               empty($data['last_name_err']) && empty($data['password_err']) && 
               empty($data['confirm_password_err'])) {
                // Validated
                
                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register User
                if($this->userModel->register($data)) {
                    if($data['role'] === 'teacher') {
                        flash('register_success', 'You are registered! Please wait for admin approval to access your account.', 
                              'bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4');
                    } else {
                        flash('register_success', 'You are registered and can now log in');
                    }
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('auth/register', $data);
            }
        } else {
            // Init data
            $data = [
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'role' => 'student',
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Load view
            $this->view('auth/register', $data);
        }
    }

    public function login() {
        // Check if logged in
        if(isset($_SESSION['user_id'])) {
            redirect('');
        }

        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate Email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }

            // Validate Password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['password_err'])) {
                // Use Auth model instead of User model
                try {
                    $loggedInUser = $this->authModel->login($data['email'], $data['password']);

                    if($loggedInUser) {
                        // Create Session
                        $this->createUserSession($loggedInUser);
                    } else {
                        $data['password_err'] = 'Password incorrect';
                        $this->view('auth/login', $data);
                    }
                } catch(\Exception $e) {
                    flash('login_error', $e->getMessage(), 'alert alert-danger');
                    $this->view('auth/login', $data);
                }
            } else {
                $this->view('auth/login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            $this->view('auth/login', $data);
        }
    }

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->first_name . ' ' . $user->last_name;
        $_SESSION['user_role'] = $user->role;
        redirect('');
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        redirect('users/login');
    }

    // Temporary debug method - remove after testing
    public function debug_check_admin() {
        if(!isLoggedIn()) {
            $user = $this->userModel->findUserByEmail('admin@example.com');
            echo "<pre>";
            var_dump([
                'exists' => $user !== false,
                'role' => $user ? $user->role : null,
                'status' => $user ? $user->status : null,
                'password_hash' => $user ? $user->password : null,
                'test_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'would_verify' => $user ? password_verify('password123', $user->password) : null
            ]);
            echo "</pre>";
            exit;
        }
    }

    // Add this debug method
    public function debug_login() {
        $email = 'admin@example.com';
        $password = 'password123';
        
        $user = $this->authModel->findUserByEmail($email);
        
        echo "<pre>";
        var_dump([
            'email' => $email,
            'password' => $password,
            'user_exists' => !empty($user),
            'user_role' => $user ? $user->role : null,
            'user_status' => $user ? $user->status : null,
            'password_matches' => $user ? password_verify($password, $user->password) : null,
            'session' => $_SESSION ?? null
        ]);
        echo "</pre>";
        exit;
    }
} 