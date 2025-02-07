<?php
namespace App\Models;

use App\Libraries\Database;

abstract class User {
    protected $db;
    protected $table = 'users';
    protected $allowedFields = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'status'
    ];

    public function __construct() {
        $this->db = new Database;
    }

    // Find user by email
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email = :email');
        $this->db->bind(':email', $email);

        return $this->db->single();
    }

    // Register User with role-based approval status
    public function register($data) {
        // Set initial status based on role
        $status = ($data['role'] === 'student') ? 'approved' : 'pending';

        $this->db->query('INSERT INTO ' . $this->table . ' (first_name, last_name, email, password, role, status) 
                         VALUES(:first_name, :last_name, :email, :password, :role, :status)');

        // Bind values
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':role', $data['role']);
        $this->db->bind(':status', $status);

        // Execute
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    // Login User
    public function login($email, $password) {
        $user = $this->findUserByEmail($email);

        if(!$user) {
            return false;
        }

        if(password_verify($password, $user->password)) {
            // Skip approval check for admin users
            if($user->role === 'admin') {
                return $user;
            }
            
            // Check if non-admin user is approved
            if($user->status !== 'approved') {
                if($user->role === 'teacher') {
                    throw new \Exception('Your teacher account is pending approval from admin.');
                } else {
                    throw new \Exception('Your account is currently ' . $user->status);
                }
            }
            return $user;
        }
        
        return false;
    }

    // Get User by ID
    public function getUserById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    // Update User Profile
    public function updateProfile($id, $data) {
        $this->db->query('UPDATE ' . $this->table . ' SET first_name = :first_name, last_name = :last_name, email = :email, updated_at = CURRENT_TIMESTAMP WHERE id = :id');

        // Bind values
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':id', $id);

        // Execute
        return $this->db->execute();
    }
} 