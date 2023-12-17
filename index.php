<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Expiry Alarm System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #expiryAlert {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1>Medicine Expiry Alarm System</h1>

    <div id="expiryAlert"></div>

    <?php
    // Connect to your MySQL database
    $servername = "localhost";
    $username = "root";
    $password = "E37Si.zQJ5p=5xq";
    $dbname = "medicine_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch medicines from the database
    $sql = "SELECT name, expiry_date FROM medicines";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<script>addMedicine('" . $row['name'] . "', '" . $row['expiry_date'] . "');</script>";
        }
    }

    $conn->close();
    ?>

    <script>
        function addMedicine(name, expiryDate) {
            // Check if the date is in the future
            if (new Date(expiryDate) > new Date()) {
                // Check for upcoming expiry
                checkExpiry(name, expiryDate);
            }
        }

        function checkExpiry(name, expiryDate) {
            var daysUntilExpiry = Math.floor((new Date(expiryDate) - new Date()) / (1000 * 60 * 60 * 24));
            var expiryAlertDiv = document.getElementById('expiryAlert');

            if (daysUntilExpiry <= 7) {
                expiryAlertDiv.innerHTML += '<p>' + name + ' will expire in ' + daysUntilExpiry + ' days!</p>';
            }
        }
    </script>

</body>
</html>
