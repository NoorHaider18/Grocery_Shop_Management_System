/**
 * A PHP program from Grocery Shop Management System Project.
 *
 * @author Noor Haider Khan
 * @version 1.0
 * @since 2025-02-04
 */

<?php
include 'db_connection.php';

$error_message = "";
$success_message = "";

if (isset($_GET['error']) && $_GET['error'] == "duplicate") {
    $error_message = "A product with the same name already exists.";
} elseif (isset($_GET['success'])) {
    $success_message = "Operation completed successfully!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operation = $_POST['operation'];
    $product_name = trim($_POST['product_name']);
    $category = trim($_POST['category']);

    // Common Validation
    if (empty($product_name) || empty($category)) {
        die("Product Name and Category are required for all operations.");
    }
    if (!preg_match("/^[a-zA-Z\s]+$/", $product_name)) {
        die("Product Name must contain only letters and spaces.");
    }
    if (!preg_match("/^[a-zA-Z\s]+$/", $category)) {
        die("Category must contain only letters and spaces.");
    }

    // Handle "Set" Operation (Add a New Product)
    if ($operation == "Set") {
        $buying_date = $_POST['buying_date'];
        $buying_price = $_POST['buying_price'];
        $selling_price = $_POST['selling_price'];

        if (empty($buying_date) || empty($buying_price) || empty($selling_price)) {
            die("All fields are required for adding a product.");
        }
        if (!filter_var($buying_price, FILTER_VALIDATE_INT)) {
            die("Buying Price must be an integer.");
        }
        if (!filter_var($selling_price, FILTER_VALIDATE_INT)) {
            die("Selling Price must be an integer.");
        }

        // Check for duplicate product names
        $check_query = "SELECT Product_Name FROM Product WHERE Product_Name = ? AND Category = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ss", $product_name, $category);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            header("Location: add_product.php?error=duplicate");
            exit();
        }

        $sql = "INSERT INTO Product (Product_Name, Buying_Date, Buying_Price, Selling_Price, Category) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdds", $product_name, $buying_date, $buying_price, $selling_price, $category);

        if ($stmt->execute()) {
            header("Location: add_product.php?success=true");
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    // Handle "Update" Operation
    elseif ($operation == "Update") {
        $buying_price = $_POST['buying_price'];
        $selling_price = $_POST['selling_price'];

        if (empty($buying_price) || empty($selling_price)) {
            die("Buying and Selling Prices are required for updating.");
        }
        if (!filter_var($buying_price, FILTER_VALIDATE_INT)) {
            die("Buying Price must be an integer.");
        }
        if (!filter_var($selling_price, FILTER_VALIDATE_INT)) {
            die("Selling Price must be an integer.");
        }

        // Check if the product exists
        $check_query = "SELECT Product_Name FROM Product WHERE Product_Name = ? AND Category = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ss", $product_name, $category);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            die("Product does not exist.");
        }

        $sql = "UPDATE Product SET Buying_Price = ?, Selling_Price = ? WHERE Product_Name = ? AND Category = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ddss", $buying_price, $selling_price, $product_name, $category);

        if ($stmt->execute()) {
            header("Location: add_product.php?success=true");
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    // Handle "Delete" Operation
    elseif ($operation == "Delete") {
        // Check if the product exists
        $check_query = "SELECT Product_Name FROM Product WHERE Product_Name = ? AND Category = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ss", $product_name, $category);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            die("Product does not exist.");
        }

        $sql = "DELETE FROM Product WHERE Product_Name = ? AND Category = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $product_name, $category);

        if ($stmt->execute()) {
            header("Location: add_product.php?success=true");
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    // Invalid Operation
    else {
        die("Invalid operation selected.");
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #456;
        }

        .home-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .home-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <?php if ($success_message): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <form id="productForm" action="add_product.php" method="POST">
        <label for="operation">Operation:</label>
        <select id="operation" name="operation" required>
            <option value="">Select an Operation</option>
            <option value="Set">Add Product</option>
            <option value="Update">Update Product</option>
            <option value="Delete">Delete Product</option>
        </select>

        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required>

        <div id="extraFields" style="display: none;">
            <label for="buying_date">Buying Date:</label>
            <input type="date" id="buying_date" name="buying_date">

            <label for="buying_price">Buying Price:</label>
            <input type="number" step="1" id="buying_price" name="buying_price">

            <label for="selling_price">Selling Price:</label>
            <input type="number" step="1" id="selling_price" name="selling_price">
        </div>

        <input type="submit" value="Submit">
    </form>
    <button onclick="window.location.href='index.php';" class="home-button">Back to Home</button>
    <script>
        const operation = document.getElementById('operation');
        const extraFields = document.getElementById('extraFields');

        operation.addEventListener('change', function () {
            if (this.value === 'Set' || this.value === 'Update') {
                extraFields.style.display = 'block';
            } else {
                extraFields.style.display = 'none';
            }
        });
    </script>
</body>
</html>
