<?php
namespace App\Models;

use App\Libraries\Database;

class Tag {
    private $db;
    protected $table = 'tags';

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query('SELECT t.*, COUNT(ct.course_id) as course_count 
                         FROM tags t 
                         LEFT JOIN course_tags ct ON t.id = ct.tag_id 
                         GROUP BY t.id 
                         ORDER BY t.name ASC');
        return $this->db->resultSet();
    }

    public function create($data) {
        $this->db->query('INSERT INTO tags (name, slug) VALUES (:name, :slug)');
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':slug', $this->createSlug($data['name']));

        return $this->db->execute();
    }

    public function getPopular($limit = 10) {
        $this->db->query('SELECT t.*, COUNT(ct.course_id) as course_count 
                         FROM tags t 
                         JOIN course_tags ct ON t.id = ct.tag_id 
                         GROUP BY t.id 
                         ORDER BY course_count DESC 
                         LIMIT :limit');
        
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    private function createSlug($string) {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }
} 