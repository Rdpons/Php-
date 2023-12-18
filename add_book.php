<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    $insertBookQuery = "INSERT INTO books (title, author, price) VALUES ('$title', '$author', '$price')";

    if (mysqli_query($conn, $insertBookQuery)) {
        echo "Book added successfully.";
    } else {
        echo "Error adding book: " . mysqli_error($conn);
    }
}
?>
