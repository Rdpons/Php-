<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Customers</title>
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

        .customer-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .customer-detail {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            transition: transform 0.3s;
        }

        .customer-detail:hover {
            transform: scale(1.05);
        }

        .customer-detail p {
            margin: 0;
            margin-bottom: 10px;
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
        <h2>Admin Dashboard - Customers</h2>
        <div class="customer-summary">
            <?php
            // Fetch all customers
            $customersQuery = "SELECT * FROM users WHERE user_type = 'user'";
            $customersResult = $conn->query($customersQuery);

            if ($customersResult && $customersResult->num_rows > 0) {
                while ($customer = $customersResult->fetch_assoc()) {
                    $customerId = $customer['id'];
                    $customerName = $customer['name'];
                    $customerEmail = $customer['email'];

                    echo "<div class='customer-detail'>";
                    echo "<p>Customer ID: {$customerId}</p>";
                    echo "<p>Name: {$customerName}</p>";
                    echo "<p>Email: {$customerEmail}</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No customers found.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

