/**
 * A PHP program from Grocery Shop Management System Project.
 *
 * @author Noor Haider Khan
 * @version 1.0
 * @since 2025-02-04
 */

<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    $salary = trim($_POST['salary']);
    $type = $_POST['type'];
    $workingHour = trim($_POST['workingHour']);
    $shift = $_POST['shift'];

    // Backend Validation
    if (empty($name) || empty($contact) || empty($address) || empty($salary) || empty($workingHour) || empty($shift)) {
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

    // SQL Query
    $sql = "INSERT INTO Employee (Name, contact_info, address, salary, type, workingHour, shift)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $contact, $address, $salary, $type, $workingHour, $shift);

    if ($stmt->execute()) {
        echo "Employee added successfully!";
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
    <title>Add Employee</title>
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
    
    <form id="employeeForm" action="add_employee.php" method="POST">
        <label>Name:</label><input type="text" name="name" id="name" required>
        <br>
        <label>Contact Info:</label><input type="text" name="contact" id="contact" required>
        <br>
        <label>Address:</label><input type="text" name="address" id="address" required>
        <br>
        <label>Salary:</label><input type="number" step="0.01" name="salary" required>
        <br>
        <label>Type:</label>
        <select name="type">
            <option value="owner">Owner</option>
            <option value="general">General</option>
        </select>
        <br>
        <label>Working Hours:</label><input type="number" name="workingHour" required>
        <br>
        <label>Shift:</label>
        <select name="shift" id="shift">
            <option value="day">Day</option>
            <option value="night">Night</option>
        </select>
        <br>
        <input type="submit" value="Add Employee">
    </form>
    <button onclick="window.location.href='index.php';" class="home-button">Back to Home</button>

    <script>
        document.getElementById("employeeForm").addEventListener("submit", function(event) {
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
