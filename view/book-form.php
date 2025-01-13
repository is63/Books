<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <title>
        <?php echo htmlentities($title); ?>
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
    <label for="ISBN">ISBN: </label><br>
    <input type="text" name="isbn" value="<?php echo htmlentities($isbn); ?>">
    <br>
    <label for="Title">Title: </label><br>
    <input type="text" name="title" value="<?php echo htmlentities($title); ?>">
    <br>
    <label for="Author">Author: </label><br>
    <input type="text" name="author" value="<?php echo htmlentities($author); ?>">
    <br>
    <label for="Publisher">Publisher: </label><br>
    <textarea name="publisher"><?php echo htmlentities($publisher); ?></textarea>
    <br>
    <label for="Pages">Pages: </label><br>
    <textarea name="pages"><?php echo htmlentities($pages); ?></textarea>
    <br>

    <input type="hidden" name="form-submitted" value="1">
    <input type="submit" value="Submit">
    <button type="button" onclick="location.href='index.php'">Cancel</button>
</form>
</body>
</html>
