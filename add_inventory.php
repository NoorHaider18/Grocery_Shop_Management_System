/**
 * A PHP program from Grocery Shop Management System Project.
 *
 * @author Noor Haider Khan
 * @version 1.0
 * @since 2025-02-04
 */

<?php
include 'db_connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitInventory'])) {
    $date = $_POST['date'];
    $product_id = $_POST['productID'];
    $quantity_available = $_POST['quantityAvailable'];

    if (empty($date) || empty($product_id) || empty($quantity_available)) {
        $error = "All fields are required!";
    } else {
        // Calculate total quantity from invoices
        $total_quantity = 0;
        $invoice_query = "
            SELECT 
                SUM(CASE WHEN Product_ID_1 = ? THEN Quantity_1 ELSE 0 END +
                    CASE WHEN Product_ID_2 = ? THEN Quantity_2 ELSE 0 END +
                    CASE WHEN Product_ID_3 = ? THEN Quantity_3 ELSE 0 END +
                    CASE WHEN Product_ID_4 = ? THEN Quantity_4 ELSE 0 END +
                    CASE WHEN Product_ID_5 = ? THEN Quantity_5 ELSE 0 END +
                    CASE WHEN Product_ID_6 = ? THEN Quantity_6 ELSE 0 END +
                    CASE WHEN Product_ID_7 = ? THEN Quantity_7 ELSE 0 END) AS total
            FROM Invoice";
        $invoice_stmt = $conn->prepare($invoice_query);
        $invoice_stmt->bind_param("iiiiiii", $product_id, $product_id, $product_id, $product_id, $product_id, $product_id, $product_id);
        $invoice_stmt->execute();
        $invoice_result = $invoice_stmt->get_result();
        if ($invoice_result->num_rows > 0) {
            $row = $invoice_result->fetch_assoc();
            $total_quantity = $row['total'];
        }

        // Insert into inventory table
        $query = "INSERT INTO Inventory (product_ID, update_date, total_quantity, quantity_available) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isii", $product_id, $date, $total_quantity, $quantity_available);
        if ($stmt->execute()) {
            $success = "Inventory added successfully!";
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Handle product autocomplete
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productAutocomplete'])) {
    $product_name = $_POST['productName'];
    $query = "SELECT Product_ID, Product_Name FROM Product WHERE Product_Name LIKE ? LIMIT 10";
    $stmt = $conn->prepare($query);
    $search = $product_name . '%';
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<div class='product-item' data-id='{$row['Product_ID']}'>{$row['Product_Name']}</div>";
    }
    exit;
}

// Handle fetching total quantity
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetchTotalQuantity'])) {
    $product_id = $_POST['productID'];
    $query = "
        SELECT 
            SUM(CASE WHEN Product_ID_1 = ? THEN Quantity_1 ELSE 0 END +
                CASE WHEN Product_ID_2 = ? THEN Quantity_2 ELSE 0 END +
                CASE WHEN Product_ID_3 = ? THEN Quantity_3 ELSE 0 END +
                CASE WHEN Product_ID_4 = ? THEN Quantity_4 ELSE 0 END +
                CASE WHEN Product_ID_5 = ? THEN Quantity_5 ELSE 0 END +
                CASE WHEN Product_ID_6 = ? THEN Quantity_6 ELSE 0 END +
                CASE WHEN Product_ID_7 = ? THEN Quantity_7 ELSE 0 END) AS total
        FROM Invoice";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiiiii", $product_id, $product_id, $product_id, $product_id, $product_id, $product_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    echo json_encode(['totalQuantity' => $row['total']]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        .autocomplete-box {
            background-color: white;
            border: 1px solid #ccc;
            display: none;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            z-index: 1000;
        }

        .product-item {
            padding: 5px;
            cursor: pointer;
        }

        .product-item:hover {
            background-color: #f0f0f0;
        }
       
    </style>
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
    <form action="" method="POST">
        <h1>Inventory</h1>
        <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

        <!-- Date -->
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <!-- Product Name -->
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" autocomplete="off">
        <input type="hidden" id="productID" name="productID">
        <div id="productList" class="autocomplete-box"></div>

        <!-- Total Quantity -->
        <label for="totalQuantity">Total Quantity (From Invoice):</label>
        <input type="number" id="totalQuantity" name="totalQuantity" readonly>

        <!-- Available Quantity -->
        <label for="quantityAvailable">Available Quantity:</label>
        <input type="number" id="quantityAvailable" name="quantityAvailable" required>

        <button type="submit" name="submitInventory">Submit</button>
    </form>
    <button onclick="window.location.href='index.php';" class="home-button">Back to Home</button>
    <script>
        $(document).ready(function () {
            // Product autocomplete
            $('#productName').on('input', function () {
                let productName = $(this).val();
                if (productName !== '') {
                    $.ajax({
                        url: '',
                        type: 'POST',
                        data: { productAutocomplete: true, productName: productName },
                        success: function (response) {
                            $('#productList').html(response).show();
                        }
                    });
                } else {
                    $('#productList').hide();
                }
            });

            // Select product
            $(document).on('click', '.product-item', function () {
                let productName = $(this).text();
                let productID = $(this).data('id');
                $('#productName').val(productName);
                $('#productID').val(productID);
                $('#productList').hide();

                // Fetch total quantity
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: { fetchTotalQuantity: true, productID: productID },
                    success: function (response) {
                        let data = JSON.parse(response);
                        $('#totalQuantity').val(data.totalQuantity);
                    }
                });
            });
        });
    </script>
</body>
</html>
