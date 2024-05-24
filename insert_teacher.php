<?php
// Include your database connection code here (e.g., db_connection.php)
include "db_connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $surname = $_POST["surname"];
    $name = $_POST["name"];
    $subject = $_POST["subject"];
    $login = $_POST["login"];
    $password = $_POST["password"];

    // Prepare and execute the SQL query to insert a new record
    $query = "INSERT INTO teachers (surname, name, subject, login, password) VALUES ('$surname', '$name', '$subject', '$login', '$password')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: teachers.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// Close the database connection
mysqli_close($conn);
?>