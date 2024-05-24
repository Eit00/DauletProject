<?php
// Include your database connection code here (e.g., db_connection.php)
include "db_connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $group_id = $_POST["group_id"];
    $teacher_id = $_POST["teacher_id"];
    $subject = $_POST["subject"];
    $lesson_days = $_POST["lesson_days"];
    $lesson_time = $_POST["lesson_time"];

    // Prepare and execute the SQL query to insert a new record
    $query = "INSERT INTO groups (group_id, teacher_id, subject, lesson_days, lesson_time) VALUES ('$group_id', '$teacher_id', '$subject', '$lesson_days', '$lesson_time')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: groups.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// Close the database connection
mysqli_close($conn);
?>