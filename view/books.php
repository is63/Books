<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <title>books</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
<header>
    <h3>CRUD BOOKS with MVC</h3>
</header>
<?php

$pagina = (!isset($_GET['pagina']) || $_GET['pagina'] < 1) ? 1 : (int)$_GET['pagina'];
$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'id';
?>
<div id="operations">
    <div id="newBook"><a href="index.php?op=new"><i class="fa-solid fa-circle-plus"></i> Add new book</a></div>
    <div id="pdf">
        <form method="GET">
            <input type="hidden" name="pagina" value="<?php echo $pagina ?>" >
            <input type="hidden" name="orderby" value="<?php echo $orderby ?>" >
            <input type="number" placeholder="Number of books" name="numeroLibros" min="1">
            <input id="inputSubmit" type="submit" name="op" value="Generar PDF">
        </form>
    </div>
</div>
<br>
<table class="books" border="0" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <th><a href="?orderby=id&pagina=<?php echo $pagina ?>">ID</a></th>
        <th><a href="?orderby=isbn&pagina=<?php echo $pagina ?>">ISBN</a></th>
        <th><a href="?orderby=title&pagina=<?php echo $pagina ?>">Title</a></th>
        <th><a href="?orderby=author&pagina=<?php echo $pagina ?>">Author</a></th>
        <th><a href="?orderby=publisher&pagina=<?php echo $pagina ?>">Publisher</a></th>
        <th><a href="?orderby=pages&pagina=<?php echo $pagina ?>">Pages</a></th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($books as $book) : ?>
        <tr>
            <td>
                <a href="index.php?op=show&id=<?php echo $book->id; ?>"><?php echo htmlentities($book->id); ?></a>
            </td>
            <td><?php echo htmlentities($book->isbn); ?></td>
            <td><?php echo htmlentities($book->title); ?></td>
            <td><?php echo htmlentities($book->author); ?></td>
            <td><?php echo htmlentities($book->publisher); ?></td>
            <td><?php echo htmlentities($book->pages); ?></td>
            <td><a style="margin-right: 5px;" href="index.php?op=edit&id=<?php echo $book->id; ?>">edit</a>
                <a href="index.php?op=delete&id=<?php echo $book->id; ?>"
                   onclick="return confirm('Are you sure you want to delete?');">delete</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div id="pagination">
    <?php
    if ($pagina > 1): ?>
        <a href="?orderby=<?php echo $orderby ?>&pagina=1">&laquo; First |</a>
        <a href="?orderby=<?php echo $orderby ?>&pagina=<?= $pagina - 1 ?>">&larr; Previous</a>
    <?php endif;

    ?>
    | Page <?= $pagina ?> of <?= $totalPaginas ?> |
    <?php

    if ($pagina < $totalPaginas): ?>
        <a href="?orderby=<?php echo $orderby ?>&pagina=<?= $pagina + 1 ?>">Next &rarr;</a>
        <a href="?orderby=<?php echo $orderby ?>&pagina=<?= $totalPaginas ?>">| Last &raquo;</a>
    <?php endif; ?>
</div>
</body>
</html>
