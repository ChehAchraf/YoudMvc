<?php
namespace App\Models;

class Admin extends User {
    protected $role = 'admin';

    // Get all users
    public function getAllUsers() {
        $this->db->query('SELECT * FROM users ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    // Update user status
    public function updateUserStatus($userId, $status) {
        $this->db->query('UPDATE users SET status = :status WHERE id = :id');
        $this->db->bind(':id', $userId);
        $this->db->bind(':status', $status);
        return $this->db->execute();
    }

    // Get platform statistics
    public function getPlatformStats() {
        $this->db->query('SELECT 
                         (SELECT COUNT(*) FROM users WHERE role = "student") as total_students,
                         (SELECT COUNT(*) FROM users WHERE role = "teacher") as total_teachers,
                         (SELECT COUNT(*) FROM courses) as total_courses,
                         (SELECT COUNT(*) FROM enrollments) as total_enrollments');
        return $this->db->single();
    }

    // Manage categories
    public function createCategory($data) {
        $this->db->query('INSERT INTO categories (name, slug, description) 
                         VALUES (:name, :slug, :description)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':slug', $data['slug']);
        $this->db->bind(':description', $data['description']);
        return $this->db->execute();
    }

    // Review and approve courses
    public function reviewCourse($courseId, $status, $feedback = '') {
        $this->db->query('UPDATE courses 
                         SET status = :status, admin_feedback = :feedback 
                         WHERE id = :id');
        $this->db->bind(':id', $courseId);
        $this->db->bind(':status', $status);
        $this->db->bind(':feedback', $feedback);
        return $this->db->execute();
    }

    // Get pending courses
    public function getPendingCourses() {
        $this->db->query('SELECT c.*, u.first_name, u.last_name 
                         FROM courses c 
                         JOIN users u ON c.instructor_id = u.id 
                         WHERE c.status = "pending"');
        return $this->db->resultSet();
    }

    public function createDefaultAdmin() {
        $this->db->query('INSERT INTO users (first_name, last_name, email, password, role, status) 
                          VALUES (:first_name, :last_name, :email, :password, :role, :status)');
        
        $this->db->bind(':first_name', 'Admin');
        $this->db->bind(':last_name', 'User');
        $this->db->bind(':email', 'admin@example.com');
        $this->db->bind(':password', password_hash('password123', PASSWORD_DEFAULT));
        $this->db->bind(':role', 'admin');
        $this->db->bind(':status', 'approved');
        
        return $this->db->execute();
    }

    // Add this method
    public function getAllCourses() {
        $this->db->query('SELECT c.*, u.first_name, u.last_name 
                         FROM courses c 
                         JOIN users u ON c.instructor_id = u.id 
                         ORDER BY c.created_at DESC');
        return $this->db->resultSet();
    }

    // Add this method
    public function getPendingTeachers() {
        $this->db->query('SELECT * FROM users 
                         WHERE role = "teacher" 
                         AND status = "pending" 
                         ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    // Add this method if not exists
    public function getRecentUsers($limit = 5) {
        $this->db->query('SELECT * FROM users 
                         ORDER BY created_at DESC 
                         LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }
} 