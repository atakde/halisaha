<?php

/**
 * View
 */
class View
{
    public function render($filename, $data = []): void
    {        
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }

        include_once(Config::get('VIEW_PATH') . '_templates/header.php');
        include_once(Config::get('VIEW_PATH') . $filename . '.php');
        include_once(Config::get('VIEW_PATH') . '_templates/footer.php');
    }

    public function renderJson($data, $code = 200): void
    {
        ob_clean();
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($data);
        
        exit();
    }
}
