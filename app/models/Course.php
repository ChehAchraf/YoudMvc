<?php
namespace App\Models;

use App\Libraries\Database;

class Course {
    private $db;
    protected $table = 'courses';

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllCategories() {
        $this->db->query('SELECT * FROM categories ORDER BY name');
        return $this->db->resultSet();
    }

    public function create($data) {
        // Handle thumbnail upload
        $thumbnailPath = '';
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnailPath = $this->uploadFile($_FILES['thumbnail'], 'thumbnails');
        }

        // Handle course file upload
        $filePath = '';
        if (isset($_FILES['course_file']) && $_FILES['course_file']['error'] === UPLOAD_ERR_OK) {
            $filePath = $this->uploadFile($_FILES['course_file'], 'courses');
        }

        // Generate slug from title
        $slug = $this->createSlug($data['title']);

        $this->db->query('INSERT INTO courses (
            title, slug, description, category_id, instructor_id, 
            price, status, thumbnail, content_type, 
            content_url, file_path
        ) VALUES (
            :title, :slug, :description, :category_id, :instructor_id, 
            :price, "draft", :thumbnail, :content_type, 
            :content_url, :file_path
        )');

        $this->db->bind(':title', $data['title']);
        $this->db->bind(':slug', $slug);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':instructor_id', $data['instructor_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':thumbnail', $thumbnailPath);
        $this->db->bind(':content_type', $data['content_type']);
        $this->db->bind(':content_url', $data['content_type'] === 'video' ? $data['video_url'] : '');
        $this->db->bind(':file_path', $filePath);

        return $this->db->execute();
    }

    private function uploadFile($file, $directory) {
        $uploadDir = PUBLICPATH . '/uploads/' . $directory . '/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $directory . '/' . $fileName;
        }

        return '';
    }

    private function createSlug($title) {
        // Convert title to lowercase and replace spaces with hyphens
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        
        // Check if slug already exists
        $this->db->query('SELECT COUNT(*) as count FROM courses WHERE slug = :slug');
        $this->db->bind(':slug', $slug);
        $result = $this->db->single();

        // If slug exists, append a number
        if ($result->count > 0) {
            $i = 1;
            do {
                $newSlug = $slug . '-' . $i;
                $this->db->query('SELECT COUNT(*) as count FROM courses WHERE slug = :slug');
                $this->db->bind(':slug', $newSlug);
                $result = $this->db->single();
                $i++;
            } while ($result->count > 0);
            $slug = $newSlug;
        }

        return $slug;
    }

    public function update($id, $data) {
        $updateFields = ['title', 'description', 'category_id', 'price'];
        $params = [];
        
        // Handle thumbnail upload
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnailPath = $this->uploadFile($_FILES['thumbnail'], 'thumbnails');
            if ($thumbnailPath) {
                $updateFields[] = 'thumbnail';
                $params[':thumbnail'] = $thumbnailPath;
            }
        }
        
        // Handle content updates
        if (isset($data['content_type'])) {
            $updateFields[] = 'content_type';
            $params[':content_type'] = $data['content_type'];
            
            if ($data['content_type'] === 'video' && isset($data['video_url'])) {
                $updateFields[] = 'content_url';
                $params[':content_url'] = $data['video_url'];
            } elseif ($data['content_type'] === 'document' && 
                      isset($_FILES['course_file']) && 
                      $_FILES['course_file']['error'] === UPLOAD_ERR_OK) {
                $filePath = $this->uploadFile($_FILES['course_file'], 'courses');
                if ($filePath) {
                    $updateFields[] = 'file_path';
                    $params[':file_path'] = $filePath;
                }
            }
        }
        
        // Build update query
        $sql = 'UPDATE courses SET ' . 
               implode(', ', array_map(fn($field) => "$field = :$field", $updateFields)) . 
               ', updated_at = NOW() WHERE id = :id AND instructor_id = :instructor_id';
        
        $this->db->query($sql);
        
        // Bind basic parameters
        $this->db->bind(':id', $id);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':instructor_id', $data['instructor_id']);
        
        // Bind additional parameters
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }
        
        return $this->db->execute();
    }

    public function getById($id) {
        $this->db->query('SELECT c.*, u.first_name, u.last_name, cat.name as category_name 
                         FROM courses c 
                         JOIN users u ON c.instructor_id = u.id 
                         JOIN categories cat ON c.category_id = cat.id 
                         WHERE c.id = :id');
        $this->db->bind(':id', $id);
        $course = $this->db->single();

        if($course) {
            $course->tags = $this->getCourseTags($id);
            $course->reviews = $this->getCourseReviews($id);
        }

        return $course;
    }

    public function addTags($courseId, $tags) {
        foreach($tags as $tagId) {
            $this->db->query('INSERT INTO course_tags (course_id, tag_id) VALUES (:course_id, :tag_id)');
            $this->db->bind(':course_id', $courseId);
            $this->db->bind(':tag_id', $tagId);
            $this->db->execute();
        }
    }

    public function updateTags($courseId, $tags) {
        // Remove existing tags
        $this->db->query('DELETE FROM course_tags WHERE course_id = :course_id');
        $this->db->bind(':course_id', $courseId);
        $this->db->execute();

        // Add new tags
        $this->addTags($courseId, $tags);
    }

    public function getCourseTags($courseId) {
        $this->db->query('SELECT t.* FROM tags t 
                         JOIN course_tags ct ON t.id = ct.tag_id 
                         WHERE ct.course_id = :course_id');
        $this->db->bind(':course_id', $courseId);
        return $this->db->resultSet();
    }

    public function getCourseReviews($courseId) {
        $this->db->query('SELECT r.*, u.first_name, u.last_name 
                         FROM course_reviews r 
                         JOIN users u ON r.user_id = u.id 
                         WHERE r.course_id = :course_id 
                         ORDER BY r.created_at DESC');
        $this->db->bind(':course_id', $courseId);
        return $this->db->resultSet();
    }

    public function search($filters = []) {
        $sql = 'SELECT c.*, u.first_name, u.last_name, cat.name as category_name,
                AVG(r.rating) as avg_rating, COUNT(DISTINCT r.id) as review_count
                FROM courses c 
                JOIN users u ON c.instructor_id = u.id 
                JOIN categories cat ON c.category_id = cat.id 
                LEFT JOIN course_reviews r ON c.id = r.course_id
                WHERE c.status = "published"';
        
        $params = [];

        if(!empty($filters['category'])) {
            $sql .= ' AND c.category_id = :category_id';
            $params[':category_id'] = $filters['category'];
        }

        if(!empty($filters['level'])) {
            $sql .= ' AND c.level = :level';
            $params[':level'] = $filters['level'];
        }

        if(!empty($filters['price_max'])) {
            $sql .= ' AND c.price <= :price_max';
            $params[':price_max'] = $filters['price_max'];
        }

        $sql .= ' GROUP BY c.id';

        if(!empty($filters['rating'])) {
            $sql .= ' HAVING avg_rating >= :rating';
            $params[':rating'] = $filters['rating'];
        }

        $sql .= ' ORDER BY c.created_at DESC';

        $this->db->query($sql);
        foreach($params as $param => $value) {
            $this->db->bind($param, $value);
        }

        return $this->db->resultSet();
    }

    public function addReview($data) {
        $this->db->query('INSERT INTO course_reviews (course_id, user_id, rating, review) 
                          VALUES (:course_id, :user_id, :rating, :review)');

        // Bind values
        $this->db->bind(':course_id', $data['course_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':review', $data['comment']);

        return $this->db->execute();
    }

    public function getAllCoursesWithDetails() {
        $this->db->query('SELECT c.*, u.first_name, u.last_name, cat.name as category_name,
                          COUNT(DISTINCT e.id) as enrollment_count,
                          AVG(r.rating) as avg_rating
                          FROM courses c 
                          JOIN users u ON c.instructor_id = u.id 
                          JOIN categories cat ON c.category_id = cat.id 
                          LEFT JOIN enrollments e ON c.id = e.course_id
                          LEFT JOIN course_reviews r ON c.id = r.course_id
                          GROUP BY c.id
                          ORDER BY c.created_at DESC');
        return $this->db->resultSet();
    }

    public function updateStatus($data) {
        $this->db->query('UPDATE courses SET status = :status, updated_at = NOW() WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':status', $data['status']);
        return $this->db->execute();
    }

    public function getPublishedCoursesCount($search = []) {
        $sql = 'SELECT COUNT(DISTINCT c.id) as count 
                FROM courses c 
                JOIN users u ON c.instructor_id = u.id 
                JOIN categories cat ON c.category_id = cat.id 
                LEFT JOIN course_reviews r ON c.id = r.course_id
                WHERE c.status = "published"';

        $params = [];
        
        if(!empty($search['keyword'])) {
            $sql .= ' AND (c.title LIKE :keyword OR c.description LIKE :keyword)';
            $params[':keyword'] = '%' . $search['keyword'] . '%';
        }

        if(!empty($search['category'])) {
            $sql .= ' AND c.category_id = :category_id';
            $params[':category_id'] = $search['category'];
        }

        if(!empty($search['price_min'])) {
            $sql .= ' AND c.price >= :price_min';
            $params[':price_min'] = $search['price_min'];
        }

        if(!empty($search['price_max'])) {
            $sql .= ' AND c.price <= :price_max';
            $params[':price_max'] = $search['price_max'];
        }

        if(!empty($search['rating'])) {
            $sql .= ' HAVING AVG(r.rating) >= :rating';
            $params[':rating'] = $search['rating'];
        }

        $this->db->query($sql);
        foreach($params as $param => $value) {
            $this->db->bind($param, $value);
        }

        $result = $this->db->single();
        return $result->count;
    }

    public function getPublishedCourses($page = 1, $perPage = 12, $search = []) {
        $offset = ($page - 1) * $perPage;

        $sql = 'SELECT c.*, u.first_name, u.last_name, cat.name as category_name,
                AVG(r.rating) as avg_rating, COUNT(DISTINCT r.id) as review_count
                FROM courses c 
                JOIN users u ON c.instructor_id = u.id 
                JOIN categories cat ON c.category_id = cat.id 
                LEFT JOIN course_reviews r ON c.id = r.course_id
                WHERE c.status = "published"';

        $params = [];
        
        if(!empty($search['keyword'])) {
            $sql .= ' AND (c.title LIKE :keyword OR c.description LIKE :keyword)';
            $params[':keyword'] = '%' . $search['keyword'] . '%';
        }

        if(!empty($search['category'])) {
            $sql .= ' AND c.category_id = :category_id';
            $params[':category_id'] = $search['category'];
        }

        if(!empty($search['price_min'])) {
            $sql .= ' AND c.price >= :price_min';
            $params[':price_min'] = $search['price_min'];
        }

        if(!empty($search['price_max'])) {
            $sql .= ' AND c.price <= :price_max';
            $params[':price_max'] = $search['price_max'];
        }

        $sql .= ' GROUP BY c.id';

        if(!empty($search['rating'])) {
            $sql .= ' HAVING AVG(r.rating) >= :rating';
            $params[':rating'] = $search['rating'];
        }

        $sql .= ' ORDER BY c.created_at DESC LIMIT :offset, :limit';
        $params[':offset'] = $offset;
        $params[':limit'] = $perPage;

        $this->db->query($sql);
        foreach($params as $param => $value) {
            $this->db->bind($param, $value);
        }

        return $this->db->resultSet();
    }
} 