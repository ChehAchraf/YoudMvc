<?php
namespace App\Models;

use App\Libraries\Database;

class Review {
    private $db;
    protected $table = 'course_reviews';

    public function __construct() {
        $this->db = new Database;
    }

    public function create($data) {
        $this->db->query('INSERT INTO course_reviews (course_id, user_id, rating, review, created_at) 
                         VALUES (:course_id, :user_id, :rating, :review, NOW())');
        
        $this->db->bind(':course_id', $data['course_id']);
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':review', $data['review']);

        return $this->db->execute();
    }

    public function update($id, $data) {
        $this->db->query('UPDATE course_reviews SET 
                         rating = :rating, 
                         review = :review,
                         updated_at = NOW()
                         WHERE id = :id AND user_id = :user_id');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':review', $data['review']);

        return $this->db->execute();
    }

    public function getUserReview($courseId, $userId) {
        $this->db->query('SELECT * FROM course_reviews 
                         WHERE course_id = :course_id AND user_id = :user_id');
        
        $this->db->bind(':course_id', $courseId);
        $this->db->bind(':user_id', $userId);

        return $this->db->single();
    }

    public function getCourseStats($courseId) {
        $this->db->query('SELECT 
                         COUNT(*) as total_reviews,
                         AVG(rating) as avg_rating,
                         COUNT(CASE WHEN rating = 5 THEN 1 END) as five_star,
                         COUNT(CASE WHEN rating = 4 THEN 1 END) as four_star,
                         COUNT(CASE WHEN rating = 3 THEN 1 END) as three_star,
                         COUNT(CASE WHEN rating = 2 THEN 1 END) as two_star,
                         COUNT(CASE WHEN rating = 1 THEN 1 END) as one_star
                         FROM course_reviews 
                         WHERE course_id = :course_id');
        
        $this->db->bind(':course_id', $courseId);
        return $this->db->single();
    }
} 