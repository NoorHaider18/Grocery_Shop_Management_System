<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    $type = $_POST['type'];
   
    // Backend Validation
    if (empty($name) || empty($contact) || empty($address)) {
        die("All fields are required.");
    }
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        die("Invalid name. Only alphabets and spaces are allowed.");
    }
    if (!preg_match("/^\d+$/", $contact)) {
        die("Invalid contact number. Only digits are allowed.");
    }
    if (!preg_match("/^[a-zA-Z0-9,\.\s]+$/", $address)) {
        die("Invalid address. Only letters, numbers, commas, and periods are allowed.");
    }
    if (!in_array($type, ['regular', 'irregular'])) {
        die("Invalid customer type.");
    }

    // SQL Query
    $sql = "INSERT INTO Customer (Name, contact_info, address, type)
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $contact, $address, $type);

    if ($stmt->execute()) {
        echo "Customer added successfully!";
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
    <title>Add Customer</title>
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

    <form id="customerForm" action="add_customer.php" method="POST">
        <label>Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label>Contact Info:</label>
        <input type="text" name="contact" id="contact" required>
        <br>
        <label>Address:</label>
        <input type="text" name="address" id="address" required>
        <br>
        <label>Type:</label>
        <select name="type" id="type">
            <option value="regular">Regular</option>
            <option value="irregular">Irregular</option>
        </select>
        <br>
        <input type="submit" value="Add Customer">
    </form>
    <button onclick="window.location.href='index.php';" class="home-button">Back to Home</button>

    <script>
        document.getElementById("customerForm").addEventListener("submit", function(event) {
            const name = document.getElementById("name").value.trim();
            const contact = document.getElementById("contact").value.trim();
            const address = document.getElementById("address").value.trim();

            if (name === "" || contact === "" || address === "") {
                alert("All fields are required.");
                event.preventDefault();
                return;
            }

            if (!/^[a-zA-Z\s]+$/.test(name)) {
                alert("Name must contain only letters and spaces.");
                event.preventDefault();
                return;
            }

            if (!/^\d+$/.test(contact)) {
                alert("Contact number must contain only digits.");
                event.preventDefault();
                return;
            }

            if (!/^[a-zA-Z0-9,\.\s]+$/.test(address)) {
                alert("Address can only contain letters, numbers, commas, and periods.");
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
