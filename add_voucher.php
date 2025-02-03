/**
 * A PHP program from Grocery Shop Management System Project.
 *
 * @author Noor Haider Khan
 * @version 1.0
 * @since 2025-02-04
 */

<?php
include 'db_connection.php';

// Fetch matching names based on selected type and input query
if (isset($_GET['type']) && isset($_GET['query'])) {
    $type = $_GET['type'];
    $query = $_GET['query'];

    $table = ($type === 'Customer') ? 'Customer' : 'Supplier';
    $sql = "SELECT Name FROM $table WHERE Name LIKE ? ORDER BY Name ASC";
    $stmt = $conn->prepare($sql);
    $search = $query . '%';
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $names = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $names[] = $row['Name'];
        }
    }
    echo json_encode($names);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $type = $_POST['type'];
    $party_name = $_POST['party_name'];
    $amount = $_POST['amount'];
    $due = $_POST['due'];

    $table = ($type === 'Customer') ? 'Customer' : 'Supplier';
    $id_column = 'ID'; // Assuming both tables have an ID column.

    $sql = "SELECT $id_column FROM $table WHERE Name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $party_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $party_id = $row[$id_column];

        $sql = "INSERT INTO Voucher (date, type, party_id, Amount, Due) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssidd", $date, $type, $party_id, $amount, $due);

        if ($stmt->execute()) {
            echo "Voucher added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Invalid Party Name.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Voucher</title>
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
    <script>
        async function fetchFilteredNames() {
            const type = document.querySelector('select[name="type"]').value;
            const query = document.querySelector('input[name="party_name"]').value;

            if (type && query.length > 0) {
                const response = await fetch(`add_voucher.php?type=${type}&query=${query}`);
                const names = await response.json();

                const suggestionBox = document.getElementById("nameSuggestions");
                suggestionBox.innerHTML = ""; // Clear previous suggestions

                names.forEach(name => {
                    const option = document.createElement("div");
                    option.textContent = name;
                    option.classList.add("suggestion-item");
                    option.onclick = () => {
                        document.querySelector('input[name="party_name"]').value = name;
                        suggestionBox.innerHTML = ""; // Clear suggestions
                    };
                    suggestionBox.appendChild(option);
                });
            } else {
                document.getElementById("nameSuggestions").innerHTML = ""; // Clear suggestions if query is empty
            }
        }
    </script>
    <style>
        .suggestion-box {
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            background: #fff;
            z-index: 1000;
        }
        .suggestion-item {
            padding: 5px;
            cursor: pointer;
        }
        .suggestion-item:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <form action="add_voucher.php" method="POST">
        <label>Date:</label><input type="date" name="date" required><br>
        <label>Party Type:</label>
        <select name="type" onchange="fetchFilteredNames()" required>
            <option value="">Select Type</option>
            <option value="Customer">Customer</option>
            <option value="Supplier">Supplier</option>
        </select><br>
        <label>Party Name:</label>
        <input type="text" name="party_name" oninput="fetchFilteredNames()" autocomplete="off" required>
        <div id="nameSuggestions" class="suggestion-box"></div><br>
        <label>Pay_Amount:</label><input type="number" step="0.01" name="amount" required><br>
        <label>Due:</label><input type="number" step="0.01" name="due" required><br>
        <input type="submit" value="Add Voucher">
    </form>
    <button onclick="window.location.href='index.php';" class="home-button">Back to Home</button>
</body>
</html>
