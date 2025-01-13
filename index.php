<link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
<?php
require_once 'controller/BooksController.php';

$controller = new BooksController();

$controller->handleRequest();

