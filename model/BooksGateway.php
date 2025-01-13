<?php
require_once 'Database.php';
require_once 'pdfBooks.php';


class booksGateway extends Database
{

    public function selectAll($order)
    {
        if (!isset($order)) {
            $order = 'id';
        }
        $pdo = Database::connect();
        $librosPagina = 10;
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($paginaActual < 1) {
            $paginaActual = 1;
        }
        $inicio = ($paginaActual - 1) * $librosPagina;

        $sql = $pdo->prepare("SELECT * FROM books ORDER BY $order ASC LIMIT $inicio,$librosPagina");
        $sql->execute();
        $books = array();
        while ($obj = $sql->fetch(PDO::FETCH_OBJ)) {
            $books[] = $obj;
        }
        return $books;
    }

    public function getTotalNumPages()
    {
        $pdo = Database::connect();
        $booksPagina = 10;

        $librosTotales = $pdo->query("SELECT COUNT(*) AS total FROM books");
        $total = $librosTotales->fetch(PDO::FETCH_ASSOC)['total'];
        return ceil($total / $booksPagina);
    }

    public function selectById($id)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("SELECT * FROM books WHERE id = ?");
        $sql->bindValue(1, $id);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);

        return $result;
    }

    public function insert($isbn, $title, $author, $publisher, $pages)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("INSERT INTO books (isbn, title, author, publisher, pages) VALUES ( ?, ?, ?, ?, ?)");
        $result = $sql->execute(array($isbn, $title, $author, $publisher, $pages));
    }

    public function edit($isbn, $title, $author, $publisher, $pages, $id)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("UPDATE books set isbn = ?, title = ?, author = ?, publisher = ?, pages = ? WHERE id = ? LIMIT 1");
        $result = $sql->execute(array($isbn, $title, $author, $publisher, $pages, $id));
    }

    public function delete($id)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("DELETE FROM books WHERE id = ?");
        $sql->execute(array($id));
    }

    public function generarPDF($orderby, $page, $numeroLibros)
    {
        // Se conecta a la base de datos;
        ob_start();
        $pdo = Database::connect();

        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->AddCol('isbn', 25, 'ISBN', 'C');
        $pdf->AddCol('title', 85, 'Title', 'C');
        $pdf->AddCol('author', 35, 'Author', 'C');
        $pdf->AddCol('publisher', 45, 'Publisher', 'C');
        $pdf->AddCol('pages', 15, 'Pages', 'C');

        $page = $_GET["pagina"];
        if($page == null){
            $page = '1';
        }
        $numeroLibros = $_GET["numeroLibros"];
        if($numeroLibros == null){
            $numeroLibros = '1';
        }
        $inicio = ($page - 1) * 10;

        $pdf->Table($pdo, "SELECT * FROM books ORDER BY $orderby ASC LIMIT $inicio,$numeroLibros");
        $pdf->Output();
        ob_end_flush();


    }

}

?>
