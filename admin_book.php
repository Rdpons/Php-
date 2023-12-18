<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location: login.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input data
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $price = floatval($_POST['price']); // Ensure it's a float

    // Additional fields
    $isbn = htmlspecialchars($_POST['isbn']);
    $genre = htmlspecialchars($_POST['genre']);
    $type = htmlspecialchars($_POST['type']);

    // Process image upload (assuming you have an <input type="file" name="image"> in your form)
    $imageFileName = $_FILES['image']['name'];
    $imageTempName = $_FILES['image']['tmp_name'];
    $imagePath = "images/$imageFileName";

    move_uploaded_file($imageTempName, $imagePath);

    // Insert the book into the database (modify this query based on your database structure)
    $query = "INSERT INTO books (title, author, price, isbn, genre, type, img) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdssss", $title, $author, $price, $isbn, $genre, $type, $imageFileName);
    $stmt->execute();
    
    // Check for success
    if ($stmt->affected_rows > 0) {
        echo "Book added successfully!";
    } else {
        echo "Failed to add book. Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Book</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            background-color: #343a40;
            color: #fff;
            padding: 1rem;
            text-align: center;
            width: 100%;
            font-size: 24px;
        }

        nav {
            background-color: #343a40;
            padding: 0.5rem;
            width: 100%;
            text-align: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
        }

        .admin-container {
            width: 80%;
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .admin-container h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .add-book-container {
            max-width: 400px;
            margin: 0 auto;
        }

        .add-book-container h3 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
        }

        input {
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #343a40;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0ef6cc;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['admin_name']; ?>!</h1>
    </header>
    <nav>
        <a href="admin_page.php">Home</a>
        <a href="admin_orders.php">Orders</a>
        <a href="admin_customer.php">Customers</a>
        <a href="admin_book.php">Add Book</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="admin-container">
        <h2>Admin Dashboard - Add Book</h2>
        <div class="add-book-container">
            <h3>Add Book</h3>
            <form action="admin_book.php" method="post" enctype="multipart/form-data">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required>

                <!-- New Fields -->
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" required>

                <label for="genre">Genre:</label>
                <input type="text" id="genre" name="genre" required>

                <label for="type">Type:</label>
                <input type="text" id="type" name="type" required>

                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>

                <button type="submit">Add Book</button>
            </form>
        </div>
    </div>
</body>
</html>
