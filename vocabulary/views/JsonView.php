<?php

class JsonView extends ApiView {
    public function render($content) {
        header('Content-Type: application/json');
        echo json_encode($content,JSON_PRETTY_PRINT);
        return true;
    }
}
