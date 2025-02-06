<?php 
namespace App\Controllers;

use App\Libraries\Controller;

class Pages extends Controller {
    public function __construct() {
        
    }
    
    public function index() {
        $data = [
            'title' => 'Welcome'
        ];
        
        $this->view('pages/index', $data);
    }
}