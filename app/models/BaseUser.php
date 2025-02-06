<?php
namespace App\Models;

use App\Libraries\Database;

abstract class BaseUser {
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

    // Move all the existing methods from User.php here
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email = :email');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    // Other existing methods...
} 