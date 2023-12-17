<?php

// Function to sanitize form values
function sanitizeFormValue($value) {
    return htmlspecialchars(trim($value));
}

// Function to insert data into MySQL database
function insertIntoDatabase($data) {
    $servername = "localhost";  // Replace with your MySQL server hostname
    $username = "root";  // Replace with your MySQL username
    $password = "E37Si.zQJ5p=5xq";  // Replace with your MySQL password
    $dbname = "medicine_database";  // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL query
    $sql = "INSERT INTO medicine (serialNumber, medicineName, manufacturedDate, expiryDate, useDescription) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $data[0], $data[1], $data[2], $data[3], $data[4]);
    $stmt->execute();

    // Close connection
    $stmt->close();
    $conn->close();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize form values
    $serialNumber = sanitizeFormValue($_POST['serialNumber']);
    $medicineName = sanitizeFormValue($_POST['medicineName']);
    $manufacturedDate = sanitizeFormValue($_POST['manufacturedDate']);
    $expiryDate = sanitizeFormValue($_POST['expiryDate']);
    $use = sanitizeFormValue($_POST['use']);

    // Prepare data array
    $data = array(
        $serialNumber,
        $medicineName,
        $manufacturedDate,
        $expiryDate,
        $use
    );

    // Insert data into MySQL database
    insertIntoDatabase($data);

    // Redirect back to the form or any other page
    header('Location: table.html');
    exit();
}

?>
