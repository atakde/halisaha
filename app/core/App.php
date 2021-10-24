<?php

class App
{
    private $controller;
    private string $controllerName;
    private string $action;
    private array $params = [];

    public function run()
    {
        $this->splitUrl();
        $this->init();

        $controllerFile =  Config::get('CONTROLLER_PATH') . $this->controllerName . '.php';
        if (file_exists($controllerFile)) {
            require $controllerFile;
            $this->controller = new $this->controllerName();
            if (is_callable([$this->controller, $this->action])) {
                if (count($this->params) > 0) {
                    call_user_func_array([$this->controller, $this->action], $this->params);
                } else {
                    $this->controller->{$this->action}();
                }
            } else {
                Helper::show404();
            }
        } else {
            Helper::show404();
        }
    }

    private function splitUrl(): void
    {
        if (Request::get('url')) {
            $url = trim(Request::get('url'), '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $this->controllerName = $url[0] ?? "";
            $this->action = $url[1] ?? "";
            $this->params = array_values($url);
        }
    }

    private function init()
    {
        $this->controllerName = !empty($this->controllerName) ? $this->controllerName : 'home';
        $this->controllerName = ucwords($this->controllerName) . 'Controller';
        $this->action = !empty($this->action) ? $this->action : 'home';
    }
}
