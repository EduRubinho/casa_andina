<?php
namespace App\Controllers;

class HomeController {
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function index() {
        include __DIR__.'/../Views/home.php';
    }
}
