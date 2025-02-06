<?php
namespace App\Models;

use App\Libraries\Database;

class Category {
    private $db;
    protected $table = 'categories';

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query('SELECT c.*, COUNT(co.id) as course_count 
                         FROM categories c 
                         LEFT JOIN courses co ON c.id = co.category_id 
                         GROUP BY c.id 
                         ORDER BY c.name ASC');
        return $this->db->resultSet();
    }

    public function create($data) {
        $this->db->query('INSERT INTO categories (name, slug, description) 
                         VALUES (:name, :slug, :description)');
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':slug', $this->createSlug($data['name']));
        $this->db->bind(':description', $data['description']);

        return $this->db->execute();
    }

    public function update($id, $data) {
        $this->db->query('UPDATE categories SET 
                         name = :name, 
                         slug = :slug, 
                         description = :description 
                         WHERE id = :id');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':slug', $this->createSlug($data['name']));
        $this->db->bind(':description', $data['description']);

        return $this->db->execute();
    }

    private function createSlug($string) {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }
} 