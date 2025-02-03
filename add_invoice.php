/**
 * A PHP program from Grocery Shop Management System Project.
 *
 * @author Noor Haider Khan
 * @version 1.0
 * @since 2025-02-04
 */

<?php
include 'db_connection.php'; // Include your database connection

// Handle AJAX request for supplier autocomplete
if (isset($_POST['supplierName']) && !isset($_POST['date'])) {
    $Name = $_POST['supplierName'];
    $query = "SELECT id, Name FROM Supplier WHERE Name LIKE ? LIMIT 10";
    $stmt = $conn->prepare($query);
    $search = $Name . '%';
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<div class='supplier-item' data-id='{$row['id']}'>{$row['Name']}</div>";
    }
    exit();
}

// Handle AJAX request for product autocomplete
if (isset($_POST['productName']) && !isset($_POST['date'])) {
    $product_name = $_POST['productName'];
    $query = "SELECT Product_ID, Product_Name, Buying_Price FROM Product WHERE Product_Name LIKE ? LIMIT 10";
    $stmt = $conn->prepare($query);
    $search = $product_name . '%';
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<div class='product-item' data-id='{$row['Product_ID']}' data-rate='{$row['Buying_Price']}'>{$row['Product_Name']}</div>";
    }
    exit();
}

// Handle form submission for invoice
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['date'])) {
    // Get data from the form
    $supplier_id = $_POST['supplierID'];
    $date = $_POST['date']; // Get the submitted date
    $total_amount = $_POST['totalAmount'];

    // Validate data
    if (empty($supplier_id) || empty($date) || empty($total_amount)) {
        echo "All fields are required!";
        exit();
    }

    // Prepare data for products
    $product_ids = $_POST['productID'];
    $product_names = $_POST['productName'];
    $quantities = $_POST['quantity'];
    $rates = $_POST['rate'];
    $amounts = $_POST['amount'];

    // Start building the query for inserting the invoice
    $invoice_query = "INSERT INTO Invoice (
        Supplier_ID, Date, Total_Amount, 
        Product_ID_1, Product_Name_1, Quantity_1, Rate_1, Amount_1,
        Product_ID_2, Product_Name_2, Quantity_2, Rate_2, Amount_2,
        Product_ID_3, Product_Name_3, Quantity_3, Rate_3, Amount_3,
        Product_ID_4, Product_Name_4, Quantity_4, Rate_4, Amount_4,
        Product_ID_5, Product_Name_5, Quantity_5, Rate_5, Amount_5,
        Product_ID_6, Product_Name_6, Quantity_6, Rate_6, Amount_6,
        Product_ID_7, Product_Name_7, Quantity_7, Rate_7, Amount_7
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Dynamically create the parameters array
    $params = [$supplier_id, $date, $total_amount];
    for ($i = 0; $i < 7; $i++) {
        $params[] = isset($product_ids[$i]) ? $product_ids[$i] : null;
        $params[] = isset($product_names[$i]) ? $product_names[$i] : null;
        $params[] = isset($quantities[$i]) ? $quantities[$i] : null;
        $params[] = isset($rates[$i]) ? $rates[$i] : null;
        $params[] = isset($amounts[$i]) ? $amounts[$i] : null;
    }

    // Dynamically create the type string
    $type_string = 'iss' . str_repeat('issdi', 7); // Adjust type string for MySQL

    // Bind parameters dynamically
    $stmt = $conn->prepare($invoice_query);
    $stmt->bind_param($type_string, ...$params);

    // Execute the query
    if ($stmt->execute()) {
        echo "Invoice added successfully!";
    } else {
        echo "Error: " . $stmt->error;
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
    <title>Add Invoice</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
    <link rel="stylesheet" href="style.css">
    
    <style>
       /* General body styling */
       /* Styling for the heading */
/* Styling for the h1 heading */

body {
    font-family: Arial, sans-serif;
    background-color: #fff;
    margin: 0;
    padding: 0;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow-y: auto;
}

/* Form container */
form {
    background-color: #FF914D; /* Orange background */
    width: 80%;
    max-width: 1000px;
    border-radius: 80px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    padding: 20px;
    color: white;
    font-size: 16px;
}

/* Heading */
h1 {
    text-align: center;
    margin-bottom: 20px;
    color: red;
}

/* Label styling */
label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

/* Input fields */
input[type="text"],
input[type="number"],
input[type="date"],
#totalAmount {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 0.1px solid #ddd;
    font-size: 16px;
}

/* Autocomplete box for supplier/product suggestions */
.autocomplete-box {
    background-color: red; /* Set the background color for the entire dropdown */
    border: 1px solid #ccc; /* Border for the dropdown */
    max-height: 200px; /* Allow enough height for multiple items */
    overflow-y: auto; /* Enable scrolling for dropdown items if necessary */
    z-index: 1000; /* Ensure the dropdown appears above other elements */
    position: absolute; /* Position it relative to the parent element */
    width: 250px; /* Adjust the width as needed */
    display: none; /* Initially hidden */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add a shadow for better visuals */
    border-radius: 4px; /* Optional: Rounded corners */
}

/* Styling for individual items inside the dropdown */
.autocomplete-box div {
    padding: 10px; /* Space around each item */
    color: white; /* Text color */
    cursor: pointer; /* Pointer cursor for dropdown items */
}

/* Hover effect for better UX */
.autocomplete-box div:hover {
    background-color: #ff7f50; /* Change background on hover */
}

.supplier-item,
.product-item {
    padding: 10px;
    cursor: pointer;
}

.supplier-item:hover,
.product-item:hover {
    background-color: blue;
}

/* Product section */
.product-row {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 10px;
}

.product-row input {
    flex: 1; /* Distribute input sizes evenly */
}

/* Buttons */
button,
#addProduct {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin: 10px 0;
}

button:hover,
#addProduct:hover {
    background-color: #45a049;
}

/* Total Amount */
#totalAmount {
    background-color: #f4f4f4;
    color: #333;
    font-weight: bold;
}

/* Home button */
.home-button {
    position: fixed;
    top: 20px;
    left: 20px;
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
}

.home-button:hover {
    background-color: #45a049;
}


    </style> 

</head>
<body>
<form action="" method="POST">
        <h1> INVOICE   </h1>
        <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
   
    <form action="add_invoice.php" method="POST">
        <!-- Supplier Selection -->
        <label for="supplierName">Supplier Name:</label>
        <input type="text" id="supplierName" name="supplierName" autocomplete="off">
        <input type="hidden" id="supplierID" name="supplierID">
        <div id="supplierList" class="autocomplete-box"></div>

        <!-- Date -->
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <!-- Product Inputs -->
        <h3>Products</h3>
        <div id="products">
            <div class="product-row">
                <input type="hidden" name="productID[]" class="productID">
                <label>Product Name:</label>
                <input type="text" name="productName[]" class="productName" autocomplete="off">
                <div class="productList autocomplete-box"></div>
                <label>Quantity:</label>
                <input type="number" name="quantity[]" class="quantity" step="1" min="1" required>
                <label>Rate:</label>
                <input type="number" name="rate[]" class="rate" step="0.01" required>
                <label>Amount:</label>
                <input type="number" name="amount[]" class="amount" step="0.01" readonly>
            </div>
        </div>
        <button type="button" id="addProduct">Add Product</button>

        <!-- Total Amount -->
        <label for="totalAmount">Total Amount:</label>
        <input type="number" id="totalAmount" name="totalAmount" step="0.01" readonly required>

        <button type="submit">Submit</button>
    </form>
    <button onclick="window.location.href='index.php';" class="home-button">Back to Home</button>

    <script>
        $(document).ready(function () {
            // Supplier autocomplete
            $('#supplierName').on('input', function () {
                let supplierName = $(this).val();
                if (supplierName !== '') {
                    $.ajax({
                        url: 'add_invoice.php',
                        type: 'POST',
                        data: { supplierName: supplierName },
                        success: function (response) {
                            $('#supplierList').html(response).show();
                        }
                    });
                } else {
                    $('#supplierList').hide();
                }
            });

            // Select supplier
            $(document).on('click', '.supplier-item', function () {
                let supplierName = $(this).text();
                let supplierID = $(this).data('id');
                $('#supplierName').val(supplierName);
                $('#supplierID').val(supplierID);
                $('#supplierList').hide();
            });

            // Product autocomplete
            $(document).on('input', '.productName', function () {
                let productName = $(this).val();
                let productList = $(this).siblings('.productList');
                if (productName !== '') {
                    $.ajax({
                        url: 'add_invoice.php',
                        type: 'POST',
                        data: { productName: productName },
                        success: function (response) {
                            productList.html(response).show();
                        }
                    });
                } else {
                    productList.hide();
                }
            });

            // Select product
            $(document).on('click', '.product-item', function () {
                let productRow = $(this).closest('.product-row');
                productRow.find('.productName').val($(this).text());
                productRow.find('.productID').val($(this).data('id'));
                productRow.find('.rate').val($(this).data('rate'));
                $(this).parent('.productList').hide();
            });

            // Calculate amount for each product
            $(document).on('input', '.quantity, .rate', function () {
                let productRow = $(this).closest('.product-row');
                let quantity = parseFloat(productRow.find('.quantity').val()) || 0;
                let rate = parseFloat(productRow.find('.rate').val()) || 0;
                productRow.find('.amount').val((quantity * rate).toFixed(2));
                calculateTotalAmount();
            });

            // Add product row
            $('#addProduct').click(function () {
                let newRow = $('.product-row:first').clone();
                newRow.find('input').val('');
                $('#products').append(newRow);
            });

            // Calculate total amount
            function calculateTotalAmount() {
                let total = 0;
                $('.amount').each(function () {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#totalAmount').val(total.toFixed(2));
            }
        });
    </script>
</body>
</html>
