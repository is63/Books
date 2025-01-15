<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/Autoloader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/BooksService.php';
class BooksController
{
    private $booksService = null;

    public function __construct()
    {
        $this->booksService = new BooksService();
    }

    public function redirect($location)
    {
        header('Location: ' . $location);
    }

    public function handleRequest()
    {
        $op = isset($_GET['op']) ? $_GET['op'] : null;

        try {

            if (!$op || $op == 'list') {
                $this->booksList();
            } elseif ($op == 'new') {
                $this->saveBook();
            } elseif ($op == 'edit') {
                $this->editBook();
            } elseif ($op == 'delete') {
                $this->deleteBook();
            } elseif ($op == 'show') {
                $this->showBook();
            } elseif($op == "Generar PDF"){
                $this->generarPDF();
            } else {
                $this->showError("Page not found", "Page for operation " . $op . " was not found!");
            }
        } catch (Exception $e) {
            $this->showError("Application error", $e->getMessage());
        }
    }

    public function booksList()
    {
        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : null;
        $books = $this->booksService->getAllBooks($orderby);
        $totalPaginas = $this->booksService->getNumPages();
        include ROOT_PATH . '/view/books.php';

    }

    public function saveBook()
    {
        $title = 'Add new book';

        $isbn = '';
        $title = '';
        $author = '';
        $publisher = '';
        $pages = '';

        $errors = array();

        if (isset($_POST['form-submitted'])) {

            $isbn = isset($_POST['isbn']) ? trim($_POST['isbn']) : null;
            $title = isset($_POST['title']) ? trim($_POST['title']) : null;
            $author = isset($_POST['author']) ? trim($_POST['author']) : null;
            $publisher = isset($_POST['publisher']) ? trim($_POST['publisher']) : null;
            $pages = isset($_POST['pages']) ? trim($_POST['pages']) : null;

            try {
                $this->booksService->createBook($isbn, $title, $author, $publisher, $pages);
                $this->redirect('index.php');
                return;
            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }

        include ROOT_PATH . '/view/book-form.php';
    }

    public function editBook()
    {
        $title = "Edit Book";

        $isbn = '';
        $title = '';
        $author = '';
        $publisher = '';
        $pages = '';
        $id = $_GET['id'];

        $errors = array();

        $books = $this->booksService->getBook($id);

        if (isset($_POST['form-submitted'])) {

            $isbn = isset($_POST['isbn']) ? trim($_POST['isbn']) : null;
            $title = isset($_POST['title']) ? trim($_POST['title']) : null;
            $author = isset($_POST['author']) ? trim($_POST['author']) : null;
            $publisher = isset($_POST['publisher']) ? trim($_POST['publisher']) : null;
            $pages = isset($_POST['pages']) ? trim($_POST['pages']) : null;

            try {
                $this->booksService->editBook($isbn, $title, $author, $publisher, $pages, $id);
                $this->redirect('index.php');
                return;
            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }
        // Include in the view of the edit form
        include ROOT_PATH . 'view/book-form-edit.php';
    }

    public function deleteBook()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) {
            throw new Exception('Internal error');
        }
        $this->booksService->deleteBook($id);

        $this->redirect('index.php');
    }

    public function showBook()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        $errors = array();

        if (!$id) {
            throw new Exception('Internal error');
        }
        $books = $this->booksService->getBook($id);

        include ROOT_PATH . 'view/book.php';
    }

    public function showError($title, $message)
    {
        include ROOT_PATH . 'view/error.php';
    }

    public function generarPDF()
    {
        $orderby = isset($_GET['orderby']) && !empty($_GET['orderby']) ? $_GET['orderby'] : 'id';
        $pagina = isset($_GET['pagina']) && !empty($_GET['pagina']) ? $_GET['pagina'] : '1';
        $numLibs = isset($_GET['numerolibros']) && !empty($_GET['numerolibros']) ? $_GET['numerolibros'] : '1';
        $this->booksService->generarPDF($orderby, $pagina, $numLibs );
    }
}