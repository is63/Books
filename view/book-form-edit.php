<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <title>
    </title>
</head>
<body>
<h3>Add New Book</h3>
<?php
if ($errors) {
    echo '<ul class="errors">';
    foreach ($errors as $field => $error) {
        echo '<li>' . htmlentities($error) . '</li>';
    }
    echo '</ul>';
}
?>

<form method="post" action="">
    <label for="isbn">ISBN: </label><br>
    <input type="text" name="isbn" value="<?php echo htmlentities($books->isbn); ?>">
    <br>
    <label for="title">Title: </label><br>
    <input type="text" name="title" value="<?php echo htmlentities($books->title); ?>">
    <br>
    <label for="author">Author: </label><br>
    <input type="text" name="author" value="<?php echo htmlentities($books->author); ?>">
    <br>
    <label for="publisher">Publisher: </label><br>
    <textarea name="publisher"><?php echo htmlentities($books->publisher); ?></textarea>
    <br>
    <label for="pages">Pages: </label><br>
    <textarea name="pages"><?php echo htmlentities($books->pages); ?></textarea>
    <br>

    <input type="hidden" name="form-submitted" value="1">
    <input type="submit" value="Update">
    <button type="button" onclick="location.href='index.php'">Cancel</button>
</form>
</body>
</html>
