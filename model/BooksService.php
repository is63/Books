<?php

require_once 'BooksGateway.php';
require_once 'ValidationException.php';
require_once 'Database.php';

class BooksService extends BooksGateway
{

    private $booksGateway = null;

    public function __construct()
    {
        $this->booksGateway = new BooksGateway();
    }

    public function getAllBooks($order)
    {
        try {
            self::connect();
            $res = $this->booksGateway->selectAll($order);
            self::disconnect();
            return $res;
        } catch (Exception $e) {
            self::disconnect();
            throw $e;
        }
    }

    public function getBook($id)
    {
        try {
            self::connect();
            $result = $this->booksGateway->selectById($id);
            self::disconnect();
            return $result;
        } catch (Exception $e) {
            self::disconnect();
            throw $e;
        }
    }

    private function validateBookParams($isbn, $title, $author, $publisher, $pages)
    {
        $errors = array();
        if (!isset($isbn) || empty($isbn)) {
            $errors[] = 'ISBN is required';
        }
        if (!isset($title) || empty($title)) {
            $errors[] = 'Title is required';
        }
        if (!isset($author) || empty($author)) {
            $errors[] = 'Author is required';
        }
        if (!isset($publisher) || empty($publisher)) {
            $errors[] = 'Publisher field is required';
        }
        if (!isset($pages) || empty($pages)) {
            $errors[] = 'Pages field is required';
        }
        if (empty($errors)) {
            return;
        }
        throw new ValidationException($errors);
    }

    public function createNewBook($isbn, $title, $author, $publisher, $pages)
    {
        try {
            self::connect();
            $this->validateBookParams($isbn, $title, $author, $publisher, $pages);
            $result = $this->booksGateway->insert($isbn, $title, $author, $publisher, $pages);
            self::disconnect();
            return $result;
        } catch (Exception $e) {
            self::disconnect();
            throw $e;

        }
    }

    public function editBook($isbn, $title, $author, $publisher, $pages, $id)
    {
        try {
            self::connect();
            $result = $this->booksGateway->edit($isbn, $title, $author, $publisher, $pages, $id);
            self::disconnect();
        } catch (Exception $e) {
            self::disconnect();
            throw $e;
        }
    }

    public function deleteBook($id)
    {
        try {
            self::connect();
            $result = $this->booksGateway->delete($id);
            self::disconnect();
        } catch (Exception $e) {
            self::disconnect();
            throw $e;
        }
    }

    public function generarPDF($orderby, $pagina, $numeroLibros){
        try{
            self::connect();
            $this->booksGateway->generarPDF($orderby, $pagina, $numeroLibros);
            self::disconnect();
        }catch (Exception $e){
            throw $e;
        }
    }

}
?>
