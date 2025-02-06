<?php
namespace App\Models;

class Teacher extends User {
    protected $role = 'teacher';

    // Get teacher's statistics
    public function getTeacherStats($teacherId) {
        $this->db->query('SELECT 
            (SELECT COUNT(DISTINCT e.user_id) 
             FROM courses c 
             LEFT JOIN enrollments e ON c.id = e.course_id 
             WHERE c.instructor_id = :id1) as total_students,
            
            (SELECT COUNT(*) 
             FROM courses 
             WHERE instructor_id = :id2) as total_courses,
            
            (SELECT COALESCE(SUM(c.price * IFNULL(e.student_count, 0)), 0)
             FROM courses c 
             LEFT JOIN (
                 SELECT course_id, COUNT(*) as student_count 
                 FROM enrollments 
                 GROUP BY course_id
             ) e ON c.id = e.course_id 
             WHERE c.instructor_id = :id3) as total_earnings,
            
            COALESCE(
                (SELECT AVG(r.rating) 
                 FROM courses c 
                 LEFT JOIN course_reviews r ON c.id = r.course_id 
                 WHERE c.instructor_id = :id4
                 AND r.rating IS NOT NULL), 0
            ) as avg_rating');

        // Bind the same teacher ID to all placeholders
        $this->db->bind(':id1', $teacherId);
        $this->db->bind(':id2', $teacherId);
        $this->db->bind(':id3', $teacherId);
        $this->db->bind(':id4', $teacherId);

        return $this->db->single();
    }

    // Get recent enrollments for teacher's courses
    public function getRecentEnrollments($teacherId, $limit = 5) {
        $this->db->query('SELECT e.*, 
                         CONCAT(u.first_name, " ", u.last_name) as student_name,
                         c.title as course_title
                         FROM courses c
                         LEFT JOIN enrollments e ON c.id = e.course_id
                         LEFT JOIN users u ON e.user_id = u.id
                         WHERE c.instructor_id = :teacher_id
                         AND e.id IS NOT NULL
                         ORDER BY e.enrolled_at DESC
                         LIMIT :limit');

        $this->db->bind(':teacher_id', $teacherId);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    // Get all enrolled students for teacher's courses
    public function getEnrolledStudents($teacherId) {
        $this->db->query('SELECT DISTINCT u.*, 
                         COUNT(e.id) as courses_enrolled,
                         MAX(e.enrolled_at) as last_enrollment
                         FROM users u 
                         JOIN enrollments e ON u.id = e.user_id
                         JOIN courses c ON e.course_id = c.id
                         WHERE c.instructor_id = :teacher_id
                         GROUP BY u.id
                         ORDER BY last_enrollment DESC');

        $this->db->bind(':teacher_id', $teacherId);
        return $this->db->resultSet();
    }

    // Get earnings data
    public function getEarningsData($teacherId) {
        $this->db->query('SELECT 
                         c.title,
                         COUNT(e.id) as enrollments,
                         SUM(c.price) as total_earnings,
                         c.price as price_per_enrollment,
                         MAX(e.enrolled_at) as last_enrollment
                         FROM courses c
                         LEFT JOIN enrollments e ON c.id = e.course_id
                         WHERE c.instructor_id = :teacher_id
                         GROUP BY c.id
                         ORDER BY total_earnings DESC');

        $this->db->bind(':teacher_id', $teacherId);
        return $this->db->resultSet();
    }

    // Get teacher's courses
    public function getTeacherCourses($teacherId) {
        $this->db->query('SELECT c.*, 
                         COUNT(DISTINCT e.id) as enrollment_count,
                         COALESCE(AVG(r.rating), 0) as avg_rating,
                         cat.name as category_name
                         FROM courses c
                         LEFT JOIN enrollments e ON c.id = e.course_id
                         LEFT JOIN course_reviews r ON c.id = r.course_id
                         LEFT JOIN categories cat ON c.category_id = cat.id
                         WHERE c.instructor_id = :teacher_id
                         GROUP BY c.id
                         ORDER BY c.created_at DESC');

        $this->db->bind(':teacher_id', $teacherId);
        return $this->db->resultSet();
    }

    // Get created courses
    public function getMyCourses() {
        $this->db->query('SELECT * FROM courses WHERE instructor_id = :instructor_id');
        $this->db->bind(':instructor_id', $_SESSION['user_id']);
        return $this->db->resultSet();
    }

    // Create a new course
    public function createCourse($data) {
        $this->db->query('INSERT INTO courses (title, description, instructor_id, category_id, price, status) 
                         VALUES (:title, :description, :instructor_id, :category_id, :price, "draft")');

        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':instructor_id', $data['instructor_id']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':price', $data['price']);

        return $this->db->execute();
    }

    // Update course
    public function updateCourse($data) {
        $this->db->query('UPDATE courses 
                         SET title = :title, 
                             description = :description, 
                             category_id = :category_id, 
                             price = :price
                         WHERE id = :id AND instructor_id = :instructor_id');

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':instructor_id', $data['instructor_id']);

        return $this->db->execute();
    }

    // Get course statistics
    public function getCourseStats($courseId) {
        $this->db->query('SELECT 
                         COUNT(DISTINCT e.user_id) as total_students,
                         AVG(r.rating) as avg_rating,
                         COUNT(DISTINCT r.id) as total_reviews
                         FROM courses c
                         LEFT JOIN enrollments e ON c.id = e.course_id
                         LEFT JOIN course_reviews r ON c.id = r.course_id
                         WHERE c.id = :course_id AND c.instructor_id = :instructor_id
                         GROUP BY c.id');
        
        $this->db->bind(':course_id', $courseId);
        $this->db->bind(':instructor_id', $_SESSION['user_id']);
        return $this->db->single();
    }
} 