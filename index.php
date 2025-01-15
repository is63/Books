<link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
<?php
require_once 'controller/BooksController.php';

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

$controller = new BooksController();

$controller->handleRequest();

