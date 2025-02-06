<?php 
namespace App\Libraries;

class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];
    protected $validMethods = ['index', 'show', 'enroll', /* other methods */];

    public function __construct() {
        $url = $this->getUrl();
        
        // Check if controller exists
        if(!empty($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // Set as controller
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }

        // Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';
        
        // Instantiate controller class with namespace
        $this->currentController = 'App\\Controllers\\' . $this->currentController;
        $this->currentController = new $this->currentController;
        if(isset($url[1])) {
            if(method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    protected function getUrl() {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }

}