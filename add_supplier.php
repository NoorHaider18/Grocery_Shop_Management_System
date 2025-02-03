/**
 * A PHP program from Grocery Shop Management System Project.
 *
 * @author Noor Haider Khan
 * @version 1.0
 * @since 2025-02-04
 */

<?php
// Database connection
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    $productType = trim($_POST['productType']);
    $role = $_POST['role'];

    // Backend Validation
    if (empty($name) || empty($contact) || empty($address) || empty($productType) || empty($role)) {
        die("All fields are required.");
    }

    // Name: Only letters and spaces allowed
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        die("Invalid name. Only letters and spaces are allowed.");
    }

    // Contact: Only digits allowed
    if (!preg_match("/^\d+$/", $contact)) {
        die("Invalid contact number. Only digits are allowed.");
    }

    // Address: Letters, numbers, commas, periods, and spaces allowed
    if (!preg_match("/^[a-zA-Z0-9,.\s]+$/", $address)) {
        die("Invalid address. Only letters, numbers, commas, periods, and spaces are allowed.");
    }

    // Check if a supplier with the same details already exists
    $checkSql = "SELECT * FROM Supplier WHERE Name = ? AND contact_info = ? AND address = ? AND productType = ? AND role = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("sssss", $name, $contact, $address, $productType, $role);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        die("A supplier with the same details already exists. Please modify at least one field.");
    }

    $checkStmt->close();

    // Insert new supplier
    $sql = "INSERT INTO Supplier (Name, contact_info, address, productType, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $contact, $address, $productType, $role);

    if ($stmt->execute()) {
        echo "Supplier added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Supplier</title>
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
    
    <form id="supplierForm" action="add_supplier.php" method="POST">
        <label>Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label>Contact Info:</label>
        <input type="text" name="contact" id="contact" required>
        <br>
        <label>Address:</label>
        <input type="text" name="address" id="address" required>
        <br>
        <label>Product Type:</label>
        <input type="text" name="productType" id="productType" required>
        <br>
        <label>Role:</label>
        <select name="role" id="role">
            <option value="specificDealer">Specific Dealer</option>
            <option value="ordinarySupplier">Ordinary Supplier</option>
        </select>
        <br>
        <input type="submit" value="Add Supplier">
    </form>
    <button onclick="window.location.href='index.php';" class="home-button">Back to Home</button>

    <script>
        document.getElementById("supplierForm").addEventListener("submit", function(event) {
            const name = document.getElementById("name").value.trim();
            const contact = document.getElementById("contact").value.trim();
            const address = document.getElementById("address").value.trim();

            // Name Validation: Only letters and spaces allowed
            if (!/^[a-zA-Z\s]+$/.test(name)) {
                alert("Name must contain only letters and spaces.");
                event.preventDefault();
                return;
            }

            // Contact Validation: Only digits allowed
            if (!/^\d+$/.test(contact)) {
                alert("Contact number must contain only digits.");
                event.preventDefault();
                return;
            }

            // Address Validation: Letters, numbers, commas, periods, and spaces allowed
            if (!/^[a-zA-Z0-9,.\s]+$/.test(address)) {
                alert("Address must contain only letters, numbers, commas, periods, and spaces.");
                event.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>
