<?php
namespace App\Models;

class Student extends User {
    protected $role = 'student';

    public function getStudentProfile($userId) {
        // Get basic student details
        $this->db->query('SELECT u.* 
                         FROM users u 
                         WHERE u.id = :user_id AND u.role = \'student\'');
        
        $this->db->bind(':user_id', $userId);
        $profile = $this->db->single();

        if($profile) {
            // Get enrollment stats
            $this->db->query('SELECT 
                             COUNT(DISTINCT e.id) as enrolled_courses,
                             COUNT(DISTINCT r.id) as reviews_given,
                             AVG(c.price) as avg_course_price
                             FROM users u 
                             LEFT JOIN enrollments e ON u.id = e.user_id
                             LEFT JOIN course_reviews r ON u.id = r.user_id
                             LEFT JOIN courses c ON e.course_id = c.id
                             WHERE u.id = :user_id');
            
            $this->db->bind(':user_id', $userId);
            $stats = $this->db->single();
            
            // Add stats to profile
            $profile->enrolled_courses = $stats->enrolled_courses ?? 0;
            $profile->reviews_given = $stats->reviews_given ?? 0;
            $profile->avg_course_price = $stats->avg_course_price ?? 0;

            // Get enrolled courses with details
            $this->db->query('SELECT 
                             c.*, 
                             u.first_name, 
                             u.last_name,
                             cat.name as category_name,
                             e.id as enrollment_id,
                             COALESCE(r.rating, 0) as user_rating
                             FROM courses c 
                             JOIN enrollments e ON c.id = e.course_id
                             JOIN users u ON c.instructor_id = u.id
                             JOIN categories cat ON c.category_id = cat.id
                             LEFT JOIN course_reviews r ON c.id = r.course_id AND r.user_id = e.user_id
                             WHERE e.user_id = :user_id
                             ORDER BY e.id DESC');
            
            $this->db->bind(':user_id', $userId);
            $profile->enrolled_courses_details = $this->db->resultSet();

            // Get recent reviews
            $this->db->query('SELECT 
                             r.*, 
                             c.title as course_title,
                             c.thumbnail,
                             c.slug as course_slug
                             FROM course_reviews r
                             JOIN courses c ON r.course_id = c.id
                             WHERE r.user_id = :user_id
                             ORDER BY r.created_at DESC
                             LIMIT 5');
            
            $this->db->bind(':user_id', $userId);
            $profile->recent_reviews = $this->db->resultSet();

            // Get total investment
            $this->db->query('SELECT 
                             SUM(c.price) as total_investment,
                             COUNT(DISTINCT c.category_id) as unique_categories
                             FROM enrollments e
                             JOIN courses c ON e.course_id = c.id
                             WHERE e.user_id = :user_id');
            
            $this->db->bind(':user_id', $userId);
            $investment = $this->db->single();
            
            $profile->total_investment = $investment->total_investment ?? 0;
            $profile->unique_categories = $investment->unique_categories ?? 0;
        }

        return $profile;
    }

    public function enrollCourse($courseId) {
        try {
            // Check if course exists and is published
            $this->db->query('SELECT id FROM courses 
                             WHERE id = :course_id 
                             AND status = \'published\'');
            $this->db->bind(':course_id', $courseId);
            if(!$this->db->single()) {
                return false;
            }

            // Check if already enrolled
            $this->db->query('SELECT id FROM enrollments 
                             WHERE user_id = :user_id 
                             AND course_id = :course_id');
            $this->db->bind(':user_id', $_SESSION['user_id']);
            $this->db->bind(':course_id', $courseId);
            
            if($this->db->single()) {
                return false; // Already enrolled
            }

            // Enroll in course
            $this->db->query('INSERT INTO enrollments (user_id, course_id) 
                             VALUES (:user_id, :course_id)');
            $this->db->bind(':user_id', $_SESSION['user_id']);
            $this->db->bind(':course_id', $courseId);
            return $this->db->execute();

        } catch(PDOException $e) {
            // Log error if needed
            return false;
        }
    }

    public function submitReview($courseId, $rating, $review) {
        // Check if already reviewed
        $this->db->query('SELECT id FROM course_reviews 
                         WHERE user_id = :user_id AND course_id = :course_id');
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->bind(':course_id', $courseId);
        
        if($this->db->single()) {
            // Update existing review
            $this->db->query('UPDATE course_reviews 
                             SET rating = :rating, review = :review, updated_at = CURRENT_TIMESTAMP
                             WHERE user_id = :user_id AND course_id = :course_id');
        } else {
            // Insert new review
            $this->db->query('INSERT INTO course_reviews (user_id, course_id, rating, review) 
                             VALUES (:user_id, :course_id, :rating, :review)');
        }

        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->bind(':course_id', $courseId);
        $this->db->bind(':rating', $rating);
        $this->db->bind(':review', $review);
        return $this->db->execute();
    }

    public function getEnrolledCourses() {
        $this->db->query('SELECT c.*, u.first_name, u.last_name, cat.name as category_name
                         FROM courses c
                         JOIN enrollments e ON c.id = e.course_id
                         JOIN users u ON c.instructor_id = u.id
                         JOIN categories cat ON c.category_id = cat.id
                         WHERE e.user_id = :user_id
                         ORDER BY e.created_at DESC');
        
        $this->db->bind(':user_id', $_SESSION['user_id']);
        return $this->db->resultSet();
    }
} 