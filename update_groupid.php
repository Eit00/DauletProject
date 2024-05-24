<?php
// Include your database connection code here (e.g., db_connection.php)
include "db_connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $student_id = $_POST["student_id"];
    $group_id = $_POST["group_id"];

    // Prepare and execute the SQL query to insert a new record
    $query = "UPDATE students SET group_id='$group_id' WHERE student_id='$student_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: students.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// Close the database connection
mysqli_close($conn);
?>