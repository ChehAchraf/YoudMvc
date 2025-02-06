<?php
namespace App\Models;

class Auth extends User {
    // Create appropriate user instance based on role
    public static function createUser($role) {
        switch($role) {
            case 'student':
                return new Student();
            case 'teacher':
                return new Teacher();
            case 'admin':
                return new Admin();
            default:
                throw new \Exception('Invalid user role');
        }
    }

    // Login with role-specific instance
    public function login($email, $password) {
        $user = $this->findUserByEmail($email);

        if(!$user) {
            return false;
        }

        if(password_verify($password, $user->password)) {
            // For admin, skip the approval check
            if($user->role === 'admin' || $user->status === 'approved') {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_name'] = $user->first_name . ' ' . $user->last_name;
                $_SESSION['user_role'] = $user->role;
                return $user;
            }
            
            if($user->role === 'teacher') {
                throw new \Exception('Your teacher account is pending approval from admin.');
            } else {
                throw new \Exception('Your account is currently ' . $user->status);
            }
        }
        
        return false;
    }

    // You can add specific authentication methods here
    // The base functionality is inherited from User
} 