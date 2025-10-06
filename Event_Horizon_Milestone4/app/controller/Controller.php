<?php
/**
 * Base Controller - NO session handling here
 */
class Controller {

    /**
     * Loads the corresponding model for the controller.
     */
    public function model() {
        $model = str_replace("Controller", "Model", get_class($this));
        return new $model();
    }

    /**
     * Loads a view with optional data.
     */
    public function view($data = []) {
        $controller = strtolower(str_replace('Controller', '', get_called_class()));
        $action = debug_backtrace()[1]['function'];
        $viewTemplate = 'app/view/' . $controller . '/' . $action . '.php';
        
        if (!file_exists($viewTemplate)) {
            throw new Exception("Template file: " . $viewTemplate . " doesn't exist.");
        }

        $model = $this->model();

        require 'app/view/inc/header.php';
        require $viewTemplate;
        require 'app/view/inc/footer.php';
    }
}
